<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
		/*
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
        ],*/
		/*
        'commonFunctions' => [
            'class' => 'common\components\CommonFunctions'
        ],*/
    ],
	/*
    'bootstrap'=>[
        'common\components\Settings',
    ],*/
    'timeZone' => 'UTC',
];


