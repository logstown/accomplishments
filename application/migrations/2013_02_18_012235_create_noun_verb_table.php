<?php

class Create_Noun_Verb_Table {    

	public function up()
    {
		Schema::create('noun_verb', function($table) {
			$table->increments('id');
			$table->integer('noun_id');
			$table->integer('verb_id');
			$table->timestamps();
	});

    }    

	public function down()
    {
		Schema::drop('noun_verb');

    }

}