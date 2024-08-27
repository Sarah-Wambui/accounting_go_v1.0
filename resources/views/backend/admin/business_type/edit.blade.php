@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<span class="panel-title">{{ _lang('Update Business Type') }}</span>
			</div>
			<div class="card-body">
				<form method="post" class="validate" autocomplete="off" action="{{ route('business_types.update', $id) }}" enctype="multipart/form-data">
					{{ csrf_field()}}
					<input name="_method" type="hidden" value="PATCH">
					<div class="row">
						<div class="col-lg-10">
							<div class="form-group row">
								<label class="col-xl-3 col-form-label">{{ _lang('Name') }}</label>						
								<div class="col-xl-9">
									<input type="text" class="form-control" name="name" value="{{ $businesstype->name }}" required>
								</div>
							</div>

							<div class="form-group row">
								<label class="col-xl-3 col-form-label">{{ _lang('Status') }}</label>						
								<div class="col-xl-9">
									<select class="form-control auto-select" data-selected="{{ $businesstype->status }}" name="status" required>
										<option value="1">{{ _lang('Active') }}</option>
										<option value="0">{{ _lang('Disabled') }}</option>
									</select>
								</div>
							</div>
			
							<div class="form-group row">
								<div class="col-xl-9 offset-xl-3">
									<button type="submit" class="btn btn-primary"><i class="ti-check-box mr-2"></i>{{ _lang('Update') }}</button>
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


