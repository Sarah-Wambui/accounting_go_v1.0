@extends('layouts.app')

@section('content')
<div class="row">
	<div class="{{ $alert_col }}">
		<div class="card">
			<div class="card-header text-center">
				<span class="panel-title">{{ _lang('Affiliate Settings') }}</span>
			</div>
			<div class="card-body">
			    <form method="post" class="validate" autocomplete="off" action="{{ route('affiliate.settings') }}" enctype="multipart/form-data">
					@csrf
					<div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">{{ _lang('Commission Percentage') }}</label>	
                                <div class="input-group">					
                                    <input type="text" class="form-control float-field no-msg" name="affiliate_commission" value="{{ get_option('affiliate_commission', old('affiliate_commission', 0)) }}" required>
                                    <div class="input-group-append">
										<span class="input-group-text">%</span>
									</div>	
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">{{ _lang('Status') }}</label>						
                                <select class="form-control auto-select" data-selected="{{ get_option('affiliate_status', old('affiliate_status', 0)) }}" name="affiliate_status" required>
                                    <option value="1">{{ _lang('Active') }}</option>
                                    <option value="0">{{ _lang('Disabled') }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">{{ _lang('Minimum Payout') }}</label>	
                                <div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text">{{ currency_symbol() }}</span>
									</div>					
                                    <input type="text" class="form-control float-field no-msg" name="affiliate_minimum_payout" value="{{ get_option('affiliate_minimum_payout', old('affiliate_minimum_payout', 0)) }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">{{ _lang('Instructions') }}</label>						
                                <textarea class="form-control affiliate_instructions" name="affiliate_instructions">{{ get_option('affiliate_instructions', old('affiliate_instructions')) }}</textarea>
                            </div>
                        </div>
                    
                        <div class="col-md-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary"><i class="ti-check-box mr-2"></i>{{ _lang('Save Changes') }}</button>
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
    $('.affiliate_instructions').summernote({
        tabsize: 4,
        height: 250,
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']],
            ['insert', ['link', 'table']],
        ]
    });
})(jQuery);
</script>
@endsection