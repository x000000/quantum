<?php

use yii\db\Migration;

class m160803_122729_insert_test_data extends Migration
{
    public function up()
    {
		$this->batchInsert(
			'countries',
			['name'],
			$countries = [
				['name' => 'United States'],
				['name' => 'Russia'],
				['name' => 'France'],
				['name' => 'Germany'],
				['name' => 'Sweden'],
				['name' => 'Finland'],
			]
		);
	    $this->batchInsert(
		    'users',
		    ['name', 'phone', 'country_id'],
		    array_map(function($row) use ($countries) {
			    $row['country_id'] = round(rand(1, count($countries)));
			    return $row;
		    }, [
			    ['name' => 'Alexey',  'phone' => '+7-(911)-100-55-00'],
			    ['name' => 'Maria',   'phone' => '+7-(961)-154-81-51'],
			    ['name' => 'Sophia',  'phone' => '+7-(911)-622-47-15'],
			    ['name' => 'Michael', 'phone' => '+7-(965)-150-24-18'],
			    ['name' => 'Denis',   'phone' => '+7-(911)-010-50-97'],
			    ['name' => 'Roman',   'phone' => '+7-(965)-185-55-00'],
			    ['name' => 'Elena',   'phone' => '+7-(812)-100-48-78'],
			    ['name' => 'Victor',  'phone' => '+7-(951)-185-17-88'],
		    ])
        );
    }

    public function down()
    {
        $this->truncateTable('users');
        $this->truncateTable('countries');
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
