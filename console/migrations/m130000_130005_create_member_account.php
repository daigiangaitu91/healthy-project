<?php

use yii\db\Migration;

/**
 * Class m130000_130005_create_member_account
 */
class m130000_130005_create_member_account extends Migration{

	/**
	 * @return bool|false|mixed|void
	 * @throws \yii\base\Exception
	 */
	public function up(){
		$this->insert('{{%user}}', [
			'id'            => 2,
			'username'      => 'nguyennam',
			'email'         => 'nguyennam@yopmail.com',
			'first_name'    => 'Nguyen',
			'last_name'     => 'Nam',
			'type'          => \common\models\User::TYPE_MEMBER,
			'auth_key'      => Yii::$app->security->generateRandomString(),
			'password_hash' => Yii::$app->security->generatePasswordHash('abc@123'),
			'updated_at'    => time(),
			'created_at'    => time()
		]);

		$this->insert('{{%user_group}}', [
			'id'         => 2,
			'name'       => 'Member',
			'is_primary' => 0,
			'created_by' => 1,
			'created_at' => time()
		]);

		$this->insert('{{%user_user_group}}', [
			'user_id'       => 2,
			'user_group_id' => 2
		]);

	}

	/**
	 * @return bool|false|mixed|void
	 */
	public function down(){
		return FALSE;
	}
}
