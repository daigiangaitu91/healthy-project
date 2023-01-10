<?php

use yii\db\Migration;

/**
 * Class m130000_120000_create_table_es_user_user_group
 */
class m130000_120000_create_table_es_user_user_group extends Migration{

	/**
	 * @return bool|false|mixed|void
	 */
	public function up(){
		$tableOptions = NULL;
		if ($this->db->driverName === 'mysql'){
			$tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
		}

		$this->createTable('{{%user_user_group}}', [
			'user_id'       => 'INT(11) NOT NULL',
			'user_group_id' => 'INT(11) NOT NULL'
		], $tableOptions);

		$this->addPrimaryKey('PRIMARY_KEY', '{{%user_user_group}}', ['user_id', 'user_group_id']);
		$this->addForeignKey('fk_user_map_user_id', '{{%user_user_group}}', 'user_id', '{{%user}}',
			'id', 'NO ACTION', 'NO ACTION');
		$this->addForeignKey('fk_user_map_group_id', '{{%user_user_group}}', 'user_group_id',
			'{{%user_group}}', 'id', 'NO ACTION', 'NO ACTION');
	}

	/**
	 * @return bool|false|mixed|void
	 */
	public function down(){
		$this->dropTable('{{%user_user_group}}');
	}
}
