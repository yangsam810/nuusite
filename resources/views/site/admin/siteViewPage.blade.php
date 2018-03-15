
<!-- extends file: resources/view/layout/master.blade.php -->
@extends('layout.master')

@section('unit', $unit)

@section('content')
	
	<div class="text-center page-title">
		<h2><b>  </b>場地借用資料</h2><br>
	</div>
	<div class="col-md-12">
		<div class="table-responsive">
			<div class="col-md-8 col-md-offset-2">
				<table class="table table-bordered table-fixed">
					<tbody>
						<tr>
							<td> <h5> 申請人姓名 </h5> </td>
							<td> <h5> {{ $apply['account'] }} </h5> </td>
							<td> <h5> 申請人電話 </h5> </td>
							<td> <h5> {{ $apply['phone'] }} </h5> </td>
						</tr>
						<tr>
							<td> <h5> 借用日期 </h5> </td>
							<td> <h5> {{ $apply['date'] }} </h5> </td>
							<td> <h5> 借用時間 </h5> </td>
							<td> <h5> {{ $apply['time'] }} </h5> </td>
						</tr>
						<tr>
							<td> <h5> 會議主持人 </h5> </td>
							<td> <h5> {{ $apply['presenter'] }} </h5> </td>
							<td> <h5> 會議室 </h5> </td>
							<td> <h5> {{ $apply['room'] }} </h5> </td>
						</tr>
						<tr>
							<td> <h5> 預估參加人數 </h5> </td>
							<td> <h5> {{ $apply['people'] }} </h5> </td>
							<td colspan="2"> <h5>  </h5> </td>
						</tr>
						<tr>
							<td> <h5> 事由 </h5> </td>
							<td colspan="3"> <h5> {{ $apply['reason'] }} </h5> </td>
						</tr>
						<tr>
							<td> <h5> 備註 </h5> </td>
							<td colspan="3"> <h5> {{ $apply['remark'] }} </h5> </td>
						</tr>
					</tbody>
				</table>
				<br>
				<div class="col-sm-12 text-center">
					<button onclick="javascript:history.go(-1);" class="btn btn-default"> 返回 </button>
				</div>
				<br>
			</div>
		</div>
	</div>

@endsection