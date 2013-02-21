<?php

class Create_Verbs_Table {    

	public function up()
    {
		Schema::create('verbs', function($table) {
			$table->increments('id');
			$table->integer('category_id');
			$table->string('word');
			$table->timestamps();
	});

    }    

	public function down()
    {
		Schema::drop('verbs');

    }

}