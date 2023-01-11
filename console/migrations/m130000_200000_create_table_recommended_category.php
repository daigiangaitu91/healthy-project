<?php

use yii\db\Migration;

/**
 * Class m130000_200000_create_recommended_category
 */
class m130000_200000_create_table_recommended_category extends Migration{

	/**
	 * @return bool|false|mixed|void
	 */
	public function up(){
		$tableOptions = NULL;
		if ($this->db->driverName === 'mysql'){
			$tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
		}

		$this->createTable('{{%recommended_category}}', [
			'id'          => $this->primaryKey(),
			'title'       => $this->string()->notNull(),
			'description' => $this->text(),
			'status'      => $this->integer()->notNull()->defaultValue('10'),
			'created_by'  => $this->integer(),
			'created_at'  => $this->integer(),
			'updated_by'  => $this->integer(),
			'updated_at'  => $this->integer(),
		], $tableOptions);
	}

	/**
	 * @return bool|false|mixed|void
	 */
	public function down(){
		$this->dropTable('{{%recommended_category}}');
	}
}
