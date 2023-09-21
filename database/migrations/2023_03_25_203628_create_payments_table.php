<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePaymentsTable extends Migration {

	public function up()
	{
		Schema::create('payments', function(Blueprint $table) {
			$table->increments('id');
			$table->decimal('price');
			$table->integer('restaurant_id')->unsigned()->nullable();
			$table->date('date');
			$table->text('note');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('payments');
	}
}