<?php

class Create_Categories_Table {    

	public function up()
    {
		Schema::create('categories', function($table) {
			$table->increments('id');
			$table->integer('user_id');
			$table->string('word');
			$table->timestamps();
	});

    }    

	public function down()
    {
		Schema::drop('categories');

    }

}