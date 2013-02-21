<?php

class Create_Nouns_Table {    

	public function up()
    {
		Schema::create('nouns', function($table) {
			$table->increments('id');
			$table->string('word');
			$table->timestamps();
	});

    }    

	public function down()
    {
		Schema::drop('nouns');

    }

}