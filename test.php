<?php

/*
 * This file is part of the overtrue/chinese-calendar.
 * (c) overtrue <i@overtrue.me>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

require __DIR__.'/vendor/autoload.php';

use Overtrue\ChineseCalendar\Calendar;

$calendar = new Calendar();

echo json_encode($calendar->solar(2017, 5, 5), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
//var_dump($calendar->getTerm(2017,3));
