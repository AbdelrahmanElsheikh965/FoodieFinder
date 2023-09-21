<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNotificationsTable extends Migration {

	public function up()
	{
		Schema::create('notifications', function(Blueprint $table) {
			$table->integer('id', true)->unsigned();
			$table->integer('notifiable_id');
			$table->string('notifiable_type');
			$table->string('content');
			$table->boolean('is_seen');
            $table->integer('order_id')->unsigned();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('notifications');
	}
}
