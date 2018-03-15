<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applies', function (Blueprint $table) {
            
			$table->increments('aid');	
			
			$table->integer('untid');	// 負責單位
			
			$table->date('date');		// 申請時間
			
			$table->string('tid', 20);	// 申請時段
			
			$table->integer('rid');		// 會議室
			
			$table->string('account', 20);	// 申請人帳號
			
			$table->string('name', 10);		// 申請人姓名
			
			$table->string('phone', 15);	// 申請人電話
			
			$table->string('presenter', 10);// 主持人
			
			$table->integer('people');		// 參加人數
			
			$table->string('reason', 100);	// 事由
			
			$table->string('remark', 100)->nullable();	// 備註
			
			$table->string('state', 1)->default('c');	// 審核狀態
			
			/*
				c 審核中
				d 刪除中
				x 確認刪除
				n 未通過
				p 通過
			*/
			
			$table->tinyInteger('check_level')->default(0);	
            
			$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('applies');
    }
}
