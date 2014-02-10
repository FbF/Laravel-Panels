<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePanelsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('fbf_panels', function(Blueprint $table)
		{
			$table->increments('id');
			$types = array_keys(Config::get('laravel-panels::types'));
			$defaultType = current($types);
			$table->enum('type', $types)->default($defaultType);
			$table->string('title');
			$table->text('summary');
			$table->string('link_url');
			$table->string('link_text');
			$table->string('image_1');
			$table->string('image_2');
			$table->string('css_class');
			$table->integer('order')->unsigned()->nullable();
			$table->enum('status', array('DRAFT', 'APPROVED'))->default('DRAFT');
			$table->dateTime('published_date');
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
		Schema::drop('fbf_panels');
	}

}
