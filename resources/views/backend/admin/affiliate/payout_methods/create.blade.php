@extends('layouts.app')

@section('content')
<div class="row">
	<div class="{{ $alert_col }}">
		<div class="card">
			<div class="card-header">
				<span class="panel-title">{{ _lang('Add Payout Method') }}</span>
			</div>
			<div class="card-body">
			    <form method="post" class="validate" autocomplete="off" action="{{ route('affiliate_payout_methods.store') }}" enctype="multipart/form-data">
					{{ csrf_field() }}
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label">{{ _lang('Name') }}</label>						
								<input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label">{{ _lang('Status') }}</label>						
								<select class="form-control auto-select" data-selected="{{ old('status', 1) }}" name="status" required>
									<option value="1">{{ _lang('Active') }}</option>
									<option value="0">{{ _lang('Disabled') }}</option>
								</select>
							</div>
						</div>

						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label">{{ _lang('Image') }}</label>						
								<input type="file" class="form-control dropify" name="image" data-max-file-size="2M" data-allowed-file-extensions="png jpg jpeg">
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label">{{ _lang('Fixed Charge') }}</label>						
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text">{{ currency() }}</span>
									</div>
									<input type="text" class="form-control float-field" name="fixed_charge" value="{{ old('fixed_charge', 0) }}">	
								</div>	
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label">{{ _lang('Charge In Percentage') }}</label>
								<div class="input-group">
									<input type="text" class="form-control float-field no-msg" name="charge_in_percentage" value="{{ old('charge_in_percentage', 0) }}">
									<div class="input-group-append">
										<span class="input-group-text">%</span>
									</div>
								</div>						
							</div>
						</div>

						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label">{{ _lang('Instructions') }}</label>						
								<textarea class="form-control instructions" name="instructions">{{ old('instructions') }}</textarea>
							</div>
						</div>

						<div class="col-md-12 mt-3">
							<hr>
							<div class="d-flex align-items-center justify-content-between">
								<h5 class="mb-0"><b>{{ _lang('Payout Details') }}</b></h5>
								<button type="button" id="add-new-field" class="btn btn-outline-primary btn-xs"><i class="fas fa-plus mr-1"></i>{{ _lang('Add New Field') }}</button>
							</div>
							<hr>
							<div class="row">
								<div class="col-md-12 mt-4">
									<table class="table table-bordered" id="form-fields">
										<thead class="bg-light">
											<th class="text-dark">{{ _lang('Field Name') }}</th>
											<th class="text-dark">{{ _lang('Field Type') }}</th>
											<th class="text-dark">{{ _lang('Validation') }}</th>
											<th class="text-dark">{{ _lang('File Max Size (MB)') }}</th>
											<th class="text-center text-dark">{{ _lang('Action') }}</th>
										</thead>
										<tbody>
											<tr class="row-data">
												<td><input type="text" name="field_name[]" class="form-control" placeholder="Field Name" required></td>
												<td>
													<select name="field_type[]" class="form-select form-control" required>
														<option value="file">File (PNG,JPG,PDF)</option>
														<option value="text">Textbox</option>
														<option value="number">Number</option>
														<option value="textarea">Textarea</option>
													</select>
												</td>
												<td>
													<select name="validation[]" class="form-control" required>
														<option value="required">Required</option>
														<option value="nullable">No Required</option>
													</select>
												</td>
												<td><input type="number" name="max_size[]" class="form-control" placeholder="2" value="2" required></td>
												<td class="text-center"><button type="button" class="btn btn-danger btn-xs btn-remove-row"><i class="far fa-trash-alt"></i></button></td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
							
						<div class="col-md-12 mt-4">
							<div class="form-group">
								<button type="submit" class="btn btn-primary"><i class="ti-check-box mr-1"></i> {{ _lang('Save Changes') }}</button>
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

	$(document).on('click', '#add-new-field', function () {
		var rowData = `<tr class="row-data">
							<td><input type="text" name="field_name[]" class="form-control" placeholder="Field Name" required></td>
							<td>
								<select name="field_type[]" class="form-control" required>
									<option value="file">File (PNG,JPG,PDF)</option>
									<option value="text">Textbox</option>
									<option value="number">Number</option>
									<option value="textarea">Textarea</option>
								</select>
							</td>
							<td>
								<select name="validation[]" class="form-control" required>
									<option value="required">Required</option>
									<option value="nullable">No Required</option>
								</select>
							</td>
							<td><input type="number" name="max_size[]" class="form-control" placeholder="2" value="2" required></td>
							<td class="text-center"><button type="button" class="btn btn-danger btn-xs btn-remove-row"><i class="far fa-trash-alt"></i></button></td>
						</tr>`;

		$('#form-fields tbody').append(rowData);
	});

	$(document).on('click', '.btn-remove-row', function () {
		$(this).closest('.row-data').remove();
	});

	$('.instructions').summernote({
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


