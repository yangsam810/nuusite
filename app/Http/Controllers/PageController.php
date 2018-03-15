<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class PageController extends Controller
{

	public function selet($unit)
    {
		return view('site.userLoginPage.')->with('unit', $unt->unit);
    }
	
	
	/**
     * Page direct to 'site/rulePage/UNITNAME.blade.php'
     */
	public function siteRulePage($unit)
    {
		$unt = $this->getUnit($unit);
		
		return view('site.rulePage.'.$unt->unit)->with('unit', $unt->unit)
												->with('name', $unt->name);
    }
	
	/**
     * 場地查詢頁面 'site/rulePage/UNITNAME.blade.php'
	 * 
	 * $unit 		: 單位
	 * $schoolSite 	: 校區
	 * $request->get('date') : 查詢時間
	 * 
     */
	public function siteSearchPage(Request $request, $unit, $schoolSite)
    {
		// $unit exists or not
		$unt = $this->getUnit($unit);
		if(!$unt) $this->NotFoundPage();
		
		// $schoolSite exists or not
		if($schoolSite != 1 && $schoolSite != 2) $this->NotFoundPage();

		
		$title 	= ($schoolSite == 1)?'二坪校區':'八甲校區';
		$nowDate 	= $this->getNowDate();
		$deadline	= $this->getDeadline();
		
		$rooms	  = $this->getRooms($unit, $schoolSite);
		$roomList = $rooms->map(function ($room){
			return [
				'rid'	=> $room->rid,
				'room'	=> $room->room,
			];
		});
		
		// Search time -> default now date
		$searchTime = $nowDate;
		if($request->get('date')) $searchTime = $request->get('date');
		
		$times	  = $this->getTimes($unit);
		$applies  = $this->getApplies($unit, $searchTime);
		$timeList = [];
		foreach($times as $time)
		{
			$room = [];
			if($applies)
			{
				foreach($applies as $apply)
				{
					if($apply->state == 'c' || $apply->state == 'p')
					{
						$t = explode(':', $apply->tid);
						if($time->tid >= $t[0] && $time->tid <= $t[1])
						{
							$room[] = $apply->rid;
						}
					}
				}
			}
			$timeList[] = [
				'time' 	=> $time->start,
				'range' => $time->start.":00 ~ ".$time->end.":00",
				'room'  => $room,
			]; 
		}
		
		return view('site.searchPage', [
			'title' 	=> $title,
			'nowDate'	=> $nowDate,
			'deadline'	=> $deadline,
			'roomList' 	=> $roomList,
			'TimeList' 	=> $timeList,
			'unit' 		=> $unit,
			'schoolSite'=> $schoolSite,
			'search'	=> $searchTime,
		]);
    }
	
	/**
     * Page direct to 'site/userLoginPage.blade.php'
     */
	public function userLoginPage($unit)
    {
		$unt = $this->getUnit($unit);
		if($unt)
		{
			return view('site.userLoginPage')->with('name', $unt->name)
											 ->with('unit', $unit);
		}
		else
		{
			return view('apply.NotFoundPage');
		}
    }
	
	/**
     * Page direct to 'site/admin/siteApplyPage.blade.php'
     */
	public function siteApplyPage($unit)
    {
		$nowDate 	= $this->getNowDate();
		$deadline 	= $this->getDeadline();
		
		$times 	  = $this->getTimes($unit);
		$timeList = $times->map(function ($t){
			return [
				'tid' 	=> $t->tid,
				'start' => $t->start.":00",
				'end' 	=> $t->end.":00",
			];
		});
		
		$room1Site = $this->getRooms($unit, 1);
		$room2Site = $this->getRooms($unit, 2);
		$room1List = $room1Site->map(function ($room){
			return [
				'rid' 	=> $room->rid,
				'name'	=> '(二坪校區) '.$room->room,
			];
		});
		$room2List = $room2Site->map(function ($room){
			return [
				'rid' 	=> $room->rid,
				'name'	=> '(八甲校區) '.$room->room,
			];
		});
		
		return view('site.admin.siteApplyPage', [
			'timeList'	=> $timeList,
			'room1List' => $room1List,
			'room2List' => $room2List,
			'nowDate' 	=> $nowDate,
			'deadline' 	=> $deadline,
			'unit'		=> $unit,
		]);
    }
	
	/**
     * Page direct to 'site/admin/siteApplyPage.blade.php'
     */
	public function siteStatePage($unit)
    {
		$nowDate = $this->getNowDate();
		$applies = $this->getUserApplies($unit, session()->get('account'));
		$checkList = [];
		$passList  = []; 

		foreach($applies as $apply)
		{
			if( strtotime($apply->date) >= strtotime($nowDate) )
			{
				$room  = $this->getRoom($apply->rid);
				$time = explode(":", $apply->tid);
				$timeStart = $this->getTime($time[0]);
				$timeEnd   = $this->getTime($time[1]);
				
				$state = null;
				switch($apply->state){
					case('c'):
						$state = '審核中';
						break;

					case('d'):
						$state = '刪除中';
						break;
					
					case('p'):
						$state = '通過';
						break;
					
					case('n'):
						$state = '未通過';
						break;
				}
				
				$level1 = $this->strLevel($apply->state, $apply->check_level, 1);
				$level2 = $this->strLevel($apply->state, $apply->check_level, 2);
				$level3 = $this->strLevel($apply->state, $apply->check_level, 3);
				
				$checkList[] = [
					'aid' 	=> $apply->aid,
					'level' => $room->level,
					'state' => $state,
					'check_level' => $apply->check_level,
					'date'	=> $apply->date,
					'room'	=> (($room->site == 1)?'(二坪)':'(八甲)').$room->room,
					'time'	=> $timeStart->start.":00 ~ ".$timeEnd->end.':00', 
					'level1'=> $level1,
					'level2'=> $level2,
					'level3'=> $level3,
				];
			}
		}
		
		return view('site.admin.siteStatePage', [
			'checkList' => $checkList,
			'unit'		=> $unit,
		]);
    }
	
	/**
     * Page direct to 'site/admin/siteApplyPage.blade.php'
     */
	public function siteCheckPage($unit)
    {
		$nowDate = $this->getNowDate();
		$applies = $this->getChecks($unit, $nowDate);
		$checkList = [];
		$passList  = []; 

		foreach($applies as $apply)
		{
			$room  = $this->getRoom($apply->rid);
			$time = explode(":", $apply->tid);
			$timeStart = $this->getTime($time[0]);
			$timeEnd   = $this->getTime($time[1]);
			
			$state = null;
			switch($apply->state){
				case('c'):
					$state = '審核中';
					break;

				case('d'):
					$state = '刪除中';
					break;
				
				case('p'):
					$state = '通過';
					break;
				
				case('n'):
					$state = '未通過';
					break;
			}
			
			$level1 = $this->strLevel($apply->state, $apply->check_level, 1);
			$level2 = $this->strLevel($apply->state, $apply->check_level, 2);
			$level3 = $this->strLevel($apply->state, $apply->check_level, 3);
			$check  = ($apply->check_level == session()->get('adminLevel')-1)? true: false;
			
			if($check)
			{
				$checkList[] = [
					'aid' 	=> $apply->aid,
					'level' => $room->level,
					'state' => $state,
					'check' => $check,
					'date'	=> $apply->date,
					'room'	=> (($room->site == 1)?'(二坪)':'(八甲)').$room->room,
					'time'	=> $timeStart->start.":00 ~ ".$timeEnd->end.':00', 
					'level1'=> $level1,
					'level2'=> $level2,
					'level3'=> $level3,
				];
			}
			else
			{
				$passList[] = [
					'aid' 	=> $apply->aid,
					'level' => $room->level,
					'state' => $state,
					'date'	=> $apply->date,
					'room'	=> (($room->site == 1)?'(二坪)':'(八甲)').$room->room,
					'time'	=> $timeStart->start.":00 ~ ".$timeEnd->end.':00', 
					'level1'=> $level1,
					'level2'=> $level2,
					'level3'=> $level3,
				];
			}
			
		}
		
		return view('site.admin.siteCheckPage', [
			'checkList' => $checkList,
			'passList'	=> $passList,
			'unit'		=> $unit,
		]);
    }
	
	/**
     * Page direct to 'site/admin/siteViewPage.blade.php'
     */
	public function siteViewPage($unit, $aid)
    {
		$apply 	= $this->getApply($aid);
		$tid 	= explode(":", $apply->tid);
		$start	= $this->getTime($tid[0])->start;
		$end	= $this->getTime($tid[1])->end;
		$room 	= $this->getRoom($apply->rid);
		
		$applyList = [
			'account'	=> $apply->account,
			'phone'		=> $apply->phone,
			'date'		=> $apply->date,
			'time'		=> $start.':00 ~ '.$end.":00",
			'presenter'	=> $apply->presenter,
			'room'		=> $room->room,
			'people'	=> $apply->people,
			'reason'	=> $apply->reason,
			'remark'	=> $apply->remark,
		];
		
		return view('site.admin.siteViewPage', [
			'apply' => $applyList,
			'unit' 	=> $unit,
		]);
    }
	
	public function siteSuccessPage($unit, $aid)
    {
		$apply 	= $this->getApply($aid);
		$tid 	= explode(":", $apply->tid);
		$start	= $this->getTime($tid[0])->start;
		$end	= $this->getTime($tid[1])->end;
		$room 	= $this->getRoom($apply->rid);
		
		$applyList = [
			'account'	=> $apply->account,
			'phone'		=> $apply->phone,
			'date'		=> $apply->date,
			'time'		=> $start.':00 ~ '.$end.":00",
			'presenter'	=> $apply->presenter,
			'room'		=> $room->room,
			'people'	=> $apply->people,
			'reason'	=> $apply->reason,
			'remark'	=> $apply->remark,
		];
		
		return view('site.admin.siteSuccessPage', [
			'apply' => $applyList,
			'unit' 	=> $unit,
		]);
    }
	
	
	public function siteHistoryPage($unit)
    {
		$title = '歷史紀錄';
		$nowDate = $this->getNowDate();
		$applies = $this->getUserHistory($unit, session()->get('account'));
		$checkList = [];

		foreach($applies as $apply)
		{
			$room  = $this->getRoom($apply->rid);
			$time = explode(":", $apply->tid);
			$timeStart = $this->getTime($time[0]);
			$timeEnd   = $this->getTime($time[1]);
			
			$state = null;
			switch($apply->state){
				case('c'):
					$state = '審核中';
					break;

				case('d'):
					$state = '刪除中';
					break;
				
				case('p'):
					$state = '通過';
					break;
				
				case('n'):
					$state = '未通過';
					break;
			}
			
			$level1 = $this->strLevel($apply->state, $apply->check_level, 1);
			$level2 = $this->strLevel($apply->state, $apply->check_level, 2);
			$level3 = $this->strLevel($apply->state, $apply->check_level, 3);
			
			$checkList[] = [
				'aid' 	=> $apply->aid,
				'level' => $room->level,
				'state' => $state,
				'check_level' => $apply->check_level,
				'date'	=> $apply->date,
				'room'	=> (($room->site == 1)?'(二坪)':'(八甲)').$room->room,
				'time'	=> $timeStart->start.":00 ~ ".$timeEnd->end.':00', 
				'level1'=> $level1,
				'level2'=> $level2,
				'level3'=> $level3,
			];
		}
		
		return view('site.admin.siteHistoryPage', [
			'title'		=> $title,
			'checkList' => $checkList,
			'unit'		=> $unit,
		]);
    }
	
	
	public function siteAdminHistoryPage($unit)
    {
		$title = '所有紀錄';
		$applies = $this->getAdminHistory($unit);
		$checkList = [];

		foreach($applies as $apply)
		{
			$room  = $this->getRoom($apply->rid);
			$time = explode(":", $apply->tid);
			$timeStart = $this->getTime($time[0]);
			$timeEnd   = $this->getTime($time[1]);
			
			$state = null;
			switch($apply->state){
				case('c'):
					$state = '審核中';
					break;

				case('d'):
					$state = '刪除中';
					break;
				
				case('p'):
					$state = '通過';
					break;
				
				case('n'):
					$state = '未通過';
					break;
			}
			
			$level1 = $this->strLevel($apply->state, $apply->check_level, 1);
			$level2 = $this->strLevel($apply->state, $apply->check_level, 2);
			$level3 = $this->strLevel($apply->state, $apply->check_level, 3);
			
			$checkList[] = [
				'aid' 	=> $apply->aid,
				'level' => $room->level,
				'state' => $state,
				'check_level' => $apply->check_level,
				'date'	=> $apply->date,
				'room'	=> (($room->site == 1)?'(二坪)':'(八甲)').$room->room,
				'time'	=> $timeStart->start.":00 ~ ".$timeEnd->end.':00', 
				'level1'=> $level1,
				'level2'=> $level2,
				'level3'=> $level3,
			];
		}
		
		return view('site.admin.siteHistoryPage', [
			'title'		=> $title,
			'checkList' => $checkList,
			'unit'		=> $unit,
		]);
    }
	
	
	/**
     * Page direct to 'errors/404.blade.php'
     */
	public function NotFoundPage()
    {
		return view('errors.404');
    }

	

	public function getUnit($unit)
    {
		$unt = DB::table('units')->where('unit', $unit)
								 ->first();
		return $unt;
	}
	
	public function getTime($tid)
    {
		$time = DB::table('times')->where('tid', $tid)
								  ->first();
		return $time;
	}
	
	public function getTimes($unit)
    {
		$unt = $this->getUnit($unit);
		$times = DB::table('times')->where('untid', $unt->untid)
								   ->orderBy('start')
								   ->get();
		return $times;
	}
	
	public function getRoom($rid)
    {
		$room = DB::table('rooms')->where('rid', $rid)
								  ->first();
		return $room;
	}
	
	public function getRooms($unit, $schoolSite)
    {
		$unt = $this->getUnit($unit);
		$rooms = DB::table('rooms')->where('untid', $unt->untid)
								   ->where('site', $schoolSite)
								   ->select('rid', 'room')
								   ->orderBy('level', 'room')
								   ->get();
		return $rooms;
	}
	
	public function getApply($aid)
    {
		$apply = DB::table('applies')->where('aid', $aid)
									 ->first();
		return $apply;
	}

	public function getApplies($unit, $date)
    {
		$unt = $this->getUnit($unit);
		$applys = DB::table('applies')->where('untid', $unt->untid)
									  ->where('date', $date)
									  ->get();
		return $applys;
	}
	
	public function getChecks($unit, $date)
    {
		$unt = $this->getUnit($unit);
		$applys = DB::table('applies')->where('untid', $unt->untid)
									  ->where('date', ">=", $date)
									  ->where('state', '!=', "x")
									  ->where('check_level', '>=', session()->get('adminLevel') - 1)
									  ->orderBy('state')
									  ->get();
		return $applys;
	}
		
	public function getUserApplies($unit, $account)
    {
		$unt = $this->getUnit($unit);
		$applys = DB::table('applies')->where('untid', $unt->untid)
									  ->where('account', $account)
									  ->where('state', '!=', "x")
									  ->orderBy('state')
									  ->get();
		return $applys;
	}
	
	public function getUserHistory($unit, $account)
    {
		$unt 	= $this->getUnit($unit);
		$nowDate= $this->getNowDate();
		$applys = DB::table('applies')->where('untid', $unt->untid)
									  ->where('account', $account)
									  ->where('date', '<', $nowDate)
									  ->where('state', '!=', "x")
									  ->get();
		return $applys;
	}
	
	public function getAdminHistory($unit)
    {
		$unt 	= $this->getUnit($unit);
		$nowDate= $this->getNowDate();
		$applys = DB::table('applies')->where('untid', $unt->untid)
									  ->where('date', '<', $nowDate)
									  ->where('state', '!=', "x")
									  ->get();
		return $applys;
	}
	
	public function getNowDate()
    {
		date_default_timezone_set('Asia/Taipei');
		$nowDate = date('Y-m-d');
		
		return $nowDate;
	}
	
	public function getDeadline()
    {
		date_default_timezone_set('Asia/Taipei');
		$range = strtotime("+6 Months");
		$deadline = date('Y-m-d', $range);
		
		return $deadline;
	}
	
	public function strLevel($state, $check_level, $level)
	{
		$str = null;
		switch($state){
			case('c'):
				if($check_level >= $level)
					$str = '通過';
				else if($check_level == $level-1)
					$str = '審核中';
				break;

			case('d'):
				if($level == 0)
					$str = '刪除中';
				break;
			
			case('p'):
				if($check_level >= $level)
					$str = '通過';
				break;
			
			case('n'):
				if($check_level == $level)
					$str = '未通過';
				else if($check_level > $level)
					$str = '通過';
				break;
		}
		return $str;
		
	}

	
}
