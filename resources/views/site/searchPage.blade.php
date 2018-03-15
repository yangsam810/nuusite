
<!-- extends file: resources/view/layout/master.blade.php -->
@extends('layout.master')

@section('unit', $unit)

@section('content')

	<div class="text-center page-title">
		<h2><b> {{ $title }} </b>場地租借情況</h2><br>
	</div>
	<div class="col-sm-12 col-md-12">
		<form method="POST" action="/site/{{ $unit }}/{{ $schoolSite }}/search" class="form-inline">
			{{ method_field('get') }}
			{{ csrf_field() }}
			<label> <h5>查詢時間: </h5></label>
			<div class="form-group">                                   
				<input type="date" name="date" value="{{ $search }}" min="{{ $nowDate }}" max="{{ $deadline }}" required>
			</div> 
			<button class="btn search-btn" type="submit"><i class="fa fa-search"></i></button>
		</form>
	</div><br><br>
	<div class="col-md-12">
		<div class="table-responsive">
			<table class="table table-bordered table-fixed">
				<thead>
					<tr>
						<th> <h4>時間</h4> </th>
						@foreach($roomList as $room)
						<th> <h4> {{ $room['room'] }} </h4> </th>
						@endforeach
					</tr>
				</thead>
				<tbody>
					@foreach($TimeList as $time)
					<tr>	
						<td> <h5> {{ $time['range'] }} </h5> </td>
						@foreach($roomList as $room)
							@if(in_array($room['rid'], $time['room']))
								<td class="warning"> <h5></h5> </td>
							@else
								<td> <h5></h5> </td>
							@endif
						@endforeach
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>

@endsection

