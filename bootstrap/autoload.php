<?php

/*
 * This file is part of Jitamin.
 *
 * Copyright (C) Jitamin Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require __DIR__.'/../vendor/autoload.php';

if (file_exists(__DIR__.'/cache/config.php')) {
    $configAll = require __DIR__.'/cache/config.php';
    $config = $configAll['config'];
    $configApp = $configAll['app'];
} else {
    $config = require __DIR__.'/../config/config.php';
    $configApp = require __DIR__.'/../config/app.php';
}

require __DIR__.'/bootstrap.php';
require __DIR__.'/env.php';
