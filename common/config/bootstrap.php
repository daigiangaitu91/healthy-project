<?php
Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('@backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('@api', dirname(dirname(__DIR__)) . '/api');
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');
Yii::setAlias('@private_files', dirname(dirname(__DIR__)) . '/files/private');
Yii::setAlias('@files', dirname(dirname(__DIR__)) . '/public/contents');
Yii::setAlias('@file_url', dirname(dirname(__DIR__)) . '/public');