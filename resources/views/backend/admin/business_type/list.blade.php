@extends('layouts.app')

@section('content')

<div class="row">
	<div class="col-lg-12">
		<div class="card no-export">
		    <div class="card-header d-flex align-items-center">
				<span class="panel-title">{{ _lang('Business Types') }}</span>
				<a class="btn btn-primary btn-xs ml-auto ajax-modal" data-title="{{ _lang('Add Business Type') }}" href="{{ route('business_types.create') }}"><i class="ti-plus mr-2"></i>{{ _lang('Add New') }}</a>
			</div>
			<div class="card-body">
				<table id="business_types_table" class="table data-table">
					<thead>
					    <tr>
						    <th>{{ _lang('Name') }}</th>
							<th>{{ _lang('Status') }}</th>
							<th class="text-center">{{ _lang('Action') }}</th>
					    </tr>
					</thead>
					<tbody>
					    @foreach($businesstypes as $businesstype)
					    <tr data-id="row_{{ $businesstype->id }}">
							<td class='name'>{{ $businesstype->name }}</td>
							<td class='status'>{!! xss_clean(status($businesstype->status)) !!}</td>
							
							<td class="text-center">
								<span class="dropdown">
								  <button class="btn btn-outline-primary dropdown-toggle btn-xs" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								  {{ _lang('Action') }}
								  </button>
								  <form action="{{ route('business_types.destroy', $businesstype['id']) }}" method="post">
									{{ csrf_field() }}
									<input name="_method" type="hidden" value="DELETE">

									<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
										<a href="{{ route('business_types.edit', $businesstype['id']) }}" data-title="{{ _lang('Update Business Type') }}" class="dropdown-item dropdown-edit ajax-modal"><i class="ti-pencil mr-2"></i> {{ _lang('Edit') }}</a>
										<button class="btn-remove dropdown-item" type="submit"><i class="ti-trash mr-2"></i>{{ _lang('Delete') }}</button>
									</div>
								  </form>
								</span>
							</td>
					    </tr>
					    @endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

@endsection