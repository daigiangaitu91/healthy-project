<?php

use yii\db\Migration;

/**
 * Class m130000_130000_create_admin_account
 */
class m130000_130000_create_admin_account extends Migration{

	/**
	 * @return bool|false|mixed|void
	 * @throws \yii\base\Exception
	 */
	public function up(){
		$this->insert('{{%user}}', [
			'id'            => 1,
			'username'      => 'root',
			'email'         => 'root@example.com',
			'first_name'    => 'admin',
			'last_name'     => 'admin',
			'type'          => \common\models\User::TYPE_ADMIN,
			'auth_key'      => Yii::$app->security->generateRandomString(),
			'password_hash' => Yii::$app->security->generatePasswordHash('root'),
			'updated_at'    => time(),
			'created_at'    => time()
		]);

		$this->insert('{{%user_group}}', [
			'id'         => 1,
			'name'       => 'Administrator',
			'is_primary' => 1,
			'created_by' => 1,
			'created_at' => time()
		]);

		$this->insert('{{%user_user_group}}', [
			'user_id'       => 1,
			'user_group_id' => 1
		]);

	}

	/**
	 * @return bool|false|mixed|void
	 */
	public function down(){
		return FALSE;
	}
}
