<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrdersTable extends Migration {

	public function up()
	{
		Schema::create('orders', function(Blueprint $table) {
			$table->increments('id');
			$table->enum('state', array('pending', 'accepted', 'rejected', 'delivered', 'declined'))->default('pending');
//			$table->string('notes');
			$table->enum('payment', array('online', 'cash'));
			$table->integer('client_id')->unsigned();
			$table->integer('restaurant_id')->unsigned()->nullable();
			$table->decimal('price')->nullable();
			$table->decimal('commission');
			$table->decimal('shipping_taxes')->nullable();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('orders');
	}
}
