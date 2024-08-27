@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="card">
		    <div class="card-header">
				<span class="panel-title">{{ _lang('Payout Request Details') }}</span>
			</div>
			
			<div class="card-body">
			    <table class="table table-bordered">
                    <tr><td>{{ _lang('User Name') }}</td><td>{{ $referralPayout->user->name }}</td></tr>
                    <tr><td>{{ _lang('User eamil') }}</td><td>{{ $referralPayout->user->email }}</td></tr>
					<tr><td>{{ _lang('Payout Method') }}</td><td>{{ $referralPayout->affiliate_payout_method->name }}</td></tr>
					<tr><td>{{ _lang('Amount') }}</td><td>{{ decimalPlace($referralPayout->amount, currency_symbol()) }}</td></tr>
					<tr><td>{{ _lang('Charge') }}</td><td>-{{ decimalPlace($referralPayout->charge, currency_symbol()) }}</td></tr>
					<tr><td>{{ _lang('Final Amount') }}</td><td>{{ decimalPlace($referralPayout->final_amount, currency_symbol()) }}</td></tr>
                    @if($referralPayout->requirements)
                        @foreach($referralPayout->requirements as $key => $value)
                            <tr>
                                <td><b>{{ $value->field_label }}</b></td>
                                <td>
                                    @if($value->field_type != 'file')
                                    {{ $value->field_value }}
                                    @else
                                    <a href="{{ asset('/public/uploads/media/'. $value->field_value) }}" class="btn btn-outline-primary btn-xs" target="_blank"><i class="fas fa-eye mr-1"></i>{{ _lang('Preview') }}</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endif
					<tr>
                        <td>{{ _lang('Status') }}</td>
                        <td>
                            @if($referralPayout->status == 0)
                                {!! xss_clean(show_status(_lang('Pending'), 'warning')) !!}
                            @elseif($referralPayout->status == 1)
                                {!! xss_clean(show_status(_lang('Completed'), 'success')) !!}
                            @else
                                {!! xss_clean(show_status(_lang('Cancelled'), 'danger')) !!}
                            @endif
                        </td>
                    </tr>
                    @if($referralPayout->status == 0)
                    <tr>
                        <td>{{ _lang('Action') }}</td>
                        <td>
                            <a href="{{ route('affiliate.approve_payout_requests', $referralPayout->id) }}" class="btn btn-primary"><i class="fas fa-check-circle mr-1"></i>{{ _lang('Approved') }}</a>
                            <a href="{{ route('affiliate.reject_payout_requests', $referralPayout->id) }}" class="btn btn-danger ajax-modal" data-title="{{ _lang('Rejection Reason') }}"><i class="fas fa-times-circle mr-1"></i>{{ _lang('Reject') }}</a>
                        </td>
                    </tr>
                    @endif
			    </table>
			</div>
	    </div>
	</div>
</div>
@endsection