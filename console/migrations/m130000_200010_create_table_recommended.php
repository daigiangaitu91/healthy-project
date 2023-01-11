<?php

use yii\db\Migration;

/**
 * Class m130000_200010_create_recommended
 */
class m130000_200010_create_table_recommended extends Migration{

	/**
	 * @return bool|false|mixed|void
	 */
	public function up(){
		$tableOptions = NULL;
		if ($this->db->driverName === 'mysql'){
			$tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
		}

		$this->createTable('{{%recommended}}', [
			'id'                      => $this->primaryKey(),
			'title'                   => $this->string()->notNull(),
			'content'                 => "LONGTEXT",
			'thumbnail'               => $this->string(),
			'recommended_category_id' => $this->integer(),
			'tags'                    => $this->text(),
			'status'                  => $this->integer()->notNull()->defaultValue('10'),
			'created_by'              => $this->integer(),
			'created_at'              => $this->integer(),
			'updated_by'              => $this->integer(),
			'updated_at'              => $this->integer(),
		], $tableOptions);

		$this->addForeignKey('fk_recommended_category', '{{%recommended}}',
			'recommended_category_id',
			'{{%recommended_category}}', 'id', 'NO ACTION', 'NO ACTION');
	}

	/**
	 * @return bool|false|mixed|void
	 */
	public function down(){
		$this->dropTable('{{%recommended_category}}');
	}
}
