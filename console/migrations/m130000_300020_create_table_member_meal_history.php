<?php

use yii\db\Migration;

/**
 * Class m130000_300020_create_table_member_meal_history
 */
class m130000_300020_create_table_member_meal_history extends Migration{

	/**
	 * @return bool|false|mixed|void
	 */
	public function up(){
		$tableOptions = NULL;
		if ($this->db->driverName === 'mysql'){
			$tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
		}

		$this->createTable('{{%member_meal_history}}', [
			'id'         => $this->primaryKey(),
			'user_id'    => $this->integer(),
			'meal_name'  => $this->string(255),
			'date_meal'  => $this->integer(),
			'category'   => $this->integer(),
			'kcal'       => $this->double(),
			'thumbnail'  => $this->string(),
			'status'     => $this->integer()->notNull()->defaultValue('10'),
			'created_by' => $this->integer(),
			'created_at' => $this->integer(),
			'updated_by' => $this->integer(),
			'updated_at' => $this->integer(),
		], $tableOptions);

		$this->addForeignKey('fk_member_meal_history', '{{%member_meal_history}}',
			'user_id',
			'{{%user}}', 'id', 'NO ACTION', 'NO ACTION');
	}

	/**
	 * @return bool|false|mixed|void
	 */
	public function down(){
		$this->dropTable('{{%member_meal_history}}');
	}
}
