<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class UserController extends Controller
{
	public function userLogin(Request $request, $unit)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "http://nuucloud.com:8007/userLoginTest.php");
		curl_setopt($ch, CURLOPT_POST, true); // 啟用POST
		curl_setopt($ch, CURLOPT_RETURNTRANSFER , 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query( array( "account"=>$request['account'], "password"=>$request['password']))); 
		$result = curl_exec($ch);
		curl_close($ch);
		
		$result = json_decode($result, TRUE);
		
		if($result)
		{
			session()->put('userLogin', true);
			
			$unt 	= $this->getUnit($unit);
			$level	= $this->getManagers($unt->name);
			$admin	= false;
			if($result['ldap_id'] == $level['一級主管']['信箱'])
			{
				session()->put('adminUnit', $unit);
				session()->put('adminLogin', true);
				session()->put('adminLevel', 3);
				$admin = true;
			}
			else if($result['ldap_id'] == $level['二級主管']['信箱'])
			{
				session()->put('adminUnit', $unit);
				session()->put('adminLogin', true);
				session()->put('adminLevel', 2);
				$admin = true;
			}
			else if($this->admin($unit, $result['ldap_id']))
			{
				session()->put('adminUnit', $unit);
				session()->put('adminLogin', true);
				session()->put('adminLevel', 1);
				$admin = true;
			}
			
			session()->put('account', $result['ldap_id']);
			session()->put('userName', $result['name']);
			
			if($admin)
				return redirect('/site/'.$unit.'/check');
		
			// 重新導向原先使用者造訪頁面
			return  redirect()->intended('/site/'.$unit.'/rule');
		}
		else
		{
			return redirect('/site/'.$unit.'/login');
		}
	}
	
	public function userLogout($unit)
	{
		session()->flush();
		return redirect('/site/'.$unit.'/rule');
	}
	
	// Table 'units'
	public function getUnit($unit)
    {
		$unt = DB::table('units')->where('unit', $unit)
								 ->first();
		return $unt;
	}
	
	public function admin($unit, $ladpId)
	{
		$unt = $this->getUnit($unit);
		$admin = DB::table('users')->where('untid', $unt->untid)
								   ->where('ldap_id', $ladpId)
								   ->first();
		if($admin) return true;
		return false;
	}
	
	// 人事組織架構：取得個人資料
	public function getInfo($ldapId)
    {
		$ch = curl_init();
		$account = 'nUusiTe';
		$password = 'z4SBHVtrKRYpsXPy';
		curl_setopt($ch, CURLOPT_URL, "http://120.105.144.15/sign/api/getInfo.php");
		curl_setopt($ch, CURLOPT_POST, true); // 啟用POST
		curl_setopt($ch, CURLOPT_RETURNTRANSFER , 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query( array( "ldap_id"=>$ldapId, "account"=>$account, "password"=>$password))); 
		$result = curl_exec($ch);
		curl_close($ch);
		
		return json_decode($result, TRUE);
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
