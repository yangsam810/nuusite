
<!-- extends file: resources/view/layout/master.blade.php -->
@extends('layout.master')

@section('unit', $unit)

@section('content')

	<div class="col-md-10 col-md-offset-1 col-sm-12">
		<div class="text-center page-title">
			<h2><b>聯合大學 </b>場地申請</h2><br>
		</div>
		<div class="col-md-10 col-md-offset-1">
		<div class="box-for overflow">
			<div class="col-md-12 col-xs-12 register-blocks">
				
				@if($errors->count() >0)
				<div class="alert alert-danger" role="alert">
					<ul>
						@foreach($errors->all() as $error)
						<li> {{ $error }}</li>
						@endforeach
					</ul>
				</div>
				@endif
				
				
				<form method="POST" action="/site/{{ $unit }}/apply/submit">	
					{{ csrf_field() }}
					<div class="controls">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="form_date">借用日期 *</label>
									<input class="form-control" type="date" name="date" value="{{ old('date') }}" min="{{ $nowDate }}" max="{{ $deadline }}" required="required">
									<div class="help-block with-errors"></div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="form_time">借用時間 *</label>
									<div class="row">
										<div class="col-md-6" >
											<select class="form-control" name="timeStart" required="required">
												<option value="">開始時間 *</option>
												@foreach($timeList as $time)
												<option value="{{ $time['tid']}}" <?php if(old('timeStart') == $time['tid']) echo 'selected';?>> {{ $time['start'] }}</option>
												@endforeach
											</select>
										</div>
										<div class="col-md-6" >
											<select class="form-control" name="timeEnd" required="required">
												<option value="">結束時間 *</option>
												@foreach($timeList as $time)
												<option value="{{ $time['tid']}}" <?php if(old('timeEnd') == $time['tid']) echo 'selected';?> > {{ $time['end'] }}</option>
												@endforeach
											</select>
										</div>
										<div class="help-block with-errors"></div>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="form_account">申請人姓名 *</label>
									<input class="form-control" type="text" name="name" value="{{ old('name') }}" >
									<div class="help-block with-errors"></div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="form_phone">申請人電話 *</label>
									<input class="form-control" type="text" name="phone" value="{{ old('phone') }}" required="required">
									<div class="help-block with-errors"></div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="form_presenter">會議主持人* </label>
									<input class="form-control" type="text" name="presenter" value="{{ old('presenter') }}" required="required">
									<div class="help-block with-errors"></div>
								</div>
							</div>
							<div class="col-md-6" name="room">
								<label for="form_time">會議室 *</label>
								<select class="form-control" name="room" required="required">
									<option value="">會議室 *</option>
									@foreach($room1List as $room)
									<option value="{{ $room['rid']}}" <?php if(old('room') == $room['rid']) echo 'selected';?> > {{ $room['name'] }}</option>
									@endforeach
									@foreach($room2List as $room)
									<option value="{{ $room['rid']}}" <?php if(old('room') == $room['rid']) echo 'selected';?> > {{ $room['name'] }}</option>
									@endforeach
								</select>
								<div class="help-block with-errors"></div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label for="form_cnt">預估參加人數 *</label>
									<input class="form-control" type="text" name="count" value="{{ old('count') }}" required="required">
									<div class="help-block with-errors"></div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label for="form_reason">事由 *</label>
									<input class="form-control" type="text" name="reason" value="{{ old('reason') }}" rows="3" placeholder="請簡述申請原因 (100字以內)。" required="required">
									<div class="help-block with-errors"></div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label for="form_remark">備註</label>
									<input class="form-control" type="text" name="remark" value="{{ old('remark') }}" rows="3" placeholder="備註說明 (100字以內)。" >
									<div class="help-block with-errors"></div>
								</div>
							</div>
							<div class="col-md-12">
								<input type="submit" class="btn btn-primary btn-send" value="確認申請" onclick="return confirm('送出後無法再修改，確認送出申請?')">
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
		</div>
	</div>

	<script>


	</script>
	
@endsection

