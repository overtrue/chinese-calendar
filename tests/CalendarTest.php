<?php

/*
 * This file is part of the overtrue/chinese-calendar.
 * (c) overtrue <i@overtrue.me>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Overtrue\ChineseCalendar\Tests;

use DateTime;
use DateTimeZone;
use InvalidArgumentException;
use Overtrue\ChineseCalendar\Calendar;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(Calendar::class)]
final class CalendarTest extends TestCase
{
    // region ganZhiYear

    public function testJiaZiGanZhiYear(): void
    {
        $calendar = new Calendar();
        $ganZhi = $calendar->ganZhiYear(1984);
        $this->assertEquals('甲子', $ganZhi);
    }

    public function testKuiHaiGanZhiYear(): void
    {
        $calendar = new Calendar();
        $ganZhi = $calendar->ganZhiYear(1983);
        $this->assertEquals('癸亥', $ganZhi);
    }

    // endregion ganZhiYear

    public function testSameNormalDateDiffInYears(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 29, false);
        $lunar2 = $calendar->lunar(2017, 6, 29, false);
        $diff1 = $calendar->diffInYears($lunar1, $lunar2, false);
        $diff2 = $calendar->diffInYears($lunar2, $lunar1, false);
        $this->assertEquals(0, $diff1);
        $this->assertEquals(0, $diff2);
    }

    public function testSameLeapDateDiffInYears(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 30, true);
        $lunar2 = $calendar->lunar(2017, 6, 30, true);
        $diff1 = $calendar->diffInYears($lunar1, $lunar2, false);
        $diff2 = $calendar->diffInYears($lunar2, $lunar1, false);
        $this->assertEquals(0, $diff1);
        $this->assertEquals(0, $diff2);
    }

    // region less month

    public function testLessMonthLessDayNormalDateAndNormalDateDiffInYears(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, false);
        $lunar2 = $calendar->lunar(2027, 8, 20, false);
        $diff1 = $calendar->diffInYears($lunar1, $lunar2, false);
        $diff2 = $calendar->diffInYears($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInYears($lunar2, $lunar1);
        $this->assertEquals(10, $diff1);
        $this->assertEquals(-10, $diff2);
        $this->assertEquals(10, $diff2a);
    }

    public function testLessMonthLessDayNormalDateAndLeapDateDiffInYears(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2007, 5, 10, false);
        $lunar2 = $calendar->lunar(2017, 6, 20, true);
        $diff1 = $calendar->diffInYears($lunar1, $lunar2, false);
        $diff2 = $calendar->diffInYears($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInYears($lunar2, $lunar1);
        $this->assertEquals(10, $diff1);
        $this->assertEquals(-10, $diff2);
        $this->assertEquals(10, $diff2a);
    }

    public function testLessMonthLessDayLeapDateAndNormalDateDiffInYears(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, true);
        $lunar2 = $calendar->lunar(2027, 7, 20, false);
        $diff1 = $calendar->diffInYears($lunar1, $lunar2, false);
        $diff2 = $calendar->diffInYears($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInYears($lunar2, $lunar1);
        $this->assertEquals(10, $diff1);
        $this->assertEquals(-10, $diff2);
        $this->assertEquals(10, $diff2a);
    }

    public function testLessMonthLessDayLeapDateAndLeapDateDiffInYears(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, true);
        $lunar2 = $calendar->lunar(2052, 8, 20, true);
        $diff1 = $calendar->diffInYears($lunar1, $lunar2, false);
        $diff2 = $calendar->diffInYears($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInYears($lunar2, $lunar1);
        $this->assertEquals(35, $diff1);
        $this->assertEquals(-35, $diff2);
        $this->assertEquals(35, $diff2a);
    }

    public function testLessMonthEqualDayNormalDateAndNormalDateDiffInYears(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, false);
        $lunar2 = $calendar->lunar(2027, 8, 10, false);
        $diff1 = $calendar->diffInYears($lunar1, $lunar2, false);
        $diff2 = $calendar->diffInYears($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInYears($lunar2, $lunar1);
        $this->assertEquals(10, $diff1);
        $this->assertEquals(-10, $diff2);
        $this->assertEquals(10, $diff2a);
    }

    public function testLessMonthEqualDayNormalDateAndLeapDateDiffInYears(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2007, 5, 10, false);
        $lunar2 = $calendar->lunar(2017, 6, 10, true);
        $diff1 = $calendar->diffInYears($lunar1, $lunar2, false);
        $diff2 = $calendar->diffInYears($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInYears($lunar2, $lunar1);
        $this->assertEquals(10, $diff1);
        $this->assertEquals(-10, $diff2);
        $this->assertEquals(10, $diff2a);
    }

    public function testLessMonthEqualDayLeapDateAndNormalDateDiffInYears(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, true);
        $lunar2 = $calendar->lunar(2027, 7, 10, false);
        $diff1 = $calendar->diffInYears($lunar1, $lunar2, false);
        $diff2 = $calendar->diffInYears($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInYears($lunar2, $lunar1);
        $this->assertEquals(10, $diff1);
        $this->assertEquals(-10, $diff2);
        $this->assertEquals(10, $diff2a);
    }

    public function testLessMonthEqualDayLeapDateAndLeapDateDiffInYears(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, true);
        $lunar2 = $calendar->lunar(2052, 8, 10, true);
        $diff1 = $calendar->diffInYears($lunar1, $lunar2, false);
        $diff2 = $calendar->diffInYears($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInYears($lunar2, $lunar1);
        $this->assertEquals(35, $diff1);
        $this->assertEquals(-35, $diff2);
        $this->assertEquals(35, $diff2a);
    }

    public function testLessMonthGreaterDayNormalDateAndNormalDateDiffInYears(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, false);
        $lunar2 = $calendar->lunar(2027, 8, 1, false);
        $diff1 = $calendar->diffInYears($lunar1, $lunar2, false);
        $diff2 = $calendar->diffInYears($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInYears($lunar2, $lunar1);
        $this->assertEquals(10, $diff1);
        $this->assertEquals(-10, $diff2);
        $this->assertEquals(10, $diff2a);
    }

    public function testLessMonthGreaterDayNormalDateAndLeapDateDiffInYears(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2007, 5, 10, false);
        $lunar2 = $calendar->lunar(2017, 6, 1, true);
        $diff1 = $calendar->diffInYears($lunar1, $lunar2, false);
        $diff2 = $calendar->diffInYears($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInYears($lunar2, $lunar1);
        $this->assertEquals(10, $diff1);
        $this->assertEquals(-10, $diff2);
        $this->assertEquals(10, $diff2a);
    }

    public function testLessMonthGreaterDayLeapDateAndNormalDateDiffInYears(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, true);
        $lunar2 = $calendar->lunar(2027, 7, 1, false);
        $diff1 = $calendar->diffInYears($lunar1, $lunar2, false);
        $diff2 = $calendar->diffInYears($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInYears($lunar2, $lunar1);
        $this->assertEquals(10, $diff1);
        $this->assertEquals(-10, $diff2);
        $this->assertEquals(10, $diff2a);
    }

    public function testLessMonthGreaterDayLeapDateAndLeapDateDiffInYears(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, true);
        $lunar2 = $calendar->lunar(2052, 8, 1, true);
        $diff1 = $calendar->diffInYears($lunar1, $lunar2, false);
        $diff2 = $calendar->diffInYears($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInYears($lunar2, $lunar1);
        $this->assertEquals(35, $diff1);
        $this->assertEquals(-35, $diff2);
        $this->assertEquals(35, $diff2a);
    }

    // endregion less month

    // region equal month

    public function testEqualMonthLessDayNormalDateAndNormalDateDiffInYears(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, false);
        $lunar2 = $calendar->lunar(2027, 6, 20, false);
        $diff1 = $calendar->diffInYears($lunar1, $lunar2, false);
        $diff2 = $calendar->diffInYears($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInYears($lunar2, $lunar1);
        $this->assertEquals(10, $diff1);
        $this->assertEquals(-10, $diff2);
        $this->assertEquals(10, $diff2a);
    }

    public function testEqualMonthLessDayNormalDateAndLeapDateDiffInYears(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2007, 6, 10, false);
        $lunar2 = $calendar->lunar(2017, 6, 20, true);
        $diff1 = $calendar->diffInYears($lunar1, $lunar2, false);
        $diff2 = $calendar->diffInYears($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInYears($lunar2, $lunar1);
        $this->assertEquals(10, $diff1);
        $this->assertEquals(-10, $diff2);
        $this->assertEquals(10, $diff2a);
    }

    public function testEqualMonthLessDayLeapDateAndNormalDateDiffInYears(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, true);
        $lunar2 = $calendar->lunar(2027, 6, 20, false);
        $diff1 = $calendar->diffInYears($lunar1, $lunar2, false);
        $diff2 = $calendar->diffInYears($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInYears($lunar2, $lunar1);
        $this->assertEquals(9, $diff1);
        $this->assertEquals(-9, $diff2);
        $this->assertEquals(9, $diff2a);
    }

    public function testEqualMonthLessDayLeapDateAndLeapDateDiffInYears(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, true);
        $lunar2 = $calendar->lunar(2025, 6, 20, true);
        $diff1 = $calendar->diffInYears($lunar1, $lunar2, false);
        $diff2 = $calendar->diffInYears($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInYears($lunar2, $lunar1);
        $this->assertEquals(8, $diff1);
        $this->assertEquals(-8, $diff2);
        $this->assertEquals(8, $diff2a);
    }

    public function testEqualMonthEqualDayNormalDateAndNormalDateDiffInYears(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, false);
        $lunar2 = $calendar->lunar(2027, 6, 10, false);
        $diff1 = $calendar->diffInYears($lunar1, $lunar2, false);
        $diff2 = $calendar->diffInYears($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInYears($lunar2, $lunar1);
        $this->assertEquals(10, $diff1);
        $this->assertEquals(-10, $diff2);
        $this->assertEquals(10, $diff2a);
    }

    public function testEqualMonthEqualDayNormalDateAndLeapDateDiffInYears(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2007, 6, 10, false);
        $lunar2 = $calendar->lunar(2017, 6, 10, true);
        $diff1 = $calendar->diffInYears($lunar1, $lunar2, false);
        $diff2 = $calendar->diffInYears($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInYears($lunar2, $lunar1);
        $this->assertEquals(10, $diff1);
        $this->assertEquals(-10, $diff2);
        $this->assertEquals(10, $diff2a);
    }

    public function testEqualMonthEqualDayLeapDateAndNormalDateDiffInYears(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, true);
        $lunar2 = $calendar->lunar(2027, 6, 10, false);
        $diff1 = $calendar->diffInYears($lunar1, $lunar2, false);
        $diff2 = $calendar->diffInYears($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInYears($lunar2, $lunar1);
        $this->assertEquals(9, $diff1);
        $this->assertEquals(-9, $diff2);
        $this->assertEquals(9, $diff2a);
    }

    public function testEqualMonthEqualDayLeapDateAndLeapDateDiffInYears(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, true);
        $lunar2 = $calendar->lunar(2025, 6, 10, true);
        $diff1 = $calendar->diffInYears($lunar1, $lunar2, false);
        $diff2 = $calendar->diffInYears($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInYears($lunar2, $lunar1);
        $this->assertEquals(8, $diff1);
        $this->assertEquals(-8, $diff2);
        $this->assertEquals(8, $diff2a);
    }

    public function testEqualMonthGreaterDayNormalDateAndNormalDateDiffInYears(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, false);
        $lunar2 = $calendar->lunar(2027, 6, 1, false);
        $diff1 = $calendar->diffInYears($lunar1, $lunar2, false);
        $diff2 = $calendar->diffInYears($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInYears($lunar2, $lunar1);
        $this->assertEquals(9, $diff1);
        $this->assertEquals(-9, $diff2);
        $this->assertEquals(9, $diff2a);
    }

    public function testEqualMonthGreaterDayNormalDateAndLeapDateDiffInYears(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2007, 6, 10, false);
        $lunar2 = $calendar->lunar(2017, 6, 1, true);
        $diff1 = $calendar->diffInYears($lunar1, $lunar2, false);
        $diff2 = $calendar->diffInYears($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInYears($lunar2, $lunar1);
        $this->assertEquals(10, $diff1);
        $this->assertEquals(-10, $diff2);
        $this->assertEquals(10, $diff2a);
    }

    public function testEqualMonthGreaterDayLeapDateAndNormalDateDiffInYears(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, true);
        $lunar2 = $calendar->lunar(2027, 6, 1, false);
        $diff1 = $calendar->diffInYears($lunar1, $lunar2, false);
        $diff2 = $calendar->diffInYears($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInYears($lunar2, $lunar1);
        $this->assertEquals(9, $diff1);
        $this->assertEquals(-9, $diff2);
        $this->assertEquals(9, $diff2a);
    }

    public function testEqualMonthGreaterDayLeapDateAndLeapDateDiffInYears(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, true);
        $lunar2 = $calendar->lunar(2025, 6, 1, true);
        $diff1 = $calendar->diffInYears($lunar1, $lunar2, false);
        $diff2 = $calendar->diffInYears($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInYears($lunar2, $lunar1);
        $this->assertEquals(7, $diff1);
        $this->assertEquals(-7, $diff2);
        $this->assertEquals(7, $diff2a);
    }

    // endregion equal month

    // region greater month

    public function testGreaterMonthLessDayNormalDateAndNormalDateDiffInYears(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, false);
        $lunar2 = $calendar->lunar(2027, 5, 20, false);
        $diff1 = $calendar->diffInYears($lunar1, $lunar2, false);
        $diff2 = $calendar->diffInYears($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInYears($lunar2, $lunar1);
        $this->assertEquals(9, $diff1);
        $this->assertEquals(-9, $diff2);
        $this->assertEquals(9, $diff2a);
    }

    public function testGreaterMonthLessDayNormalDateAndLeapDateDiffInYears(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, false);
        $lunar2 = $calendar->lunar(2027, 5, 20, true);
        $diff1 = $calendar->diffInYears($lunar1, $lunar2, false);
        $diff2 = $calendar->diffInYears($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInYears($lunar2, $lunar1);
        $this->assertEquals(9, $diff1);
        $this->assertEquals(-9, $diff2);
        $this->assertEquals(9, $diff2a);
    }

    public function testGreaterMonthLessDayLeapDateAndNormalDateDiffInYears(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, true);
        $lunar2 = $calendar->lunar(2027, 5, 20, false);
        $diff1 = $calendar->diffInYears($lunar1, $lunar2, false);
        $diff2 = $calendar->diffInYears($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInYears($lunar2, $lunar1);
        $this->assertEquals(9, $diff1);
        $this->assertEquals(-9, $diff2);
        $this->assertEquals(9, $diff2a);
    }

    public function testGreaterMonthLessDayLeapDateAndLeapDateDiffInYears(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, true);
        $lunar2 = $calendar->lunar(2020, 4, 20, true);
        $diff1 = $calendar->diffInYears($lunar1, $lunar2, false);
        $diff2 = $calendar->diffInYears($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInYears($lunar2, $lunar1);
        $this->assertEquals(2, $diff1);
        $this->assertEquals(-2, $diff2);
        $this->assertEquals(2, $diff2a);
    }

    public function testGreaterMonthEqualDayNormalDateAndNormalDateDiffInYears(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, false);
        $lunar2 = $calendar->lunar(2027, 5, 10, false);
        $diff1 = $calendar->diffInYears($lunar1, $lunar2, false);
        $diff2 = $calendar->diffInYears($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInYears($lunar2, $lunar1);
        $this->assertEquals(9, $diff1);
        $this->assertEquals(-9, $diff2);
        $this->assertEquals(9, $diff2a);
    }

    public function testGreaterMonthEqualDayNormalDateAndLeapDateDiffInYears(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, false);
        $lunar2 = $calendar->lunar(2027, 5, 10, true);
        $diff1 = $calendar->diffInYears($lunar1, $lunar2, false);
        $diff2 = $calendar->diffInYears($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInYears($lunar2, $lunar1);
        $this->assertEquals(9, $diff1);
        $this->assertEquals(-9, $diff2);
        $this->assertEquals(9, $diff2a);
    }

    public function testGreaterMonthEqualDayLeapDateAndNormalDateDiffInYears(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, true);
        $lunar2 = $calendar->lunar(2027, 5, 10, false);
        $diff1 = $calendar->diffInYears($lunar1, $lunar2, false);
        $diff2 = $calendar->diffInYears($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInYears($lunar2, $lunar1);
        $this->assertEquals(9, $diff1);
        $this->assertEquals(-9, $diff2);
        $this->assertEquals(9, $diff2a);
    }

    public function testGreaterMonthEqualDayLeapDateAndLeapDateDiffInYears(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, true);
        $lunar2 = $calendar->lunar(2020, 4, 10, true);
        $diff1 = $calendar->diffInYears($lunar1, $lunar2, false);
        $diff2 = $calendar->diffInYears($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInYears($lunar2, $lunar1);
        $this->assertEquals(2, $diff1);
        $this->assertEquals(-2, $diff2);
        $this->assertEquals(2, $diff2a);
    }

    public function testGreaterMonthGreaterDayNormalDateAndNormalDateDiffInYears(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, false);
        $lunar2 = $calendar->lunar(2027, 5, 1, false);
        $diff1 = $calendar->diffInYears($lunar1, $lunar2, false);
        $diff2 = $calendar->diffInYears($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInYears($lunar2, $lunar1);
        $this->assertEquals(9, $diff1);
        $this->assertEquals(-9, $diff2);
        $this->assertEquals(9, $diff2a);
    }

    public function testGreaterMonthGreaterDayNormalDateAndLeapDateDiffInYears(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, false);
        $lunar2 = $calendar->lunar(2027, 5, 1, true);
        $diff1 = $calendar->diffInYears($lunar1, $lunar2, false);
        $diff2 = $calendar->diffInYears($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInYears($lunar2, $lunar1);
        $this->assertEquals(9, $diff1);
        $this->assertEquals(-9, $diff2);
        $this->assertEquals(9, $diff2a);
    }

    public function testGreaterMonthGreaterDayLeapDateAndNormalDateDiffInYears(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, true);
        $lunar2 = $calendar->lunar(2027, 5, 1, false);
        $diff1 = $calendar->diffInYears($lunar1, $lunar2, false);
        $diff2 = $calendar->diffInYears($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInYears($lunar2, $lunar1);
        $this->assertEquals(9, $diff1);
        $this->assertEquals(-9, $diff2);
        $this->assertEquals(9, $diff2a);
    }

    public function testGreaterMonthGreaterDayLeapDateAndLeapDateDiffInYears(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, true);
        $lunar2 = $calendar->lunar(2020, 4, 1, true);
        $diff1 = $calendar->diffInYears($lunar1, $lunar2, false);
        $diff2 = $calendar->diffInYears($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInYears($lunar2, $lunar1);
        $this->assertEquals(2, $diff1);
        $this->assertEquals(-2, $diff2);
        $this->assertEquals(2, $diff2a);
    }

    // endregion greater month

    // endregion diffInYears

    // region diffInMonths

    // region different year less month less day

    public function testDifferentYearLessMonthLessDayNormalYearNormalDateAndNormalYearNormalDateDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2018, 2, 10, false);
        $lunar2 = $calendar->lunar(2026, 8, 20, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(105, $diff1);
        $this->assertEquals(105, $diff1a);
        $this->assertEquals(-105, $diff2);
        $this->assertEquals(105, $diff2a);
    }

    public function testDifferentYearLessMonthLessDayNormalYearNormalDateAndLeapYearNormalDateLessThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2018, 2, 10, false);
        $lunar2 = $calendar->lunar(2025, 5, 20, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(89, $diff1);
        $this->assertEquals(89, $diff1a);
        $this->assertEquals(-89, $diff2);
        $this->assertEquals(89, $diff2a);
    }

    public function testDifferentYearLessMonthLessDayNormalYearNormalDateAndLeapYearNormalDateEqualLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2018, 2, 10, false);
        $lunar2 = $calendar->lunar(2025, 6, 20, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(90, $diff1);
        $this->assertEquals(90, $diff1a);
        $this->assertEquals(-90, $diff2);
        $this->assertEquals(90, $diff2a);
    }

    public function testDifferentYearLessMonthLessDayNormalYearNormalDateAndLeapYearNormalDateGreaterThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2018, 2, 10, false);
        $lunar2 = $calendar->lunar(2025, 7, 20, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(92, $diff1);
        $this->assertEquals(92, $diff1a);
        $this->assertEquals(-92, $diff2);
        $this->assertEquals(92, $diff2a);
    }

    public function testDifferentYearLessMonthLessDayNormalYearNormalDateAndLeapDateDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2018, 2, 10, false);
        $lunar2 = $calendar->lunar(2025, 6, 20, true);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(91, $diff1);
        $this->assertEquals(91, $diff1a);
        $this->assertEquals(-91, $diff2);
        $this->assertEquals(91, $diff2a);
    }

    public function testDifferentYearLessMonthLessDayLeapYearNormalDateLessThanLeapMonthAndNormalYearNormalDateDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2020, 2, 10, false);
        $lunar2 = $calendar->lunar(2026, 8, 20, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(81, $diff1);
        $this->assertEquals(81, $diff1a);
        $this->assertEquals(-81, $diff2);
        $this->assertEquals(81, $diff2a);
    }

    public function testDifferentYearLessMonthLessDayLeapYearNormalDateLessThanLeapMonthAndLeapYearNormalDateLessThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2020, 2, 10, false);
        $lunar2 = $calendar->lunar(2025, 5, 20, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(65, $diff1);
        $this->assertEquals(65, $diff1a);
        $this->assertEquals(-65, $diff2);
        $this->assertEquals(65, $diff2a);
    }

    public function testDifferentYearLessMonthLessDayLeapYearNormalDateLessThanLeapMonthAndLeapYearNormalDateEqualLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2020, 2, 10, false);
        $lunar2 = $calendar->lunar(2025, 6, 20, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(66, $diff1);
        $this->assertEquals(66, $diff1a);
        $this->assertEquals(-66, $diff2);
        $this->assertEquals(66, $diff2a);
    }

    public function testDifferentYearLessMonthLessDayLeapYearNormalDateLessThanLeapMonthAndLeapYearNormalDateGreaterThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2020, 2, 10, false);
        $lunar2 = $calendar->lunar(2025, 7, 20, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(68, $diff1);
        $this->assertEquals(68, $diff1a);
        $this->assertEquals(-68, $diff2);
        $this->assertEquals(68, $diff2a);
    }

    public function testDifferentYearLessMonthLessDayLeapYearNormalDateLessThanLeapMonthAndLeapDateDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2020, 2, 10, false);
        $lunar2 = $calendar->lunar(2025, 6, 20, true);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(67, $diff1);
        $this->assertEquals(67, $diff1a);
        $this->assertEquals(-67, $diff2);
        $this->assertEquals(67, $diff2a);
    }

    public function testDifferentYearLessMonthLessDayLeapYearNormalDateEqualLeapMonthAndNormalYearNormalDateDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2020, 4, 10, false);
        $lunar2 = $calendar->lunar(2026, 8, 20, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(79, $diff1);
        $this->assertEquals(79, $diff1a);
        $this->assertEquals(-79, $diff2);
        $this->assertEquals(79, $diff2a);
    }

    public function testDifferentYearLessMonthLessDayLeapYearNormalDateEqualLeapMonthAndLeapYearNormalDateLessThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2020, 4, 10, false);
        $lunar2 = $calendar->lunar(2025, 5, 20, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(63, $diff1);
        $this->assertEquals(63, $diff1a);
        $this->assertEquals(-63, $diff2);
        $this->assertEquals(63, $diff2a);
    }

    public function testDifferentYearLessMonthLessDayLeapYearNormalDateEqualLeapMonthAndLeapYearNormalDateEqualLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2020, 4, 10, false);
        $lunar2 = $calendar->lunar(2025, 6, 20, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(64, $diff1);
        $this->assertEquals(64, $diff1a);
        $this->assertEquals(-64, $diff2);
        $this->assertEquals(64, $diff2a);
    }

    public function testDifferentYearLessMonthLessDayLeapYearNormalDateEqualLeapMonthAndLeapYearNormalDateGreaterThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2020, 4, 10, false);
        $lunar2 = $calendar->lunar(2025, 7, 20, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(66, $diff1);
        $this->assertEquals(66, $diff1a);
        $this->assertEquals(-66, $diff2);
        $this->assertEquals(66, $diff2a);
    }

    public function testDifferentYearLessMonthLessDayLeapYearNormalDateEqualLeapMonthAndLeapDateDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2020, 4, 10, false);
        $lunar2 = $calendar->lunar(2025, 6, 20, true);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(65, $diff1);
        $this->assertEquals(65, $diff1a);
        $this->assertEquals(-65, $diff2);
        $this->assertEquals(65, $diff2a);
    }

    public function testDifferentYearLessMonthLessDayLeapYearNormalDateGreaterThanLeapMonthAndNormalYearNormalDateDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2020, 5, 10, false);
        $lunar2 = $calendar->lunar(2026, 8, 20, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(77, $diff1);
        $this->assertEquals(77, $diff1a);
        $this->assertEquals(-77, $diff2);
        $this->assertEquals(77, $diff2a);
    }

    public function testDifferentYearLessMonthLessDayLeapYearNormalDateGreaterThanLeapMonthAndLeapYearNormalDateLessThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2020, 5, 10, false);
        $lunar2 = $calendar->lunar(2025, 5, 20, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(61, $diff1);
        $this->assertEquals(61, $diff1a);
        $this->assertEquals(-61, $diff2);
        $this->assertEquals(61, $diff2a);
    }

    public function testDifferentYearLessMonthLessDayLeapYearNormalDateGreaterThanLeapMonthAndLeapYearNormalDateEqualLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2020, 5, 10, false);
        $lunar2 = $calendar->lunar(2025, 6, 20, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(62, $diff1);
        $this->assertEquals(62, $diff1a);
        $this->assertEquals(-62, $diff2);
        $this->assertEquals(62, $diff2a);
    }

    public function testDifferentYearLessMonthLessDayLeapYearNormalDateGreaterThanLeapMonthAndLeapYearNormalDateGreaterThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2020, 5, 10, false);
        $lunar2 = $calendar->lunar(2025, 7, 20, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(64, $diff1);
        $this->assertEquals(64, $diff1a);
        $this->assertEquals(-64, $diff2);
        $this->assertEquals(64, $diff2a);
    }

    public function testDifferentYearLessMonthLessDayLeapYearNormalDateGreaterThanLeapMonthAndLeapDateDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2020, 5, 10, false);
        $lunar2 = $calendar->lunar(2025, 6, 20, true);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(63, $diff1);
        $this->assertEquals(63, $diff1a);
        $this->assertEquals(-63, $diff2);
        $this->assertEquals(63, $diff2a);
    }

    public function testDifferentYearLessMonthLessDayLeapDateAndNormalYearNormalDateDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2020, 4, 10, true);
        $lunar2 = $calendar->lunar(2026, 8, 20, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(78, $diff1);
        $this->assertEquals(78, $diff1a);
        $this->assertEquals(-78, $diff2);
        $this->assertEquals(78, $diff2a);
    }

    public function testDifferentYearLessMonthLessDayLeapDateAndLeapYearNormalDateLessThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2020, 4, 10, true);
        $lunar2 = $calendar->lunar(2025, 5, 20, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(62, $diff1);
        $this->assertEquals(62, $diff1a);
        $this->assertEquals(-62, $diff2);
        $this->assertEquals(62, $diff2a);
    }

    public function testDifferentYearLessMonthLessDayLeapDateAndLeapYearNormalDateEqualLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2020, 4, 10, true);
        $lunar2 = $calendar->lunar(2025, 6, 20, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(63, $diff1);
        $this->assertEquals(63, $diff1a);
        $this->assertEquals(-63, $diff2);
        $this->assertEquals(63, $diff2a);
    }

    public function testDifferentYearLessMonthLessDayLeapDateAndLeapYearNormalDateGreaterThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2020, 4, 10, true);
        $lunar2 = $calendar->lunar(2025, 7, 20, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(65, $diff1);
        $this->assertEquals(65, $diff1a);
        $this->assertEquals(-65, $diff2);
        $this->assertEquals(65, $diff2a);
    }

    public function testDifferentYearLessMonthLessDayLeapDateAndLeapDateDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2020, 4, 10, true);
        $lunar2 = $calendar->lunar(2025, 6, 20, true);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(64, $diff1);
        $this->assertEquals(64, $diff1a);
        $this->assertEquals(-64, $diff2);
        $this->assertEquals(64, $diff2a);
    }

    // endregion different year less month less day

    // region different year less month equal day

    public function testDifferentYearLessMonthEqualDayNormalYearNormalDateAndNormalYearNormalDateDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2018, 2, 10, false);
        $lunar2 = $calendar->lunar(2026, 8, 10, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(105, $diff1);
        $this->assertEquals(105, $diff1a);
        $this->assertEquals(-105, $diff2);
        $this->assertEquals(105, $diff2a);
    }

    public function testDifferentYearLessMonthEqualDayNormalYearNormalDateAndLeapYearNormalDateLessThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2018, 2, 10, false);
        $lunar2 = $calendar->lunar(2025, 5, 10, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(89, $diff1);
        $this->assertEquals(89, $diff1a);
        $this->assertEquals(-89, $diff2);
        $this->assertEquals(89, $diff2a);
    }

    public function testDifferentYearLessMonthEqualDayNormalYearNormalDateAndLeapYearNormalDateEqualLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2018, 2, 10, false);
        $lunar2 = $calendar->lunar(2025, 6, 10, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(90, $diff1);
        $this->assertEquals(90, $diff1a);
        $this->assertEquals(-90, $diff2);
        $this->assertEquals(90, $diff2a);
    }

    public function testDifferentYearLessMonthEqualDayNormalYearNormalDateAndLeapYearNormalDateGreaterThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2018, 2, 10, false);
        $lunar2 = $calendar->lunar(2025, 7, 10, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(92, $diff1);
        $this->assertEquals(92, $diff1a);
        $this->assertEquals(-92, $diff2);
        $this->assertEquals(92, $diff2a);
    }

    public function testDifferentYearLessMonthEqualDayNormalYearNormalDateAndLeapDateDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2018, 2, 10, false);
        $lunar2 = $calendar->lunar(2025, 6, 10, true);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(91, $diff1);
        $this->assertEquals(91, $diff1a);
        $this->assertEquals(-91, $diff2);
        $this->assertEquals(91, $diff2a);
    }

    public function testDifferentYearLessMonthEqualDayLeapYearNormalDateLessThanLeapMonthAndNormalYearNormalDateDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2020, 2, 10, false);
        $lunar2 = $calendar->lunar(2026, 8, 10, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(81, $diff1);
        $this->assertEquals(81, $diff1a);
        $this->assertEquals(-81, $diff2);
        $this->assertEquals(81, $diff2a);
    }

    public function testDifferentYearLessMonthEqualDayLeapYearNormalDateLessThanLeapMonthAndLeapYearNormalDateLessThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2020, 2, 10, false);
        $lunar2 = $calendar->lunar(2025, 5, 10, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(65, $diff1);
        $this->assertEquals(65, $diff1a);
        $this->assertEquals(-65, $diff2);
        $this->assertEquals(65, $diff2a);
    }

    public function testDifferentYearLessMonthEqualDayLeapYearNormalDateLessThanLeapMonthAndLeapYearNormalDateEqualLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2020, 2, 10, false);
        $lunar2 = $calendar->lunar(2025, 6, 10, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(66, $diff1);
        $this->assertEquals(66, $diff1a);
        $this->assertEquals(-66, $diff2);
        $this->assertEquals(66, $diff2a);
    }

    public function testDifferentYearLessMonthEqualDayLeapYearNormalDateLessThanLeapMonthAndLeapYearNormalDateGreaterThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2020, 2, 10, false);
        $lunar2 = $calendar->lunar(2025, 7, 10, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(68, $diff1);
        $this->assertEquals(68, $diff1a);
        $this->assertEquals(-68, $diff2);
        $this->assertEquals(68, $diff2a);
    }

    public function testDifferentYearLessMonthEqualDayLeapYearNormalDateLessThanLeapMonthAndLeapDateDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2020, 2, 10, false);
        $lunar2 = $calendar->lunar(2025, 6, 10, true);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(67, $diff1);
        $this->assertEquals(67, $diff1a);
        $this->assertEquals(-67, $diff2);
        $this->assertEquals(67, $diff2a);
    }

    public function testDifferentYearLessMonthEqualDayLeapYearNormalDateEqualLeapMonthAndNormalYearNormalDateDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2020, 4, 10, false);
        $lunar2 = $calendar->lunar(2026, 8, 10, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(79, $diff1);
        $this->assertEquals(79, $diff1a);
        $this->assertEquals(-79, $diff2);
        $this->assertEquals(79, $diff2a);
    }

    public function testDifferentYearLessMonthEqualDayLeapYearNormalDateEqualLeapMonthAndLeapYearNormalDateLessThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2020, 4, 10, false);
        $lunar2 = $calendar->lunar(2025, 5, 10, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(63, $diff1);
        $this->assertEquals(63, $diff1a);
        $this->assertEquals(-63, $diff2);
        $this->assertEquals(63, $diff2a);
    }

    public function testDifferentYearLessMonthEqualDayLeapYearNormalDateEqualLeapMonthAndLeapYearNormalDateEqualLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2020, 4, 10, false);
        $lunar2 = $calendar->lunar(2025, 6, 10, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(64, $diff1);
        $this->assertEquals(64, $diff1a);
        $this->assertEquals(-64, $diff2);
        $this->assertEquals(64, $diff2a);
    }

    public function testDifferentYearLessMonthEqualDayLeapYearNormalDateEqualLeapMonthAndLeapYearNormalDateGreaterThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2020, 4, 10, false);
        $lunar2 = $calendar->lunar(2025, 7, 10, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(66, $diff1);
        $this->assertEquals(66, $diff1a);
        $this->assertEquals(-66, $diff2);
        $this->assertEquals(66, $diff2a);
    }

    public function testDifferentYearLessMonthEqualDayLeapYearNormalDateEqualLeapMonthAndLeapDateDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2020, 4, 10, false);
        $lunar2 = $calendar->lunar(2025, 6, 10, true);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(65, $diff1);
        $this->assertEquals(65, $diff1a);
        $this->assertEquals(-65, $diff2);
        $this->assertEquals(65, $diff2a);
    }

    public function testDifferentYearLessMonthEqualDayLeapYearNormalDateGreaterThanLeapMonthAndNormalYearNormalDateDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2020, 5, 10, false);
        $lunar2 = $calendar->lunar(2026, 8, 10, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(77, $diff1);
        $this->assertEquals(77, $diff1a);
        $this->assertEquals(-77, $diff2);
        $this->assertEquals(77, $diff2a);
    }

    public function testDifferentYearLessMonthEqualDayLeapYearNormalDateGreaterThanLeapMonthAndLeapYearNormalDateLessThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2020, 5, 10, false);
        $lunar2 = $calendar->lunar(2025, 5, 10, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(61, $diff1);
        $this->assertEquals(61, $diff1a);
        $this->assertEquals(-61, $diff2);
        $this->assertEquals(61, $diff2a);
    }

    public function testDifferentYearLessMonthEqualDayLeapYearNormalDateGreaterThanLeapMonthAndLeapYearNormalDateEqualLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2020, 5, 10, false);
        $lunar2 = $calendar->lunar(2025, 6, 10, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(62, $diff1);
        $this->assertEquals(62, $diff1a);
        $this->assertEquals(-62, $diff2);
        $this->assertEquals(62, $diff2a);
    }

    public function testDifferentYearLessMonthEqualDayLeapYearNormalDateGreaterThanLeapMonthAndLeapYearNormalDateGreaterThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2020, 5, 10, false);
        $lunar2 = $calendar->lunar(2025, 7, 10, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(64, $diff1);
        $this->assertEquals(64, $diff1a);
        $this->assertEquals(-64, $diff2);
        $this->assertEquals(64, $diff2a);
    }

    public function testDifferentYearLessMonthEqualDayLeapYearNormalDateGreaterThanLeapMonthAndLeapDateDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2020, 5, 10, false);
        $lunar2 = $calendar->lunar(2025, 6, 10, true);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(63, $diff1);
        $this->assertEquals(63, $diff1a);
        $this->assertEquals(-63, $diff2);
        $this->assertEquals(63, $diff2a);
    }

    public function testDifferentYearLessMonthEqualDayLeapDateAndNormalYearNormalDateDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2020, 4, 10, true);
        $lunar2 = $calendar->lunar(2026, 8, 10, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(78, $diff1);
        $this->assertEquals(78, $diff1a);
        $this->assertEquals(-78, $diff2);
        $this->assertEquals(78, $diff2a);
    }

    public function testDifferentYearLessMonthEqualDayLeapDateAndLeapYearNormalDateLessThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2020, 4, 10, true);
        $lunar2 = $calendar->lunar(2025, 5, 10, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(62, $diff1);
        $this->assertEquals(62, $diff1a);
        $this->assertEquals(-62, $diff2);
        $this->assertEquals(62, $diff2a);
    }

    public function testDifferentYearLessMonthEqualDayLeapDateAndLeapYearNormalDateEqualLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2020, 4, 10, true);
        $lunar2 = $calendar->lunar(2025, 6, 10, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(63, $diff1);
        $this->assertEquals(63, $diff1a);
        $this->assertEquals(-63, $diff2);
        $this->assertEquals(63, $diff2a);
    }

    public function testDifferentYearLessMonthEqualDayLeapDateAndLeapYearNormalDateGreaterThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2020, 4, 10, true);
        $lunar2 = $calendar->lunar(2025, 7, 10, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(65, $diff1);
        $this->assertEquals(65, $diff1a);
        $this->assertEquals(-65, $diff2);
        $this->assertEquals(65, $diff2a);
    }

    public function testDifferentYearLessMonthEqualDayLeapDateAndLeapDateDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2020, 4, 10, true);
        $lunar2 = $calendar->lunar(2025, 6, 10, true);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(64, $diff1);
        $this->assertEquals(64, $diff1a);
        $this->assertEquals(-64, $diff2);
        $this->assertEquals(64, $diff2a);
    }

    // endregion different year less month equal day

    // region different year less month greater day

    public function testDifferentYearLessMonthGreaterDayNormalYearNormalDateAndNormalYearNormalDateDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2018, 2, 10, false);
        $lunar2 = $calendar->lunar(2026, 8, 9, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(104, $diff1);
        $this->assertEquals(104, $diff1a);
        $this->assertEquals(-104, $diff2);
        $this->assertEquals(104, $diff2a);
    }

    public function testDifferentYearLessMonthGreaterDayNormalYearNormalDateAndLeapYearNormalDateLessThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2018, 2, 10, false);
        $lunar2 = $calendar->lunar(2025, 5, 9, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(88, $diff1);
        $this->assertEquals(88, $diff1a);
        $this->assertEquals(-88, $diff2);
        $this->assertEquals(88, $diff2a);
    }

    public function testDifferentYearLessMonthGreaterDayNormalYearNormalDateAndLeapYearNormalDateEqualLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2018, 2, 10, false);
        $lunar2 = $calendar->lunar(2025, 6, 9, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(89, $diff1);
        $this->assertEquals(89, $diff1a);
        $this->assertEquals(-89, $diff2);
        $this->assertEquals(89, $diff2a);
    }

    public function testDifferentYearLessMonthGreaterDayNormalYearNormalDateAndLeapYearNormalDateGreaterThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2018, 2, 10, false);
        $lunar2 = $calendar->lunar(2025, 7, 9, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(91, $diff1);
        $this->assertEquals(91, $diff1a);
        $this->assertEquals(-91, $diff2);
        $this->assertEquals(91, $diff2a);
    }

    public function testDifferentYearLessMonthGreaterDayNormalYearNormalDateAndLeapDateDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2018, 2, 10, false);
        $lunar2 = $calendar->lunar(2025, 6, 9, true);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(90, $diff1);
        $this->assertEquals(90, $diff1a);
        $this->assertEquals(-90, $diff2);
        $this->assertEquals(90, $diff2a);
    }

    public function testDifferentYearLessMonthGreaterDayLeapYearNormalDateLessThanLeapMonthAndNormalYearNormalDateDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2020, 2, 10, false);
        $lunar2 = $calendar->lunar(2026, 8, 9, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(80, $diff1);
        $this->assertEquals(80, $diff1a);
        $this->assertEquals(-80, $diff2);
        $this->assertEquals(80, $diff2a);
    }

    public function testDifferentYearLessMonthGreaterDayLeapYearNormalDateLessThanLeapMonthAndLeapYearNormalDateLessThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2020, 2, 10, false);
        $lunar2 = $calendar->lunar(2025, 5, 9, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(64, $diff1);
        $this->assertEquals(64, $diff1a);
        $this->assertEquals(-64, $diff2);
        $this->assertEquals(64, $diff2a);
    }

    public function testDifferentYearLessMonthGreaterDayLeapYearNormalDateLessThanLeapMonthAndLeapYearNormalDateEqualLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2020, 2, 10, false);
        $lunar2 = $calendar->lunar(2025, 6, 9, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(65, $diff1);
        $this->assertEquals(65, $diff1a);
        $this->assertEquals(-65, $diff2);
        $this->assertEquals(65, $diff2a);
    }

    public function testDifferentYearLessMonthGreaterDayLeapYearNormalDateLessThanLeapMonthAndLeapYearNormalDateGreaterThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2020, 2, 10, false);
        $lunar2 = $calendar->lunar(2025, 7, 9, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(67, $diff1);
        $this->assertEquals(67, $diff1a);
        $this->assertEquals(-67, $diff2);
        $this->assertEquals(67, $diff2a);
    }

    public function testDifferentYearLessMonthGreaterDayLeapYearNormalDateLessThanLeapMonthAndLeapDateDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2020, 2, 10, false);
        $lunar2 = $calendar->lunar(2025, 6, 9, true);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(66, $diff1);
        $this->assertEquals(66, $diff1a);
        $this->assertEquals(-66, $diff2);
        $this->assertEquals(66, $diff2a);
    }

    public function testDifferentYearLessMonthGreaterDayLeapYearNormalDateEqualLeapMonthAndNormalYearNormalDateDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2020, 4, 10, false);
        $lunar2 = $calendar->lunar(2026, 8, 9, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(78, $diff1);
        $this->assertEquals(78, $diff1a);
        $this->assertEquals(-78, $diff2);
        $this->assertEquals(78, $diff2a);
    }

    public function testDifferentYearLessMonthGreaterDayLeapYearNormalDateEqualLeapMonthAndLeapYearNormalDateLessThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2020, 4, 10, false);
        $lunar2 = $calendar->lunar(2025, 5, 9, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(62, $diff1);
        $this->assertEquals(62, $diff1a);
        $this->assertEquals(-62, $diff2);
        $this->assertEquals(62, $diff2a);
    }

    public function testDifferentYearLessMonthGreaterDayLeapYearNormalDateEqualLeapMonthAndLeapYearNormalDateEqualLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2020, 4, 10, false);
        $lunar2 = $calendar->lunar(2025, 6, 9, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(63, $diff1);
        $this->assertEquals(63, $diff1a);
        $this->assertEquals(-63, $diff2);
        $this->assertEquals(63, $diff2a);
    }

    public function testDifferentYearLessMonthGreaterDayLeapYearNormalDateEqualLeapMonthAndLeapYearNormalDateGreaterThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2020, 4, 10, false);
        $lunar2 = $calendar->lunar(2025, 7, 9, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(65, $diff1);
        $this->assertEquals(65, $diff1a);
        $this->assertEquals(-65, $diff2);
        $this->assertEquals(65, $diff2a);
    }

    public function testDifferentYearLessMonthGreaterDayLeapYearNormalDateEqualLeapMonthAndLeapDateDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2020, 4, 10, false);
        $lunar2 = $calendar->lunar(2025, 6, 9, true);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(64, $diff1);
        $this->assertEquals(64, $diff1a);
        $this->assertEquals(-64, $diff2);
        $this->assertEquals(64, $diff2a);
    }

    public function testDifferentYearLessMonthGreaterDayLeapYearNormalDateGreaterThanLeapMonthAndNormalYearNormalDateDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2020, 5, 10, false);
        $lunar2 = $calendar->lunar(2026, 8, 9, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(76, $diff1);
        $this->assertEquals(76, $diff1a);
        $this->assertEquals(-76, $diff2);
        $this->assertEquals(76, $diff2a);
    }

    public function testDifferentYearLessMonthGreaterDayLeapYearNormalDateGreaterThanLeapMonthAndLeapYearNormalDateLessThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2020, 5, 10, false);
        $lunar2 = $calendar->lunar(2025, 5, 9, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(60, $diff1);
        $this->assertEquals(60, $diff1a);
        $this->assertEquals(-60, $diff2);
        $this->assertEquals(60, $diff2a);
    }

    public function testDifferentYearLessMonthGreaterDayLeapYearNormalDateGreaterThanLeapMonthAndLeapYearNormalDateEqualLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2020, 5, 10, false);
        $lunar2 = $calendar->lunar(2025, 6, 9, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(61, $diff1);
        $this->assertEquals(61, $diff1a);
        $this->assertEquals(-61, $diff2);
        $this->assertEquals(61, $diff2a);
    }

    public function testDifferentYearLessMonthGreaterDayLeapYearNormalDateGreaterThanLeapMonthAndLeapYearNormalDateGreaterThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2020, 5, 10, false);
        $lunar2 = $calendar->lunar(2025, 7, 9, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(63, $diff1);
        $this->assertEquals(63, $diff1a);
        $this->assertEquals(-63, $diff2);
        $this->assertEquals(63, $diff2a);
    }

    public function testDifferentYearLessMonthGreaterDayLeapYearNormalDateGreaterThanLeapMonthAndLeapDateDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2020, 5, 10, false);
        $lunar2 = $calendar->lunar(2025, 6, 9, true);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(62, $diff1);
        $this->assertEquals(62, $diff1a);
        $this->assertEquals(-62, $diff2);
        $this->assertEquals(62, $diff2a);
    }

    public function testDifferentYearLessMonthGreaterDayLeapDateAndNormalYearNormalDateDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2020, 4, 10, true);
        $lunar2 = $calendar->lunar(2026, 8, 9, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(77, $diff1);
        $this->assertEquals(77, $diff1a);
        $this->assertEquals(-77, $diff2);
        $this->assertEquals(77, $diff2a);
    }

    public function testDifferentYearLessMonthGreaterDayLeapDateAndLeapYearNormalDateLessThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2020, 4, 10, true);
        $lunar2 = $calendar->lunar(2025, 5, 9, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(61, $diff1);
        $this->assertEquals(61, $diff1a);
        $this->assertEquals(-61, $diff2);
        $this->assertEquals(61, $diff2a);
    }

    public function testDifferentYearLessMonthGreaterDayLeapDateAndLeapYearNormalDateEqualLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2020, 4, 10, true);
        $lunar2 = $calendar->lunar(2025, 6, 9, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(62, $diff1);
        $this->assertEquals(62, $diff1a);
        $this->assertEquals(-62, $diff2);
        $this->assertEquals(62, $diff2a);
    }

    public function testDifferentYearLessMonthGreaterDayLeapDateAndLeapYearNormalDateGreaterThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2020, 4, 10, true);
        $lunar2 = $calendar->lunar(2025, 7, 9, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(64, $diff1);
        $this->assertEquals(64, $diff1a);
        $this->assertEquals(-64, $diff2);
        $this->assertEquals(64, $diff2a);
    }

    public function testDifferentYearLessMonthGreaterDayLeapDateAndLeapDateDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2020, 4, 10, true);
        $lunar2 = $calendar->lunar(2025, 6, 9, true);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(63, $diff1);
        $this->assertEquals(63, $diff1a);
        $this->assertEquals(-63, $diff2);
        $this->assertEquals(63, $diff2a);
    }

    // endregion different year less month greater day

    // region different year equal month less day

    public function testDifferentYearEqualMonthLessDayNormalYearNormalDateAndNormalYearNormalDateDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2018, 2, 10, false);
        $lunar2 = $calendar->lunar(2026, 2, 20, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(99, $diff1);
        $this->assertEquals(99, $diff1a);
        $this->assertEquals(-99, $diff2);
        $this->assertEquals(99, $diff2a);
    }

    public function testDifferentYearEqualMonthLessDayNormalYearNormalDateAndLeapYearNormalDateLessThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2018, 2, 10, false);
        $lunar2 = $calendar->lunar(2025, 2, 20, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(86, $diff1);
        $this->assertEquals(86, $diff1a);
        $this->assertEquals(-86, $diff2);
        $this->assertEquals(86, $diff2a);
    }

    public function testDifferentYearEqualMonthLessDayNormalYearNormalDateAndLeapYearNormalDateEqualLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2018, 6, 10, false);
        $lunar2 = $calendar->lunar(2025, 6, 20, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(86, $diff1);
        $this->assertEquals(86, $diff1a);
        $this->assertEquals(-86, $diff2);
        $this->assertEquals(86, $diff2a);
    }

    public function testDifferentYearEqualMonthLessDayNormalYearNormalDateAndLeapYearNormalDateGreaterThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2018, 7, 10, false);
        $lunar2 = $calendar->lunar(2025, 7, 20, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(87, $diff1);
        $this->assertEquals(87, $diff1a);
        $this->assertEquals(-87, $diff2);
        $this->assertEquals(87, $diff2a);
    }

    public function testDifferentYearEqualMonthLessDayNormalYearNormalDateAndLeapDateDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2018, 6, 10, false);
        $lunar2 = $calendar->lunar(2025, 6, 20, true);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(87, $diff1);
        $this->assertEquals(87, $diff1a);
        $this->assertEquals(-87, $diff2);
        $this->assertEquals(87, $diff2a);
    }

    public function testDifferentYearEqualMonthLessDayLeapYearNormalDateLessThanLeapMonthAndNormalYearNormalDateDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2020, 2, 10, false);
        $lunar2 = $calendar->lunar(2026, 2, 20, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(75, $diff1);
        $this->assertEquals(75, $diff1a);
        $this->assertEquals(-75, $diff2);
        $this->assertEquals(75, $diff2a);
    }

    public function testDifferentYearEqualMonthLessDayLeapYearNormalDateLessThanLeapMonthAndLeapYearNormalDateLessThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2020, 2, 10, false);
        $lunar2 = $calendar->lunar(2025, 2, 20, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(62, $diff1);
        $this->assertEquals(62, $diff1a);
        $this->assertEquals(-62, $diff2);
        $this->assertEquals(62, $diff2a);
    }

    public function testDifferentYearEqualMonthLessDayLeapYearNormalDateLessThanLeapMonthAndLeapYearNormalDateEqualLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 5, 10, false);
        $lunar2 = $calendar->lunar(2028, 5, 20, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(136, $diff1);
        $this->assertEquals(136, $diff1a);
        $this->assertEquals(-136, $diff2);
        $this->assertEquals(136, $diff2a);
    }

    public function testDifferentYearEqualMonthLessDayLeapYearNormalDateLessThanLeapMonthAndLeapYearNormalDateGreaterThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 5, 10, false);
        $lunar2 = $calendar->lunar(2023, 5, 20, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(75, $diff1);
        $this->assertEquals(75, $diff1a);
        $this->assertEquals(-75, $diff2);
        $this->assertEquals(75, $diff2a);
    }

    public function testDifferentYearEqualMonthLessDayLeapYearNormalDateLessThanLeapMonthAndLeapDateDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 5, 10, false);
        $lunar2 = $calendar->lunar(2028, 5, 20, true);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(137, $diff1);
        $this->assertEquals(137, $diff1a);
        $this->assertEquals(-137, $diff2);
        $this->assertEquals(137, $diff2a);
    }

    public function testDifferentYearEqualMonthLessDayLeapYearNormalDateEqualLeapMonthAndNormalYearNormalDateDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, false);
        $lunar2 = $calendar->lunar(2026, 6, 20, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(112, $diff1);
        $this->assertEquals(112, $diff1a);
        $this->assertEquals(-112, $diff2);
        $this->assertEquals(112, $diff2a);
    }

    public function testDifferentYearEqualMonthLessDayLeapYearNormalDateEqualLeapMonthAndLeapYearNormalDateLessThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, false);
        $lunar2 = $calendar->lunar(2033, 6, 20, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(198, $diff1);
        $this->assertEquals(198, $diff1a);
        $this->assertEquals(-198, $diff2);
        $this->assertEquals(198, $diff2a);
    }

    public function testDifferentYearEqualMonthLessDayLeapYearNormalDateEqualLeapMonthAndLeapYearNormalDateEqualLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, false);
        $lunar2 = $calendar->lunar(2025, 6, 20, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(99, $diff1);
        $this->assertEquals(99, $diff1a);
        $this->assertEquals(-99, $diff2);
        $this->assertEquals(99, $diff2a);
    }

    public function testDifferentYearEqualMonthLessDayLeapYearNormalDateEqualLeapMonthAndLeapYearNormalDateGreaterThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, false);
        $lunar2 = $calendar->lunar(2028, 6, 20, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(137, $diff1);
        $this->assertEquals(137, $diff1a);
        $this->assertEquals(-137, $diff2);
        $this->assertEquals(137, $diff2a);
    }

    public function testDifferentYearEqualMonthLessDayLeapYearNormalDateEqualLeapMonthAndLeapDateDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, false);
        $lunar2 = $calendar->lunar(2025, 6, 20, true);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(100, $diff1);
        $this->assertEquals(100, $diff1a);
        $this->assertEquals(-100, $diff2);
        $this->assertEquals(100, $diff2a);
    }

    public function testDifferentYearEqualMonthLessDayLeapYearNormalDateGreaterThanLeapMonthAndNormalYearNormalDateDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2020, 5, 10, false);
        $lunar2 = $calendar->lunar(2026, 4, 20, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(73, $diff1);
        $this->assertEquals(73, $diff1a);
        $this->assertEquals(-73, $diff2);
        $this->assertEquals(73, $diff2a);
    }

    public function testDifferentYearEqualMonthLessDayLeapYearNormalDateGreaterThanLeapMonthAndLeapYearNormalDateLessThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2020, 5, 10, false);
        $lunar2 = $calendar->lunar(2033, 5, 20, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(160, $diff1);
        $this->assertEquals(160, $diff1a);
        $this->assertEquals(-160, $diff2);
        $this->assertEquals(160, $diff2a);
    }

    public function testDifferentYearEqualMonthLessDayLeapYearNormalDateGreaterThanLeapMonthAndLeapYearNormalDateEqualLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2020, 5, 10, false);
        $lunar2 = $calendar->lunar(2028, 5, 20, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(98, $diff1);
        $this->assertEquals(98, $diff1a);
        $this->assertEquals(-98, $diff2);
        $this->assertEquals(98, $diff2a);
    }

    public function testDifferentYearEqualMonthLessDayLeapYearNormalDateGreaterThanLeapMonthAndLeapYearNormalDateGreaterThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2020, 5, 10, false);
        $lunar2 = $calendar->lunar(2031, 5, 20, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(136, $diff1);
        $this->assertEquals(136, $diff1a);
        $this->assertEquals(-136, $diff2);
        $this->assertEquals(136, $diff2a);
    }

    public function testDifferentYearEqualMonthLessDayLeapYearNormalDateGreaterThanLeapMonthAndLeapDateDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2020, 5, 10, false);
        $lunar2 = $calendar->lunar(2028, 5, 20, true);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(99, $diff1);
        $this->assertEquals(99, $diff1a);
        $this->assertEquals(-99, $diff2);
        $this->assertEquals(99, $diff2a);
    }

    public function testDifferentYearEqualMonthLessDayLeapDateAndNormalYearNormalDateDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, true);
        $lunar2 = $calendar->lunar(2026, 6, 20, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(111, $diff1);
        $this->assertEquals(111, $diff1a);
        $this->assertEquals(-111, $diff2);
        $this->assertEquals(111, $diff2a);
    }

    public function testDifferentYearEqualMonthLessDayLeapDateAndLeapYearNormalDateLessThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, true);
        $lunar2 = $calendar->lunar(2033, 6, 20, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(197, $diff1);
        $this->assertEquals(197, $diff1a);
        $this->assertEquals(-197, $diff2);
        $this->assertEquals(197, $diff2a);
    }

    public function testDifferentYearEqualMonthLessDayLeapDateAndLeapYearNormalDateEqualLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, true);
        $lunar2 = $calendar->lunar(2025, 6, 20, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(98, $diff1);
        $this->assertEquals(98, $diff1a);
        $this->assertEquals(-98, $diff2);
        $this->assertEquals(98, $diff2a);
    }

    public function testDifferentYearEqualMonthLessDayLeapDateAndLeapYearNormalDateGreaterThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, true);
        $lunar2 = $calendar->lunar(2028, 6, 20, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(136, $diff1);
        $this->assertEquals(136, $diff1a);
        $this->assertEquals(-136, $diff2);
        $this->assertEquals(136, $diff2a);
    }

    public function testDifferentYearEqualMonthLessDayLeapDateAndLeapDateDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, true);
        $lunar2 = $calendar->lunar(2025, 6, 20, true);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(99, $diff1);
        $this->assertEquals(99, $diff1a);
        $this->assertEquals(-99, $diff2);
        $this->assertEquals(99, $diff2a);
    }

    // endregion different year equal month less day

    // region different year equal month equal day

    public function testDifferentYearEqualMonthEqualDayNormalYearNormalDateAndNormalYearNormalDateDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2018, 2, 10, false);
        $lunar2 = $calendar->lunar(2026, 2, 10, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(99, $diff1);
        $this->assertEquals(99, $diff1a);
        $this->assertEquals(-99, $diff2);
        $this->assertEquals(99, $diff2a);
    }

    public function testDifferentYearEqualMonthEqualDayNormalYearNormalDateAndLeapYearNormalDateLessThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2018, 2, 10, false);
        $lunar2 = $calendar->lunar(2025, 2, 10, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(86, $diff1);
        $this->assertEquals(86, $diff1a);
        $this->assertEquals(-86, $diff2);
        $this->assertEquals(86, $diff2a);
    }

    public function testDifferentYearEqualMonthEqualDayNormalYearNormalDateAndLeapYearNormalDateEqualLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2018, 6, 10, false);
        $lunar2 = $calendar->lunar(2025, 6, 10, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(86, $diff1);
        $this->assertEquals(86, $diff1a);
        $this->assertEquals(-86, $diff2);
        $this->assertEquals(86, $diff2a);
    }

    public function testDifferentYearEqualMonthEqualDayNormalYearNormalDateAndLeapYearNormalDateGreaterThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2018, 7, 10, false);
        $lunar2 = $calendar->lunar(2025, 7, 10, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(87, $diff1);
        $this->assertEquals(87, $diff1a);
        $this->assertEquals(-87, $diff2);
        $this->assertEquals(87, $diff2a);
    }

    public function testDifferentYearEqualMonthEqualDayNormalYearNormalDateAndLeapDateDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2018, 6, 10, false);
        $lunar2 = $calendar->lunar(2025, 6, 10, true);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(87, $diff1);
        $this->assertEquals(87, $diff1a);
        $this->assertEquals(-87, $diff2);
        $this->assertEquals(87, $diff2a);
    }

    public function testDifferentYearEqualMonthEqualDayLeapYearNormalDateLessThanLeapMonthAndNormalYearNormalDateDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2020, 2, 10, false);
        $lunar2 = $calendar->lunar(2026, 2, 10, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(75, $diff1);
        $this->assertEquals(75, $diff1a);
        $this->assertEquals(-75, $diff2);
        $this->assertEquals(75, $diff2a);
    }

    public function testDifferentYearEqualMonthEqualDayLeapYearNormalDateLessThanLeapMonthAndLeapYearNormalDateLessThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2020, 2, 10, false);
        $lunar2 = $calendar->lunar(2025, 2, 10, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(62, $diff1);
        $this->assertEquals(62, $diff1a);
        $this->assertEquals(-62, $diff2);
        $this->assertEquals(62, $diff2a);
    }

    public function testDifferentYearEqualMonthEqualDayLeapYearNormalDateLessThanLeapMonthAndLeapYearNormalDateEqualLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 5, 10, false);
        $lunar2 = $calendar->lunar(2028, 5, 10, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(136, $diff1);
        $this->assertEquals(136, $diff1a);
        $this->assertEquals(-136, $diff2);
        $this->assertEquals(136, $diff2a);
    }

    public function testDifferentYearEqualMonthEqualDayLeapYearNormalDateLessThanLeapMonthAndLeapYearNormalDateGreaterThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 5, 10, false);
        $lunar2 = $calendar->lunar(2023, 5, 10, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(75, $diff1);
        $this->assertEquals(75, $diff1a);
        $this->assertEquals(-75, $diff2);
        $this->assertEquals(75, $diff2a);
    }

    public function testDifferentYearEqualMonthEqualDayLeapYearNormalDateLessThanLeapMonthAndLeapDateDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 5, 10, false);
        $lunar2 = $calendar->lunar(2028, 5, 10, true);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(137, $diff1);
        $this->assertEquals(137, $diff1a);
        $this->assertEquals(-137, $diff2);
        $this->assertEquals(137, $diff2a);
    }

    public function testDifferentYearEqualMonthEqualDayLeapYearNormalDateEqualLeapMonthAndNormalYearNormalDateDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, false);
        $lunar2 = $calendar->lunar(2026, 6, 10, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(112, $diff1);
        $this->assertEquals(112, $diff1a);
        $this->assertEquals(-112, $diff2);
        $this->assertEquals(112, $diff2a);
    }

    public function testDifferentYearEqualMonthEqualDayLeapYearNormalDateEqualLeapMonthAndLeapYearNormalDateLessThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, false);
        $lunar2 = $calendar->lunar(2033, 6, 10, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(198, $diff1);
        $this->assertEquals(198, $diff1a);
        $this->assertEquals(-198, $diff2);
        $this->assertEquals(198, $diff2a);
    }

    public function testDifferentYearEqualMonthEqualDayLeapYearNormalDateEqualLeapMonthAndLeapYearNormalDateEqualLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, false);
        $lunar2 = $calendar->lunar(2025, 6, 10, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(99, $diff1);
        $this->assertEquals(99, $diff1a);
        $this->assertEquals(-99, $diff2);
        $this->assertEquals(99, $diff2a);
    }

    public function testDifferentYearEqualMonthEqualDayLeapYearNormalDateEqualLeapMonthAndLeapYearNormalDateGreaterThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, false);
        $lunar2 = $calendar->lunar(2028, 6, 10, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(137, $diff1);
        $this->assertEquals(137, $diff1a);
        $this->assertEquals(-137, $diff2);
        $this->assertEquals(137, $diff2a);
    }

    public function testDifferentYearEqualMonthEqualDayLeapYearNormalDateEqualLeapMonthAndLeapDateDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, false);
        $lunar2 = $calendar->lunar(2025, 6, 10, true);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(100, $diff1);
        $this->assertEquals(100, $diff1a);
        $this->assertEquals(-100, $diff2);
        $this->assertEquals(100, $diff2a);
    }

    public function testDifferentYearEqualMonthEqualDayLeapYearNormalDateGreaterThanLeapMonthAndNormalYearNormalDateDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2020, 5, 10, false);
        $lunar2 = $calendar->lunar(2026, 4, 10, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(73, $diff1);
        $this->assertEquals(73, $diff1a);
        $this->assertEquals(-73, $diff2);
        $this->assertEquals(73, $diff2a);
    }

    public function testDifferentYearEqualMonthEqualDayLeapYearNormalDateGreaterThanLeapMonthAndLeapYearNormalDateLessThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2020, 5, 10, false);
        $lunar2 = $calendar->lunar(2033, 5, 10, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(160, $diff1);
        $this->assertEquals(160, $diff1a);
        $this->assertEquals(-160, $diff2);
        $this->assertEquals(160, $diff2a);
    }

    public function testDifferentYearEqualMonthEqualDayLeapYearNormalDateGreaterThanLeapMonthAndLeapYearNormalDateEqualLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2020, 5, 10, false);
        $lunar2 = $calendar->lunar(2028, 5, 10, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(98, $diff1);
        $this->assertEquals(98, $diff1a);
        $this->assertEquals(-98, $diff2);
        $this->assertEquals(98, $diff2a);
    }

    public function testDifferentYearEqualMonthEqualDayLeapYearNormalDateGreaterThanLeapMonthAndLeapYearNormalDateGreaterThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2020, 5, 10, false);
        $lunar2 = $calendar->lunar(2031, 5, 10, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(136, $diff1);
        $this->assertEquals(136, $diff1a);
        $this->assertEquals(-136, $diff2);
        $this->assertEquals(136, $diff2a);
    }

    public function testDifferentYearEqualMonthEqualDayLeapYearNormalDateGreaterThanLeapMonthAndLeapDateDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2020, 5, 10, false);
        $lunar2 = $calendar->lunar(2028, 5, 10, true);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(99, $diff1);
        $this->assertEquals(99, $diff1a);
        $this->assertEquals(-99, $diff2);
        $this->assertEquals(99, $diff2a);
    }

    public function testDifferentYearEqualMonthEqualDayLeapDateAndNormalYearNormalDateDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, true);
        $lunar2 = $calendar->lunar(2026, 6, 10, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(111, $diff1);
        $this->assertEquals(111, $diff1a);
        $this->assertEquals(-111, $diff2);
        $this->assertEquals(111, $diff2a);
    }

    public function testDifferentYearEqualMonthEqualDayLeapDateAndLeapYearNormalDateLessThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, true);
        $lunar2 = $calendar->lunar(2033, 6, 10, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(197, $diff1);
        $this->assertEquals(197, $diff1a);
        $this->assertEquals(-197, $diff2);
        $this->assertEquals(197, $diff2a);
    }

    public function testDifferentYearEqualMonthEqualDayLeapDateAndLeapYearNormalDateEqualLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, true);
        $lunar2 = $calendar->lunar(2025, 6, 10, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(98, $diff1);
        $this->assertEquals(98, $diff1a);
        $this->assertEquals(-98, $diff2);
        $this->assertEquals(98, $diff2a);
    }

    public function testDifferentYearEqualMonthEqualDayLeapDateAndLeapYearNormalDateGreaterThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, true);
        $lunar2 = $calendar->lunar(2028, 6, 10, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(136, $diff1);
        $this->assertEquals(136, $diff1a);
        $this->assertEquals(-136, $diff2);
        $this->assertEquals(136, $diff2a);
    }

    public function testDifferentYearEqualMonthEqualDayLeapDateAndLeapDateDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, true);
        $lunar2 = $calendar->lunar(2025, 6, 10, true);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(99, $diff1);
        $this->assertEquals(99, $diff1a);
        $this->assertEquals(-99, $diff2);
        $this->assertEquals(99, $diff2a);
    }

    // endregion different year equal month equal day

    // region different year equal month greater day

    public function testDifferentYearEqualMonthGreaterDayNormalYearNormalDateAndNormalYearNormalDateDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2018, 2, 10, false);
        $lunar2 = $calendar->lunar(2026, 2, 1, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(98, $diff1);
        $this->assertEquals(98, $diff1a);
        $this->assertEquals(-98, $diff2);
        $this->assertEquals(98, $diff2a);
    }

    public function testDifferentYearEqualMonthGreaterDayNormalYearNormalDateAndLeapYearNormalDateLessThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2018, 2, 10, false);
        $lunar2 = $calendar->lunar(2025, 2, 1, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(85, $diff1);
        $this->assertEquals(85, $diff1a);
        $this->assertEquals(-85, $diff2);
        $this->assertEquals(85, $diff2a);
    }

    public function testDifferentYearEqualMonthGreaterDayNormalYearNormalDateAndLeapYearNormalDateEqualLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2018, 6, 10, false);
        $lunar2 = $calendar->lunar(2025, 6, 1, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(85, $diff1);
        $this->assertEquals(85, $diff1a);
        $this->assertEquals(-85, $diff2);
        $this->assertEquals(85, $diff2a);
    }

    public function testDifferentYearEqualMonthGreaterDayNormalYearNormalDateAndLeapYearNormalDateGreaterThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2018, 7, 10, false);
        $lunar2 = $calendar->lunar(2025, 7, 1, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(86, $diff1);
        $this->assertEquals(86, $diff1a);
        $this->assertEquals(-86, $diff2);
        $this->assertEquals(86, $diff2a);
    }

    public function testDifferentYearEqualMonthGreaterDayNormalYearNormalDateAndLeapDateDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2018, 6, 10, false);
        $lunar2 = $calendar->lunar(2025, 6, 1, true);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(86, $diff1);
        $this->assertEquals(86, $diff1a);
        $this->assertEquals(-86, $diff2);
        $this->assertEquals(86, $diff2a);
    }

    public function testDifferentYearEqualMonthGreaterDayLeapYearNormalDateLessThanLeapMonthAndNormalYearNormalDateDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2020, 2, 10, false);
        $lunar2 = $calendar->lunar(2026, 2, 1, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(74, $diff1);
        $this->assertEquals(74, $diff1a);
        $this->assertEquals(-74, $diff2);
        $this->assertEquals(74, $diff2a);
    }

    public function testDifferentYearEqualMonthGreaterDayLeapYearNormalDateLessThanLeapMonthAndLeapYearNormalDateLessThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2020, 2, 10, false);
        $lunar2 = $calendar->lunar(2025, 2, 1, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(61, $diff1);
        $this->assertEquals(61, $diff1a);
        $this->assertEquals(-61, $diff2);
        $this->assertEquals(61, $diff2a);
    }

    public function testDifferentYearEqualMonthGreaterDayLeapYearNormalDateLessThanLeapMonthAndLeapYearNormalDateEqualLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 5, 10, false);
        $lunar2 = $calendar->lunar(2028, 5, 1, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(135, $diff1);
        $this->assertEquals(135, $diff1a);
        $this->assertEquals(-135, $diff2);
        $this->assertEquals(135, $diff2a);
    }

    public function testDifferentYearEqualMonthGreaterDayLeapYearNormalDateLessThanLeapMonthAndLeapYearNormalDateGreaterThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 5, 10, false);
        $lunar2 = $calendar->lunar(2023, 5, 1, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(74, $diff1);
        $this->assertEquals(74, $diff1a);
        $this->assertEquals(-74, $diff2);
        $this->assertEquals(74, $diff2a);
    }

    public function testDifferentYearEqualMonthGreaterDayLeapYearNormalDateLessThanLeapMonthAndLeapDateDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 5, 10, false);
        $lunar2 = $calendar->lunar(2028, 5, 1, true);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(136, $diff1);
        $this->assertEquals(136, $diff1a);
        $this->assertEquals(-136, $diff2);
        $this->assertEquals(136, $diff2a);
    }

    public function testDifferentYearEqualMonthGreaterDayLeapYearNormalDateEqualLeapMonthAndNormalYearNormalDateDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, false);
        $lunar2 = $calendar->lunar(2026, 6, 1, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(111, $diff1);
        $this->assertEquals(111, $diff1a);
        $this->assertEquals(-111, $diff2);
        $this->assertEquals(111, $diff2a);
    }

    public function testDifferentYearEqualMonthGreaterDayLeapYearNormalDateEqualLeapMonthAndLeapYearNormalDateLessThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, false);
        $lunar2 = $calendar->lunar(2033, 6, 1, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(197, $diff1);
        $this->assertEquals(197, $diff1a);
        $this->assertEquals(-197, $diff2);
        $this->assertEquals(197, $diff2a);
    }

    public function testDifferentYearEqualMonthGreaterDayLeapYearNormalDateEqualLeapMonthAndLeapYearNormalDateEqualLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, false);
        $lunar2 = $calendar->lunar(2025, 6, 1, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(98, $diff1);
        $this->assertEquals(98, $diff1a);
        $this->assertEquals(-98, $diff2);
        $this->assertEquals(98, $diff2a);
    }

    public function testDifferentYearEqualMonthGreaterDayLeapYearNormalDateEqualLeapMonthAndLeapYearNormalDateGreaterThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, false);
        $lunar2 = $calendar->lunar(2028, 6, 1, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(136, $diff1);
        $this->assertEquals(136, $diff1a);
        $this->assertEquals(-136, $diff2);
        $this->assertEquals(136, $diff2a);
    }

    public function testDifferentYearEqualMonthGreaterDayLeapYearNormalDateEqualLeapMonthAndLeapDateDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, false);
        $lunar2 = $calendar->lunar(2025, 6, 1, true);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(99, $diff1);
        $this->assertEquals(99, $diff1a);
        $this->assertEquals(-99, $diff2);
        $this->assertEquals(99, $diff2a);
    }

    public function testDifferentYearEqualMonthGreaterDayLeapYearNormalDateGreaterThanLeapMonthAndNormalYearNormalDateDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2020, 5, 10, false);
        $lunar2 = $calendar->lunar(2026, 4, 1, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(72, $diff1);
        $this->assertEquals(72, $diff1a);
        $this->assertEquals(-72, $diff2);
        $this->assertEquals(72, $diff2a);
    }

    public function testDifferentYearEqualMonthGreaterDayLeapYearNormalDateGreaterThanLeapMonthAndLeapYearNormalDateLessThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2020, 5, 10, false);
        $lunar2 = $calendar->lunar(2033, 5, 1, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(159, $diff1);
        $this->assertEquals(159, $diff1a);
        $this->assertEquals(-159, $diff2);
        $this->assertEquals(159, $diff2a);
    }

    public function testDifferentYearEqualMonthGreaterDayLeapYearNormalDateGreaterThanLeapMonthAndLeapYearNormalDateEqualLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2020, 5, 10, false);
        $lunar2 = $calendar->lunar(2028, 5, 1, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(97, $diff1);
        $this->assertEquals(97, $diff1a);
        $this->assertEquals(-97, $diff2);
        $this->assertEquals(97, $diff2a);
    }

    public function testDifferentYearEqualMonthGreaterDayLeapYearNormalDateGreaterThanLeapMonthAndLeapYearNormalDateGreaterThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2020, 5, 10, false);
        $lunar2 = $calendar->lunar(2031, 5, 1, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(135, $diff1);
        $this->assertEquals(135, $diff1a);
        $this->assertEquals(-135, $diff2);
        $this->assertEquals(135, $diff2a);
    }

    public function testDifferentYearEqualMonthGreaterDayLeapYearNormalDateGreaterThanLeapMonthAndLeapDateDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2020, 5, 10, false);
        $lunar2 = $calendar->lunar(2028, 5, 1, true);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(98, $diff1);
        $this->assertEquals(98, $diff1a);
        $this->assertEquals(-98, $diff2);
        $this->assertEquals(98, $diff2a);
    }

    public function testDifferentYearEqualMonthGreaterDayLeapDateAndNormalYearNormalDateDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, true);
        $lunar2 = $calendar->lunar(2026, 6, 1, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(110, $diff1);
        $this->assertEquals(110, $diff1a);
        $this->assertEquals(-110, $diff2);
        $this->assertEquals(110, $diff2a);
    }

    public function testDifferentYearEqualMonthGreaterDayLeapDateAndLeapYearNormalDateLessThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, true);
        $lunar2 = $calendar->lunar(2033, 6, 1, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(196, $diff1);
        $this->assertEquals(196, $diff1a);
        $this->assertEquals(-196, $diff2);
        $this->assertEquals(196, $diff2a);
    }

    public function testDifferentYearEqualMonthGreaterDayLeapDateAndLeapYearNormalDateEqualLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, true);
        $lunar2 = $calendar->lunar(2025, 6, 1, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(97, $diff1);
        $this->assertEquals(97, $diff1a);
        $this->assertEquals(-97, $diff2);
        $this->assertEquals(97, $diff2a);
    }

    public function testDifferentYearEqualMonthGreaterDayLeapDateAndLeapYearNormalDateGreaterThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, true);
        $lunar2 = $calendar->lunar(2028, 6, 1, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(135, $diff1);
        $this->assertEquals(135, $diff1a);
        $this->assertEquals(-135, $diff2);
        $this->assertEquals(135, $diff2a);
    }

    public function testDifferentYearEqualMonthGreaterDayLeapDateAndLeapDateDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, true);
        $lunar2 = $calendar->lunar(2025, 6, 1, true);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(98, $diff1);
        $this->assertEquals(98, $diff1a);
        $this->assertEquals(-98, $diff2);
        $this->assertEquals(98, $diff2a);
    }

    // endregion different year equal month greater day

    // region different year greater month less day

    public function testDifferentYearGreaterMonthLessDayNormalYearNormalDateAndNormalYearNormalDateDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2018, 6, 10, false);
        $lunar2 = $calendar->lunar(2026, 2, 20, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(95, $diff1);
        $this->assertEquals(95, $diff1a);
        $this->assertEquals(-95, $diff2);
        $this->assertEquals(95, $diff2a);
    }

    public function testDifferentYearGreaterMonthLessDayNormalYearNormalDateAndLeapYearNormalDateLessThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2018, 6, 10, false);
        $lunar2 = $calendar->lunar(2025, 2, 20, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(82, $diff1);
        $this->assertEquals(82, $diff1a);
        $this->assertEquals(-82, $diff2);
        $this->assertEquals(82, $diff2a);
    }

    public function testDifferentYearGreaterMonthLessDayNormalYearNormalDateAndLeapYearNormalDateEqualLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2018, 7, 10, false);
        $lunar2 = $calendar->lunar(2025, 6, 20, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(85, $diff1);
        $this->assertEquals(85, $diff1a);
        $this->assertEquals(-85, $diff2);
        $this->assertEquals(85, $diff2a);
    }

    public function testDifferentYearGreaterMonthLessDayNormalYearNormalDateAndLeapYearNormalDateGreaterThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2018, 8, 10, false);
        $lunar2 = $calendar->lunar(2025, 7, 20, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(86, $diff1);
        $this->assertEquals(86, $diff1a);
        $this->assertEquals(-86, $diff2);
        $this->assertEquals(86, $diff2a);
    }

    public function testDifferentYearGreaterMonthLessDayNormalYearNormalDateAndLeapDateDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2018, 7, 10, false);
        $lunar2 = $calendar->lunar(2025, 6, 20, true);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(86, $diff1);
        $this->assertEquals(86, $diff1a);
        $this->assertEquals(-86, $diff2);
        $this->assertEquals(86, $diff2a);
    }

    public function testDifferentYearGreaterMonthLessDayLeapYearNormalDateLessThanLeapMonthAndNormalYearNormalDateDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2020, 3, 10, false);
        $lunar2 = $calendar->lunar(2026, 2, 20, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(74, $diff1);
        $this->assertEquals(74, $diff1a);
        $this->assertEquals(-74, $diff2);
        $this->assertEquals(74, $diff2a);
    }

    public function testDifferentYearGreaterMonthLessDayLeapYearNormalDateLessThanLeapMonthAndLeapYearNormalDateLessThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2020, 3, 10, false);
        $lunar2 = $calendar->lunar(2025, 2, 20, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(61, $diff1);
        $this->assertEquals(61, $diff1a);
        $this->assertEquals(-61, $diff2);
        $this->assertEquals(61, $diff2a);
    }

    public function testDifferentYearGreaterMonthLessDayLeapYearNormalDateLessThanLeapMonthAndLeapYearNormalDateEqualLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 5, 10, false);
        $lunar2 = $calendar->lunar(2023, 2, 20, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(71, $diff1);
        $this->assertEquals(71, $diff1a);
        $this->assertEquals(-71, $diff2);
        $this->assertEquals(71, $diff2a);
    }

    public function testDifferentYearGreaterMonthLessDayLeapYearNormalDateLessThanLeapMonthAndLeapYearNormalDateGreaterThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 5, 10, false);
        $lunar2 = $calendar->lunar(2023, 4, 20, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(74, $diff1);
        $this->assertEquals(74, $diff1a);
        $this->assertEquals(-74, $diff2);
        $this->assertEquals(74, $diff2a);
    }

    public function testDifferentYearGreaterMonthLessDayLeapYearNormalDateLessThanLeapMonthAndLeapDateDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 5, 10, false);
        $lunar2 = $calendar->lunar(2023, 2, 20, true);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(72, $diff1);
        $this->assertEquals(72, $diff1a);
        $this->assertEquals(-72, $diff2);
        $this->assertEquals(72, $diff2a);
    }

    public function testDifferentYearGreaterMonthLessDayLeapYearNormalDateEqualLeapMonthAndNormalYearNormalDateDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, false);
        $lunar2 = $calendar->lunar(2026, 5, 20, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(111, $diff1);
        $this->assertEquals(111, $diff1a);
        $this->assertEquals(-111, $diff2);
        $this->assertEquals(111, $diff2a);
    }

    public function testDifferentYearGreaterMonthLessDayLeapYearNormalDateEqualLeapMonthAndLeapYearNormalDateLessThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, false);
        $lunar2 = $calendar->lunar(2033, 5, 20, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(197, $diff1);
        $this->assertEquals(197, $diff1a);
        $this->assertEquals(-197, $diff2);
        $this->assertEquals(197, $diff2a);
    }

    public function testDifferentYearGreaterMonthLessDayLeapYearNormalDateEqualLeapMonthAndLeapYearNormalDateEqualLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, false);
        $lunar2 = $calendar->lunar(2023, 2, 20, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(70, $diff1);
        $this->assertEquals(70, $diff1a);
        $this->assertEquals(-70, $diff2);
        $this->assertEquals(70, $diff2a);
    }

    public function testDifferentYearGreaterMonthLessDayLeapYearNormalDateEqualLeapMonthAndLeapYearNormalDateGreaterThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, false);
        $lunar2 = $calendar->lunar(2023, 5, 20, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(74, $diff1);
        $this->assertEquals(74, $diff1a);
        $this->assertEquals(-74, $diff2);
        $this->assertEquals(74, $diff2a);
    }

    public function testDifferentYearGreaterMonthLessDayLeapYearNormalDateEqualLeapMonthAndLeapDateDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, false);
        $lunar2 = $calendar->lunar(2023, 2, 20, true);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(71, $diff1);
        $this->assertEquals(71, $diff1a);
        $this->assertEquals(-71, $diff2);
        $this->assertEquals(71, $diff2a);
    }

    public function testDifferentYearGreaterMonthLessDayLeapYearNormalDateGreaterThanLeapMonthAndNormalYearNormalDateDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 7, 10, false);
        $lunar2 = $calendar->lunar(2026, 5, 20, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(109, $diff1);
        $this->assertEquals(109, $diff1a);
        $this->assertEquals(-109, $diff2);
        $this->assertEquals(109, $diff2a);
    }

    public function testDifferentYearGreaterMonthLessDayLeapYearNormalDateGreaterThanLeapMonthAndLeapYearNormalDateLessThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 7, 10, false);
        $lunar2 = $calendar->lunar(2033, 5, 20, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(195, $diff1);
        $this->assertEquals(195, $diff1a);
        $this->assertEquals(-195, $diff2);
        $this->assertEquals(195, $diff2a);
    }

    public function testDifferentYearGreaterMonthLessDayLeapYearNormalDateGreaterThanLeapMonthAndLeapYearNormalDateEqualLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 7, 10, false);
        $lunar2 = $calendar->lunar(2023, 2, 20, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(68, $diff1);
        $this->assertEquals(68, $diff1a);
        $this->assertEquals(-68, $diff2);
        $this->assertEquals(68, $diff2a);
    }

    public function testDifferentYearGreaterMonthLessDayLeapYearNormalDateGreaterThanLeapMonthAndLeapYearNormalDateGreaterThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 7, 10, false);
        $lunar2 = $calendar->lunar(2023, 5, 20, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(72, $diff1);
        $this->assertEquals(72, $diff1a);
        $this->assertEquals(-72, $diff2);
        $this->assertEquals(72, $diff2a);
    }

    public function testDifferentYearGreaterMonthLessDayLeapYearNormalDateGreaterThanLeapMonthAndLeapDateDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 7, 10, false);
        $lunar2 = $calendar->lunar(2023, 2, 20, true);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(69, $diff1);
        $this->assertEquals(69, $diff1a);
        $this->assertEquals(-69, $diff2);
        $this->assertEquals(69, $diff2a);
    }

    public function testDifferentYearGreaterMonthLessDayLeapYearLeapDateAndNormalYearNormalDateDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, true);
        $lunar2 = $calendar->lunar(2026, 5, 20, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(110, $diff1);
        $this->assertEquals(110, $diff1a);
        $this->assertEquals(-110, $diff2);
        $this->assertEquals(110, $diff2a);
    }

    public function testDifferentYearGreaterMonthLessDayLeapYearLeapDateAndLeapYearNormalDateLessThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, true);
        $lunar2 = $calendar->lunar(2033, 5, 20, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(196, $diff1);
        $this->assertEquals(196, $diff1a);
        $this->assertEquals(-196, $diff2);
        $this->assertEquals(196, $diff2a);
    }

    public function testDifferentYearGreaterMonthLessDayLeapYearLeapDateAndLeapYearNormalDateEqualLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, true);
        $lunar2 = $calendar->lunar(2023, 2, 20, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(69, $diff1);
        $this->assertEquals(69, $diff1a);
        $this->assertEquals(-69, $diff2);
        $this->assertEquals(69, $diff2a);
    }

    public function testDifferentYearGreaterMonthLessDayLeapYearLeapDateAndLeapYearNormalDateGreaterThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, true);
        $lunar2 = $calendar->lunar(2023, 5, 20, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(73, $diff1);
        $this->assertEquals(73, $diff1a);
        $this->assertEquals(-73, $diff2);
        $this->assertEquals(73, $diff2a);
    }

    public function testDifferentYearGreaterMonthLessDayLeapYearLeapDateAndLeapDateDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, true);
        $lunar2 = $calendar->lunar(2023, 2, 20, true);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(70, $diff1);
        $this->assertEquals(70, $diff1a);
        $this->assertEquals(-70, $diff2);
        $this->assertEquals(70, $diff2a);
    }

    // endregion different year greater month less day

    // region different year greater month equal day

    public function testDifferentYearGreaterMonthEqualDayNormalYearNormalDateAndNormalYearNormalDateDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2018, 6, 10, false);
        $lunar2 = $calendar->lunar(2026, 2, 10, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(95, $diff1);
        $this->assertEquals(95, $diff1a);
        $this->assertEquals(-95, $diff2);
        $this->assertEquals(95, $diff2a);
    }

    public function testDifferentYearGreaterMonthEqualDayNormalYearNormalDateAndLeapYearNormalDateLessThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2018, 6, 10, false);
        $lunar2 = $calendar->lunar(2025, 2, 10, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(82, $diff1);
        $this->assertEquals(82, $diff1a);
        $this->assertEquals(-82, $diff2);
        $this->assertEquals(82, $diff2a);
    }

    public function testDifferentYearGreaterMonthEqualDayNormalYearNormalDateAndLeapYearNormalDateEqualLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2018, 7, 10, false);
        $lunar2 = $calendar->lunar(2025, 6, 10, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(85, $diff1);
        $this->assertEquals(85, $diff1a);
        $this->assertEquals(-85, $diff2);
        $this->assertEquals(85, $diff2a);
    }

    public function testDifferentYearGreaterMonthEqualDayNormalYearNormalDateAndLeapYearNormalDateGreaterThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2018, 8, 10, false);
        $lunar2 = $calendar->lunar(2025, 7, 10, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(86, $diff1);
        $this->assertEquals(86, $diff1a);
        $this->assertEquals(-86, $diff2);
        $this->assertEquals(86, $diff2a);
    }

    public function testDifferentYearGreaterMonthEqualDayNormalYearNormalDateAndLeapDateDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2018, 7, 10, false);
        $lunar2 = $calendar->lunar(2025, 6, 10, true);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(86, $diff1);
        $this->assertEquals(86, $diff1a);
        $this->assertEquals(-86, $diff2);
        $this->assertEquals(86, $diff2a);
    }

    public function testDifferentYearGreaterMonthEqualDayLeapYearNormalDateLessThanLeapMonthAndNormalYearNormalDateDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2020, 3, 10, false);
        $lunar2 = $calendar->lunar(2026, 2, 10, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(74, $diff1);
        $this->assertEquals(74, $diff1a);
        $this->assertEquals(-74, $diff2);
        $this->assertEquals(74, $diff2a);
    }

    public function testDifferentYearGreaterMonthEqualDayLeapYearNormalDateLessThanLeapMonthAndLeapYearNormalDateLessThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2020, 3, 10, false);
        $lunar2 = $calendar->lunar(2025, 2, 10, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(61, $diff1);
        $this->assertEquals(61, $diff1a);
        $this->assertEquals(-61, $diff2);
        $this->assertEquals(61, $diff2a);
    }

    public function testDifferentYearGreaterMonthEqualDayLeapYearNormalDateLessThanLeapMonthAndLeapYearNormalDateEqualLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 5, 10, false);
        $lunar2 = $calendar->lunar(2023, 2, 10, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(71, $diff1);
        $this->assertEquals(71, $diff1a);
        $this->assertEquals(-71, $diff2);
        $this->assertEquals(71, $diff2a);
    }

    public function testDifferentYearGreaterMonthEqualDayLeapYearNormalDateLessThanLeapMonthAndLeapYearNormalDateGreaterThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 5, 10, false);
        $lunar2 = $calendar->lunar(2023, 4, 10, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(74, $diff1);
        $this->assertEquals(74, $diff1a);
        $this->assertEquals(-74, $diff2);
        $this->assertEquals(74, $diff2a);
    }

    public function testDifferentYearGreaterMonthEqualDayLeapYearNormalDateLessThanLeapMonthAndLeapDateDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 5, 10, false);
        $lunar2 = $calendar->lunar(2023, 2, 10, true);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(72, $diff1);
        $this->assertEquals(72, $diff1a);
        $this->assertEquals(-72, $diff2);
        $this->assertEquals(72, $diff2a);
    }

    public function testDifferentYearGreaterMonthEqualDayLeapYearNormalDateEqualLeapMonthAndNormalYearNormalDateDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, false);
        $lunar2 = $calendar->lunar(2026, 5, 10, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(111, $diff1);
        $this->assertEquals(111, $diff1a);
        $this->assertEquals(-111, $diff2);
        $this->assertEquals(111, $diff2a);
    }

    public function testDifferentYearGreaterMonthEqualDayLeapYearNormalDateEqualLeapMonthAndLeapYearNormalDateLessThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, false);
        $lunar2 = $calendar->lunar(2033, 5, 10, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(197, $diff1);
        $this->assertEquals(197, $diff1a);
        $this->assertEquals(-197, $diff2);
        $this->assertEquals(197, $diff2a);
    }

    public function testDifferentYearGreaterMonthEqualDayLeapYearNormalDateEqualLeapMonthAndLeapYearNormalDateEqualLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, false);
        $lunar2 = $calendar->lunar(2023, 2, 10, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(70, $diff1);
        $this->assertEquals(70, $diff1a);
        $this->assertEquals(-70, $diff2);
        $this->assertEquals(70, $diff2a);
    }

    public function testDifferentYearGreaterMonthEqualDayLeapYearNormalDateEqualLeapMonthAndLeapYearNormalDateGreaterThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, false);
        $lunar2 = $calendar->lunar(2023, 5, 10, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(74, $diff1);
        $this->assertEquals(74, $diff1a);
        $this->assertEquals(-74, $diff2);
        $this->assertEquals(74, $diff2a);
    }

    public function testDifferentYearGreaterMonthEqualDayLeapYearNormalDateEqualLeapMonthAndLeapDateDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, false);
        $lunar2 = $calendar->lunar(2023, 2, 10, true);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(71, $diff1);
        $this->assertEquals(71, $diff1a);
        $this->assertEquals(-71, $diff2);
        $this->assertEquals(71, $diff2a);
    }

    public function testDifferentYearGreaterMonthEqualDayLeapYearNormalDateGreaterThanLeapMonthAndNormalYearNormalDateDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 7, 10, false);
        $lunar2 = $calendar->lunar(2026, 5, 10, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(109, $diff1);
        $this->assertEquals(109, $diff1a);
        $this->assertEquals(-109, $diff2);
        $this->assertEquals(109, $diff2a);
    }

    public function testDifferentYearGreaterMonthEqualDayLeapYearNormalDateGreaterThanLeapMonthAndLeapYearNormalDateLessThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 7, 10, false);
        $lunar2 = $calendar->lunar(2033, 5, 10, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(195, $diff1);
        $this->assertEquals(195, $diff1a);
        $this->assertEquals(-195, $diff2);
        $this->assertEquals(195, $diff2a);
    }

    public function testDifferentYearGreaterMonthEqualDayLeapYearNormalDateGreaterThanLeapMonthAndLeapYearNormalDateEqualLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 7, 10, false);
        $lunar2 = $calendar->lunar(2023, 2, 10, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(68, $diff1);
        $this->assertEquals(68, $diff1a);
        $this->assertEquals(-68, $diff2);
        $this->assertEquals(68, $diff2a);
    }

    public function testDifferentYearGreaterMonthEqualDayLeapYearNormalDateGreaterThanLeapMonthAndLeapYearNormalDateGreaterThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 7, 10, false);
        $lunar2 = $calendar->lunar(2023, 5, 10, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(72, $diff1);
        $this->assertEquals(72, $diff1a);
        $this->assertEquals(-72, $diff2);
        $this->assertEquals(72, $diff2a);
    }

    public function testDifferentYearGreaterMonthEqualDayLeapYearNormalDateGreaterThanLeapMonthAndLeapDateDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 7, 10, false);
        $lunar2 = $calendar->lunar(2023, 2, 10, true);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(69, $diff1);
        $this->assertEquals(69, $diff1a);
        $this->assertEquals(-69, $diff2);
        $this->assertEquals(69, $diff2a);
    }

    public function testDifferentYearGreaterMonthEqualDayLeapYearLeapDateAndNormalYearNormalDateDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, true);
        $lunar2 = $calendar->lunar(2026, 5, 10, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(110, $diff1);
        $this->assertEquals(110, $diff1a);
        $this->assertEquals(-110, $diff2);
        $this->assertEquals(110, $diff2a);
    }

    public function testDifferentYearGreaterMonthEqualDayLeapYearLeapDateAndLeapYearNormalDateLessThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, true);
        $lunar2 = $calendar->lunar(2033, 5, 10, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(196, $diff1);
        $this->assertEquals(196, $diff1a);
        $this->assertEquals(-196, $diff2);
        $this->assertEquals(196, $diff2a);
    }

    public function testDifferentYearGreaterMonthEqualDayLeapYearLeapDateAndLeapYearNormalDateEqualLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, true);
        $lunar2 = $calendar->lunar(2023, 2, 10, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(69, $diff1);
        $this->assertEquals(69, $diff1a);
        $this->assertEquals(-69, $diff2);
        $this->assertEquals(69, $diff2a);
    }

    public function testDifferentYearGreaterMonthEqualDayLeapYearLeapDateAndLeapYearNormalDateGreaterThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, true);
        $lunar2 = $calendar->lunar(2023, 5, 10, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(73, $diff1);
        $this->assertEquals(73, $diff1a);
        $this->assertEquals(-73, $diff2);
        $this->assertEquals(73, $diff2a);
    }

    public function testDifferentYearGreaterMonthEqualDayLeapYearLeapDateAndLeapDateDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, true);
        $lunar2 = $calendar->lunar(2023, 2, 10, true);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(70, $diff1);
        $this->assertEquals(70, $diff1a);
        $this->assertEquals(-70, $diff2);
        $this->assertEquals(70, $diff2a);
    }

    // endregion different year greater month equal day

    // region different year greater month greater day

    public function testDifferentYearGreaterMonthGreaterDayNormalYearNormalDateAndNormalYearNormalDateDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2018, 6, 10, false);
        $lunar2 = $calendar->lunar(2026, 2, 9, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(94, $diff1);
        $this->assertEquals(94, $diff1a);
        $this->assertEquals(-94, $diff2);
        $this->assertEquals(94, $diff2a);
    }

    public function testDifferentYearGreaterMonthGreaterDayNormalYearNormalDateAndLeapYearNormalDateLessThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2018, 6, 10, false);
        $lunar2 = $calendar->lunar(2025, 2, 9, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(81, $diff1);
        $this->assertEquals(81, $diff1a);
        $this->assertEquals(-81, $diff2);
        $this->assertEquals(81, $diff2a);
    }

    public function testDifferentYearGreaterMonthGreaterDayNormalYearNormalDateAndLeapYearNormalDateEqualLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2018, 7, 10, false);
        $lunar2 = $calendar->lunar(2025, 6, 9, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(84, $diff1);
        $this->assertEquals(84, $diff1a);
        $this->assertEquals(-84, $diff2);
        $this->assertEquals(84, $diff2a);
    }

    public function testDifferentYearGreaterMonthGreaterDayNormalYearNormalDateAndLeapYearNormalDateGreaterThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2018, 8, 10, false);
        $lunar2 = $calendar->lunar(2025, 7, 9, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(85, $diff1);
        $this->assertEquals(85, $diff1a);
        $this->assertEquals(-85, $diff2);
        $this->assertEquals(85, $diff2a);
    }

    public function testDifferentYearGreaterMonthGreaterDayNormalYearNormalDateAndLeapDateDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2018, 7, 10, false);
        $lunar2 = $calendar->lunar(2025, 6, 9, true);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(85, $diff1);
        $this->assertEquals(85, $diff1a);
        $this->assertEquals(-85, $diff2);
        $this->assertEquals(85, $diff2a);
    }

    public function testDifferentYearGreaterMonthGreaterDayLeapYearNormalDateLessThanLeapMonthAndNormalYearNormalDateDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2020, 3, 10, false);
        $lunar2 = $calendar->lunar(2026, 2, 9, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(73, $diff1);
        $this->assertEquals(73, $diff1a);
        $this->assertEquals(-73, $diff2);
        $this->assertEquals(73, $diff2a);
    }

    public function testDifferentYearGreaterMonthGreaterDayLeapYearNormalDateLessThanLeapMonthAndLeapYearNormalDateLessThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2020, 3, 10, false);
        $lunar2 = $calendar->lunar(2025, 2, 9, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(60, $diff1);
        $this->assertEquals(60, $diff1a);
        $this->assertEquals(-60, $diff2);
        $this->assertEquals(60, $diff2a);
    }

    public function testDifferentYearGreaterMonthGreaterDayLeapYearNormalDateLessThanLeapMonthAndLeapYearNormalDateEqualLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 5, 10, false);
        $lunar2 = $calendar->lunar(2023, 2, 9, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(70, $diff1);
        $this->assertEquals(70, $diff1a);
        $this->assertEquals(-70, $diff2);
        $this->assertEquals(70, $diff2a);
    }

    public function testDifferentYearGreaterMonthGreaterDayLeapYearNormalDateLessThanLeapMonthAndLeapYearNormalDateGreaterThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 5, 10, false);
        $lunar2 = $calendar->lunar(2023, 4, 9, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(73, $diff1);
        $this->assertEquals(73, $diff1a);
        $this->assertEquals(-73, $diff2);
        $this->assertEquals(73, $diff2a);
    }

    public function testDifferentYearGreaterMonthGreaterDayLeapYearNormalDateLessThanLeapMonthAndLeapDateDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 5, 10, false);
        $lunar2 = $calendar->lunar(2023, 2, 9, true);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(71, $diff1);
        $this->assertEquals(71, $diff1a);
        $this->assertEquals(-71, $diff2);
        $this->assertEquals(71, $diff2a);
    }

    public function testDifferentYearGreaterMonthGreaterDayLeapYearNormalDateEqualLeapMonthAndNormalYearNormalDateDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, false);
        $lunar2 = $calendar->lunar(2026, 5, 9, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(110, $diff1);
        $this->assertEquals(110, $diff1a);
        $this->assertEquals(-110, $diff2);
        $this->assertEquals(110, $diff2a);
    }

    public function testDifferentYearGreaterMonthGreaterDayLeapYearNormalDateEqualLeapMonthAndLeapYearNormalDateLessThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, false);
        $lunar2 = $calendar->lunar(2033, 5, 9, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(196, $diff1);
        $this->assertEquals(196, $diff1a);
        $this->assertEquals(-196, $diff2);
        $this->assertEquals(196, $diff2a);
    }

    public function testDifferentYearGreaterMonthGreaterDayLeapYearNormalDateEqualLeapMonthAndLeapYearNormalDateEqualLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, false);
        $lunar2 = $calendar->lunar(2023, 2, 9, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(69, $diff1);
        $this->assertEquals(69, $diff1a);
        $this->assertEquals(-69, $diff2);
        $this->assertEquals(69, $diff2a);
    }

    public function testDifferentYearGreaterMonthGreaterDayLeapYearNormalDateEqualLeapMonthAndLeapYearNormalDateGreaterThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, false);
        $lunar2 = $calendar->lunar(2023, 5, 9, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(73, $diff1);
        $this->assertEquals(73, $diff1a);
        $this->assertEquals(-73, $diff2);
        $this->assertEquals(73, $diff2a);
    }

    public function testDifferentYearGreaterMonthGreaterDayLeapYearNormalDateEqualLeapMonthAndLeapDateDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, false);
        $lunar2 = $calendar->lunar(2023, 2, 9, true);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(70, $diff1);
        $this->assertEquals(70, $diff1a);
        $this->assertEquals(-70, $diff2);
        $this->assertEquals(70, $diff2a);
    }

    public function testDifferentYearGreaterMonthGreaterDayLeapYearNormalDateGreaterThanLeapMonthAndNormalYearNormalDateDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 7, 10, false);
        $lunar2 = $calendar->lunar(2026, 5, 9, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(108, $diff1);
        $this->assertEquals(108, $diff1a);
        $this->assertEquals(-108, $diff2);
        $this->assertEquals(108, $diff2a);
    }

    public function testDifferentYearGreaterMonthGreaterDayLeapYearNormalDateGreaterThanLeapMonthAndLeapYearNormalDateLessThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 7, 10, false);
        $lunar2 = $calendar->lunar(2033, 5, 9, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(194, $diff1);
        $this->assertEquals(194, $diff1a);
        $this->assertEquals(-194, $diff2);
        $this->assertEquals(194, $diff2a);
    }

    public function testDifferentYearGreaterMonthGreaterDayLeapYearNormalDateGreaterThanLeapMonthAndLeapYearNormalDateEqualLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 7, 10, false);
        $lunar2 = $calendar->lunar(2023, 2, 9, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(67, $diff1);
        $this->assertEquals(67, $diff1a);
        $this->assertEquals(-67, $diff2);
        $this->assertEquals(67, $diff2a);
    }

    public function testDifferentYearGreaterMonthGreaterDayLeapYearNormalDateGreaterThanLeapMonthAndLeapYearNormalDateGreaterThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 7, 10, false);
        $lunar2 = $calendar->lunar(2023, 5, 9, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(71, $diff1);
        $this->assertEquals(71, $diff1a);
        $this->assertEquals(-71, $diff2);
        $this->assertEquals(71, $diff2a);
    }

    public function testDifferentYearGreaterMonthGreaterDayLeapYearNormalDateGreaterThanLeapMonthAndLeapDateDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 7, 10, false);
        $lunar2 = $calendar->lunar(2023, 2, 9, true);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(68, $diff1);
        $this->assertEquals(68, $diff1a);
        $this->assertEquals(-68, $diff2);
        $this->assertEquals(68, $diff2a);
    }

    public function testDifferentYearGreaterMonthGreaterDayLeapYearLeapDateAndNormalYearNormalDateDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, true);
        $lunar2 = $calendar->lunar(2026, 5, 9, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(109, $diff1);
        $this->assertEquals(109, $diff1a);
        $this->assertEquals(-109, $diff2);
        $this->assertEquals(109, $diff2a);
    }

    public function testDifferentYearGreaterMonthGreaterDayLeapYearLeapDateAndLeapYearNormalDateLessThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, true);
        $lunar2 = $calendar->lunar(2033, 5, 9, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(195, $diff1);
        $this->assertEquals(195, $diff1a);
        $this->assertEquals(-195, $diff2);
        $this->assertEquals(195, $diff2a);
    }

    public function testDifferentYearGreaterMonthGreaterDayLeapYearLeapDateAndLeapYearNormalDateEqualLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, true);
        $lunar2 = $calendar->lunar(2023, 2, 9, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(68, $diff1);
        $this->assertEquals(68, $diff1a);
        $this->assertEquals(-68, $diff2);
        $this->assertEquals(68, $diff2a);
    }

    public function testDifferentYearGreaterMonthGreaterDayLeapYearLeapDateAndLeapYearNormalDateGreaterThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, true);
        $lunar2 = $calendar->lunar(2023, 5, 9, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(72, $diff1);
        $this->assertEquals(72, $diff1a);
        $this->assertEquals(-72, $diff2);
        $this->assertEquals(72, $diff2a);
    }

    public function testDifferentYearGreaterMonthGreaterDayLeapYearLeapDateAndLeapDateDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, true);
        $lunar2 = $calendar->lunar(2023, 2, 9, true);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(69, $diff1);
        $this->assertEquals(69, $diff1a);
        $this->assertEquals(-69, $diff2);
        $this->assertEquals(69, $diff2a);
    }

    // endregion different year greater month greater day

    // region same year less month less day

    public function testSameYearLessMonthLessDayNormalYearNormalDateAndNormalDateDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2018, 2, 10, false);
        $lunar2 = $calendar->lunar(2018, 8, 20, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(6, $diff1);
        $this->assertEquals(6, $diff1a);
        $this->assertEquals(-6, $diff2);
        $this->assertEquals(6, $diff2a);
    }

    public function testSameYearLessMonthLessDayLeapYearNormalDateLessThanLeapMonthAndNormalDateLessThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2025, 2, 10, false);
        $lunar2 = $calendar->lunar(2025, 5, 20, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(3, $diff1);
        $this->assertEquals(3, $diff1a);
        $this->assertEquals(-3, $diff2);
        $this->assertEquals(3, $diff2a);
    }

    public function testSameYearLessMonthLessDayLeapYearNormalDateLessThanLeapMonthAndNormalDateEqualLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2025, 3, 10, false);
        $lunar2 = $calendar->lunar(2025, 6, 20, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(3, $diff1);
        $this->assertEquals(3, $diff1a);
        $this->assertEquals(-3, $diff2);
        $this->assertEquals(3, $diff2a);
    }

    public function testSameYearLessMonthLessDayLeapYearNormalDateLessThanLeapMonthAndNormalDateGreaterThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2025, 5, 10, false);
        $lunar2 = $calendar->lunar(2025, 7, 20, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(3, $diff1);
        $this->assertEquals(3, $diff1a);
        $this->assertEquals(-3, $diff2);
        $this->assertEquals(3, $diff2a);
    }

    public function testSameYearLessMonthLessDayLeapYearNormalDateLessThanLeapMonthAndLeapDateDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2025, 4, 10, false);
        $lunar2 = $calendar->lunar(2025, 6, 20, true);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(3, $diff1);
        $this->assertEquals(3, $diff1a);
        $this->assertEquals(-3, $diff2);
        $this->assertEquals(3, $diff2a);
    }

    public function testSameYearLessMonthLessDayLeapYearNormalDateEqualLeapMonthAndNormalDateGreaterThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2025, 6, 10, false);
        $lunar2 = $calendar->lunar(2025, 8, 20, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(3, $diff1);
        $this->assertEquals(3, $diff1a);
        $this->assertEquals(-3, $diff2);
        $this->assertEquals(3, $diff2a);
    }

    public function testSameYearLessMonthLessDayLeapYearNormalDateGreaterThanLeapMonthAndNormalDateGreaterThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2025, 7, 10, false);
        $lunar2 = $calendar->lunar(2025, 10, 20, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(3, $diff1);
        $this->assertEquals(3, $diff1a);
        $this->assertEquals(-3, $diff2);
        $this->assertEquals(3, $diff2a);
    }

    public function testSameYearLessMonthLessDayLeapYearLeapDateAndNormalDateGreaterThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2025, 6, 10, true);
        $lunar2 = $calendar->lunar(2025, 9, 20, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(3, $diff1);
        $this->assertEquals(3, $diff1a);
        $this->assertEquals(-3, $diff2);
        $this->assertEquals(3, $diff2a);
    }

    // endregion same year less month less day

    // region same year less month equal day

    public function testSameYearLessMonthEqualDayNormalYearNormalDateAndNormalDateDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2018, 2, 10, false);
        $lunar2 = $calendar->lunar(2018, 8, 10, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(6, $diff1);
        $this->assertEquals(6, $diff1a);
        $this->assertEquals(-6, $diff2);
        $this->assertEquals(6, $diff2a);
    }

    public function testSameYearLessMonthEqualDayLeapYearNormalDateLessThanLeapMonthAndNormalDateLessThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2025, 2, 10, false);
        $lunar2 = $calendar->lunar(2025, 5, 10, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(3, $diff1);
        $this->assertEquals(3, $diff1a);
        $this->assertEquals(-3, $diff2);
        $this->assertEquals(3, $diff2a);
    }

    public function testSameYearLessMonthEqualDayLeapYearNormalDateLessThanLeapMonthAndNormalDateEqualLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2025, 3, 10, false);
        $lunar2 = $calendar->lunar(2025, 6, 10, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(3, $diff1);
        $this->assertEquals(3, $diff1a);
        $this->assertEquals(-3, $diff2);
        $this->assertEquals(3, $diff2a);
    }

    public function testSameYearLessMonthEqualDayLeapYearNormalDateLessThanLeapMonthAndNormalDateGreaterThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2025, 5, 10, false);
        $lunar2 = $calendar->lunar(2025, 7, 10, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(3, $diff1);
        $this->assertEquals(3, $diff1a);
        $this->assertEquals(-3, $diff2);
        $this->assertEquals(3, $diff2a);
    }

    public function testSameYearLessMonthEqualDayLeapYearNormalDateLessThanLeapMonthAndLeapDateDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2025, 4, 10, false);
        $lunar2 = $calendar->lunar(2025, 6, 10, true);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(3, $diff1);
        $this->assertEquals(3, $diff1a);
        $this->assertEquals(-3, $diff2);
        $this->assertEquals(3, $diff2a);
    }

    public function testSameYearLessMonthEqualDayLeapYearNormalDateEqualLeapMonthAndNormalDateGreaterThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2025, 6, 10, false);
        $lunar2 = $calendar->lunar(2025, 8, 10, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(3, $diff1);
        $this->assertEquals(3, $diff1a);
        $this->assertEquals(-3, $diff2);
        $this->assertEquals(3, $diff2a);
    }

    public function testSameYearLessMonthEqualDayLeapYearNormalDateGreaterThanLeapMonthAndNormalDateGreaterThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2025, 7, 10, false);
        $lunar2 = $calendar->lunar(2025, 10, 10, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(3, $diff1);
        $this->assertEquals(3, $diff1a);
        $this->assertEquals(-3, $diff2);
        $this->assertEquals(3, $diff2a);
    }

    public function testSameYearLessMonthEqualDayLeapYearLeapDateAndNormalDateGreaterThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2025, 6, 10, true);
        $lunar2 = $calendar->lunar(2025, 9, 10, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(3, $diff1);
        $this->assertEquals(3, $diff1a);
        $this->assertEquals(-3, $diff2);
        $this->assertEquals(3, $diff2a);
    }

    // endregion same year less month equal day

    // region same year less month greater day

    public function testSameYearLessMonthGreaterDayNormalYearNormalDateAndNormalDateDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2018, 2, 10, false);
        $lunar2 = $calendar->lunar(2018, 8, 9, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(5, $diff1);
        $this->assertEquals(5, $diff1a);
        $this->assertEquals(-5, $diff2);
        $this->assertEquals(5, $diff2a);
    }

    public function testSameYearLessMonthGreaterDayLeapYearNormalDateLessThanLeapMonthAndNormalDateLessThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2025, 2, 10, false);
        $lunar2 = $calendar->lunar(2025, 5, 9, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(2, $diff1);
        $this->assertEquals(2, $diff1a);
        $this->assertEquals(-2, $diff2);
        $this->assertEquals(2, $diff2a);
    }

    public function testSameYearLessMonthGreaterDayLeapYearNormalDateLessThanLeapMonthAndNormalDateEqualLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2025, 3, 10, false);
        $lunar2 = $calendar->lunar(2025, 6, 9, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(2, $diff1);
        $this->assertEquals(2, $diff1a);
        $this->assertEquals(-2, $diff2);
        $this->assertEquals(2, $diff2a);
    }

    public function testSameYearLessMonthGreaterDayLeapYearNormalDateLessThanLeapMonthAndNormalDateGreaterThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2025, 5, 10, false);
        $lunar2 = $calendar->lunar(2025, 7, 9, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(2, $diff1);
        $this->assertEquals(2, $diff1a);
        $this->assertEquals(-2, $diff2);
        $this->assertEquals(2, $diff2a);
    }

    public function testSameYearLessMonthGreaterDayLeapYearNormalDateLessThanLeapMonthAndLeapDateDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2025, 4, 10, false);
        $lunar2 = $calendar->lunar(2025, 6, 9, true);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(2, $diff1);
        $this->assertEquals(2, $diff1a);
        $this->assertEquals(-2, $diff2);
        $this->assertEquals(2, $diff2a);
    }

    public function testSameYearLessMonthGreaterDayLeapYearNormalDateEqualLeapMonthAndNormalDateGreaterThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2025, 6, 10, false);
        $lunar2 = $calendar->lunar(2025, 8, 9, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(2, $diff1);
        $this->assertEquals(2, $diff1a);
        $this->assertEquals(-2, $diff2);
        $this->assertEquals(2, $diff2a);
    }

    public function testSameYearLessMonthGreaterDayLeapYearNormalDateGreaterThanLeapMonthAndNormalDateGreaterThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2025, 7, 10, false);
        $lunar2 = $calendar->lunar(2025, 10, 9, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(2, $diff1);
        $this->assertEquals(2, $diff1a);
        $this->assertEquals(-2, $diff2);
        $this->assertEquals(2, $diff2a);
    }

    public function testSameYearLessMonthGreaterDayLeapYearLeapDateAndNormalDateGreaterThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2025, 6, 10, true);
        $lunar2 = $calendar->lunar(2025, 9, 9, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(2, $diff1);
        $this->assertEquals(2, $diff1a);
        $this->assertEquals(-2, $diff2);
        $this->assertEquals(2, $diff2a);
    }

    // endregion same year less month greater day

    // region same year equal month less day

    public function testSameYearEqualMonthLessDayNormalYearNormalDateAndNormalDateDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2018, 8, 10, false);
        $lunar2 = $calendar->lunar(2018, 8, 20, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(0, $diff1);
        $this->assertEquals(0, $diff1a);
        $this->assertEquals(-0, $diff2);
        $this->assertEquals(0, $diff2a);
    }

    public function testSameYearEqualMonthLessDayLeapYearNormalDateLessThanLeapMonthAndNormalDateLessThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2025, 2, 10, false);
        $lunar2 = $calendar->lunar(2025, 2, 20, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(0, $diff1);
        $this->assertEquals(0, $diff1a);
        $this->assertEquals(-0, $diff2);
        $this->assertEquals(0, $diff2a);
    }

    public function testSameYearEqualMonthLessDayLeapYearNormalDateEqualLeapMonthAndNormalDateEqualLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2025, 6, 10, false);
        $lunar2 = $calendar->lunar(2025, 6, 20, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(0, $diff1);
        $this->assertEquals(0, $diff1a);
        $this->assertEquals(-0, $diff2);
        $this->assertEquals(0, $diff2a);
    }

    public function testSameYearEqualMonthLessDayLeapYearNormalDateGreaterThanLeapMonthAndNormalDateGreaterThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2025, 8, 10, false);
        $lunar2 = $calendar->lunar(2025, 8, 20, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(0, $diff1);
        $this->assertEquals(0, $diff1a);
        $this->assertEquals(-0, $diff2);
        $this->assertEquals(0, $diff2a);
    }

    public function testSameYearEqualMonthLessDayLeapYearNormalDateLessThanLeapMonthAndLeapDateDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2025, 6, 10, false);
        $lunar2 = $calendar->lunar(2025, 6, 20, true);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(1, $diff1);
        $this->assertEquals(1, $diff1a);
        $this->assertEquals(-1, $diff2);
        $this->assertEquals(1, $diff2a);
    }

    public function testSameYearEqualMonthLessDayLeapDateAndLeapDateDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2025, 6, 10, true);
        $lunar2 = $calendar->lunar(2025, 6, 20, true);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(0, $diff1);
        $this->assertEquals(0, $diff1a);
        $this->assertEquals(-0, $diff2);
        $this->assertEquals(0, $diff2a);
    }

    // endregion same year equal month less day

    // region same year equal month equal day

    public function testSameYearEqualMonthEqualDayNormalYearNormalDateAndNormalDateDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2018, 8, 10, false);
        $lunar2 = $calendar->lunar(2018, 8, 10, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(0, $diff1);
        $this->assertEquals(0, $diff1a);
        $this->assertEquals(-0, $diff2);
        $this->assertEquals(0, $diff2a);
    }

    public function testSameYearEqualMonthEqualDayLeapYearNormalDateLessThanLeapMonthAndNormalDateLessThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2025, 2, 10, false);
        $lunar2 = $calendar->lunar(2025, 2, 10, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(0, $diff1);
        $this->assertEquals(0, $diff1a);
        $this->assertEquals(-0, $diff2);
        $this->assertEquals(0, $diff2a);
    }

    public function testSameYearEqualMonthEqualDayLeapYearNormalDateEqualLeapMonthAndNormalDateEqualLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2025, 6, 10, false);
        $lunar2 = $calendar->lunar(2025, 6, 10, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(0, $diff1);
        $this->assertEquals(0, $diff1a);
        $this->assertEquals(-0, $diff2);
        $this->assertEquals(0, $diff2a);
    }

    public function testSameYearEqualMonthEqualDayLeapYearNormalDateGreaterThanLeapMonthAndNormalDateGreaterThanLeapMonthDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2025, 8, 10, false);
        $lunar2 = $calendar->lunar(2025, 8, 10, false);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(0, $diff1);
        $this->assertEquals(0, $diff1a);
        $this->assertEquals(-0, $diff2);
        $this->assertEquals(0, $diff2a);
    }

    public function testSameYearEqualMonthEqualDayLeapYearNormalDateLessThanLeapMonthAndLeapDateDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2025, 6, 10, false);
        $lunar2 = $calendar->lunar(2025, 6, 10, true);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(1, $diff1);
        $this->assertEquals(1, $diff1a);
        $this->assertEquals(-1, $diff2);
        $this->assertEquals(1, $diff2a);
    }

    public function testSameYearEqualMonthEqualDayLeapDateAndLeapDateDiffInMonths(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2025, 6, 10, true);
        $lunar2 = $calendar->lunar(2025, 6, 10, true);
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1);
        $this->assertEquals(0, $diff1);
        $this->assertEquals(0, $diff1a);
        $this->assertEquals(-0, $diff2);
        $this->assertEquals(0, $diff2a);
    }

    // endregion same year equal month equal day

    // endregion diffInMonths

    // region diffInDays

    public function testDiffInDays(): void
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2018, 7, 18, false);
        $lunar2 = $calendar->lunar(2044, 7, 18, true);
        $diff1 = $calendar->diffInDays($lunar1, $lunar2, false);
        $diff1a = $calendar->diffInDays($lunar1, $lunar2);
        $diff2 = $calendar->diffInDays($lunar2, $lunar1, false);
        $diff2a = $calendar->diffInDays($lunar2, $lunar1);
        $this->assertEquals(9509, $diff1);
        $this->assertEquals(9509, $diff1a);
        $this->assertEquals(-9509, $diff2);
        $this->assertEquals(9509, $diff2a);
    }

    public function testDiffInDaysAcrossLocalMeanTimeAndDaylightSavingTime(): void
    {
        $calendar = new Calendar();

        // 农历 1900 年正月初一 = 公历 1900-01-31，当时 Asia/Shanghai 还是 LMT +08:05:43；
        // 农历 1986 年四月廿四 = 公历 1986-06-01，处于中国夏令时期间，相差 31532 天；
        // 农历 1991 年三月初一 = 公历 1991-04-15，同样处于夏令时期间，相差 33311 天。
        // PHP < 8.1 的 DateTime::diff()->days 在这种组合下会少算一天，见 issue #37 / #52
        $lunar1 = $calendar->lunar(1900, 1, 1, false);
        $lunar2 = $calendar->lunar(1986, 4, 24, false);
        $lunar3 = $calendar->lunar(1991, 3, 1, false);

        $this->assertSame(31532, $calendar->diffInDays($lunar1, $lunar2, false));
        $this->assertSame(-31532, $calendar->diffInDays($lunar2, $lunar1, false));
        $this->assertSame(31532, $calendar->diffInDays($lunar2, $lunar1));
        $this->assertSame(33311, $calendar->diffInDays($lunar1, $lunar3, false));
        $this->assertSame(1779, $calendar->diffInDays($lunar3, $lunar2));
    }

    public function testDiffInDaysIsIndependentOfDefaultTimezone(): void
    {
        $calendar = new Calendar();

        foreach (['UTC', 'America/New_York', 'Pacific/Kiritimati'] as $timezone) {
            $this->withDefaultTimezone($timezone, function () use ($calendar, $timezone) {
                $lunar1 = $calendar->lunar(2018, 7, 18, false);
                $lunar2 = $calendar->lunar(2044, 7, 18, true);

                $this->assertSame(9509, $calendar->diffInDays($lunar1, $lunar2, false), $timezone);
                $this->assertSame(-9509, $calendar->diffInDays($lunar2, $lunar1, false), $timezone);
                $this->assertSame(0, $calendar->diffInDays($lunar1, $lunar1), $timezone);
            });
        }
    }

    // endregion diffInDays

    // region addYears

    public function testLastDayOfLeapMonthOverFlowAddYears(): void
    {
        $calendar = new Calendar();
        $lunar = $calendar->lunar(2017, 6, 30, true);
        $newLunar = $calendar->addYears($lunar, 10, true);
        $this->assertEquals(2027, $newLunar['lunar_year']);
        $this->assertEquals(7, $newLunar['lunar_month']);
        $this->assertEquals(1, $newLunar['lunar_day']);
        $this->assertEquals(false, $newLunar['is_leap']);
    }

    public function testLastDayOfLeapMonthNotOverFlowAddYears(): void
    {
        $calendar = new Calendar();
        $lunar = $calendar->lunar(2017, 6, 30, true);
        $newLunar = $calendar->addYears($lunar, 10, false);
        $this->assertEquals(2027, $newLunar['lunar_year']);
        $this->assertEquals(6, $newLunar['lunar_month']);
        $this->assertEquals(29, $newLunar['lunar_day']);
        $this->assertEquals(false, $newLunar['is_leap']);
    }

    public function testLastDayOfYearOverFlowAddYears(): void
    {
        $calendar = new Calendar();
        $lunar = $calendar->lunar(2018, 12, 30, false);
        $newLunar = $calendar->addYears($lunar, 6, true);
        $this->assertEquals(2025, $newLunar['lunar_year']);
        $this->assertEquals(1, $newLunar['lunar_month']);
        $this->assertEquals(1, $newLunar['lunar_day']);
        $this->assertEquals(false, $newLunar['is_leap']);
    }

    public function testLastDayOfYearNotOverFlowAddYears(): void
    {
        $calendar = new Calendar();
        $lunar = $calendar->lunar(2018, 12, 30, false);
        $newLunar = $calendar->addYears($lunar, 6, false);
        $this->assertEquals(2024, $newLunar['lunar_year']);
        $this->assertEquals(12, $newLunar['lunar_month']);
        $this->assertEquals(29, $newLunar['lunar_day']);
        $this->assertEquals(false, $newLunar['is_leap']);
    }

    public function testLeapMonthAddYearsToLeapMonth(): void
    {
        $calendar = new Calendar();
        $lunar = $calendar->lunar(1998, 5, 29, true);
        $newLunar = $calendar->addYears($lunar, 11, false);
        $this->assertEquals(2009, $newLunar['lunar_year']);
        $this->assertEquals(5, $newLunar['lunar_month']);
        $this->assertEquals(29, $newLunar['lunar_day']);
        $this->assertEquals(true, $newLunar['is_leap']);
    }

    public function testNormalMonthAddYearsToNormalMonth(): void
    {
        $calendar = new Calendar();
        $lunar = $calendar->lunar(1998, 5, 29, false);
        $newLunar = $calendar->addYears($lunar, 11, false);
        $this->assertEquals(2009, $newLunar['lunar_year']);
        $this->assertEquals(5, $newLunar['lunar_month']);
        $this->assertEquals(29, $newLunar['lunar_day']);
        $this->assertEquals(false, $newLunar['is_leap']);
    }

    // endregion addYears

    // region subYears

    public function testLastDayOfLeapMonthOverFlowSubYears(): void
    {
        $calendar = new Calendar();
        $lunar = $calendar->lunar(2017, 6, 30, true);
        $newLunar = $calendar->subYears($lunar, 9, true);
        $this->assertEquals(2008, $newLunar['lunar_year']);
        $this->assertEquals(7, $newLunar['lunar_month']);
        $this->assertEquals(1, $newLunar['lunar_day']);
        $this->assertEquals(false, $newLunar['is_leap']);
    }

    public function testLastDayOfLeapMonthNotOverFlowSubYears(): void
    {
        $calendar = new Calendar();
        $lunar = $calendar->lunar(2017, 6, 30, true);
        $newLunar = $calendar->subYears($lunar, 9, false);
        $this->assertEquals(2008, $newLunar['lunar_year']);
        $this->assertEquals(6, $newLunar['lunar_month']);
        $this->assertEquals(29, $newLunar['lunar_day']);
        $this->assertEquals(false, $newLunar['is_leap']);
    }

    public function testLastDayOfYearOverFlowSubYears(): void
    {
        $calendar = new Calendar();
        $lunar = $calendar->lunar(2018, 12, 30, false);
        $newLunar = $calendar->subYears($lunar, 7, true);
        $this->assertEquals(2012, $newLunar['lunar_year']);
        $this->assertEquals(1, $newLunar['lunar_month']);
        $this->assertEquals(1, $newLunar['lunar_day']);
        $this->assertEquals(false, $newLunar['is_leap']);
    }

    public function testLastDayOfYearNotOverFlowSubYears(): void
    {
        $calendar = new Calendar();
        $lunar = $calendar->lunar(2018, 12, 30, false);
        $newLunar = $calendar->subYears($lunar, 7, false);
        $this->assertEquals(2011, $newLunar['lunar_year']);
        $this->assertEquals(12, $newLunar['lunar_month']);
        $this->assertEquals(29, $newLunar['lunar_day']);
        $this->assertEquals(false, $newLunar['is_leap']);
    }

    public function testLeapMonthSubYearsToLeapMonth(): void
    {
        $calendar = new Calendar();
        $lunar = $calendar->lunar(2009, 5, 29, true);
        $newLunar = $calendar->subYears($lunar, 11, false);
        $this->assertEquals(1998, $newLunar['lunar_year']);
        $this->assertEquals(5, $newLunar['lunar_month']);
        $this->assertEquals(29, $newLunar['lunar_day']);
        $this->assertEquals(true, $newLunar['is_leap']);
    }

    // endregion subYears

    // region addMonths

    public function testAddMonthsLesserThanLeapMonth(): void
    {
        $calendar = new Calendar();
        $lunar = $calendar->lunar(2017, 1, 1, false);
        $newLunar = $calendar->addMonths($lunar, 2);
        $this->assertEquals(2017, $newLunar['lunar_year']);
        $this->assertEquals(3, $newLunar['lunar_month']);
        $this->assertEquals(1, $newLunar['lunar_day']);
        $this->assertEquals(false, $newLunar['is_leap']);
    }

    public function testNormalMonthAddMonthsToSameLeapMonth(): void
    {
        $calendar = new Calendar();
        $lunar = $calendar->lunar(2017, 6, 29, false);
        $newLunar = $calendar->addMonths($lunar);
        $this->assertEquals(2017, $newLunar['lunar_year']);
        $this->assertEquals(6, $newLunar['lunar_month']);
        $this->assertEquals(29, $newLunar['lunar_day']);
        $this->assertEquals(true, $newLunar['is_leap']);
    }

    public function testLastDayOfLeapMonthOverFlowAddMonthsOverLeapMonthToLeapMonth(): void
    {
        $calendar = new Calendar();
        $lunar = $calendar->lunar(2017, 6, 30, true);
        $newLunar = $calendar->addMonths($lunar, 70, true);
        $this->assertEquals(2023, $newLunar['lunar_year']);
        $this->assertEquals(3, $newLunar['lunar_month']);
        $this->assertEquals(1, $newLunar['lunar_day']);
        $this->assertEquals(false, $newLunar['is_leap']);
    }

    public function testLastDayOfLeapMonthNotOverFlowAddMonthsOverLeapMonthToLeapMonth(): void
    {
        $calendar = new Calendar();
        $lunar = $calendar->lunar(2017, 6, 30, true);
        $newLunar = $calendar->addMonths($lunar, 70, false);
        $this->assertEquals(2023, $newLunar['lunar_year']);
        $this->assertEquals(2, $newLunar['lunar_month']);
        $this->assertEquals(29, $newLunar['lunar_day']);
        $this->assertEquals(true, $newLunar['is_leap']);
    }

    public function testLastDayOfLeapMonthOverFlowAddMonthsOverLeapMonthToNormalMonth(): void
    {
        $calendar = new Calendar();
        $lunar = $calendar->lunar(2017, 6, 30, true);
        $newLunar = $calendar->addMonths($lunar, 71, true);
        $this->assertEquals(2023, $newLunar['lunar_year']);
        $this->assertEquals(4, $newLunar['lunar_month']);
        $this->assertEquals(1, $newLunar['lunar_day']);
        $this->assertEquals(false, $newLunar['is_leap']);
    }

    public function testLastDayOfLeapMonthNotOverFlowAddMonthsOverLeapMonthToNormalMonth(): void
    {
        $calendar = new Calendar();
        $lunar = $calendar->lunar(2017, 6, 30, true);
        $newLunar = $calendar->addMonths($lunar, 71, false);
        $this->assertEquals(2023, $newLunar['lunar_year']);
        $this->assertEquals(3, $newLunar['lunar_month']);
        $this->assertEquals(29, $newLunar['lunar_day']);
        $this->assertEquals(false, $newLunar['is_leap']);
    }

    public function testLastDayOfNormalMonthOverFlowAddMonthsOverLeapMonthToLeapMonth(): void
    {
        $calendar = new Calendar();
        $lunar = $calendar->lunar(2017, 4, 30, false);
        $newLunar = $calendar->addMonths($lunar, 73, true);
        $this->assertEquals(2023, $newLunar['lunar_year']);
        $this->assertEquals(3, $newLunar['lunar_month']);
        $this->assertEquals(1, $newLunar['lunar_day']);
        $this->assertEquals(false, $newLunar['is_leap']);
    }

    public function testLastDayOfNormalMonthNotOverFlowAddMonthsOverLeapMonthToLeapMonth(): void
    {
        $calendar = new Calendar();
        $lunar = $calendar->lunar(2017, 4, 30, false);
        $newLunar = $calendar->addMonths($lunar, 73, false);
        $this->assertEquals(2023, $newLunar['lunar_year']);
        $this->assertEquals(2, $newLunar['lunar_month']);
        $this->assertEquals(29, $newLunar['lunar_day']);
        $this->assertEquals(true, $newLunar['is_leap']);
    }

    public function testLastDayOfNormalMonthOverFlowAddMonthsOverLeapMonthToNormalMonth(): void
    {
        $calendar = new Calendar();
        $lunar = $calendar->lunar(2017, 4, 30, false);
        $newLunar = $calendar->addMonths($lunar, 74, true);
        $this->assertEquals(2023, $newLunar['lunar_year']);
        $this->assertEquals(4, $newLunar['lunar_month']);
        $this->assertEquals(1, $newLunar['lunar_day']);
        $this->assertEquals(false, $newLunar['is_leap']);
    }

    public function testLastDayOfNormalMonthNotOverFlowAddMonthsOverLeapMonthToNormalMonth(): void
    {
        $calendar = new Calendar();
        $lunar = $calendar->lunar(2017, 4, 30, false);
        $newLunar = $calendar->addMonths($lunar, 74, false);
        $this->assertEquals(2023, $newLunar['lunar_year']);
        $this->assertEquals(3, $newLunar['lunar_month']);
        $this->assertEquals(29, $newLunar['lunar_day']);
        $this->assertEquals(false, $newLunar['is_leap']);
    }

    // endregion addMonths

    // region subMonths

    public function testSubMonthsGreaterThanLeapMonth(): void
    {
        $calendar = new Calendar();
        $lunar = $calendar->lunar(2017, 9, 1, false);
        $newLunar = $calendar->subMonths($lunar, 2);
        $this->assertEquals(2017, $newLunar['lunar_year']);
        $this->assertEquals(7, $newLunar['lunar_month']);
        $this->assertEquals(1, $newLunar['lunar_day']);
        $this->assertEquals(false, $newLunar['is_leap']);
    }

    public function testLeapMonthSubMonthsToSameNormalMonth(): void
    {
        $calendar = new Calendar();
        $lunar = $calendar->lunar(2017, 6, 29, true);
        $newLunar = $calendar->subMonths($lunar);
        $this->assertEquals(2017, $newLunar['lunar_year']);
        $this->assertEquals(6, $newLunar['lunar_month']);
        $this->assertEquals(29, $newLunar['lunar_day']);
        $this->assertEquals(false, $newLunar['is_leap']);
    }

    public function testSubMonthsToLeapMonth(): void
    {
        $calendar = new Calendar();
        $lunar = $calendar->lunar(2017, 9, 1, false);
        $newLunar = $calendar->subMonths($lunar, 3);
        $this->assertEquals(2017, $newLunar['lunar_year']);
        $this->assertEquals(6, $newLunar['lunar_month']);
        $this->assertEquals(1, $newLunar['lunar_day']);
        $this->assertEquals(true, $newLunar['is_leap']);
    }

    public function testSubMonthsToNormalMonth(): void
    {
        $calendar = new Calendar();
        $lunar = $calendar->lunar(2017, 9, 1, false);
        $newLunar = $calendar->subMonths($lunar, 4);
        $this->assertEquals(2017, $newLunar['lunar_year']);
        $this->assertEquals(6, $newLunar['lunar_month']);
        $this->assertEquals(1, $newLunar['lunar_day']);
        $this->assertEquals(false, $newLunar['is_leap']);
    }

    public function testLastDayOfLeapMonthOverFlowSubMonthsOverLeapMonthToLeapMonth(): void
    {
        $calendar = new Calendar();
        $lunar = $calendar->lunar(2017, 6, 30, true);
        $newLunar = $calendar->subMonths($lunar, 64, true);
        $this->assertEquals(2012, $newLunar['lunar_year']);
        $this->assertEquals(5, $newLunar['lunar_month']);
        $this->assertEquals(1, $newLunar['lunar_day']);
        $this->assertEquals(false, $newLunar['is_leap']);
    }

    public function testLastDayOfLeapMonthNotOverFlowSubMonthsOverLeapMonthToLeapMonth(): void
    {
        $calendar = new Calendar();
        $lunar = $calendar->lunar(2017, 6, 30, true);
        $newLunar = $calendar->subMonths($lunar, 64, false);
        $this->assertEquals(2012, $newLunar['lunar_year']);
        $this->assertEquals(4, $newLunar['lunar_month']);
        $this->assertEquals(29, $newLunar['lunar_day']);
        $this->assertEquals(true, $newLunar['is_leap']);
    }

    public function testLastDayOfLeapMonthOverFlowSubMonthsOverLeapMonthToNormalMonth(): void
    {
        $calendar = new Calendar();
        $lunar = $calendar->lunar(2017, 6, 30, true);
        $newLunar = $calendar->subMonths($lunar, 67, true);
        $this->assertEquals(2012, $newLunar['lunar_year']);
        $this->assertEquals(3, $newLunar['lunar_month']);
        $this->assertEquals(1, $newLunar['lunar_day']);
        $this->assertEquals(false, $newLunar['is_leap']);
    }

    public function testLastDayOfLeapMonthNotOverFlowSubMonthsOverLeapMonthToNormalMonth(): void
    {
        $calendar = new Calendar();
        $lunar = $calendar->lunar(2017, 6, 30, true);
        $newLunar = $calendar->subMonths($lunar, 67, false);
        $this->assertEquals(2012, $newLunar['lunar_year']);
        $this->assertEquals(2, $newLunar['lunar_month']);
        $this->assertEquals(29, $newLunar['lunar_day']);
        $this->assertEquals(false, $newLunar['is_leap']);
    }

    // endregion subMonths

    // region addDays

    public function testAddDaysOverYears(): void
    {
        $calendar = new Calendar();
        $lunar = $calendar->lunar(2018, 7, 11, false);
        $newLunar = $calendar->addDays($lunar, 4655, false);
        $this->assertEquals(2031, $newLunar['lunar_year']);
        $this->assertEquals(3, $newLunar['lunar_month']);
        $this->assertEquals(29, $newLunar['lunar_day']);
        $this->assertEquals(true, $newLunar['is_leap']);
    }

    // endregion addDays

    // region subDays

    public function testSubDaysOverYears(): void
    {
        $calendar = new Calendar();
        $lunar = $calendar->lunar(2031, 3, 29, true);
        $newLunar = $calendar->subDays($lunar, 4655, false);
        $this->assertEquals(2018, $newLunar['lunar_year']);
        $this->assertEquals(7, $newLunar['lunar_month']);
        $this->assertEquals(11, $newLunar['lunar_day']);
        $this->assertEquals(false, $newLunar['is_leap']);
    }

    // endregion subDays

    // region getAnimal

    public function testMouseGetAnimal(): void
    {
        $calendar = new Calendar();
        $animal = $calendar->getAnimal(1984);
        $this->assertEquals('鼠', $animal);
    }

    public function testPigGetAnimal(): void
    {
        $calendar = new Calendar();
        $animal = $calendar->getAnimal(1983);
        $this->assertEquals('猪', $animal);
    }

    // region solar2lunar

    public function testSolar2LunarChinaDaylightSavingTimeStart1986(): void
    {
        $calendar = new Calendar();

        // 1986 年中国夏令时自 5 月 4 日 02:00 开始（见 issue #52）
        $this->assertEquals(25, $calendar->solar2lunar(1986, 5, 3)['lunar_day']);
        $this->assertEquals(26, $calendar->solar2lunar(1986, 5, 4)['lunar_day']);
        $this->assertEquals(27, $calendar->solar2lunar(1986, 5, 5)['lunar_day']);
        $this->assertEquals(28, $calendar->solar2lunar(1986, 5, 6)['lunar_day']);
    }

    public function testSolar2LunarChinaDaylightSavingTimeEnd1986(): void
    {
        $calendar = new Calendar();

        // 1986 年夏令时于 9 月 14 日 02:00 结束
        $this->assertEquals(10, $calendar->solar2lunar(1986, 9, 13)['lunar_day']);
        $this->assertEquals(11, $calendar->solar2lunar(1986, 9, 14)['lunar_day']);
        $this->assertEquals(12, $calendar->solar2lunar(1986, 9, 15)['lunar_day']);
        $this->assertEquals(13, $calendar->solar2lunar(1986, 9, 16)['lunar_day']);
    }

    public function testSolar2LunarChinaDaylightSavingTime1987(): void
    {
        $calendar = new Calendar();

        // 1987 年夏令时自 4 月 12 日 02:00 开始，9 月 13 日 02:00 结束
        $this->assertEquals(14, $calendar->solar2lunar(1987, 4, 11)['lunar_day']);
        $this->assertEquals(15, $calendar->solar2lunar(1987, 4, 12)['lunar_day']);
        $this->assertEquals(16, $calendar->solar2lunar(1987, 4, 13)['lunar_day']);
        $this->assertEquals(17, $calendar->solar2lunar(1987, 4, 14)['lunar_day']);

        $this->assertEquals(21, $calendar->solar2lunar(1987, 9, 13)['lunar_day']);
        $this->assertEquals(22, $calendar->solar2lunar(1987, 9, 14)['lunar_day']);
    }

    public function testSolar2LunarChinaDaylightSavingTime1991(): void
    {
        $calendar = new Calendar();

        // 1991 年夏令时自 4 月 14 日 02:00 开始，恰好跨过农历月末
        $lunar = $calendar->solar2lunar(1991, 4, 14);
        $this->assertEquals(2, $lunar['lunar_month']);
        $this->assertEquals(30, $lunar['lunar_day']);

        $lunar = $calendar->solar2lunar(1991, 4, 15);
        $this->assertEquals(3, $lunar['lunar_month']);
        $this->assertEquals(1, $lunar['lunar_day']);
    }

    public function testSolar2LunarDayContinuityDuringChinaDaylightSavingTime(): void
    {
        $calendar = new Calendar();

        // 覆盖上海/中国历史上所有夏令时时期：1919、1940-1949、1986-1991
        $date = new DateTime('1918-01-01', new DateTimeZone('UTC'));
        $end = new DateTime('1993-01-01', new DateTimeZone('UTC'));

        $prev = null;
        while ($date < $end) {
            $lunar = $calendar->solar2lunar($date->format('Y'), $date->format('n'), $date->format('j'));

            if (null !== $prev) {
                $maxDays = $prev['is_leap']
                    ? $calendar->leapDays($prev['lunar_year'])
                    : $calendar->lunarDays($prev['lunar_year'], $prev['lunar_month']);

                if ($prev['lunar_day'] == $maxDays) {
                    // 上一天是月末，今天应是下一个农历月的初一
                    $leapMonth = $calendar->leapMonth($prev['lunar_year']);

                    if ($prev['is_leap']) {
                        // 闰月之后是下一个普通月
                        $this->assertEquals($prev['lunar_month'] + 1, $lunar['lunar_month']);
                        $this->assertEquals(false, $lunar['is_leap']);
                    } elseif ($prev['lunar_month'] == $leapMonth) {
                        // 普通月之后紧跟该年的闰月
                        $this->assertEquals($prev['lunar_month'], $lunar['lunar_month']);
                        $this->assertEquals(true, $lunar['is_leap']);
                    } elseif (12 == $prev['lunar_month']) {
                        $this->assertEquals($prev['lunar_year'] + 1, $lunar['lunar_year']);
                        $this->assertEquals(1, $lunar['lunar_month']);
                        $this->assertEquals(false, $lunar['is_leap']);
                    } else {
                        $this->assertEquals($prev['lunar_month'] + 1, $lunar['lunar_month']);
                        $this->assertEquals(false, $lunar['is_leap']);
                    }
                    $this->assertEquals(1, $lunar['lunar_day']);
                } else {
                    $this->assertEquals($prev['lunar_year'], $lunar['lunar_year']);
                    $this->assertEquals($prev['lunar_month'], $lunar['lunar_month']);
                    $this->assertEquals($prev['is_leap'], $lunar['is_leap']);
                    $this->assertEquals($prev['lunar_day'] + 1, $lunar['lunar_day']);
                }
            }

            $prev = $lunar;
            $date->modify('+1 day');
        }
    }

    // endregion solar2lunar

    // region lunar2solar

    public function testLunar2SolarFirstLunarMonthOf1900(): void
    {
        $calendar = new Calendar();

        // 农历 1900 年正月初一是本历法的起点，对应公历 1900-01-31；该月为小月，共 29 天
        $this->assertSame(
            ['solar_year' => '1900', 'solar_month' => '01', 'solar_day' => '31'],
            $calendar->lunar2solar(1900, 1, 1)
        );
        $this->assertSame(
            ['solar_year' => '1900', 'solar_month' => '02', 'solar_day' => '28'],
            $calendar->lunar2solar(1900, 1, 29)
        );
        $this->assertSame(
            ['solar_year' => '1900', 'solar_month' => '03', 'solar_day' => '01'],
            $calendar->lunar2solar(1900, 2, 1)
        );

        $lunar = $calendar->lunar(1900, 1, 1);
        $this->assertSame('1900-01-31', "{$lunar['gregorian_year']}-{$lunar['gregorian_month']}-{$lunar['gregorian_day']}");
        $this->assertSame('甲辰', $lunar['ganzhi_day']);

        // 正月没有三十
        $this->expectException(InvalidArgumentException::class);
        $calendar->lunar2solar(1900, 1, 30);
    }

    public function testLunar2SolarUpperBound(): void
    {
        $calendar = new Calendar();

        // 农历 2100 年腊月初一 = 公历 2100-12-31，是数据表的最后一天
        $this->assertSame(
            ['solar_year' => '2100', 'solar_month' => '12', 'solar_day' => '31'],
            $calendar->lunar2solar(2100, 12, 1)
        );
        $this->assertSame(-1, $calendar->lunar2solar(2100, 12, 2));
    }

    /**
     * @return iterable<string, array{int, int, int}>
     */
    public static function invalidLunarDateProvider(): iterable
    {
        yield '年份下界之外' => [1899, 12, 1];
        yield '年份上界之外' => [2101, 1, 1];
        yield '日期为零' => [2024, 1, 0];
        yield '日期为负' => [2024, 1, -5];
        yield '月份大于 12' => [2024, 13, 1];
        yield '月份为零' => [2024, 0, 1];
    }

    // 越界入参应干净地抛出异常，而不是带着 Warning 或算出错误结果
    #[DataProvider('invalidLunarDateProvider')]
    public function testLunar2SolarRejectsInvalidInput(int $year, int $month, int $day): void
    {
        $calendar = new Calendar();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('传入的参数不合法');

        $calendar->lunar2solar($year, $month, $day);
    }

    public function testLunar2SolarIsIndependentOfDefaultTimezone(): void
    {
        $calendar = new Calendar();

        $timezones = ['UTC', 'Asia/Shanghai', 'America/New_York', 'America/Los_Angeles', 'Pacific/Kiritimati', 'Pacific/Pago_Pago'];

        foreach ($timezones as $timezone) {
            $this->withDefaultTimezone($timezone, function () use ($calendar, $timezone) {
                $this->assertSame(
                    ['solar_year' => '2024', 'solar_month' => '02', 'solar_day' => '10'],
                    $calendar->lunar2solar(2024, 1, 1),
                    $timezone
                );
                $this->assertSame(
                    ['solar_year' => '2017', 'solar_month' => '05', 'solar_day' => '05'],
                    $calendar->lunar2solar(2017, 4, 10),
                    $timezone
                );
                $this->assertSame(
                    ['solar_year' => '2017', 'solar_month' => '07', 'solar_day' => '23'],
                    $calendar->lunar2solar(2017, 6, 1, true),
                    $timezone
                );
                $this->assertSame(
                    ['solar_year' => '1900', 'solar_month' => '01', 'solar_day' => '31'],
                    $calendar->lunar2solar(1900, 1, 1),
                    $timezone
                );
                $this->assertSame(
                    ['solar_year' => '2100', 'solar_month' => '12', 'solar_day' => '31'],
                    $calendar->lunar2solar(2100, 12, 1),
                    $timezone
                );

                // README 里的示例
                $lunar = $calendar->lunar(2017, 4, 10);
                $this->assertSame('2017-05-05', "{$lunar['gregorian_year']}-{$lunar['gregorian_month']}-{$lunar['gregorian_day']}", $timezone);
                $this->assertSame('星期五', $lunar['week_name'], $timezone);
                $this->assertSame('壬辰', $lunar['ganzhi_day'], $timezone);

                $newLunar = $calendar->addDays($calendar->lunar(2020, 1, 1), 1);
                $this->assertSame('01', $newLunar['lunar_month'], $timezone);
                $this->assertSame('02', $newLunar['lunar_day'], $timezone);
            });
        }
    }

    public function testLunar2SolarRoundTripForEveryLunarMonth(): void
    {
        $calendar = new Calendar();

        // 故意在一个与北京时间相差很大的默认时区下跑，确保结果与默认时区无关
        $this->withDefaultTimezone('America/Los_Angeles', function () use ($calendar) {
            for ($year = 1900; $year <= 2100; ++$year) {
                $leapMonth = $calendar->leapMonth($year);

                for ($month = 1; $month <= 12; ++$month) {
                    foreach ([false, true] as $isLeap) {
                        if ($isLeap && $month != $leapMonth) {
                            continue;
                        }

                        $lastDay = $isLeap ? $calendar->leapDays($year) : $calendar->lunarDays($year, $month);
                        // 农历 2100 年腊月只有初一在数据表范围内
                        $days = (2100 == $year && 12 == $month) ? [1] : [1, $lastDay];

                        foreach ($days as $day) {
                            $message = sprintf('lunar %d-%d-%d leap=%d', $year, $month, $day, $isLeap);
                            $solar = $calendar->lunar2solar($year, $month, $day, $isLeap);
                            $lunar = $calendar->solar2lunar($solar['solar_year'], $solar['solar_month'], $solar['solar_day']);

                            $this->assertSame((string) $year, $lunar['lunar_year'], $message);
                            $this->assertSame(sprintf('%02d', $month), $lunar['lunar_month'], $message);
                            $this->assertSame(sprintf('%02d', $day), $lunar['lunar_day'], $message);
                            $this->assertSame($isLeap, $lunar['is_leap'], $message);
                        }
                    }
                }
            }
        });
    }

    // endregion lunar2solar

    // region solar

    public function testSolarIsTodayOnlyForToday(): void
    {
        $calendar = new Calendar();

        // 「今天」以北京时间为准，且不受进程默认时区影响
        $this->withDefaultTimezone('America/Los_Angeles', function () use ($calendar) {
            $today = new DateTime('now', new DateTimeZone('Asia/Shanghai'));

            foreach ([-1 => false, 0 => true, 1 => false] as $offset => $expected) {
                $date = clone $today;
                $date->modify("{$offset} day");

                $solar = $calendar->solar($date->format('Y'), $date->format('n'), $date->format('j'));
                $this->assertSame($expected, $solar['is_today'], "{$offset} day");
            }
        });
    }

    // endregion solar

    // region ganzhi_year & animal

    /**
     * @return iterable<string, array{int, int, int, string, string, string}>
     */
    public static function solarTermDayGanZhiProvider(): iterable
    {
        yield '2022 大寒' => [2022, 1, 20, '大寒', '辛丑', '牛'];
        yield '2023 立春' => [2023, 2, 4, '立春', '癸卯', '兔'];
        yield '2024 小寒' => [2024, 1, 6, '小寒', '癸卯', '兔'];
        yield '2025 小寒' => [2025, 1, 5, '小寒', '甲辰', '龙'];
        yield '2025 大寒' => [2025, 1, 20, '大寒', '甲辰', '龙'];
        yield '2025 立春' => [2025, 2, 3, '立春', '乙巳', '蛇'];
        yield '2017 立春' => [2017, 2, 3, '立春', '丁酉', '鸡'];
    }

    // 早期版本会在小寒、大寒、立春当天把干支年加一（issue #50），结果与任何分界约定都不符
    #[DataProvider('solarTermDayGanZhiProvider')]
    public function testGanZhiYearAndAnimalAreNotShiftedOnSolarTermDays(int $year, int $month, int $day, string $term, string $ganZhiYear, string $animal): void
    {
        $solar = (new Calendar())->solar($year, $month, $day);

        $this->assertSame($term, $solar['term']);
        $this->assertSame($ganZhiYear, $solar['ganzhi_year']);
        $this->assertSame($animal, $solar['animal']);
    }

    /**
     * @return iterable<string, array{int, int, int, string, string, string}>
     */
    public static function lunarNewYearBoundaryProvider(): iterable
    {
        yield '2024 立春当天（正月初一之前）' => [2024, 2, 4, '2023', '癸卯', '兔'];
        yield '2024 除夕' => [2024, 2, 9, '2023', '癸卯', '兔'];
        yield '2024 正月初一' => [2024, 2, 10, '2024', '甲辰', '龙'];
        yield '2018 立春当天（正月初一之前）' => [2018, 2, 4, '2017', '丁酉', '鸡'];
        yield '2018 正月初一' => [2018, 2, 16, '2018', '戊戌', '狗'];
    }

    // 立春早于正月初一时，分界仍以正月初一为准，与 lunar_year 一致
    #[DataProvider('lunarNewYearBoundaryProvider')]
    public function testGanZhiYearAndAnimalFollowLunarNewYear(int $year, int $month, int $day, string $lunarYear, string $ganZhiYear, string $animal): void
    {
        $solar = (new Calendar())->solar($year, $month, $day);

        $this->assertSame($lunarYear, $solar['lunar_year']);
        $this->assertSame($ganZhiYear, $solar['ganzhi_year']);
        $this->assertSame($animal, $solar['animal']);
    }

    public function testGanZhiYearAndAnimalAreConsistentWithLunarYearEveryDay(): void
    {
        $calendar = new Calendar();

        $date = new DateTime('2020-01-01', new DateTimeZone('UTC'));
        $end = new DateTime('2026-01-01', new DateTimeZone('UTC'));

        while ($date < $end) {
            $solar = $calendar->solar2lunar($date->format('Y'), $date->format('n'), $date->format('j'));
            $message = $date->format('Y-m-d');

            $this->assertSame($calendar->ganZhiYear($solar['lunar_year']), $solar['ganzhi_year'], $message);
            $this->assertSame($calendar->getAnimal($solar['lunar_year']), $solar['animal'], $message);

            $date->modify('+1 day');
        }
    }

    // endregion ganzhi_year & animal

    // region data tables

    public function testLunarMonthsMatchHongKongObservatoryTables(): void
    {
        $calendar = new Calendar();
        $rows = $this->loadFixture('lunar-months-1901-2100.csv');

        $this->assertGreaterThan(2400, count($rows));

        foreach ($rows as list($firstDay, $lunarYear, $lunarMonth, $isLeap, $days)) {
            list($year, $month, $day) = explode('-', $firstDay);
            $isLeap = (bool) $isLeap;
            $message = "{$firstDay} = 农历 {$lunarYear} 年".($isLeap ? '闰' : '')."{$lunarMonth} 月初一";

            $lunar = $calendar->solar2lunar($year, $month, $day);
            $this->assertSame($lunarYear, $lunar['lunar_year'], $message);
            $this->assertSame(sprintf('%02d', $lunarMonth), $lunar['lunar_month'], $message);
            $this->assertSame('01', $lunar['lunar_day'], $message);
            $this->assertSame($isLeap, $lunar['is_leap'], $message);

            $monthDays = $isLeap ? $calendar->leapDays($lunarYear) : $calendar->lunarDays($lunarYear, $lunarMonth);
            $this->assertSame((int) $days, $monthDays, $message);

            $solar = $calendar->lunar2solar($lunarYear, $lunarMonth, 1, $isLeap);
            $this->assertSame($firstDay, "{$solar['solar_year']}-{$solar['solar_month']}-{$solar['solar_day']}", $message);
        }
    }

    public function testSolarTermsMatchHongKongObservatoryTables(): void
    {
        $calendar = new Calendar();
        $rows = $this->loadFixture('solar-terms-1901-2100.csv');
        $names = [
            '小寒', '大寒', '立春', '雨水', '惊蛰', '春分', '清明', '谷雨', '立夏', '小满', '芒种', '夏至',
            '小暑', '大暑', '立秋', '处暑', '白露', '秋分', '寒露', '霜降', '立冬', '小雪', '大雪', '冬至',
        ];

        $this->assertSame(200, count($rows));

        foreach ($rows as $row) {
            $year = (int) array_shift($row);
            $this->assertCount(24, $row, (string) $year);

            foreach ($row as $index => $dayOfMonth) {
                $no = $index + 1; // 1 = 小寒 … 24 = 冬至
                $month = (int) (($no + 1) / 2); // 每月两个节气：小寒、大寒在 1 月，立春、雨水在 2 月……
                $message = "{$year} 年 {$names[$index]}";

                $this->assertSame((int) $dayOfMonth, (int) $calendar->getTerm($year, $no), $message);
                $this->assertSame($names[$index], $calendar->solar2lunar($year, $month, $dayOfMonth)['term'], $message);
            }
        }
    }

    public function testSolarTermsOf1900(): void
    {
        $calendar = new Calendar();

        // 1900 年不在香港天文台对照表范围内（表从 1901 年起），此处按独立来源（6tail/lunar 逐日比对一致）固化
        $expected = [6, 20, 4, 19, 6, 21, 5, 20, 6, 21, 6, 22, 7, 23, 8, 23, 8, 23, 9, 24, 8, 23, 7, 22];

        foreach ($expected as $index => $dayOfMonth) {
            $this->assertSame($dayOfMonth, $calendar->getTerm(1900, $index + 1), '1900 年第 '.($index + 1).' 个节气');
        }

        // 支持范围从 1900-01-31 起，立春（02-04）与雨水（02-19）都在范围内
        $this->assertSame('立春', $calendar->solar2lunar(1900, 2, 4)['term']);
        $this->assertSame('雨水', $calendar->solar2lunar(1900, 2, 19)['term']);
    }

    public function testLunarMonthLengthsOf1933(): void
    {
        $calendar = new Calendar();

        // issue #46：1933 年闰五月为大月（30 天）、六月为小月（29 天），原数据 0x06e95 把两者写反了
        $this->assertSame(5, $calendar->leapMonth(1933));
        $this->assertSame(30, $calendar->leapDays(1933));
        $this->assertSame(29, $calendar->lunarDays(1933, 6));
        $this->assertSame(384, $calendar->daysOfYear(1933));

        $lunar = $calendar->solar2lunar(1933, 7, 22);
        $this->assertSame(['05', true, '30', '闰五月', '三十'], [
            $lunar['lunar_month'], $lunar['is_leap'], $lunar['lunar_day'], $lunar['lunar_month_chinese'], $lunar['lunar_day_chinese'],
        ]);

        $lunar = $calendar->solar2lunar(1933, 7, 23);
        $this->assertSame(['06', false, '01'], [$lunar['lunar_month'], $lunar['is_leap'], $lunar['lunar_day']]);

        $lunar = $calendar->solar2lunar(1933, 8, 20);
        $this->assertSame(['06', '29'], [$lunar['lunar_month'], $lunar['lunar_day']]);

        $lunar = $calendar->solar2lunar(1933, 8, 21);
        $this->assertSame(['07', '01'], [$lunar['lunar_month'], $lunar['lunar_day']]);

        $this->assertSame(
            ['solar_year' => '1933', 'solar_month' => '07', 'solar_day' => '22'],
            $calendar->lunar2solar(1933, 5, 30, true)
        );
    }

    public function testLunarMonthLengthsOf2060(): void
    {
        $calendar = new Calendar();

        // 2060 年三月为小月（29 天）、四月为大月（30 天），原数据 0x0a2e0 把两者写反了
        $this->assertSame(29, $calendar->lunarDays(2060, 3));
        $this->assertSame(30, $calendar->lunarDays(2060, 4));
        $this->assertSame(354, $calendar->daysOfYear(2060));

        $cases = [
            [2060, 4, 29, '03', '29'],
            [2060, 4, 30, '04', '01'],
            [2060, 5, 29, '04', '30'],
            [2060, 5, 30, '05', '01'],
        ];

        foreach ($cases as list($year, $month, $day, $lunarMonth, $lunarDay)) {
            $lunar = $calendar->solar2lunar($year, $month, $day);
            $this->assertSame([$lunarMonth, $lunarDay], [$lunar['lunar_month'], $lunar['lunar_day']], "{$year}-{$month}-{$day}");
        }

        $this->assertSame(
            ['solar_year' => '2060', 'solar_month' => '04', 'solar_day' => '30'],
            $calendar->lunar2solar(2060, 4, 1)
        );
        $this->assertSame(
            ['solar_year' => '2060', 'solar_month' => '05', 'solar_day' => '29'],
            $calendar->lunar2solar(2060, 4, 30)
        );
    }

    public function testLunarMonthLengthsOf2057FollowHongKongObservatory(): void
    {
        $calendar = new Calendar();

        // 2057 年九月初一的新月发生在 2057-09-28 北京时间 23:59 左右，距午夜仅十余秒，各家算法有分歧；
        // 本库采用香港天文台的结果：八月 29 天，九月初一为 2057-09-28，九月 30 天
        $this->assertSame(29, $calendar->lunarDays(2057, 8));
        $this->assertSame(30, $calendar->lunarDays(2057, 9));
        $this->assertSame(354, $calendar->daysOfYear(2057));

        $cases = [
            [2057, 9, 27, '08', '29'],
            [2057, 9, 28, '09', '01'],
            [2057, 10, 27, '09', '30'],
            [2057, 10, 28, '10', '01'],
        ];

        foreach ($cases as list($year, $month, $day, $lunarMonth, $lunarDay)) {
            $lunar = $calendar->solar2lunar($year, $month, $day);
            $this->assertSame([$lunarMonth, $lunarDay], [$lunar['lunar_month'], $lunar['lunar_day']], "{$year}-{$month}-{$day}");
        }
    }

    // endregion data tables

    // region ganzhi_day & ganzhi_hour

    public function testEightCharactersDuringChinaDaylightSavingTime(): void
    {
        $calendar = new Calendar();

        // issue #54：1991-08-21 处于中国夏令时期间，PHP < 8.1 上旧版日柱会少算一天（壬戌/丙午），正确为 癸亥/戊午
        $solar = $calendar->solar(1991, 8, 21, 12);
        $this->assertSame(
            ['辛未', '丙申', '癸亥', '戊午'],
            [$solar['ganzhi_year'], $solar['ganzhi_month'], $solar['ganzhi_day'], $solar['ganzhi_hour']]
        );
        $this->assertSame(['07', '12'], [$solar['lunar_month'], $solar['lunar_day']]);

        $solar = $calendar->solar(1991, 8, 21, 0);
        $this->assertSame(['癸亥', '壬子'], [$solar['ganzhi_day'], $solar['ganzhi_hour']]);

        $solar = $calendar->solar(1986, 6, 1, 12);
        $this->assertSame(
            ['丙寅', '癸巳', '丙子', '甲午'],
            [$solar['ganzhi_year'], $solar['ganzhi_month'], $solar['ganzhi_day'], $solar['ganzhi_hour']]
        );
    }

    // endregion ganzhi_day & ganzhi_hour

    // region auxiliary methods

    /**
     * @return iterable<string, array{int, int, int}>
     */
    public static function solarDaysProvider(): iterable
    {
        yield '1900 年 2 月（整百非闰）' => [1900, 2, 28];
        yield '2000 年 2 月（四百年闰）' => [2000, 2, 29];
        yield '2100 年 2 月（整百非闰）' => [2100, 2, 28];
        yield '2024 年 2 月（普通闰年）' => [2024, 2, 29];
        yield '2023 年 2 月（平年）' => [2023, 2, 28];
        yield '大月' => [2024, 1, 31];
        yield '小月' => [2024, 4, 30];
        yield '十二月' => [2024, 12, 31];
        yield '月份为零返回 -1' => [2024, 0, -1];
        yield '月份大于 12 返回 -1' => [2024, 13, -1];
    }

    #[DataProvider('solarDaysProvider')]
    public function testSolarDays(int $year, int $month, int $expected): void
    {
        $this->assertSame($expected, (new Calendar())->solarDays($year, $month));
    }

    /**
     * @return iterable<string, array{int, int, string}>
     */
    public static function constellationBoundaryProvider(): iterable
    {
        // 固化库内分界表（各类历书对个别分界日存在 ±1 天差异，此处以库内表为准）：
        // 每月分界日前一天属上一星座，分界日当天起属下一星座
        yield '1 月 19 日' => [1, 19, '魔羯'];
        yield '1 月 20 日' => [1, 20, '水瓶'];
        yield '2 月 18 日' => [2, 18, '水瓶'];
        yield '2 月 19 日' => [2, 19, '双鱼'];
        yield '3 月 20 日' => [3, 20, '双鱼'];
        yield '3 月 21 日' => [3, 21, '白羊'];
        yield '4 月 20 日' => [4, 20, '白羊'];
        yield '4 月 21 日' => [4, 21, '金牛'];
        yield '5 月 20 日' => [5, 20, '金牛'];
        yield '5 月 21 日' => [5, 21, '双子'];
        yield '6 月 21 日' => [6, 21, '双子'];
        yield '6 月 22 日' => [6, 22, '巨蟹'];
        yield '7 月 22 日' => [7, 22, '巨蟹'];
        yield '7 月 23 日' => [7, 23, '狮子'];
        yield '8 月 22 日' => [8, 22, '狮子'];
        yield '8 月 23 日' => [8, 23, '处女'];
        yield '9 月 22 日' => [9, 22, '处女'];
        yield '9 月 23 日' => [9, 23, '天秤'];
        yield '10 月 22 日' => [10, 22, '天秤'];
        yield '10 月 23 日' => [10, 23, '天蝎'];
        yield '11 月 21 日' => [11, 21, '天蝎'];
        yield '11 月 22 日' => [11, 22, '射手'];
        yield '12 月 21 日' => [12, 21, '射手'];
        yield '12 月 22 日' => [12, 22, '魔羯'];
    }

    #[DataProvider('constellationBoundaryProvider')]
    public function testToConstellationBoundaries(int $month, int $day, string $expected): void
    {
        $this->assertSame($expected, (new Calendar())->toConstellation($month, $day));
    }

    /**
     * @return iterable<string, array{int, string}>
     */
    public static function chinaDayProvider(): iterable
    {
        yield '初一' => [1, '初一'];
        yield '初二' => [2, '初二'];
        yield '初十' => [10, '初十'];
        yield '十一' => [11, '十一'];
        yield '十九' => [19, '十九'];
        yield '二十' => [20, '二十'];
        yield '廿一' => [21, '廿一'];
        yield '廿九' => [29, '廿九'];
        yield '三十' => [30, '三十'];
    }

    #[DataProvider('chinaDayProvider')]
    public function testToChinaDay(int $day, string $expected): void
    {
        $this->assertSame($expected, (new Calendar())->toChinaDay($day));
    }

    /**
     * @return iterable<string, array{int, string}>
     */
    public static function chinaMonthProvider(): iterable
    {
        yield '正月' => [1, '正月'];
        yield '二月' => [2, '二月'];
        yield '九月' => [9, '九月'];
        yield '十月' => [10, '十月'];
        yield '冬月' => [11, '冬月'];
        yield '腊月' => [12, '腊月'];
    }

    #[DataProvider('chinaMonthProvider')]
    public function testToChinaMonth(int $month, string $expected): void
    {
        $this->assertSame($expected, (new Calendar())->toChinaMonth($month));
    }

    /**
     * @return iterable<string, array{int}>
     */
    public static function invalidChinaMonthProvider(): iterable
    {
        yield '零' => [0];
        yield '十三' => [13];
        yield '负数' => [-1];
    }

    #[DataProvider('invalidChinaMonthProvider')]
    public function testToChinaMonthRejectsInvalidMonth(int $month): void
    {
        $this->expectException(InvalidArgumentException::class);

        (new Calendar())->toChinaMonth($month);
    }

    /**
     * @return iterable<string, array{int, string}>
     */
    public static function chinaYearProvider(): iterable
    {
        yield '二零一七' => [2017, '二零一七'];
        yield '含连续零' => [2005, '二零零五'];
        yield '一九零零' => [1900, '一九零零'];
        yield '二一零零' => [2100, '二一零零'];
    }

    #[DataProvider('chinaYearProvider')]
    public function testToChinaYear(int $year, string $expected): void
    {
        $this->assertSame($expected, (new Calendar())->toChinaYear($year));
    }

    /**
     * @return iterable<string, array{int, string}>
     */
    public static function ganZhiOffsetProvider(): iterable
    {
        yield '甲子（起点）' => [0, '甲子'];
        yield '甲戌' => [10, '甲戌'];
        yield '癸亥（一轮末位）' => [59, '癸亥'];
        yield '甲子（六十循环）' => [60, '甲子'];
        yield '乙丑' => [61, '乙丑'];
    }

    #[DataProvider('ganZhiOffsetProvider')]
    public function testToGanZhi(int $offset, string $expected): void
    {
        $this->assertSame($expected, (new Calendar())->toGanZhi($offset));
    }

    /**
     * @return iterable<string, array{int, int}>
     */
    public static function monthsOfYearProvider(): iterable
    {
        yield '1900 闰八月' => [1900, 13];
        yield '2017 闰六月' => [2017, 13];
        yield '2018 无闰月' => [2018, 12];
        yield '2023 闰二月' => [2023, 13];
        yield '2100 无闰月' => [2100, 12];
    }

    #[DataProvider('monthsOfYearProvider')]
    public function testMonthsOfYear(int $year, int $expected): void
    {
        $this->assertSame($expected, (new Calendar())->monthsOfYear($year));
    }

    public function testDateDiff(): void
    {
        $calendar = new Calendar();

        $interval = $calendar->dateDiff('2024-01-01', '2024-01-11');
        $this->assertSame(10, $interval->days);
        $this->assertSame(0, $interval->invert);

        $interval = $calendar->dateDiff('2024-01-11', '2024-01-01');
        $this->assertSame(10, $interval->days);
        $this->assertSame(1, $interval->invert);

        // 同时接受 DateTime 对象与字符串
        $date = new DateTime('2024-01-01', new DateTimeZone('Asia/Shanghai'));
        $this->assertSame(31, $calendar->dateDiff($date, '2024-02-01')->days);
    }

    public function testSolarReportsIsSameYear(): void
    {
        $calendar = new Calendar();

        $this->assertTrue($calendar->solar(2017, 5, 5)['is_same_year']);
        // 2025-01-01 仍处于农历 2024 年（甲辰年腊月）
        $this->assertFalse($calendar->solar(2025, 1, 1)['is_same_year']);
    }

    public function testSolarGoldenOutput(): void
    {
        // 完整钉住 README 示例的全部 32 个字段（含键序与取值类型），任何输出契约的变化都会在这里现形
        $this->assertSame([
            'lunar_year' => '2017',
            'lunar_month' => '04',
            'lunar_day' => '10',
            'lunar_hour' => null,
            'lunar_year_chinese' => '二零一七',
            'lunar_month_chinese' => '四月',
            'lunar_day_chinese' => '初十',
            'lunar_hour_chinese' => null,
            'ganzhi_year' => '丁酉',
            'ganzhi_month' => '乙巳',
            'ganzhi_day' => '壬辰',
            'ganzhi_hour' => null,
            'wuxing_year' => '火金',
            'wuxing_month' => '木火',
            'wuxing_day' => '水土',
            'wuxing_hour' => null,
            'color_year' => '红',
            'color_month' => '青',
            'color_day' => '黑',
            'color_hour' => null,
            'animal' => '鸡',
            'term' => '立夏',
            'is_leap' => false,
            'gregorian_year' => '2017',
            'gregorian_month' => '05',
            'gregorian_day' => '05',
            'gregorian_hour' => null,
            'week_no' => 5,
            'week_name' => '星期五',
            'is_today' => false,
            'constellation' => '金牛',
            'is_same_year' => true,
        ], (new Calendar())->solar(2017, 5, 5));
    }

    /**
     * @return iterable<string, array{int, string, string, string}>
     */
    public static function ganZhiHourProvider(): iterable
    {
        // 五鼠遁：壬辰日（丁壬日起庚子），与 6tail/lunar 全部时辰比对一致
        yield '0 点子时' => [0, '00', '庚子', '子时'];
        yield '1 点丑时' => [1, '01', '辛丑', '丑时'];
        yield '11 点午时' => [11, '11', '丙午', '午时'];
        yield '12 点午时' => [12, '12', '丙午', '午时'];
        yield '21 点亥时' => [21, '21', '辛亥', '亥时'];
        yield '22 点亥时' => [22, '22', '辛亥', '亥时'];
    }

    #[DataProvider('ganZhiHourProvider')]
    public function testGanZhiHourMapping(int $hour, string $gregorianHour, string $ganZhiHour, string $lunarHourChinese): void
    {
        $solar = (new Calendar())->solar(2017, 5, 5, $hour);

        $this->assertSame($gregorianHour, $solar['gregorian_hour']);
        $this->assertSame($ganZhiHour, $solar['ganzhi_hour']);
        $this->assertSame($lunarHourChinese, $solar['lunar_hour_chinese']);
        $this->assertSame($gregorianHour, $solar['lunar_hour']);
    }

    /**
     * @return iterable<string, array{int}>
     */
    public static function outOfRangeHourProvider(): iterable
    {
        yield '负数' => [-1];
        yield '24 点' => [24];
        yield '99 点' => [99];
    }

    // 越界小时不参与计算：所有时辰相关字段为 null，其余字段与不传小时完全一致
    #[DataProvider('outOfRangeHourProvider')]
    public function testOutOfRangeHourYieldsNullHourFields(int $hour): void
    {
        $calendar = new Calendar();

        $this->assertSame($calendar->solar(2017, 5, 5), $calendar->solar(2017, 5, 5, $hour));
    }

    public function testSolar2LunarHour23RollsToNextDay(): void
    {
        $calendar = new Calendar();

        // 23 点按「晚子时」归入次日（见 #13 与 README）：农历日期与日柱、时柱整体后移
        $lunar = $calendar->solar2lunar(2017, 5, 5, 23);
        $this->assertSame('11', $lunar['lunar_day']);
        $this->assertSame('十一', $lunar['lunar_day_chinese']);
        $this->assertSame('癸巳', $lunar['ganzhi_day']);
        $this->assertSame('壬子', $lunar['ganzhi_hour']);
        $this->assertSame('子时', $lunar['lunar_hour_chinese']);
        $this->assertSame('23', $lunar['lunar_hour']);

        // 除时辰字段外，其余字段应与次日 0 点完全一致（含跨月、跨年）
        foreach ([[2017, 5, 5, 2017, 5, 6], [2018, 5, 31, 2018, 6, 1], [2018, 12, 31, 2019, 1, 1], [2024, 2, 9, 2024, 2, 10]] as [$y, $m, $d, $ny, $nm, $nd]) {
            $rolled = $calendar->solar2lunar($y, $m, $d, 23);
            $nextDay = $calendar->solar2lunar($ny, $nm, $nd);
            unset($rolled['lunar_hour'], $rolled['lunar_hour_chinese'], $rolled['ganzhi_hour'], $rolled['wuxing_hour'], $rolled['color_hour']);
            unset($nextDay['lunar_hour'], $nextDay['lunar_hour_chinese'], $nextDay['ganzhi_hour'], $nextDay['wuxing_hour'], $nextDay['color_hour']);
            $this->assertSame($nextDay, $rolled, "{$y}-{$m}-{$d} 23:00");
        }

        // 支持范围最后一天的 23 点会滚动到 2101 年，超出数据表范围
        $this->expectException(InvalidArgumentException::class);
        $calendar->solar2lunar(2100, 12, 31, 23);
    }

    /**
     * @return iterable<string, array{int, int, int, string}>
     */
    public static function outOfRangeSolarDateProvider(): iterable
    {
        yield '1899 年' => [1899, 12, 31, '不支持的年份:1899'];
        yield '2101 年' => [2101, 1, 1, '不支持的年份:2101'];
        yield '起点之前' => [1900, 1, 30, '不支持的日期:1900-1-30'];
    }

    #[DataProvider('outOfRangeSolarDateProvider')]
    public function testSolar2LunarRejectsOutOfRangeDates(int $year, int $month, int $day, string $message): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage($message);

        (new Calendar())->solar2lunar($year, $month, $day);
    }

    public function testGetTermReturnsMinusOneForOutOfRangeInput(): void
    {
        $calendar = new Calendar();

        $this->assertSame(-1, $calendar->getTerm(1899, 1));
        $this->assertSame(-1, $calendar->getTerm(2101, 1));
        $this->assertSame(-1, $calendar->getTerm(2024, 0));
        $this->assertSame(-1, $calendar->getTerm(2024, 25));
    }

    public function testLunarThrowsBeyondUpperBound(): void
    {
        // lunar2solar() 对 2100 年腊月初二返回 -1，lunar() 应转换为异常而不是继续计算
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('传入的参数不合法');

        (new Calendar())->lunar(2100, 12, 2);
    }

    public function testDiffInDaysRejectsOutOfRangeLunarArray(): void
    {
        $calendar = new Calendar();
        $valid = $calendar->lunar(2024, 1, 1);
        $outOfRange = ['lunar_year' => 2100, 'lunar_month' => 12, 'lunar_day' => 2, 'is_leap' => false];

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('传入的参数不合法');

        $calendar->diffInDays($valid, $outOfRange);
    }

    public function testNegativeValuesDelegateBetweenAddAndSubMonths(): void
    {
        $calendar = new Calendar();
        $lunar = $calendar->lunar(2017, 6, 10);

        $this->assertSame($calendar->subMonths($lunar, 2), $calendar->addMonths($lunar, -2));
        $this->assertSame($calendar->addMonths($lunar, 2), $calendar->subMonths($lunar, -2));
    }

    public function testColorAndWuXingGuardsForInvalidGanZhi(): void
    {
        // getColor()/getWuXing() 是 protected（本库支持子类覆盖字表做本地化），通过子类验证防御性守卫
        $calendar = new class extends Calendar {
            public function color(?string $ganZhi): ?string
            {
                return $this->getColor($ganZhi);
            }

            public function wuXing(?string $ganZhi): ?string
            {
                return $this->getWuXing($ganZhi);
            }
        };

        $this->assertNull($calendar->color(null));
        $this->assertNull($calendar->color(''));
        $this->assertNull($calendar->color('不是干支'));
        $this->assertNull($calendar->wuXing(null));
        $this->assertNull($calendar->wuXing(''));
        $this->assertNull($calendar->wuXing('不是干支'));

        $this->assertSame('青', $calendar->color('甲子'));
        $this->assertSame('木水', $calendar->wuXing('甲子'));
    }

    // endregion auxiliary methods

    // region helpers

    /**
     * 读取 tests/fixtures 下的 CSV（忽略以 # 开头的注释行），返回按逗号切分后的行.
     *
     * @param string $name
     *
     * @return array
     */
    private function loadFixture(string $name): array
    {
        $rows = [];

        foreach (file(__DIR__.'/fixtures/'.$name, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
            if ('#' !== $line[0]) {
                $rows[] = explode(',', $line);
            }
        }

        return $rows;
    }

    /**
     * 在指定的默认时区下执行回调，结束后恢复原来的默认时区.
     *
     * @param string   $timezone
     * @param callable $callback
     */
    private function withDefaultTimezone(string $timezone, callable $callback): void
    {
        $previous = date_default_timezone_get();
        date_default_timezone_set($timezone);

        try {
            $callback();
        } finally {
            date_default_timezone_set($previous);
        }
    }

    // endregion helpers
}
