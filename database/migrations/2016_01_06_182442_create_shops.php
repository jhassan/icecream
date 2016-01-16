<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShops extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('shops', function(Blueprint $table)
		{
			$table->increments('shop_id');

            $table->string('shop_name', 255);
            $table->string('shop_code', 3);
            $table->string('shop_address', 255);
            $table->tinyInteger('is_active')->default(0);
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
		Schema::drop('shops');
	}

}
