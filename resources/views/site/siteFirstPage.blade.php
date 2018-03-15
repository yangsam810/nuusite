
<!-- extends file: resources/view/apply/layout/master.blade.php -->
@extends('apply.layout.master')

@section('content')

	<div class="text-center page-title">
		<h2><b>二坪校區 </b>場地租借情況</h2><br>
	</div>
	<div class="col-sm-12 col-md-12">
		<form action="" class="form-inline">
			<label> <h5>查詢時間: </h5></label>
			<div class="form-group">                                   
				<input type="date" id="date" min="2014-09-01" max="2014-10-31" required>
			</div> 
			<button class="btn search-btn" type="submit"><i class="fa fa-search"></i></button>
		</form>
	</div><br><br>
	<div class="col-md-12">
		<table class="table table-bordered">
		  <thead>
				<tr>
					<th> <h4>時間</h4> </th>
					@foreach($rooms as $room)
					<th> <h4> {{ $room->room }} </h4> </th>
					@endforeach
				</tr>
			</thead>
			<tbody>
				@foreach($TimeList as $time)
				<tr>	
					<td> <h5> {{ $time['range'] }} </h5> </td>
					<td class="warning"> <h5></h5> </td>
					<td> <h5></h5> </td>
					<td> <h5></h5> </td>
					<td> <h5></h5> </td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>

@endsection