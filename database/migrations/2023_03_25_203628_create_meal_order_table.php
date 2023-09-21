<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMealOrderTable extends Migration {

	public function up()
	{
		Schema::create('meal_order', function(Blueprint $table) {
			$table->integer('meal_id')->unsigned();
			$table->integer('order_id')->unsigned();
			$table->integer('quantity');
			$table->text('notes');
//			$table->integer('restaurant_id')->unsigned();
			$table->decimal('price');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('meal_order');
	}
}
