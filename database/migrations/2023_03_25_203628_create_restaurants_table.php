<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRestaurantsTable extends Migration {

	public function up()
	{
		Schema::create('restaurants', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->string('email')->unique();
			$table->string('phone')->unique();
			$table->string('password');
			$table->integer('region_id')->unsigned()->nullable();
            $table->bigInteger('pin_code')->nullable();
			$table->string('image');
			$table->decimal('shipping_taxes');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('restaurants');
	}
}
