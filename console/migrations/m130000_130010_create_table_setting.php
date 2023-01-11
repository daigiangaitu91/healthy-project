<?php

use yii\db\Migration;

/**
 * Class m130000_130010_create_table_setting
 */
class m130000_130010_create_table_setting extends Migration{

	/**
	 * @return false|mixed|void
	 */
	public function up(){
		$tableOptions = NULL;
		if ($this->db->driverName === 'mysql'){
			$tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
		}

		$this->createTable('{{%setting}}', [
			'key'   => $this->string(255)->unique(),
			'value' => $this->text()
		], $tableOptions);

		$this->addPrimaryKey('pk_setting_key', '{{%setting}}', 'key');
	}

	/**
	 * @return false|mixed|void
	 */
	public function down(){
		$this->dropTable('{{%setting}}');
	}
}
