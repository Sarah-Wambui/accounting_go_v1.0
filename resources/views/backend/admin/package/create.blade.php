@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-lg-10 offset-lg-1">
		<div class="card">
			<div class="card-header">
				<span class="panel-title">{{ _lang('Add New Package') }}</span>
			</div>
			<div class="card-body">
			    <form method="post" class="validate" autocomplete="off" action="{{ route('packages.store') }}" enctype="multipart/form-data">
					{{ csrf_field() }}
					<div class="row">
						<div class="col-lg-12">
							<div class="form-group row">
								<label class="col-xl-3 col-form-label">{{ _lang('Package Name') }}</label>						
								<div class="col-xl-9">
									<input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
								</div>
							</div>

							<div class="form-group row">
								<label class="col-xl-3 col-form-label">{{ _lang('Package Type') }}</label>						
								<div class="col-xl-9">
									<select class="form-control auto-select" data-selected="{{ old('package_type') }}" name="package_type" required>
										<option value="">{{ _lang('Select One') }}</option>
										<option value="monthly">{{ _lang('Monthly') }}</option>
										<option value="yearly">{{ _lang('Yearly') }}</option>
										<option value="lifetime">{{ _lang('Lifetime') }}</option>
									</select>
								</div>
							</div>

							<div class="form-group row">
								<label class="col-xl-3 col-form-label">{{ _lang('Cost') }} ({{ currency_symbol() }})</label>						
								<div class="col-xl-9">
									<input type="text" class="form-control float-field" name="cost" value="{{ old('cost') }}" required>
								</div>
							</div>
					
							<div class="form-group row">
								<label class="col-xl-3 col-form-label">{{ _lang('Discount') }} (%)</label>						
								<div class="col-xl-9">
									<input type="text" class="form-control float-field" name="discount" value="{{ old('discount', 0) }}" required>
								</div>
							</div>

							<div class="form-group row">
								<label class="col-xl-3 col-form-label">{{ _lang('Trial Days') }}</label>						
								<div class="col-xl-9">
									<input type="number" class="form-control" name="trial_days" value="{{ old('trial_days', 0) }}" required>
								</div>
							</div>

							<div class="form-group row">
								<label class="col-xl-3 col-form-label">{{ _lang('Status') }}</label>						
								<div class="col-xl-9">
									<select class="form-control auto-select" data-selected="{{ old('status', 1) }}" name="status" required>
										<option value="1">{{ _lang('Active') }}</option>
										<option value="0">{{ _lang('Disabled') }}</option>
									</select>
								</div>
							</div>

							<div class="form-group row">
								<label class="col-xl-3 col-form-label">{{ _lang('Is Popular') }}</label>						
								<div class="col-xl-9">
									<select class="form-control auto-select" data-selected="{{ old('is_popular', 0) }}" name="is_popular" required>
										<option value="0">{{ _lang('No') }}</option>
										<option value="1">{{ _lang('Yes') }}</option>
									</select>
								</div>
							</div>
						
							<hr>
							<div class="form-group row">					
								<div class="col-xl-9 offset-xl-3">
									<h5 class="text-info"><strong>{{ _lang('Manage Package Features') }}</strong></h5>
								</div>
							</div>			
							<hr>

							<div class="form-group row align-items-center">
								<label class="col-xl-3 col-form-label">{{ _lang('System User Limit') }}</label>						
								<div class="col-xl-7">
									<input type="number" class="form-control" name="user_limit" value="{{ old('user_limit') != '-1' ? old('user_limit') : '' }}" placeholder="5">
								</div>

								<div class="col-xl-2">
									<div class="form-check">
										<label class="form-check-label text-danger">
											<input type="checkbox" class="form-check-input no-msg" name="user_limit" value="-1" {{ old('user_limit') == '-1' ? 'checked' : '' }}>{{ _lang('UNLIMITED') }}
										</label>
									</div>
								</div>
							</div>

							<div class="form-group row align-items-center">
								<label class="col-xl-3 col-form-label">{{ _lang('Invoice Limit') }}</label>						
								<div class="col-xl-7">
									<input type="number" class="form-control" name="invoice_limit" value="{{ old('invoice_limit') != '-1' ? old('invoice_limit') : '' }}" placeholder="100">
								</div>

								<div class="col-xl-2">
									<div class="form-check">
										<label class="form-check-label text-danger">
											<input type="checkbox" class="form-check-input no-msg" name="invoice_limit" value="-1" {{ old('invoice_limit') == '-1' ? 'checked' : '' }}>{{ _lang('UNLIMITED') }}
										</label>
									</div>
								</div>
							</div>

							<div class="form-group row align-items-center">
								<label class="col-xl-3 col-form-label">{{ _lang('Quotation Limit') }}</label>						
								<div class="col-xl-7">
									<input type="number" class="form-control" name="quotation_limit" value="{{ old('quotation_limit') != '-1' ? old('quotation_limit') : '' }}" placeholder="150">
								</div>

								<div class="col-xl-2">
									<div class="form-check">
										<label class="form-check-label text-danger">
											<input type="checkbox" class="form-check-input no-msg" name="quotation_limit" value="-1" {{ old('quotation_limit') == '-1' ? 'checked' : '' }}>{{ _lang('UNLIMITED') }}
										</label>
									</div>
								</div>
							</div>

							<div class="form-group row align-items-center">
								<label class="col-xl-3 col-form-label">{{ _lang('Recurring Invoice') }}</label>						
								<div class="col-xl-7">
									<select class="form-control auto-select" data-selected="{{ old('recurring_invoice', 0) }}" name="recurring_invoice" required>
										<option value="0">{{ _lang('No') }}</option>
										<option value="1">{{ _lang('Yes') }}</option>
									</select>
								</div>
							</div>

							<div class="form-group row align-items-center">
								<label class="col-xl-3 col-form-label">{{ _lang('Customer Limit') }}</label>						
								<div class="col-xl-7">
									<input type="number" class="form-control" name="customer_limit" value="{{ old('customer_limit') != '-1' ? old('customer_limit') : '' }}" placeholder="100">
								</div>
								<div class="col-xl-2">
									<div class="form-check">
										<label class="form-check-label text-danger">
											<input type="checkbox" class="form-check-input no-msg" name="customer_limit" value="-1" {{ old('customer_limit') == '-1' ? 'checked' : '' }}>{{ _lang('UNLIMITED') }}
										</label>
									</div>
								</div>
							</div>

							<div class="form-group row align-items-center">
								<label class="col-xl-3 col-form-label">{{ _lang('Business Limit') }}</label>						
								<div class="col-xl-7">
									<input type="number" class="form-control" name="business_limit" value="{{ old('business_limit') != '-1' ? old('business_limit') : '' }}" placeholder="10">
								</div>
								<div class="col-xl-2">
									<div class="form-check">
										<label class="form-check-label text-danger">
											<input type="checkbox" class="form-check-input no-msg" name="business_limit" value="-1" {{ old('business_limit') == '-1' ? 'checked' : '' }}>{{ _lang('UNLIMITED') }}
										</label>
									</div>
								</div>
							</div>

							<div class="form-group row align-items-center">
								<label class="col-xl-3 col-form-label">{{ _lang('Invoice Template Maker') }}</label>						
								<div class="col-xl-7">
									<select class="form-control auto-select" data-selected="{{ old('invoice_builder') }}" name="invoice_builder" required>
										<option value="">{{ _lang('Select One') }}</option>
										<option value="0">{{ _lang('No') }}</option>
										<option value="1">{{ _lang('Yes') }}</option>
									</select>
								</div>
							</div>

							<div class="form-group row align-items-center">
								<label class="col-xl-3 col-form-label">{{ _lang('Online Invoice Payment') }}</label>						
								<div class="col-xl-7">
									<select class="form-control auto-select" data-selected="{{ old('online_invoice_payment') }}" name="online_invoice_payment" required>
										<option value="">{{ _lang('Select One') }}</option>
										<option value="0">{{ _lang('No') }}</option>
										<option value="1">{{ _lang('Yes') }}</option>
									</select>
								</div>
							</div>

							<div class="form-group row align-items-center">
								<label class="col-xl-3 col-form-label">{{ _lang('HR & Payroll Module') }}</label>						
								<div class="col-xl-7">
									<select class="form-control auto-select" data-selected="{{ old('payroll_module') }}" name="payroll_module" required>
										<option value="">{{ _lang('Select One') }}</option>
										<option value="0">{{ _lang('No') }}</option>
										<option value="1">{{ _lang('Yes') }}</option>
									</select>
								</div>
							</div>
						
							<div class="form-group row mt-2">
								<div class="col-xl-9 offset-xl-3">
									<button type="submit" class="btn btn-primary"><i class="ti-check-box mr-2"></i>{{ _lang('Save Changes') }}</button>
								</div>
							</div>
						</div>
					</div>
			    </form>
			</div>
		</div>
    </div>
</div>
@endsection


