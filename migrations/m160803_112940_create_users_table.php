<?php

use yii\db\Migration;

/**
 * Handles the creation for table `users`.
 */
class m160803_112940_create_users_table extends Migration
{
    const TABLE = 'users';

    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable(self::TABLE, [
            'id'         => $this->primaryKey()->notNull(),
            'country_id' => $this->integer()->null(),
            'name'       => $this->string(255)->notNull(),
            'phone'      => $this->string(32),
        ]);
	    $this->addForeignKey('fk-users-country_id', self::TABLE, 'country_id', 'countries', 'id');
        $this->createIndex('idx-users-name',  self::TABLE, 'name');
        $this->createIndex('idx-users-phone', self::TABLE, 'phone');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable(self::TABLE);
    }
}
