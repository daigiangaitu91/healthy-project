<?php

use yii\db\Migration;

/**
 * Class m130000_300010_create_table_member_exercise_record
 */
class m130000_300010_create_table_member_exercise_record extends Migration{

	/**
	 * @return bool|false|mixed|void
	 */
	public function up(){
		$tableOptions = NULL;
		if ($this->db->driverName === 'mysql'){
			$tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
		}

		$this->createTable('{{%member_exercise_record}}', [
			'id'            => $this->primaryKey(),
			'user_id'       => $this->integer(),
			'exercise_date' => $this->integer(),
			'description'   => $this->text(),
			'kcal'          => $this->double(),
			'duration'      => $this->double(),
			'status'        => $this->integer()->notNull()->defaultValue('10'),
			'created_by'    => $this->integer(),
			'created_at'    => $this->integer(),
			'updated_by'    => $this->integer(),
			'updated_at'    => $this->integer(),
		], $tableOptions);

		$this->addForeignKey('fk_member_exercise_record', '{{%member_exercise_record}}',
			'user_id',
			'{{%user}}', 'id', 'NO ACTION', 'NO ACTION');
	}

	/**
	 * @return bool|false|mixed|void
	 */
	public function down(){
		$this->dropTable('{{%member_exercise_record}}');
	}
}
