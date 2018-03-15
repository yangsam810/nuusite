<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            
			$table->increments('rid');	
			
			$table->string('untid', 20);		// 負責單位
			
            $table->tinyInteger('site');	// 校區 
			
			$table->string('room', 20);		// 會議室名稱
			
			$table->tinyInteger('level'); 	// 審核階級
			
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
        Schema::dropIfExists('rooms');
    }
}
