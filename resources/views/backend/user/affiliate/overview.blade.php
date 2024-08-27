@extends('layouts.app')

@section('content')
<div class="row">
    <div class="{{ $alert_col }}">
        <div class="card">
            <div class="card-body">     
                <div class="mb-4">
                    <h6 class="mb-2">{{ _lang('Share Referral Link') }}</h6>

                    <div class="referral_link">
                        <p>{{ auth()->user()->referral_link }}</p>
                        <button type="button" class="btn btn-primary btn-xs" id="btn-referral-link" data-clipboard-text="{{ auth()->user()->referral_link }}">{{ _lang('Copy Link') }}</button>
                    </div>   
                </div>   

                <div class="row">
                    <div class="col-xl-3 col-md-6">
                        <div class="card rounded mb-4 referral-dashboard-card">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <h5>{{ _lang('Total Referrals') }}</h5>
                                        <h4 class="pt-1 mb-0"><b>{{ $total_referral }}</b></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6">
                        <div class="card rounded mb-4 referral-dashboard-card">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <h5>{{ _lang('Paid Referrals') }}</h5>
                                        <h4 class="pt-1 mb-0"><b>{{ $paid_referral }}</b></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6">
                        <div class="card rounded mb-4 referral-dashboard-card">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <h5>{{ _lang('Current Balance') }}</h5>
                                        <h4 class="pt-1 mb-0"><b>{{ decimalPlace($total_earning - $total_payout, currency_symbol()) }}</b></h4>  
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6">
                        <div class="card rounded mb-4 referral-dashboard-card">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <h5>{{ _lang('Total Earning') }}</h5>
                                        <h4 class="pt-1 mb-0"><b>{{ decimalPlace($total_earning, currency_symbol()) }}</b></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>    
            </div>
        </div>
    </div>

    <div class="{{ $alert_col }}">
        <div class="card">
            <div class="card-header">
                <span class="panel-title">{{ _lang('Instructions') }}</span>
            </div>
            <div class="card-body">  
            {!! xss_clean(get_option('affiliate_instructions', old('affiliate_instructions'))) !!}
            </div>
        </div>
    </div>
</div>
@endsection

@section('js-script')
<script src="{{ asset('public/backend/assets/js/clipboard.min.js') }}"></script>
<script>
(function($) {
    "use strict";

    var clipboard = new ClipboardJS("#btn-referral-link");
    clipboard.on("success", function(e) {
        $.toast({
            text: "{{ _lang('Coiped referral link') }}",
            icon: "success",
            position: "top-right",
        });
    });

})(jQuery);
</script>
@endsection
