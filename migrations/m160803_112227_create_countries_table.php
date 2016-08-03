<?php

use yii\db\Migration;

/**
 * Handles the creation for table `countries`.
 */
class m160803_112227_create_countries_table extends Migration
{
	const TABLE = 'countries';

    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable(self::TABLE, [
            'id'   => $this->primaryKey()->notNull(),
            'name' => $this->string(255)->notNull(),
        ]);
	    $this->createIndex('idx-countries-name', self::TABLE, 'name');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable(self::TABLE);
    }
}
