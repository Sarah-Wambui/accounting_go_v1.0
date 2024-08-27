@extends('layouts.app')

@section('content')

<div class="row">
	<div class="col-lg-12">
		<div class="alert alert-primary mb-3">
			<i class="fas fa-coins mr-2"></i>{{ _lang('Your current earning').' '.decimalPlace($account_balance, currency_symbol()) }}
		</div>

		<div class="card">
			<div class="card-header d-flex align-items-center">
				<span class="panel-title">{{ _lang('Payouts') }}</span>
				<a class="btn btn-primary btn-xs ml-auto" href="{{ route('referral_payouts.payout') }}"><i class="fas fa-coins"></i> {{ _lang('Make Payout') }}</a>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table id="referral_payouts_table" class="table">
						<thead>
							<tr>
								<th>{{ _lang('Date') }}</th>
								<th>{{ _lang('Payout Method') }}</th>
								<th>{{ _lang('Amount') }}</th>
								<th>{{ _lang('Charge') }}</th>
								<th>{{ _lang('Final Amount') }}</th>
								<th>{{ _lang('Status') }}</th>
							</tr>
						</thead>
						<tbody>
							@foreach($referralPayouts as $referralPayout)
							<tr data-id="row_{{ $referralPayout->id }}">
								<td class='created_at'>{{ $referralPayout->created_at }}</td>
								<td class='affiliate_payout_method_id'>{{ $referralPayout->affiliate_payout_method->name }}</td>
								<td class='amount'>{{ decimalPlace($referralPayout->amount, currency_symbol()) }}</td>
								<td class='charge'>{{ decimalPlace($referralPayout->charge, currency_symbol()) }}</td>
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