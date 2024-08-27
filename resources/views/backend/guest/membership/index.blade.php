@extends('layouts.app')

@section('content')
<div id="pricing-table">
    <div class="row justify-content-center">      

        @if($package != null)
        <div class="col-lg-3">
            <div class="pricing-plan popular h-100 {{ $package->package_type == 'monthly' ? 'wow' : '' }} animate__zoomIn" data-wow-delay=".6s">
                <div class="pricing-plan-header">
                    @if($package->is_popular == 1)
                    <span>{{ _lang('Most popular') }}</span>
                    @endif
                    <h5>{{ $package->name }}</h5>
                    @if($package->discount > 0)
                    <p class="d-inline-block mb-4">
                        <small><del>{{ decimalPlace($package->cost, currency_symbol()) }}</del></small>
                        <span class="bg-info d-inline-block text-white px-3 py-1 rounded-pill ms-1">{{ $package->discount.'% '._lang('Discount') }}</span>
                    </p>
                    <h4><span>{{ decimalPlace($package->cost - ($package->discount / 100) * $package->cost, currency_symbol()) }}</span> / {{ ucwords($package->package_type) }}</h4>
                    @else
                    <h4><span>{{ decimalPlace($package->cost, currency_symbol()) }}</span> / {{ ucwords($package->package_type) }}</h4>
                    @endif
                </div>
                <div class="pricing-plan-body">
                    <ul>
                        <li><i class="fas fa-check-circle text-success mr-2"></i>{{ str_replace('-1',_lang('Unlimited'), $package->business_limit).' '._lang('Business Account') }}</li>
                        <li><i class="fas fa-check-circle text-success mr-2"></i>{{ str_replace('-1',_lang('Unlimited'), $package->user_limit).' '._lang('System User') }}</li>
                        <li><i class="fas fa-check-circle text-success mr-2"></i>{{ str_replace('-1',_lang('Unlimited'), $package->invoice_limit).' '._lang('Invoice') }} <i class="fas fa-info-circle ml-1" data-toggle="tooltip" data-placement="top" title="{{ _lang('Reset after renew') }}"></i></li>
                        <li><i class="fas fa-check-circle text-success mr-2"></i>{{ str_replace('-1',_lang('Unlimited'), $package->quotation_limit).' '._lang('Quotation') }} <i class="fas fa-info-circle ml-1" data-toggle="tooltip" data-placement="top" title="{{ _lang('Reset after renew') }}"></i></li>
                        <li><i class="bi {{ $package->recurring_invoice == 0 ? 'fas fa-times-circle text-danger' : 'fas fa-check-circle text-success' }} mr-2"></i>{{ _lang('Recurring Invoice') }}</li>
                        <li><i class="bi {{ $package->payroll_module == 0 ? 'fas fa-times-circle text-danger' : 'fas fa-check-circle text-success' }} mr-2"></i>{{ _lang('HR & Payroll Module') }}</li>
                        <li><i class="fas fa-check-circle text-success mr-2"></i>{{ str_replace('-1',_lang('Unlimited'), $package->customer_limit).' '._lang('Customer Account') }}</li>
                        <li><i class="bi {{ $package->invoice_builder == 0 ? 'fas fa-times-circle text-danger' : 'fas fa-check-circle text-success' }} mr-2"></i>{{ _lang('Invoice Template Builder') }}</li>
                        <li><i class="bi {{ $package->online_invoice_payment == 0 ? 'fas fa-times-circle text-danger' : 'fas fa-check-circle text-success' }} mr-2"></i>{{ _lang('Accept Online Payment') }}</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header text-center">
                    <span class="panel-title">{{ _lang('Membership Details') }}</span>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <tr>
                            <td>{{ _lang('Membership Type') }}</td>
                            <td>{{ ucwords(auth()->user()->membership_type) }}</td>
                        </tr>
                        <tr>
                            <td>{{ _lang('Subscription Date') }}</td>
                            <td>{{ auth()->user()->subscription_date }}</td>
                        </tr>
                        <tr>
                            <td>{{ _lang('Subscription Expired') }}</td>
                            <td>{{ auth()->user()->valid_to }}</td>
                        </tr>
                        <tr>
                            <td>{{ _lang('Last Payment') }}</td>
                            <td>{{ $lastPayment ? decimalPlace($lastPayment->amount, currency_symbol()) : _lang('N/A') }}</td>
                        </tr>
                        <tr>
                            <td>{{ _lang('Last Payment Date') }}</td>
                            <td>{{ $lastPayment ? $lastPayment->created_at : _lang('N/A') }}</td>
                        </tr>
                    </table>
                    <form action="{{ route('membership.choose_package') }}" method="post">
                        @csrf
                        <input type="hidden" name="package_id" value="{{ $package->id }}">
                        <a href="{{ route('membership.payment_gateways') }}" class="btn btn-primary btn-block mt-4">{{ _lang('Renew Membership') }}</a>
                        <a href="{{ route('membership.packages') }}" class="btn btn-danger btn-block mt-2" id="change-package">{{ _lang('Change Package') }}</a>
                    </form>
                </div>
            </div>
        </div>

        @endif
    </div>
</div>
@endsection

@section('js-script')
<script>
(function ($) {
    "use strict";

    $(document).on('click','#change-package', function(e){
        e.preventDefault();
        var link = $(this).attr('href');

        Swal.fire({
			text: '{{ _lang('Once you process then you will not able to rollback current subscription. You need to repay for new selected package !') }}',
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: '{{ _lang('Yes Process') }}',
			cancelButtonText: $lang_cancel_button_text
		}).then((result) => {
			if (result.value) {
				window.location.href = link;
			}
		});
    });
    
})(jQuery);
</script>
@endsection