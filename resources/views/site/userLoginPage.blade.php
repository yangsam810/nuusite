
<!-- extends file: resources/view/layout/master.blade.php -->
@extends('layout.master')

@section('unit', $unit)

@section('content')
	<div class="col-md-10 col-md-offset-1 col-sm-12">
		<div class="text-center page-title">
			<h2><b>聯合大學 </b>場地借用登入</h2><br>
		</div>
		<div class="col-md-6 col-md-offset-3">
		<div class="box-for overflow">
			<div class="col-md-12 col-xs-12 register-blocks">
				<form method="POST" action="/site/{{ $unit }}/user/submitLogin">	
					{{ csrf_field() }}
					<div class="form-group">
						<label for="account"> 帳號* </label>
						<input type="text" class="form-control" name="account" required>
					</div>
					<div class="form-group">
						<label for="password"> 密碼* </label>
						<input type="password" class="form-control" name="password" required>
					</div>
					<div class="form-group">
						<a href="javascript:forgetPassword()">校外人士?</a>
						<p id="forgetPassword"></p>
					</div>
					<div class="col-sm-12 text-center">
						<button type="submit" class="btn btn-default"> 確定 </button>
					</div>
				</form>
			</div>
		</div>
		</div>
	</div>
	<script>
		function forgetPassword()
		{
			document.getElementById("forgetPassword").innerHTML = "請向 {{ $name }} 申請!!";
		}
	</script>
@endsection