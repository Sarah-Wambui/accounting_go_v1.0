<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\ReferralPayout;
use Illuminate\Support\Facades\Validator;
use App\Notifications\RejectPayoutRequest;
use App\Notifications\ApprovePayoutRequest;

class AffiliateController extends Controller {
    private $ignoreRequests = ['_token'];

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        date_default_timezone_set(get_option('timezone', 'Asia/Dhaka'));
    }

    public function referrals(Request $request) {
        $assets = ['datatable'];
        return view('backend.admin.affiliate.referrals', compact('assets'));
    }

    public function get_referrals_data() {
        $users = User::select('users.*')
            ->with(['referral_payment', 'referrer'])
            ->whereNotNull('referrer_id')
            ->orderBy("users.id", "desc");

        return Datatables::eloquent($users)
            ->editColumn('referral_payment.amount', function ($user) {
                return $user->referral_payment ? decimalPlace($user->referral_payment->amount, currency()) : _lang('N/A');
            })
            ->editColumn('referral_payment.commission_percentage', function ($user) {
                return $user->referral_payment ? $user->referral_payment->commission_percentage . '%' : _lang('N/A');
            })
            ->editColumn('referral_payment.commission_amount', function ($user) {
                return $user->referral_payment ? decimalPlace($user->referral_payment->commission_amount, currency()) : _lang('N/A');
            })
            ->setRowId(function ($user) {
                return "row_" . $user->id;
            })
            ->rawColumns(['referral_payment.amount', 'referral_payment.commission_amount'])
            ->make(true);
    }

    public function settings(Request $request) {
        if ($request->isMethod('get')) {
            $assets    = ['summernote', 'datatable'];
            $alert_col = 'col-lg-6 offset-lg-3';
            return view('backend.admin.affiliate.settings', compact('assets', 'alert_col'));
        } else {
            $validator = Validator::make($request->all(), [
                'affiliate_commission'     => $request->affiliate_status == 0 ? 'required|numeric' : 'required|numeric|min:0.1',
                'affiliate_status'         => 'required',
                'affiliate_minimum_payout' => 'required|numeric',
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            $settingsData = $request->except($this->ignoreRequests);

            foreach ($settingsData as $key => $value) {
                $value = is_array($value) ? json_encode($value) : $value;
                update_option($key, $value ?? '');
            }

            return redirect()->route('affiliate.settings')->with('success', _lang('Saved Successfully'));
        }
    }

    public function payout_requests($type = 'pending') {
        $status = 0;
        switch ($type) {
        case "approved":
            $status = 1;
            break;
        case "cancelled":
            $status = 99;
            break;
        default:
            $status = 0;
        }

        $data                    = array();
        $data['type']            = $type;
        $data['referralPayouts'] = ReferralPayout::with('affiliate_payout_method', 'user')
            ->where('status', $status)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('backend.admin.affiliate.payout_requests', $data);
    }

    public function payout_request_details($id) {
        $referralPayout = ReferralPayout::find($id);
        return view('backend.admin.affiliate.payout_request_details', compact('referralPayout'));
    }

    public function approve_payout_requests($id) {
        $referralPayout = ReferralPayout::find($id);
        if ($referralPayout->status == 0) {
            $referralPayout->status = 1;
            $referralPayout->save();

            try {
                $referralPayout->user->notify(new ApprovePayoutRequest($referralPayout));
            } catch (\Exception $e) {}

            return back()->with('success', _lang('Payout request approved'));
        }
    }

    public function reject_payout_requests(Request $request, $id) {
        if ($request->isMethod('get')) {
            if (!$request->ajax()) {
                return back();
            }
            return view('backend.admin.affiliate.modal.reject_payout_request', compact('id'));
        } else {
            $validator = Validator::make($request->all(), [
                'reason'         => 'required',
            ]);

            if ($validator->fails()) {
                if ($request->ajax()) {
                    return response()->json(['result' => 'error', 'message' => $validator->errors()->all()]);
                } else {
                    return back()->withErrors($validator)->withInput();
                }
            }

            $referralPayout = ReferralPayout::find($id);
            if ($referralPayout->status == 0) {
                $referralPayout->status = 99;
                $referralPayout->admin_note = $request->reason;
                $referralPayout->save();
    
                try {
                    $referralPayout->user->notify(new RejectPayoutRequest($referralPayout));
                } catch (\Exception $e) {}
    
                return back()->with('success', _lang('Payout request rejected'));
            }
        }
    }

}