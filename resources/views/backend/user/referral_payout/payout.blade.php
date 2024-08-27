@extends('layouts.app')

@section('content')
<div class="row">
	<div class="{{ $alert_col }}">
		<div class="card">
			<div class="card-header text-center">
				<span class="panel-title">{{ _lang('Make Payout') }}</span>
			</div>
			<div class="card-body">
				<div class="alert alert-danger d-none mt-3 mx-4 mb-0"></div>
				<div class="alert alert-primary d-none mt-3 mx-4 mb-0"></div>

				<form class="validate" action="{{ route('referral_payouts.payout') }}" method="post" enctype="multipart/form-data">
					@csrf
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label">{{ _lang('Payout Methods') }}</label>
								<select class="form-control auto-select" data-selected="{{ old('affiliate_payout_method_id') }}" name="affiliate_payout_method_id" id="affiliate_payout_method_id">
									<option value="">{{ _lang('Select One') }}</option>
									@foreach($payout_methods as $payout_method)
									<option value="{{ $payout_method->id }}" data-charge="{{ decimalPlace($payout_method->fixed_charge, currency_symbol()) .' + '. $payout_method->charge_in_percentage .'%' }}">{{ $payout_method->name }}</option>
									@endforeach
								</select>
							</div>
						</div>

						<div class="col-md-12">
							<div id="requirements"></div>
						</div>

						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label">{{ _lang('Amount') }}</label>
								<input type="text" class="form-control" name="amount" value="{{ old('amount', $account_balance) }}" required>
							</div>
						</div>

						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label">{{ _lang('Charge') }}</label>
								<input type="text" class="form-control" name="charge" id="charge" readonly>
							</div>
						</div>

						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label">{{ _lang('Instructions') }}</label>
								<div id="instructions" class="border rounded p-2 mh-43"></div>
							</div>
						</div>

						<div class="col-md-12 mt-2">
							<div class="form-group">
								<button type="submit" class="btn btn-primary btn-block"><i class="ti-check-box mr-2"></i> {{ _lang('Submit') }}</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
    </div>
</div>
@endsection

@section('js-script')
<script>
(function ($) {
	"use strict";

	$(document).on('change','#affiliate_payout_method_id', function(){
		var payout_method_id = $(this).val();
		var charge = $(this).find(':selected').data('charge');

		if(payout_method_id != ''){
			$.ajax({
				url: _url + `/user/referral_payouts/${payout_method_id}/get_payout_method`,
				beforeSend: function(){

				},success: function(data){
					var json = JSON.parse(JSON.stringify(data));
					$("#instructions").html(json['instructions']);
					$("#charge").val(charge);
					jQuery.each(json['parameters'], function(index, item) {
						var field = generate_input_field(item);
						$("#requirements").append(field);
					});
				}
			});
		}
	});

	function generate_input_field(field) {
        var field_type = field['field_type'];
        var field_name = field['field_name'];
        var field_label = field['field_label'];
        var validation = field['validation'] == 'required' ? ' required' : '';

        var field_html = '';
        if (field_type == 'text') {
            field_html = '<input type="text" class="form-control" name="requirements[' + field_name + ']" placeholder="'+ field_label +'"' + validation + '>';
        } else if (field_type == 'textarea') {
            field_html = '<textarea class="form-control" name="requirements[' + field_name + ']" placeholder="'+ field_label +'"' + validation + '></textarea>';
        }  else if (field_type == 'file') {
            field_html = '<input type="file" class="form-control-file border p-2 rounded" name="requirements[' + field_name + ']" data-placeholder="' + field_label + '"' + validation + '>';
        } else if (field_type == 'number') {
            field_html = '<input type="number" class="form-control" name="requirements[' + field_name + ']" placeholder="' + field_label + '"' + validation + '>';
        }

		var labelClass = field['validation'] == 'required' ? '<span class="required">*</span>' : '';

		return `<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label class="control-label">${field_label} ${labelClass}</label>
							${field_html}
						</div>
					</div>
				</div>`;
    }

})(jQuery);
</script>
@endsection


