@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header d-flex align-items-center">
				<span class="panel-title">{{ _lang('Payout Methods') }}</span>
				<a class="btn btn-primary btn-xs ml-auto" href="{{ route('affiliate_payout_methods.create') }}"><i class="ti-plus"></i> {{ _lang('Add New') }}</a>
			</div>
			<div class="card-body">
				<table id="affiliate_payout_methods_table" class="table data-table">
					<thead>
					    <tr>
							<th>{{ _lang('Image') }}</th>
						    <th>{{ _lang('Name') }}</th>
							<th>{{ _lang('Payout Charge') }}</th>
							<th>{{ _lang('Status') }}</th>
							<th class="text-center">{{ _lang('Action') }}</th>
					    </tr>
					</thead>
					<tbody>
					    @foreach($payoutmethods as $payoutmethod)
					    <tr data-id="row_{{ $payoutmethod->id }}">
							<td class='image'>
								<img class="thumb-sm img-thumbnail" src="{{ asset('public/uploads/media/'.$payoutmethod->image) }}"/>
							</td>
							<td class='name'>{{ $payoutmethod->name }}</td>
							<td class='name'>{{ decimalPlace($payoutmethod->fixed_charge, currency_symbol()) }} + {{ $payoutmethod->charge_in_percentage }}%</td>
							<td class='status'>{!! xss_clean(status($payoutmethod->status)) !!}</td>
							<td class="text-center">
								<span class="dropdown">
								  <button class="btn btn-outline-primary dropdown-toggle btn-xs" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								  {{ _lang('Action') }}
								  </button>
								  <form action="{{ route('affiliate_payout_methods.destroy', $payoutmethod['id']) }}" method="post">
									{{ csrf_field() }}
									<input name="_method" type="hidden" value="DELETE">

									<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
										<a href="{{ route('affiliate_payout_methods.edit', $payoutmethod['id']) }}" class="dropdown-item dropdown-edit dropdown-edit"><i class="ti-pencil-alt"></i> {{ _lang('Edit') }}</a>
										<button class="btn-remove dropdown-item" type="submit"><i class="ti-trash"></i> {{ _lang('Delete') }}</button>
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