<?php

use yii\db\Migration;

/**
 * Class m130000_100000_create_table_es_user_permission
 */
class m130000_100000_create_table_es_user_permission extends Migration{

	/**
	 * @return bool|false|mixed|void
	 */
	public function up(){
		$tableOptions = NULL;
		if ($this->db->driverName === 'mysql'){
			$tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
		}

		$this->createTable('{{%user_permission}}', [
			'id'          => $this->primaryKey(),
			'name'        => $this->string()->notNull(),
			'description' => $this->string(),
			'created_at'  => $this->integer()->notNull(),
			'updated_at'  => $this->integer(),
			'synced'      => $this->tinyInteger()->notNull()->defaultValue('0'),
		], $tableOptions);

	}

	/**
	 * @return bool|false|mixed|void
	 */
	public function down(){
		$this->dropTable('{{%user_permission}}');
	}
}
