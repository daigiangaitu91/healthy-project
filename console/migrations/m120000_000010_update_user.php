<?php

use yii\db\Migration;

/**
 * Class m120000_000010_update_user
 */
class m120000_000010_update_user extends Migration{

	protected $table = '{{%user}}';

	/**
	 * @return bool|false|mixed|void
	 */
	public function up(){
		$this->addColumn($this->table, 'first_name', $this->string(1000));
		$this->addColumn($this->table, 'last_name', $this->string(1000));
		$this->addColumn($this->table, 'phone_number', $this->string(20));
		$this->addColumn($this->table, 'type', $this->string(20));
	}

	/**
	 * @return bool|false|mixed|void
	 */
	public function down(){
		$this->dropColumn($this->table, 'first_name');
		$this->dropColumn($this->table, 'last_name');
		$this->dropColumn($this->table, 'phone_number');
		$this->dropColumn($this->table, 'type');
	}
}
