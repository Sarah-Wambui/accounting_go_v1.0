@extends('layouts.app')

@section('content')

<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header d-flex align-items-center justify-content-between">
				<span class="panel-title">{{ _lang('Payout Requests') }}</span>
				<select class="filter-select select-status auto-select" data-selected="{{ $type }}" name="status">
					<option value="pending">{{ _lang('Pending') }}</option>
					<option value="approved">{{ _lang('Approved') }}</option>
					<option value="cancelled">{{ _lang('Cancelled') }}</option>
				</select>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table id="referral_payouts_table" class="table">
						<thead>
							<tr>
								<th>{{ _lang('Date') }}</th>
								<th>{{ _lang('User') }}</th>
								<th>{{ _lang('Payout Method') }}</th>
								<th>{{ _lang('Amount') }}</th>
								<th>{{ _lang('Charge') }}</th>
								<th>{{ _lang('Final Amount') }}</th>
								<th>{{ _lang('Status') }}</th>
								<th class="text-center">{{ _lang('Action') }}</th>
							</tr>
						</thead>
						<tbody>
							@foreach($referralPayouts as $referralPayout)
							<tr data-id="row_{{ $referralPayout->id }}">
								<td class='created_at'>{{ $referralPayout->created_at }}</td>
								<td class='user'>{{ $referralPayout->user->name }}</td>
								<td class='affiliate_payout_method'>{{ $referralPayout->affiliate_payout_method->name }}</td>
								<td class='amount'>{{ decimalPlace($referralPayout->amount, currency_symbol()) }}</td>
								<td class='charge'>-{{ decimalPlace($referralPayout->charge, currency_symbol()) }}</td>
								<td class='final_amount'>{{ decimalPlace($referralPayout->final_amount, currency_symbol()) }}</td>
								<td class='status'>
									@if($referralPayout->status == 0)
										{!! xss_clean(show_status(_lang('Pending'), 'warning')) !!}
									@elseif($referralPayout->status == 1)
										{!! xss_clean(show_status(_lang('Completed'), 'success')) !!}
									@else
										{!! xss_clean(show_status(_lang('Cancelled'), 'danger')) !!}
									@endif
								</td>
								<td class="text-center">
									<a href="{{ route('affiliate.payout_request_details', $referralPayout->id) }}" class="btn btn-primary btn-xs">{{ _lang('Details') }}</a>
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>

				<div class="pagination-container float-right">
                    {{ $referralPayouts->links() }}
                </div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('js-script')
<script>
(function ($) {
	"use strict";

	$(".select-status").on("change", function (e) {
		var status = $(this).val();
		window.location.href = _url + "/admin/affiliate/payout_requests/" + status;
	});

})(jQuery);
</script>
@endsection