<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\ReferralEarning;
use App\Models\User;
use DataTables;
use Illuminate\Http\Request;

class AffiliateController extends Controller {
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {}

    public function index() {
        $data['alert_col'] = 'col-lg-10 offset-lg-1';

        if (auth()->user()->referral_token == null) {
            auth()->user()->referral_token = generate_referral_token();
            auth()->user()->save();
        }

        $data['total_referral'] = auth()->user()->referrals()->count();
        $data['paid_referral']  = auth()->user()->referrals()->where('referral_status', 1)->count();
        $data['total_earning']  = auth()->user()->referral_earnings()->sum('commission_amount');
        $data['total_payout']   = auth()->user()->referral_payouts()->where('status', '!=', 99)->sum('amount');

        return view('backend.user.affiliate.overview', $data);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function referrals() {
        $assets = ['datatable'];
        return view('backend.user.affiliate.referrals', compact('assets'));
    }

    public function get_table_data() {
        $referralearnings = ReferralEarning::select('referral_earnings.*')
            ->with('reffered_user')
            ->where('user_id', auth()->id())
            ->orderBy("referral_earnings.id", "desc");

        return Datatables::eloquent($referralearnings)
            ->editColumn('amount', function ($referralearning) {
                return decimalPlace($referralearning->amount, currency());
            })
            ->editColumn('commission_percentage', function ($referralearning) {
                return $referralearning->commission_percentage . '%';
            })
            ->editColumn('commission_amount', function ($referralearning) {
                return decimalPlace($referralearning->commission_amount, currency());
            })
            ->setRowId(function ($referralearning) {
                return "row_" . $referralearning->id;
            })
            ->rawColumns(['amount', 'commission_amount'])
            ->make(true);
    }

    public function unpaid_referrals(Request $request) {
        $assets = ['datatable'];
        return view('backend.user.affiliate.unpaid_referrals', compact('assets'));
    }

    public function get_unpaid_table_data() {
        $users = User::select('users.*')
            ->where('referrer_id', auth()->id())
            ->where('referral_status', 0)
            ->orderBy("users.id", "desc");

        return Datatables::eloquent($users)
            ->editColumn('membership_type', function ($referralearning) {
                return ucwords($referralearning->membership_type);
            })
            ->addColumn('amount', function ($referralearning) {
                return _lang('Not Paid');
            })
            ->setRowId(function ($user) {
                return "row_" . $user->id;
            })
            ->make(true);
    }

}