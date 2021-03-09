<?php

require __DIR__ . '/../vendor/autoload.php';
(new josegonzalez\Dotenv\Loader(__DIR__ . '/../.env'))->parse()->putenv(true)->define();
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

$config = require __DIR__ . '/../config/web.php';

(new yii\web\Application($config))->run();
