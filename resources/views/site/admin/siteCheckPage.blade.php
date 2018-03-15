
<!-- extends file: resources/view/layout/master.blade.php -->
@extends('layout.master')

@section('unit', $unit)

@section('content')
	
	<div class="page-title">
		<h2><b>  </b> &nbsp &nbsp 場地申請審核 </h2><br>
	</div>
	<div class="col-md-12">
		<div class="table-responsive">
			<table class="table table-bordered table-fixed">
					<thead>
						<tr>
							<th> <h5> 狀態 </h5> </th>
							<th> <h5> 借用日期 </h5> </th>
							<th> <h5> 借用時間 </h5> </th>
							<th> <h5> 借用場地 </h5> </th>
							<th> <h5> 場地負責人 </h5> </th>
							<th> <h5> 二級主管 </h5> </th>
							<th> <h5> 一級主管 </h5> </th>
							<th> <h5> </h5> </th>
						</tr>
					</thead>
					<tbody>
					@if($checkList)
						@foreach($checkList as $check)
						<tr>
							<td> <h5> {{ $check['state'] }} </h5></td>
							<td> <h5> {{ $check['date'] }} </h5> </td>
							<td> <h5> {{ $check['time'] }} </h5> </td>
							<td> <h5> {{ $check['room'] }} </h5> </td>
							<td> <h5> {{ $check['level1'] }} </h5> </td>
							<td> <h5> {{ $check['level2'] }} </h5> </td>
							<td> <h5> {{ $check['level3'] }} </h5> </td>
							<td> 
								<a class="btn btn-info" href="{{ route('viewApply', [$unit,$check['aid']]) }}"> 內容 </a>
								@if($check['state'] == '刪除中')
								<a class="btn btn-danger" href="{{ route('deleteApply', [$unit,$check['aid']]) }}" onclick="return confirm('確認「刪除」?');"> 刪除 </a>
								@elseif($check['check'])
								<a class="btn btn-success" href="{{ route('passApply', [$unit,$check['aid']]) }}" onclick="return confirm('確認「通過」?');"> 通過 </a>
								<a class="btn btn-danger" href="{{ route('nopassApply', [$unit,$check['aid']]) }}" onclick="return confirm('確認「不通過」?');"> 不通過 </a>
								@endif
							</td>
						</tr>
						@endforeach
					@else
						<td colspan="8"> <h5> 尚無審核資料 </h5></td>
					@endif
					</tbody>
				</table>
		</div>
	</div>

	<br><br><br><br>

	<div class="page-title">
		<h2><b>  </b> &nbsp &nbsp 場地已審核 </h2><br>
	</div>
	<div class="col-md-12">
		<div class="table-responsive">
			<table class="table table-bordered table-fixed">
					<thead>
						<tr>
							<th> <h5> 狀態 </h5> </th>
							<th> <h5> 借用日期 </h5> </th>
							<th> <h5> 借用時間 </h5> </th>
							<th> <h5> 借用場地 </h5> </th>
							<th> <h5> 場地負責人 </h5> </th>
							<th> <h5> 二級主管 </h5> </th>
							<th> <h5> 一級主管 </h5> </th>
							<th> <h5> </h5> </th>
						</tr>
					</thead>
					<tbody>
					@if($passList)
						@foreach($passList as $pass)
						<tr>
							<td> <h5> {{ $pass['state'] }} </h5></td>
							<td> <h5> {{ $pass['date'] }} </h5> </td>
							<td> <h5> {{ $pass['time'] }} </h5> </td>
							<td> <h5> {{ $pass['room'] }} </h5> </td>
							<td> <h5> {{ $pass['level1'] }} </h5> </td>
							<td> <h5> {{ $pass['level2'] }} </h5> </td>
							<td> <h5> {{ $pass['level3'] }} </h5> </td>
							<td> 
								<a class="btn btn-info" href="{{ route('viewApply', [$unit,$pass['aid']]) }}"> 內容 </a>
							</td>
						</tr>
						@endforeach
					@else
						<td colspan="8"> <h5> 尚無已審核資料 </h5></td>
					@endif
					</tbody>
				</table>
		</div>
	</div>
@endsection