<?php

use yii\db\Migration;

/**
 * Class m130000_300000_create_table_member_body_record
 */
class m130000_300000_create_table_member_body_record extends Migration{

	/**
	 * @return bool|false|mixed|void
	 */
	public function up(){
		$tableOptions = NULL;
		if ($this->db->driverName === 'mysql'){
			$tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
		}

		$this->createTable('{{%member_body_record}}', [
			'id'          => $this->primaryKey(),
			'user_id'     => $this->integer(),
			'date_record' => $this->integer(),
			'target_date' => $this->double(),
			'weight'      => $this->double(),
			'body_fat'    => $this->double(),
			'status'      => $this->integer()->notNull()->defaultValue('10'),
			'created_by'  => $this->integer(),
			'created_at'  => $this->integer(),
			'updated_by'  => $this->integer(),
			'updated_at'  => $this->integer(),
		], $tableOptions);

		$this->addForeignKey('fk_member_body_record', '{{%member_body_record}}',
			'user_id',
			'{{%user}}', 'id', 'NO ACTION', 'NO ACTION');
	}

	/**
	 * @return bool|false|mixed|void
	 */
	public function down(){
		$this->dropTable('{{%member_body_record}}');
	}
}
