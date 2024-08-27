<form method="post" class="validate" autocomplete="off" action="{{ route('employee_expenses.update', $id) }}" enctype="multipart/form-data">
    @csrf
    <input name="_method" type="hidden" value="PATCH">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label">{{ _lang('Trans Date') }}</label>						
                <input type="text" class="form-control datetimepicker" name="trans_date" value="{{ $employeeexpense->getRawOriginal('trans_date') }}" required>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label">{{ _lang('Employee') }}</label>						
                <select class="form-control auto-select select2" data-selected="{{ $employeeexpense->employee_id }}" name="employee_id" required>
                    <option value="">{{ _lang('Select One') }}</option>
                    @foreach(\App\Models\Employee::active()->get() as $employee)
					<option value="{{ $employee->id }}">{{ $employee->employee_id }} ({{ $employee->name }})</option>
					@endforeach
                </select>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label">{{ _lang('Bill No') }}</label>						
                <input type="text" class="form-control" name="bill_no" value="{{ $employeeexpense->bill_no }}">
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label">{{ _lang('Amount') }}</label>						
                <input type="text" class="form-control float-field" name="amount" value="{{ $employeeexpense->amount }}" required>
            </div>
        </div>


        <div class="col-md-12">
            <div class="form-group">
                <label class="control-label">{{ _lang('Expense Type') }}</label>						
                <input type="text" class="form-control" name="expense_type" value="{{ $employeeexpense->expense_type }}" required>
            </div>
        </div>


        <div class="col-md-12">
            <div class="form-group">
                <label class="control-label">{{ _lang('Description') }}</label>						
                <textarea class="form-control" name="description">{{ $employeeexpense->description }}</textarea>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label class="control-label">{{ _lang('Attachment') }}</label>						
                <input type="file" class="form-control dropify" name="attachment">
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label class="control-label">{{ _lang('Status') }}</label>						
                <select class="form-control auto-select" data-selected="{{ $employeeexpense->status }}" name="status" required>
                    <option value="1">{{ _lang('Completed') }}</option>
					<option value="0">{{ _lang('Pending') }}</option>
                </select>
            </div>
        </div>
            
        <div class="col-md-12 mt-2">
            <div class="form-group">
                <button type="submit" class="btn btn-primary"><i class="ti-check-box mr-2"></i> {{ _lang('Update') }}</button>
            </div>
        </div>
    </div>
</form>