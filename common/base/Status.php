<?php

namespace common\base;

/**
 * Class Status
 *
 * @package common\base
 */
class Status extends StatusAttributeBehavior{

	public static function getStatus(){
		return [self::STATUS_ACTIVE => 'Active', self::STATUS_INACTIVE => 'Inactive'];
	}
}
