<?php

namespace App\Http\Controllers\User;

use App\Models\PayoutMethod;
use Illuminate\Http\Request;
use App\Models\ReferralPayout;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ReferralPayoutController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        date_default_timezone_set(get_option('timezone', 'Asia/Dhaka'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $data                    = array();
        $total_earning   = auth()->user()->referral_earnings()->sum('commission_amount');
        $total_payout    = auth()->user()->referral_payouts()->where('status', '!=', 99)->sum('amount');
        $data['account_balance'] = $total_earning - $total_payout;

        $data['referralPayouts'] = ReferralPayout::where('user_id', auth()->id())
            ->with('affiliate_payout_method')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('backend.user.referral_payout.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function payout(Request $request) {
        if ($request->isMethod('get')) {
            //Check Minimum Payout
            $minimum_payout  = get_option('affiliate_minimum_payout', 0.1);
            $total_earning   = auth()->user()->referral_earnings()->sum('commission_amount');
            $total_payout    = auth()->user()->referral_payouts()->where('status', '!=', 99)->sum('amount');
            $account_balance = $total_earning - $total_payout;

            if ($account_balance < $minimum_payout) {
                return back()->with('error', _lang('Sorry, Minimum Payout balance is' . ' ' . decimalPlace($minimum_payout, currency_symbol())));
            }

            $payout_methods = PayoutMethod::where('status', 1)->get();
            $alert_col      = 'col-lg-6 offset-lg-3';
            return view('backend.user.referral_payout.payout', compact('payout_methods', 'alert_col', 'account_balance'));
        } else {
            @ini_set('max_execution_time', 0);
            @set_time_limit(0);

            //Initial validation
            $validator = Validator::make($request->all(), [
                'affiliate_payout_method_id' => 'required',
            ], [
                'affiliate_payout_method_id.required' => 'Payout method is required',
            ]);

            if ($validator->fails()) {
                if ($request->ajax()) {
                    return response()->json(['result' => 'error', 'message' => $validator->errors()->all()]);
                } else {
                    return back()->withErrors($validator)->withInput();
                }
            }

            $payout_method      = PayoutMethod::find($request->affiliate_payout_method_id);
            $validationRules    = [];
            $validationMessages = [];

            // Custom field validation
            $customValidation = generate_custom_field_validation($payout_method->requirements);

            array_merge($validationRules, $customValidation['rules']);
            array_merge($validationMessages, $customValidation['messages']);

            $validator = Validator::make($request->all(), $validationRules, $validationMessages);

            if ($validator->fails()) {
                if ($request->ajax()) {
                    return response()->json(['result' => 'error', 'message' => $validator->errors()->all()]);
                } else {
                    return back()->withErrors($validator)->withInput();
                }
            }

            //Check Available Balance
            $minimum_payout  = get_option('affiliate_minimum_payout', 0.1);
            $total_earning   = auth()->user()->referral_earnings()->sum('commission_amount');
            $total_payout    = auth()->user()->referral_payouts()->where('status', '!=', 99)->sum('amount');
            $account_balance = $total_earning - $total_payout;

            //Check Minimum Payout
            if ($account_balance < $minimum_payout) {
                return back()->with('error', _lang('Sorry, Minimum Payout balance is' . ' ' . decimalPlace($minimum_payout, currency_symbol())));
            }

            if ($account_balance < $request->amount) {
                return back()
                    ->with('error', _lang('Insufficient balance'))
                    ->withInput();
            }

            // Store custom field data
            $requirements = store_custom_field_data($payout_method->parameters);

            //Charge Calculation
            $charge = $payout_method->fixed_charge;
            $charge += ($payout_method->charge_in_percentage / 100) * $request->amount;

            $referralPayout                             = new ReferralPayout();
            $referralPayout->user_id                    = auth()->id();
            $referralPayout->affiliate_payout_method_id = $payout_method->id;
            $referralPayout->amount                     = $request->amount;
            $referralPayout->charge                     = $charge;
            $referralPayout->final_amount               = $request->amount - $charge;
            $referralPayout->requirements               = json_encode($requirements);
            $referralPayout->save();

            if (!$request->ajax()) {
                return redirect()->route('referral_payouts.index')->with('success', _lang('Payout request submitted successfully'));
            } else {
                return response()->json(['result' => 'success', 'action' => 'store', 'message' => _lang('Payout request submitted successfully'), 'data' => $referralPayout, 'table' => '#unknown_table']);
            }
        }
    }

    public function get_payout_method($id) {
        $payout_method = PayoutMethod::find($id);
        return response()->json($payout_method);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id) {
        $referralpayout = ReferralPayout::find($id);
        if (!$request->ajax()) {
            return view('backend.user.referral_payout.view', compact('referralpayout', 'id'));
        } else {
            return view('backend.user.referral_payout.modal.view', compact('referralpayout', 'id'));
        }
    }

}