<?php

namespace api\models;

use common\base\Status;
use common\models\User;
use api\base\ErrorCode;
use Yii;
use yii\db\Expression;
use yii\db\Query;

/**
 * Class UserModel
 *
 * @package api\models
 */
class UserModel extends User{

	/**
	 * Validate data for login
	 *
	 * @param array $post
	 *
	 * @return array
	 */
	public static function validateLogin($post){
		if (empty($post['password'])){
			return [
				'error_code' => ErrorCode::STATUS_CANNOT_BLANK,
				'message'    => Yii::t('common', 'Password cannot be blank.')
			];
		}

		if (empty($post['username'])){
			return [
				'error_code' => ErrorCode::STATUS_CANNOT_BLANK,
				'message'    => Yii::t('common', 'Username cannot be blank.')
			];
		}

		return [];
	}

	/**
	 * Finds user by username
	 *
	 * @param string $username
	 *
	 * @return static|null
	 */
	public static function findByUsernameAndType($username){
		return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE, 'type' => self::TYPE_MEMBER]);
	}

	/**
	 * {@inheritdoc}
	 */
	public static function findIdentityByAccessToken($token, $type = NULL){
		return static::findOne(['auth_key' => $token, 'status' => self::STATUS_ACTIVE]);
	}

	/**
	 * @param $params
	 *
	 * @return array
	 */
	public static function getMyDiary($params){
		$user         = Yii::$app->user->identity;
		$per_page     = 10;
		$page         = $params['page'] ?? 1;
		$offset       = ($page - 1) * $per_page;
		$meal_hisytoy = MemberMealHistoryModel::find()
		                                      ->select(new Expression('"Meal" as action'))
		                                      ->addSelect('date_meal as date')
		                                      ->addSelect('meal_name as description')
		                                      ->addSelect('kcal')
		                                      ->andWhere(['user_id' => $user->getId()])
		                                      ->andWhere(['status' => Status::STATUS_ACTIVE]);
		$exercise     = MemberExerciseRecordModel::find()
		                                         ->select(new Expression('"Exercise" as action'))
		                                         ->addSelect('exercise_date as date')
		                                         ->addSelect('description')
		                                         ->addSelect('kcal')
		                                         ->andWhere(['user_id' => $user->getId()])
		                                         ->andWhere(['status' => Status::STATUS_ACTIVE]);

		return (new Query())
			->from($meal_hisytoy->union($exercise))
			->orderBy('date')
			->limit($per_page)
			->offset($offset)
			->all();

	}

}