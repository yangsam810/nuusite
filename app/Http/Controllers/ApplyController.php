<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use DB;

class ApplyController extends Controller
{
	/**
	 * 申請場地借用
	 */
	public function store(Request $request, $unit)
	{
		// 驗證時段是否重複
		$error = false;
		$applies = $this->getApplies($unit, $request['date'], $request['room']);
		foreach($applies as $apply)
		{
			// 判斷「審核中」及「通過」的表單
			if($apply->state == 'c' || $apply->state == 'p')
			{
				$t = explode(':', $apply->tid);
				// 申請的「開始時段」已被借用
				if($request['timeStart'] >= $t[0] && $request['timeStart'] <= $t[1])
				{
					$error = true;
					break;
				}
				// 申請的「結束時段」已被借用
				if($request['timeEnd'] >= $t[0] && $request['timeEnd'] <= $t[1])
				{
					$error = true;
					break;
				}
			}
		}
		if($error)
		{
			$errorMsg = [
				'msg' => [
					'申請時段重複!!',
				],
			];
			return redirect('/site/'.$unit.'/apply')->withErrors($errorMsg)
													->withInput();
		}
		
		
		date_default_timezone_set('Asia/Taipei');
		$unt = $this->getUnit($unit);
		
        $newApply = new \App\Apply();
		$newApply->untid 	= $unt->untid;
		$newApply->account 	= session()->get('account');
		$newApply->date 	= $request->get('date');
		$newApply->tid 		= $request->get('timeStart').":".$request->get('timeEnd');
		$newApply->rid 		= $request->get('room');
		$newApply->name 	= $request->get('name');
		$newApply->phone 	= $request->get('phone');
		$newApply->presenter= $request->get('presenter');
		$newApply->reason 	= $request->get('reason');
        $newApply->people 	= $request->get('count');
        $newApply->remark 	= $request->get('remark');

		$newApply->save();
		
		$admin = $this->getAdmin($unit, 1);
		$this->sendMail($admin);
		
		return redirect('/site/'.$unit.'/success/'.$newApply->id);
	} 
	
	public function cancel($unit, $id)
	{
		$apply = \App\Apply::where('aid', '=', $id)->update(['state' => 'd']);
		$apply = \App\Apply::where('aid', '=', $id)->update(['check_level' => 0]);
		$admin = $this->getAdmin($unit, 1);
		$this->sendMail($admin);
		
		return  redirect('/site/'.$unit.'/state');
	} 
	
	public function del($unit, $id)
	{
		$apply = \App\Apply::where('aid', '=', $id)->update(['state' => 'x']);
		
		return  redirect('/site/'.$unit.'/check');
	} 
	
	public function pass($unit, $id)
	{
		$apply = \App\Apply::where('aid', '=', $id)->increment('check_level');
		$apply = $this->getApply($id);
		$room = $this->getRoom($apply->rid);
		if($room->level == $apply->check_level)
		{
			$apply = \App\Apply::where('aid', '=', $id)->update(['state' => 'p']);
		}
		else
		{
			$admin = $this->getAdmin($unit, $apply->check_level);
			$this->sendMail($admin);
		}
		
		return  redirect('/site/'.$unit.'/check');
	} 
	
	public function nopass($unit, $id)
	{
		$apply = \App\Apply::where('aid', '=', $id)->increment('check_level');
		$apply = \App\Apply::where('aid', '=', $id)->update(['state' => 'n']);
		
		return  redirect('/site/'.$unit.'/check');
	} 
	
	// Table 'units'
	public function getUnit($unit)
    {
		$unt = DB::table('units')->where('unit', $unit)
								 ->first();
		return $unt;
	}
	
	// Table 'rooms'
	public function getRoom($rid)
    {
		$room = DB::table('rooms')->where('rid', $rid)
								  ->first();
		return $room;
	}
		
	// Table 'applies'
	public function getApplies($unit, $date, $room)
    {
		$unt = $this->getUnit($unit);
		$applys = DB::table('applies')->where('untid', $unt->untid)
									  ->where('date', $date)
									  ->where('rid', $room)
									  ->select(['tid','state'])
									  ->get();
		return $applys;
	}
	
	public function getApply($aid)
    {
		$apply = DB::table('applies')->where('aid', $aid)
									 ->first();
		return $apply;
	}
	
	public function getAdmin($unit, $level)
	{
		$admin = null;
		
		switch($level)
		{
			case(1):
				$unt = $this->getUnit($unit);
				$admin = DB::table('users')->where('untid', $unt->untid)
										   ->first();
				$admin = $admin->ldap_id;
				break;
				
			case(2):
				$unt = $this->getUnit($unit);
				$supervisor = $this->getManagers($unt->name);
				$admin = $supervisor['二級主管']['信箱'];
				break;
			
			case(3):
				$unt = $this->getUnit($unit);
				$supervisor = $this->getManagers($unt->name);
				$admin = $supervisor['一級主管']['信箱'];
				break;
		}
		
		
		return $admin;
	}
	
	public function sendMail($admin)
    {/*
		$account   = 'nUusiTe';
		$password  = 'z4SBHVtrKRYpsXPy';
		$subject   = '場地審核通知';
		$content   = '您有 1 則 場地審核通知<br><br> 請至 <a href="http://120.105.129.101/site/gaffairs/login"> 場地借用系統 </a> 進行審核。<br><br>(此為系統發出的告知郵件，請勿直接回覆！)';
		$reply	   = null;
		
		$recipient = array("u0324039@smail.nuu.edu.tw");
		$recipient = json_encode($recipient);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "http://120.105.144.15/sendmail.php");
		curl_setopt($ch, CURLOPT_POST, true); // 啟用POST
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query( array( "subject"=>$subject, "content"=>$content, "recipient"=>$recipient, "account"=>$account, "password"=>$password, "reply"=>$reply))); 
		curl_exec($ch); 
		curl_close($ch);*/
	}
	
	// 人事組織架構：取得單位主管資料
	public function getManagers($unit)
    {
		$ch = curl_init();
		$account = 'nUusiTe';
		$password = 'z4SBHVtrKRYpsXPy';
		curl_setopt($ch, CURLOPT_URL, "http://120.105.144.15/sign/api/getManagers.php");
		curl_setopt($ch, CURLOPT_POST, true); // 啟用POST
		curl_setopt($ch, CURLOPT_RETURNTRANSFER , 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query( array( "unit"=>$unit, "account"=>$account, "password"=>$password))); 
		$result = curl_exec($ch);
		curl_close($ch);
		
		return json_decode($result, TRUE);
	}
}
