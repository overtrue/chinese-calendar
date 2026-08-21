<?php
/**
 * User: hao.li
 * Date: 2018/8/21
 * Time: 8:54 AM.
 */

namespace Overtrue\ChineseCalendar\Tests;

use DateTime;
use DateTimeZone;
use InvalidArgumentException;
use Overtrue\ChineseCalendar\Calendar;
use PHPUnit\Framework\TestCase;

class CalendarTest extends TestCase
{
    //region ganZhiYear

    public function testJiaZiGanZhiYear()
    {
        $calendar = new Calendar();
        $ganZhi = $calendar->ganZhiYear(1984);
        $this->assertEquals('甲子', $ganZhi);
    }

    public function testKuiHaiGanZhiYear()
    {
        $calendar = new Calendar();
        $ganZhi = $calendar->ganZhiYear(1983);
        $this->assertEquals('癸亥', $ganZhi);
    }

    //endregion ganZhiYear

    public function testSameNormalDateDiffInYears()
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 29, false);
        $lunar2 = $calendar->lunar(2017, 6, 29, false);
        $diff1 = $calendar->diffInYears($lunar1, $lunar2, false);
        $diff2 = $calendar->diffInYears($lunar2, $lunar1, false);
        $this->assertEquals(0, $diff1);
        $this->assertEquals(0, $diff2);
    }

    public function testSameLeapDateDiffInYears()
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 30, true);
        $lunar2 = $calendar->lunar(2017, 6, 30, true);
        $diff1 = $calendar->diffInYears($lunar1, $lunar2, false);
        $diff2 = $calendar->diffInYears($lunar2, $lunar1, false);
        $this->assertEquals(0, $diff1);
        $this->assertEquals(0, $diff2);
    }

    //region less month

    public function testLessMonthLessDayNormalDateAndNormalDateDiffInYears()
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

    public function testLessMonthLessDayNormalDateAndLeapDateDiffInYears()
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

    public function testLessMonthLessDayLeapDateAndNormalDateDiffInYears()
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

    public function testLessMonthLessDayLeapDateAndLeapDateDiffInYears()
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

    public function testLessMonthEqualDayNormalDateAndNormalDateDiffInYears()
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

    public function testLessMonthEqualDayNormalDateAndLeapDateDiffInYears()
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

    public function testLessMonthEqualDayLeapDateAndNormalDateDiffInYears()
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

    public function testLessMonthEqualDayLeapDateAndLeapDateDiffInYears()
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

    public function testLessMonthGreaterDayNormalDateAndNormalDateDiffInYears()
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

    public function testLessMonthGreaterDayNormalDateAndLeapDateDiffInYears()
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

    public function testLessMonthGreaterDayLeapDateAndNormalDateDiffInYears()
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

    public function testLessMonthGreaterDayLeapDateAndLeapDateDiffInYears()
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

    //endregion less month

    //region equal month

    public function testEqualMonthLessDayNormalDateAndNormalDateDiffInYears()
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

    public function testEqualMonthLessDayNormalDateAndLeapDateDiffInYears()
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

    public function testEqualMonthLessDayLeapDateAndNormalDateDiffInYears()
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

    public function testEqualMonthLessDayLeapDateAndLeapDateDiffInYears()
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

    public function testEqualMonthEqualDayNormalDateAndNormalDateDiffInYears()
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

    public function testEqualMonthEqualDayNormalDateAndLeapDateDiffInYears()
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

    public function testEqualMonthEqualDayLeapDateAndNormalDateDiffInYears()
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

    public function testEqualMonthEqualDayLeapDateAndLeapDateDiffInYears()
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

    public function testEqualMonthGreaterDayNormalDateAndNormalDateDiffInYears()
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

    public function testEqualMonthGreaterDayNormalDateAndLeapDateDiffInYears()
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

    public function testEqualMonthGreaterDayLeapDateAndNormalDateDiffInYears()
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

    public function testEqualMonthGreaterDayLeapDateAndLeapDateDiffInYears()
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

    //endregion equal month

    //region greater month

    public function testGreaterMonthLessDayNormalDateAndNormalDateDiffInYears()
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

    public function testGreaterMonthLessDayNormalDateAndLeapDateDiffInYears()
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

    public function testGreaterMonthLessDayLeapDateAndNormalDateDiffInYears()
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

    public function testGreaterMonthLessDayLeapDateAndLeapDateDiffInYears()
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

    public function testGreaterMonthEqualDayNormalDateAndNormalDateDiffInYears()
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

    public function testGreaterMonthEqualDayNormalDateAndLeapDateDiffInYears()
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

    public function testGreaterMonthEqualDayLeapDateAndNormalDateDiffInYears()
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

    public function testGreaterMonthEqualDayLeapDateAndLeapDateDiffInYears()
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

    public function testGreaterMonthGreaterDayNormalDateAndNormalDateDiffInYears()
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

    public function testGreaterMonthGreaterDayNormalDateAndLeapDateDiffInYears()
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

    public function testGreaterMonthGreaterDayLeapDateAndNormalDateDiffInYears()
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

    public function testGreaterMonthGreaterDayLeapDateAndLeapDateDiffInYears()
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

    //endregion greater month

    //endregion diffInYears

    //region diffInMonths

    //region different year less month less day

    public function testDifferentYearLessMonthLessDayNormalYearNormalDateAndNormalYearNormalDateDiffInMonths()
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

    public function testDifferentYearLessMonthLessDayNormalYearNormalDateAndLeapYearNormalDateLessThanLeapMonthDiffInMonths()
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

    public function testDifferentYearLessMonthLessDayNormalYearNormalDateAndLeapYearNormalDateEqualLeapMonthDiffInMonths()
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

    public function testDifferentYearLessMonthLessDayNormalYearNormalDateAndLeapYearNormalDateGreaterThanLeapMonthDiffInMonths()
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

    public function testDifferentYearLessMonthLessDayNormalYearNormalDateAndLeapDateDiffInMonths()
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

    public function testDifferentYearLessMonthLessDayLeapYearNormalDateLessThanLeapMonthAndNormalYearNormalDateDiffInMonths()
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

    public function testDifferentYearLessMonthLessDayLeapYearNormalDateLessThanLeapMonthAndLeapYearNormalDateLessThanLeapMonthDiffInMonths()
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

    public function testDifferentYearLessMonthLessDayLeapYearNormalDateLessThanLeapMonthAndLeapYearNormalDateEqualLeapMonthDiffInMonths()
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

    public function testDifferentYearLessMonthLessDayLeapYearNormalDateLessThanLeapMonthAndLeapYearNormalDateGreaterThanLeapMonthDiffInMonths()
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

    public function testDifferentYearLessMonthLessDayLeapYearNormalDateLessThanLeapMonthAndLeapDateDiffInMonths()
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

    public function testDifferentYearLessMonthLessDayLeapYearNormalDateEqualLeapMonthAndNormalYearNormalDateDiffInMonths()
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

    public function testDifferentYearLessMonthLessDayLeapYearNormalDateEqualLeapMonthAndLeapYearNormalDateLessThanLeapMonthDiffInMonths()
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

    public function testDifferentYearLessMonthLessDayLeapYearNormalDateEqualLeapMonthAndLeapYearNormalDateEqualLeapMonthDiffInMonths()
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

    public function testDifferentYearLessMonthLessDayLeapYearNormalDateEqualLeapMonthAndLeapYearNormalDateGreaterThanLeapMonthDiffInMonths()
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

    public function testDifferentYearLessMonthLessDayLeapYearNormalDateEqualLeapMonthAndLeapDateDiffInMonths()
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

    public function testDifferentYearLessMonthLessDayLeapYearNormalDateGreaterThanLeapMonthAndNormalYearNormalDateDiffInMonths()
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

    public function testDifferentYearLessMonthLessDayLeapYearNormalDateGreaterThanLeapMonthAndLeapYearNormalDateLessThanLeapMonthDiffInMonths()
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

    public function testDifferentYearLessMonthLessDayLeapYearNormalDateGreaterThanLeapMonthAndLeapYearNormalDateEqualLeapMonthDiffInMonths()
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

    public function testDifferentYearLessMonthLessDayLeapYearNormalDateGreaterThanLeapMonthAndLeapYearNormalDateGreaterThanLeapMonthDiffInMonths()
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

    public function testDifferentYearLessMonthLessDayLeapYearNormalDateGreaterThanLeapMonthAndLeapDateDiffInMonths()
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

    public function testDifferentYearLessMonthLessDayLeapDateAndNormalYearNormalDateDiffInMonths()
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

    public function testDifferentYearLessMonthLessDayLeapDateAndLeapYearNormalDateLessThanLeapMonthDiffInMonths()
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

    public function testDifferentYearLessMonthLessDayLeapDateAndLeapYearNormalDateEqualLeapMonthDiffInMonths()
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

    public function testDifferentYearLessMonthLessDayLeapDateAndLeapYearNormalDateGreaterThanLeapMonthDiffInMonths()
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

    public function testDifferentYearLessMonthLessDayLeapDateAndLeapDateDiffInMonths()
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

    //endregion different year less month less day

    //region different year less month equal day

    public function testDifferentYearLessMonthEqualDayNormalYearNormalDateAndNormalYearNormalDateDiffInMonths()
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

    public function testDifferentYearLessMonthEqualDayNormalYearNormalDateAndLeapYearNormalDateLessThanLeapMonthDiffInMonths()
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

    public function testDifferentYearLessMonthEqualDayNormalYearNormalDateAndLeapYearNormalDateEqualLeapMonthDiffInMonths()
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

    public function testDifferentYearLessMonthEqualDayNormalYearNormalDateAndLeapYearNormalDateGreaterThanLeapMonthDiffInMonths()
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

    public function testDifferentYearLessMonthEqualDayNormalYearNormalDateAndLeapDateDiffInMonths()
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

    public function testDifferentYearLessMonthEqualDayLeapYearNormalDateLessThanLeapMonthAndNormalYearNormalDateDiffInMonths()
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

    public function testDifferentYearLessMonthEqualDayLeapYearNormalDateLessThanLeapMonthAndLeapYearNormalDateLessThanLeapMonthDiffInMonths()
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

    public function testDifferentYearLessMonthEqualDayLeapYearNormalDateLessThanLeapMonthAndLeapYearNormalDateEqualLeapMonthDiffInMonths()
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

    public function testDifferentYearLessMonthEqualDayLeapYearNormalDateLessThanLeapMonthAndLeapYearNormalDateGreaterThanLeapMonthDiffInMonths()
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

    public function testDifferentYearLessMonthEqualDayLeapYearNormalDateLessThanLeapMonthAndLeapDateDiffInMonths()
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

    public function testDifferentYearLessMonthEqualDayLeapYearNormalDateEqualLeapMonthAndNormalYearNormalDateDiffInMonths()
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

    public function testDifferentYearLessMonthEqualDayLeapYearNormalDateEqualLeapMonthAndLeapYearNormalDateLessThanLeapMonthDiffInMonths()
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

    public function testDifferentYearLessMonthEqualDayLeapYearNormalDateEqualLeapMonthAndLeapYearNormalDateEqualLeapMonthDiffInMonths()
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

    public function testDifferentYearLessMonthEqualDayLeapYearNormalDateEqualLeapMonthAndLeapYearNormalDateGreaterThanLeapMonthDiffInMonths()
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

    public function testDifferentYearLessMonthEqualDayLeapYearNormalDateEqualLeapMonthAndLeapDateDiffInMonths()
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

    public function testDifferentYearLessMonthEqualDayLeapYearNormalDateGreaterThanLeapMonthAndNormalYearNormalDateDiffInMonths()
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

    public function testDifferentYearLessMonthEqualDayLeapYearNormalDateGreaterThanLeapMonthAndLeapYearNormalDateLessThanLeapMonthDiffInMonths()
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

    public function testDifferentYearLessMonthEqualDayLeapYearNormalDateGreaterThanLeapMonthAndLeapYearNormalDateEqualLeapMonthDiffInMonths()
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

    public function testDifferentYearLessMonthEqualDayLeapYearNormalDateGreaterThanLeapMonthAndLeapYearNormalDateGreaterThanLeapMonthDiffInMonths()
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

    public function testDifferentYearLessMonthEqualDayLeapYearNormalDateGreaterThanLeapMonthAndLeapDateDiffInMonths()
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

    public function testDifferentYearLessMonthEqualDayLeapDateAndNormalYearNormalDateDiffInMonths()
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

    public function testDifferentYearLessMonthEqualDayLeapDateAndLeapYearNormalDateLessThanLeapMonthDiffInMonths()
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

    public function testDifferentYearLessMonthEqualDayLeapDateAndLeapYearNormalDateEqualLeapMonthDiffInMonths()
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

    public function testDifferentYearLessMonthEqualDayLeapDateAndLeapYearNormalDateGreaterThanLeapMonthDiffInMonths()
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

    public function testDifferentYearLessMonthEqualDayLeapDateAndLeapDateDiffInMonths()
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

    //endregion different year less month equal day

    //region different year less month greater day

    public function testDifferentYearLessMonthGreaterDayNormalYearNormalDateAndNormalYearNormalDateDiffInMonths()
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

    public function testDifferentYearLessMonthGreaterDayNormalYearNormalDateAndLeapYearNormalDateLessThanLeapMonthDiffInMonths()
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

    public function testDifferentYearLessMonthGreaterDayNormalYearNormalDateAndLeapYearNormalDateEqualLeapMonthDiffInMonths()
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

    public function testDifferentYearLessMonthGreaterDayNormalYearNormalDateAndLeapYearNormalDateGreaterThanLeapMonthDiffInMonths()
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

    public function testDifferentYearLessMonthGreaterDayNormalYearNormalDateAndLeapDateDiffInMonths()
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

    public function testDifferentYearLessMonthGreaterDayLeapYearNormalDateLessThanLeapMonthAndNormalYearNormalDateDiffInMonths()
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

    public function testDifferentYearLessMonthGreaterDayLeapYearNormalDateLessThanLeapMonthAndLeapYearNormalDateLessThanLeapMonthDiffInMonths()
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

    public function testDifferentYearLessMonthGreaterDayLeapYearNormalDateLessThanLeapMonthAndLeapYearNormalDateEqualLeapMonthDiffInMonths()
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

    public function testDifferentYearLessMonthGreaterDayLeapYearNormalDateLessThanLeapMonthAndLeapYearNormalDateGreaterThanLeapMonthDiffInMonths()
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

    public function testDifferentYearLessMonthGreaterDayLeapYearNormalDateLessThanLeapMonthAndLeapDateDiffInMonths()
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

    public function testDifferentYearLessMonthGreaterDayLeapYearNormalDateEqualLeapMonthAndNormalYearNormalDateDiffInMonths()
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

    public function testDifferentYearLessMonthGreaterDayLeapYearNormalDateEqualLeapMonthAndLeapYearNormalDateLessThanLeapMonthDiffInMonths()
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

    public function testDifferentYearLessMonthGreaterDayLeapYearNormalDateEqualLeapMonthAndLeapYearNormalDateEqualLeapMonthDiffInMonths()
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

    public function testDifferentYearLessMonthGreaterDayLeapYearNormalDateEqualLeapMonthAndLeapYearNormalDateGreaterThanLeapMonthDiffInMonths()
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

    public function testDifferentYearLessMonthGreaterDayLeapYearNormalDateEqualLeapMonthAndLeapDateDiffInMonths()
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

    public function testDifferentYearLessMonthGreaterDayLeapYearNormalDateGreaterThanLeapMonthAndNormalYearNormalDateDiffInMonths()
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

    public function testDifferentYearLessMonthGreaterDayLeapYearNormalDateGreaterThanLeapMonthAndLeapYearNormalDateLessThanLeapMonthDiffInMonths()
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

    public function testDifferentYearLessMonthGreaterDayLeapYearNormalDateGreaterThanLeapMonthAndLeapYearNormalDateEqualLeapMonthDiffInMonths()
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

    public function testDifferentYearLessMonthGreaterDayLeapYearNormalDateGreaterThanLeapMonthAndLeapYearNormalDateGreaterThanLeapMonthDiffInMonths()
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

    public function testDifferentYearLessMonthGreaterDayLeapYearNormalDateGreaterThanLeapMonthAndLeapDateDiffInMonths()
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

    public function testDifferentYearLessMonthGreaterDayLeapDateAndNormalYearNormalDateDiffInMonths()
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

    public function testDifferentYearLessMonthGreaterDayLeapDateAndLeapYearNormalDateLessThanLeapMonthDiffInMonths()
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

    public function testDifferentYearLessMonthGreaterDayLeapDateAndLeapYearNormalDateEqualLeapMonthDiffInMonths()
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

    public function testDifferentYearLessMonthGreaterDayLeapDateAndLeapYearNormalDateGreaterThanLeapMonthDiffInMonths()
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

    public function testDifferentYearLessMonthGreaterDayLeapDateAndLeapDateDiffInMonths()
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

    //endregion different year less month greater day

    //region different year equal month less day

    public function testDifferentYearEqualMonthLessDayNormalYearNormalDateAndNormalYearNormalDateDiffInMonths()
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

    public function testDifferentYearEqualMonthLessDayNormalYearNormalDateAndLeapYearNormalDateLessThanLeapMonthDiffInMonths()
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

    public function testDifferentYearEqualMonthLessDayNormalYearNormalDateAndLeapYearNormalDateEqualLeapMonthDiffInMonths()
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

    public function testDifferentYearEqualMonthLessDayNormalYearNormalDateAndLeapYearNormalDateGreaterThanLeapMonthDiffInMonths()
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

    public function testDifferentYearEqualMonthLessDayNormalYearNormalDateAndLeapDateDiffInMonths()
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

    public function testDifferentYearEqualMonthLessDayLeapYearNormalDateLessThanLeapMonthAndNormalYearNormalDateDiffInMonths()
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

    public function testDifferentYearEqualMonthLessDayLeapYearNormalDateLessThanLeapMonthAndLeapYearNormalDateLessThanLeapMonthDiffInMonths()
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

    public function testDifferentYearEqualMonthLessDayLeapYearNormalDateLessThanLeapMonthAndLeapYearNormalDateEqualLeapMonthDiffInMonths()
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

    public function testDifferentYearEqualMonthLessDayLeapYearNormalDateLessThanLeapMonthAndLeapYearNormalDateGreaterThanLeapMonthDiffInMonths()
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

    public function testDifferentYearEqualMonthLessDayLeapYearNormalDateLessThanLeapMonthAndLeapDateDiffInMonths()
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

    public function testDifferentYearEqualMonthLessDayLeapYearNormalDateEqualLeapMonthAndNormalYearNormalDateDiffInMonths()
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

    public function testDifferentYearEqualMonthLessDayLeapYearNormalDateEqualLeapMonthAndLeapYearNormalDateLessThanLeapMonthDiffInMonths()
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

    public function testDifferentYearEqualMonthLessDayLeapYearNormalDateEqualLeapMonthAndLeapYearNormalDateEqualLeapMonthDiffInMonths()
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

    public function testDifferentYearEqualMonthLessDayLeapYearNormalDateEqualLeapMonthAndLeapYearNormalDateGreaterThanLeapMonthDiffInMonths()
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

    public function testDifferentYearEqualMonthLessDayLeapYearNormalDateEqualLeapMonthAndLeapDateDiffInMonths()
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

    public function testDifferentYearEqualMonthLessDayLeapYearNormalDateGreaterThanLeapMonthAndNormalYearNormalDateDiffInMonths()
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

    public function testDifferentYearEqualMonthLessDayLeapYearNormalDateGreaterThanLeapMonthAndLeapYearNormalDateLessThanLeapMonthDiffInMonths()
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

    public function testDifferentYearEqualMonthLessDayLeapYearNormalDateGreaterThanLeapMonthAndLeapYearNormalDateEqualLeapMonthDiffInMonths()
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

    public function testDifferentYearEqualMonthLessDayLeapYearNormalDateGreaterThanLeapMonthAndLeapYearNormalDateGreaterThanLeapMonthDiffInMonths()
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

    public function testDifferentYearEqualMonthLessDayLeapYearNormalDateGreaterThanLeapMonthAndLeapDateDiffInMonths()
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

    public function testDifferentYearEqualMonthLessDayLeapDateAndNormalYearNormalDateDiffInMonths()
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

    public function testDifferentYearEqualMonthLessDayLeapDateAndLeapYearNormalDateLessThanLeapMonthDiffInMonths()
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

    public function testDifferentYearEqualMonthLessDayLeapDateAndLeapYearNormalDateEqualLeapMonthDiffInMonths()
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

    public function testDifferentYearEqualMonthLessDayLeapDateAndLeapYearNormalDateGreaterThanLeapMonthDiffInMonths()
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

    public function testDifferentYearEqualMonthLessDayLeapDateAndLeapDateDiffInMonths()
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

    //endregion different year equal month less day

    //region different year equal month equal day

    public function testDifferentYearEqualMonthEqualDayNormalYearNormalDateAndNormalYearNormalDateDiffInMonths()
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

    public function testDifferentYearEqualMonthEqualDayNormalYearNormalDateAndLeapYearNormalDateLessThanLeapMonthDiffInMonths()
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

    public function testDifferentYearEqualMonthEqualDayNormalYearNormalDateAndLeapYearNormalDateEqualLeapMonthDiffInMonths()
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

    public function testDifferentYearEqualMonthEqualDayNormalYearNormalDateAndLeapYearNormalDateGreaterThanLeapMonthDiffInMonths()
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

    public function testDifferentYearEqualMonthEqualDayNormalYearNormalDateAndLeapDateDiffInMonths()
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

    public function testDifferentYearEqualMonthEqualDayLeapYearNormalDateLessThanLeapMonthAndNormalYearNormalDateDiffInMonths()
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

    public function testDifferentYearEqualMonthEqualDayLeapYearNormalDateLessThanLeapMonthAndLeapYearNormalDateLessThanLeapMonthDiffInMonths()
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

    public function testDifferentYearEqualMonthEqualDayLeapYearNormalDateLessThanLeapMonthAndLeapYearNormalDateEqualLeapMonthDiffInMonths()
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

    public function testDifferentYearEqualMonthEqualDayLeapYearNormalDateLessThanLeapMonthAndLeapYearNormalDateGreaterThanLeapMonthDiffInMonths()
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

    public function testDifferentYearEqualMonthEqualDayLeapYearNormalDateLessThanLeapMonthAndLeapDateDiffInMonths()
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

    public function testDifferentYearEqualMonthEqualDayLeapYearNormalDateEqualLeapMonthAndNormalYearNormalDateDiffInMonths()
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

    public function testDifferentYearEqualMonthEqualDayLeapYearNormalDateEqualLeapMonthAndLeapYearNormalDateLessThanLeapMonthDiffInMonths()
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

    public function testDifferentYearEqualMonthEqualDayLeapYearNormalDateEqualLeapMonthAndLeapYearNormalDateEqualLeapMonthDiffInMonths()
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

    public function testDifferentYearEqualMonthEqualDayLeapYearNormalDateEqualLeapMonthAndLeapYearNormalDateGreaterThanLeapMonthDiffInMonths()
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

    public function testDifferentYearEqualMonthEqualDayLeapYearNormalDateEqualLeapMonthAndLeapDateDiffInMonths()
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

    public function testDifferentYearEqualMonthEqualDayLeapYearNormalDateGreaterThanLeapMonthAndNormalYearNormalDateDiffInMonths()
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

    public function testDifferentYearEqualMonthEqualDayLeapYearNormalDateGreaterThanLeapMonthAndLeapYearNormalDateLessThanLeapMonthDiffInMonths()
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

    public function testDifferentYearEqualMonthEqualDayLeapYearNormalDateGreaterThanLeapMonthAndLeapYearNormalDateEqualLeapMonthDiffInMonths()
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

    public function testDifferentYearEqualMonthEqualDayLeapYearNormalDateGreaterThanLeapMonthAndLeapYearNormalDateGreaterThanLeapMonthDiffInMonths()
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

    public function testDifferentYearEqualMonthEqualDayLeapYearNormalDateGreaterThanLeapMonthAndLeapDateDiffInMonths()
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

    public function testDifferentYearEqualMonthEqualDayLeapDateAndNormalYearNormalDateDiffInMonths()
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

    public function testDifferentYearEqualMonthEqualDayLeapDateAndLeapYearNormalDateLessThanLeapMonthDiffInMonths()
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

    public function testDifferentYearEqualMonthEqualDayLeapDateAndLeapYearNormalDateEqualLeapMonthDiffInMonths()
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

    public function testDifferentYearEqualMonthEqualDayLeapDateAndLeapYearNormalDateGreaterThanLeapMonthDiffInMonths()
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

    public function testDifferentYearEqualMonthEqualDayLeapDateAndLeapDateDiffInMonths()
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

    //endregion different year equal month equal day

    //region different year equal month greater day

    public function testDifferentYearEqualMonthGreaterDayNormalYearNormalDateAndNormalYearNormalDateDiffInMonths()
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

    public function testDifferentYearEqualMonthGreaterDayNormalYearNormalDateAndLeapYearNormalDateLessThanLeapMonthDiffInMonths()
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

    public function testDifferentYearEqualMonthGreaterDayNormalYearNormalDateAndLeapYearNormalDateEqualLeapMonthDiffInMonths()
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

    public function testDifferentYearEqualMonthGreaterDayNormalYearNormalDateAndLeapYearNormalDateGreaterThanLeapMonthDiffInMonths()
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

    public function testDifferentYearEqualMonthGreaterDayNormalYearNormalDateAndLeapDateDiffInMonths()
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

    public function testDifferentYearEqualMonthGreaterDayLeapYearNormalDateLessThanLeapMonthAndNormalYearNormalDateDiffInMonths()
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

    public function testDifferentYearEqualMonthGreaterDayLeapYearNormalDateLessThanLeapMonthAndLeapYearNormalDateLessThanLeapMonthDiffInMonths()
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

    public function testDifferentYearEqualMonthGreaterDayLeapYearNormalDateLessThanLeapMonthAndLeapYearNormalDateEqualLeapMonthDiffInMonths()
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

    public function testDifferentYearEqualMonthGreaterDayLeapYearNormalDateLessThanLeapMonthAndLeapYearNormalDateGreaterThanLeapMonthDiffInMonths()
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

    public function testDifferentYearEqualMonthGreaterDayLeapYearNormalDateLessThanLeapMonthAndLeapDateDiffInMonths()
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

    public function testDifferentYearEqualMonthGreaterDayLeapYearNormalDateEqualLeapMonthAndNormalYearNormalDateDiffInMonths()
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

    public function testDifferentYearEqualMonthGreaterDayLeapYearNormalDateEqualLeapMonthAndLeapYearNormalDateLessThanLeapMonthDiffInMonths()
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

    public function testDifferentYearEqualMonthGreaterDayLeapYearNormalDateEqualLeapMonthAndLeapYearNormalDateEqualLeapMonthDiffInMonths()
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

    public function testDifferentYearEqualMonthGreaterDayLeapYearNormalDateEqualLeapMonthAndLeapYearNormalDateGreaterThanLeapMonthDiffInMonths()
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

    public function testDifferentYearEqualMonthGreaterDayLeapYearNormalDateEqualLeapMonthAndLeapDateDiffInMonths()
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

    public function testDifferentYearEqualMonthGreaterDayLeapYearNormalDateGreaterThanLeapMonthAndNormalYearNormalDateDiffInMonths()
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

    public function testDifferentYearEqualMonthGreaterDayLeapYearNormalDateGreaterThanLeapMonthAndLeapYearNormalDateLessThanLeapMonthDiffInMonths()
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

    public function testDifferentYearEqualMonthGreaterDayLeapYearNormalDateGreaterThanLeapMonthAndLeapYearNormalDateEqualLeapMonthDiffInMonths()
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

    public function testDifferentYearEqualMonthGreaterDayLeapYearNormalDateGreaterThanLeapMonthAndLeapYearNormalDateGreaterThanLeapMonthDiffInMonths()
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

    public function testDifferentYearEqualMonthGreaterDayLeapYearNormalDateGreaterThanLeapMonthAndLeapDateDiffInMonths()
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

    public function testDifferentYearEqualMonthGreaterDayLeapDateAndNormalYearNormalDateDiffInMonths()
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

    public function testDifferentYearEqualMonthGreaterDayLeapDateAndLeapYearNormalDateLessThanLeapMonthDiffInMonths()
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

    public function testDifferentYearEqualMonthGreaterDayLeapDateAndLeapYearNormalDateEqualLeapMonthDiffInMonths()
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

    public function testDifferentYearEqualMonthGreaterDayLeapDateAndLeapYearNormalDateGreaterThanLeapMonthDiffInMonths()
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

    public function testDifferentYearEqualMonthGreaterDayLeapDateAndLeapDateDiffInMonths()
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

    //endregion different year equal month greater day

    //region different year greater month less day

    public function testDifferentYearGreaterMonthLessDayNormalYearNormalDateAndNormalYearNormalDateDiffInMonths()
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

    public function testDifferentYearGreaterMonthLessDayNormalYearNormalDateAndLeapYearNormalDateLessThanLeapMonthDiffInMonths()
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

    public function testDifferentYearGreaterMonthLessDayNormalYearNormalDateAndLeapYearNormalDateEqualLeapMonthDiffInMonths()
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

    public function testDifferentYearGreaterMonthLessDayNormalYearNormalDateAndLeapYearNormalDateGreaterThanLeapMonthDiffInMonths()
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

    public function testDifferentYearGreaterMonthLessDayNormalYearNormalDateAndLeapDateDiffInMonths()
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

    public function testDifferentYearGreaterMonthLessDayLeapYearNormalDateLessThanLeapMonthAndNormalYearNormalDateDiffInMonths()
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

    public function testDifferentYearGreaterMonthLessDayLeapYearNormalDateLessThanLeapMonthAndLeapYearNormalDateLessThanLeapMonthDiffInMonths()
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

    public function testDifferentYearGreaterMonthLessDayLeapYearNormalDateLessThanLeapMonthAndLeapYearNormalDateEqualLeapMonthDiffInMonths()
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

    public function testDifferentYearGreaterMonthLessDayLeapYearNormalDateLessThanLeapMonthAndLeapYearNormalDateGreaterThanLeapMonthDiffInMonths()
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

    public function testDifferentYearGreaterMonthLessDayLeapYearNormalDateLessThanLeapMonthAndLeapDateDiffInMonths()
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

    public function testDifferentYearGreaterMonthLessDayLeapYearNormalDateEqualLeapMonthAndNormalYearNormalDateDiffInMonths()
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

    public function testDifferentYearGreaterMonthLessDayLeapYearNormalDateEqualLeapMonthAndLeapYearNormalDateLessThanLeapMonthDiffInMonths()
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

    public function testDifferentYearGreaterMonthLessDayLeapYearNormalDateEqualLeapMonthAndLeapYearNormalDateEqualLeapMonthDiffInMonths()
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

    public function testDifferentYearGreaterMonthLessDayLeapYearNormalDateEqualLeapMonthAndLeapYearNormalDateGreaterThanLeapMonthDiffInMonths()
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

    public function testDifferentYearGreaterMonthLessDayLeapYearNormalDateEqualLeapMonthAndLeapDateDiffInMonths()
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

    public function testDifferentYearGreaterMonthLessDayLeapYearNormalDateGreaterThanLeapMonthAndNormalYearNormalDateDiffInMonths()
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

    public function testDifferentYearGreaterMonthLessDayLeapYearNormalDateGreaterThanLeapMonthAndLeapYearNormalDateLessThanLeapMonthDiffInMonths()
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

    public function testDifferentYearGreaterMonthLessDayLeapYearNormalDateGreaterThanLeapMonthAndLeapYearNormalDateEqualLeapMonthDiffInMonths()
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

    public function testDifferentYearGreaterMonthLessDayLeapYearNormalDateGreaterThanLeapMonthAndLeapYearNormalDateGreaterThanLeapMonthDiffInMonths()
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

    public function testDifferentYearGreaterMonthLessDayLeapYearNormalDateGreaterThanLeapMonthAndLeapDateDiffInMonths()
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

    public function testDifferentYearGreaterMonthLessDayLeapYearLeapDateAndNormalYearNormalDateDiffInMonths()
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

    public function testDifferentYearGreaterMonthLessDayLeapYearLeapDateAndLeapYearNormalDateLessThanLeapMonthDiffInMonths()
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

    public function testDifferentYearGreaterMonthLessDayLeapYearLeapDateAndLeapYearNormalDateEqualLeapMonthDiffInMonths()
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

    public function testDifferentYearGreaterMonthLessDayLeapYearLeapDateAndLeapYearNormalDateGreaterThanLeapMonthDiffInMonths()
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

    public function testDifferentYearGreaterMonthLessDayLeapYearLeapDateAndLeapDateDiffInMonths()
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

    //endregion different year greater month less day

    //region different year greater month equal day

    public function testDifferentYearGreaterMonthEqualDayNormalYearNormalDateAndNormalYearNormalDateDiffInMonths()
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

    public function testDifferentYearGreaterMonthEqualDayNormalYearNormalDateAndLeapYearNormalDateLessThanLeapMonthDiffInMonths()
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

    public function testDifferentYearGreaterMonthEqualDayNormalYearNormalDateAndLeapYearNormalDateEqualLeapMonthDiffInMonths()
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

    public function testDifferentYearGreaterMonthEqualDayNormalYearNormalDateAndLeapYearNormalDateGreaterThanLeapMonthDiffInMonths()
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

    public function testDifferentYearGreaterMonthEqualDayNormalYearNormalDateAndLeapDateDiffInMonths()
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

    public function testDifferentYearGreaterMonthEqualDayLeapYearNormalDateLessThanLeapMonthAndNormalYearNormalDateDiffInMonths()
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

    public function testDifferentYearGreaterMonthEqualDayLeapYearNormalDateLessThanLeapMonthAndLeapYearNormalDateLessThanLeapMonthDiffInMonths()
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

    public function testDifferentYearGreaterMonthEqualDayLeapYearNormalDateLessThanLeapMonthAndLeapYearNormalDateEqualLeapMonthDiffInMonths()
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

    public function testDifferentYearGreaterMonthEqualDayLeapYearNormalDateLessThanLeapMonthAndLeapYearNormalDateGreaterThanLeapMonthDiffInMonths()
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

    public function testDifferentYearGreaterMonthEqualDayLeapYearNormalDateLessThanLeapMonthAndLeapDateDiffInMonths()
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

    public function testDifferentYearGreaterMonthEqualDayLeapYearNormalDateEqualLeapMonthAndNormalYearNormalDateDiffInMonths()
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

    public function testDifferentYearGreaterMonthEqualDayLeapYearNormalDateEqualLeapMonthAndLeapYearNormalDateLessThanLeapMonthDiffInMonths()
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

    public function testDifferentYearGreaterMonthEqualDayLeapYearNormalDateEqualLeapMonthAndLeapYearNormalDateEqualLeapMonthDiffInMonths()
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

    public function testDifferentYearGreaterMonthEqualDayLeapYearNormalDateEqualLeapMonthAndLeapYearNormalDateGreaterThanLeapMonthDiffInMonths()
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

    public function testDifferentYearGreaterMonthEqualDayLeapYearNormalDateEqualLeapMonthAndLeapDateDiffInMonths()
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

    public function testDifferentYearGreaterMonthEqualDayLeapYearNormalDateGreaterThanLeapMonthAndNormalYearNormalDateDiffInMonths()
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

    public function testDifferentYearGreaterMonthEqualDayLeapYearNormalDateGreaterThanLeapMonthAndLeapYearNormalDateLessThanLeapMonthDiffInMonths()
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

    public function testDifferentYearGreaterMonthEqualDayLeapYearNormalDateGreaterThanLeapMonthAndLeapYearNormalDateEqualLeapMonthDiffInMonths()
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

    public function testDifferentYearGreaterMonthEqualDayLeapYearNormalDateGreaterThanLeapMonthAndLeapYearNormalDateGreaterThanLeapMonthDiffInMonths()
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

    public function testDifferentYearGreaterMonthEqualDayLeapYearNormalDateGreaterThanLeapMonthAndLeapDateDiffInMonths()
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

    public function testDifferentYearGreaterMonthEqualDayLeapYearLeapDateAndNormalYearNormalDateDiffInMonths()
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

    public function testDifferentYearGreaterMonthEqualDayLeapYearLeapDateAndLeapYearNormalDateLessThanLeapMonthDiffInMonths()
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

    public function testDifferentYearGreaterMonthEqualDayLeapYearLeapDateAndLeapYearNormalDateEqualLeapMonthDiffInMonths()
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

    public function testDifferentYearGreaterMonthEqualDayLeapYearLeapDateAndLeapYearNormalDateGreaterThanLeapMonthDiffInMonths()
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

    public function testDifferentYearGreaterMonthEqualDayLeapYearLeapDateAndLeapDateDiffInMonths()
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

    //endregion different year greater month equal day

    //region different year greater month greater day

    public function testDifferentYearGreaterMonthGreaterDayNormalYearNormalDateAndNormalYearNormalDateDiffInMonths()
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

    public function testDifferentYearGreaterMonthGreaterDayNormalYearNormalDateAndLeapYearNormalDateLessThanLeapMonthDiffInMonths()
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

    public function testDifferentYearGreaterMonthGreaterDayNormalYearNormalDateAndLeapYearNormalDateEqualLeapMonthDiffInMonths()
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

    public function testDifferentYearGreaterMonthGreaterDayNormalYearNormalDateAndLeapYearNormalDateGreaterThanLeapMonthDiffInMonths()
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

    public function testDifferentYearGreaterMonthGreaterDayNormalYearNormalDateAndLeapDateDiffInMonths()
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

    public function testDifferentYearGreaterMonthGreaterDayLeapYearNormalDateLessThanLeapMonthAndNormalYearNormalDateDiffInMonths()
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

    public function testDifferentYearGreaterMonthGreaterDayLeapYearNormalDateLessThanLeapMonthAndLeapYearNormalDateLessThanLeapMonthDiffInMonths()
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

    public function testDifferentYearGreaterMonthGreaterDayLeapYearNormalDateLessThanLeapMonthAndLeapYearNormalDateEqualLeapMonthDiffInMonths()
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

    public function testDifferentYearGreaterMonthGreaterDayLeapYearNormalDateLessThanLeapMonthAndLeapYearNormalDateGreaterThanLeapMonthDiffInMonths()
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

    public function testDifferentYearGreaterMonthGreaterDayLeapYearNormalDateLessThanLeapMonthAndLeapDateDiffInMonths()
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

    public function testDifferentYearGreaterMonthGreaterDayLeapYearNormalDateEqualLeapMonthAndNormalYearNormalDateDiffInMonths()
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

    public function testDifferentYearGreaterMonthGreaterDayLeapYearNormalDateEqualLeapMonthAndLeapYearNormalDateLessThanLeapMonthDiffInMonths()
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

    public function testDifferentYearGreaterMonthGreaterDayLeapYearNormalDateEqualLeapMonthAndLeapYearNormalDateEqualLeapMonthDiffInMonths()
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

    public function testDifferentYearGreaterMonthGreaterDayLeapYearNormalDateEqualLeapMonthAndLeapYearNormalDateGreaterThanLeapMonthDiffInMonths()
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

    public function testDifferentYearGreaterMonthGreaterDayLeapYearNormalDateEqualLeapMonthAndLeapDateDiffInMonths()
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

    public function testDifferentYearGreaterMonthGreaterDayLeapYearNormalDateGreaterThanLeapMonthAndNormalYearNormalDateDiffInMonths()
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

    public function testDifferentYearGreaterMonthGreaterDayLeapYearNormalDateGreaterThanLeapMonthAndLeapYearNormalDateLessThanLeapMonthDiffInMonths()
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

    public function testDifferentYearGreaterMonthGreaterDayLeapYearNormalDateGreaterThanLeapMonthAndLeapYearNormalDateEqualLeapMonthDiffInMonths()
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

    public function testDifferentYearGreaterMonthGreaterDayLeapYearNormalDateGreaterThanLeapMonthAndLeapYearNormalDateGreaterThanLeapMonthDiffInMonths()
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

    public function testDifferentYearGreaterMonthGreaterDayLeapYearNormalDateGreaterThanLeapMonthAndLeapDateDiffInMonths()
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

    public function testDifferentYearGreaterMonthGreaterDayLeapYearLeapDateAndNormalYearNormalDateDiffInMonths()
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

    public function testDifferentYearGreaterMonthGreaterDayLeapYearLeapDateAndLeapYearNormalDateLessThanLeapMonthDiffInMonths()
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

    public function testDifferentYearGreaterMonthGreaterDayLeapYearLeapDateAndLeapYearNormalDateEqualLeapMonthDiffInMonths()
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

    public function testDifferentYearGreaterMonthGreaterDayLeapYearLeapDateAndLeapYearNormalDateGreaterThanLeapMonthDiffInMonths()
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

    public function testDifferentYearGreaterMonthGreaterDayLeapYearLeapDateAndLeapDateDiffInMonths()
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

    //endregion different year greater month greater day

    //region same year less month less day

    public function testSameYearLessMonthLessDayNormalYearNormalDateAndNormalDateDiffInMonths()
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

    public function testSameYearLessMonthLessDayLeapYearNormalDateLessThanLeapMonthAndNormalDateLessThanLeapMonthDiffInMonths()
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

    public function testSameYearLessMonthLessDayLeapYearNormalDateLessThanLeapMonthAndNormalDateEqualLeapMonthDiffInMonths()
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

    public function testSameYearLessMonthLessDayLeapYearNormalDateLessThanLeapMonthAndNormalDateGreaterThanLeapMonthDiffInMonths()
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

    public function testSameYearLessMonthLessDayLeapYearNormalDateLessThanLeapMonthAndLeapDateDiffInMonths()
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

    public function testSameYearLessMonthLessDayLeapYearNormalDateEqualLeapMonthAndNormalDateGreaterThanLeapMonthDiffInMonths()
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

    public function testSameYearLessMonthLessDayLeapYearNormalDateGreaterThanLeapMonthAndNormalDateGreaterThanLeapMonthDiffInMonths()
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

    public function testSameYearLessMonthLessDayLeapYearLeapDateAndNormalDateGreaterThanLeapMonthDiffInMonths()
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

    //endregion same year less month less day

    //region same year less month equal day

    public function testSameYearLessMonthEqualDayNormalYearNormalDateAndNormalDateDiffInMonths()
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

    public function testSameYearLessMonthEqualDayLeapYearNormalDateLessThanLeapMonthAndNormalDateLessThanLeapMonthDiffInMonths()
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

    public function testSameYearLessMonthEqualDayLeapYearNormalDateLessThanLeapMonthAndNormalDateEqualLeapMonthDiffInMonths()
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

    public function testSameYearLessMonthEqualDayLeapYearNormalDateLessThanLeapMonthAndNormalDateGreaterThanLeapMonthDiffInMonths()
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

    public function testSameYearLessMonthEqualDayLeapYearNormalDateLessThanLeapMonthAndLeapDateDiffInMonths()
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

    public function testSameYearLessMonthEqualDayLeapYearNormalDateEqualLeapMonthAndNormalDateGreaterThanLeapMonthDiffInMonths()
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

    public function testSameYearLessMonthEqualDayLeapYearNormalDateGreaterThanLeapMonthAndNormalDateGreaterThanLeapMonthDiffInMonths()
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

    public function testSameYearLessMonthEqualDayLeapYearLeapDateAndNormalDateGreaterThanLeapMonthDiffInMonths()
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

    //endregion same year less month equal day

    //region same year less month greater day

    public function testSameYearLessMonthGreaterDayNormalYearNormalDateAndNormalDateDiffInMonths()
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

    public function testSameYearLessMonthGreaterDayLeapYearNormalDateLessThanLeapMonthAndNormalDateLessThanLeapMonthDiffInMonths()
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

    public function testSameYearLessMonthGreaterDayLeapYearNormalDateLessThanLeapMonthAndNormalDateEqualLeapMonthDiffInMonths()
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

    public function testSameYearLessMonthGreaterDayLeapYearNormalDateLessThanLeapMonthAndNormalDateGreaterThanLeapMonthDiffInMonths()
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

    public function testSameYearLessMonthGreaterDayLeapYearNormalDateLessThanLeapMonthAndLeapDateDiffInMonths()
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

    public function testSameYearLessMonthGreaterDayLeapYearNormalDateEqualLeapMonthAndNormalDateGreaterThanLeapMonthDiffInMonths()
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

    public function testSameYearLessMonthGreaterDayLeapYearNormalDateGreaterThanLeapMonthAndNormalDateGreaterThanLeapMonthDiffInMonths()
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

    public function testSameYearLessMonthGreaterDayLeapYearLeapDateAndNormalDateGreaterThanLeapMonthDiffInMonths()
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

    //endregion same year less month greater day

    //region same year equal month less day

    public function testSameYearEqualMonthLessDayNormalYearNormalDateAndNormalDateDiffInMonths()
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

    public function testSameYearEqualMonthLessDayLeapYearNormalDateLessThanLeapMonthAndNormalDateLessThanLeapMonthDiffInMonths()
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

    public function testSameYearEqualMonthLessDayLeapYearNormalDateEqualLeapMonthAndNormalDateEqualLeapMonthDiffInMonths()
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

    public function testSameYearEqualMonthLessDayLeapYearNormalDateGreaterThanLeapMonthAndNormalDateGreaterThanLeapMonthDiffInMonths()
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

    public function testSameYearEqualMonthLessDayLeapYearNormalDateLessThanLeapMonthAndLeapDateDiffInMonths()
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

    public function testSameYearEqualMonthLessDayLeapDateAndLeapDateDiffInMonths()
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

    //endregion same year equal month less day

    //region same year equal month equal day

    public function testSameYearEqualMonthEqualDayNormalYearNormalDateAndNormalDateDiffInMonths()
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

    public function testSameYearEqualMonthEqualDayLeapYearNormalDateLessThanLeapMonthAndNormalDateLessThanLeapMonthDiffInMonths()
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

    public function testSameYearEqualMonthEqualDayLeapYearNormalDateEqualLeapMonthAndNormalDateEqualLeapMonthDiffInMonths()
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

    public function testSameYearEqualMonthEqualDayLeapYearNormalDateGreaterThanLeapMonthAndNormalDateGreaterThanLeapMonthDiffInMonths()
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

    public function testSameYearEqualMonthEqualDayLeapYearNormalDateLessThanLeapMonthAndLeapDateDiffInMonths()
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

    public function testSameYearEqualMonthEqualDayLeapDateAndLeapDateDiffInMonths()
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

    //endregion same year equal month equal day

    //endregion diffInMonths

    //region diffInDays

    public function testDiffInDays()
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

    public function testDiffInDaysAcrossLocalMeanTimeAndDaylightSavingTime()
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

    public function testDiffInDaysIsIndependentOfDefaultTimezone()
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

    //endregion diffInDays

    //region addYears

    public function testLastDayOfLeapMonthOverFlowAddYears()
    {
        $calendar = new Calendar();
        $lunar = $calendar->lunar(2017, 6, 30, true);
        $newLunar = $calendar->addYears($lunar, 10, true);
        $this->assertEquals(2027, $newLunar['lunar_year']);
        $this->assertEquals(7, $newLunar['lunar_month']);
        $this->assertEquals(1, $newLunar['lunar_day']);
        $this->assertEquals(false, $newLunar['is_leap']);
    }

    public function testLastDayOfLeapMonthNotOverFlowAddYears()
    {
        $calendar = new Calendar();
        $lunar = $calendar->lunar(2017, 6, 30, true);
        $newLunar = $calendar->addYears($lunar, 10, false);
        $this->assertEquals(2027, $newLunar['lunar_year']);
        $this->assertEquals(6, $newLunar['lunar_month']);
        $this->assertEquals(29, $newLunar['lunar_day']);
        $this->assertEquals(false, $newLunar['is_leap']);
    }

    public function testLastDayOfYearOverFlowAddYears()
    {
        $calendar = new Calendar();
        $lunar = $calendar->lunar(2018, 12, 30, false);
        $newLunar = $calendar->addYears($lunar, 6, true);
        $this->assertEquals(2025, $newLunar['lunar_year']);
        $this->assertEquals(1, $newLunar['lunar_month']);
        $this->assertEquals(1, $newLunar['lunar_day']);
        $this->assertEquals(false, $newLunar['is_leap']);
    }

    public function testLastDayOfYearNotOverFlowAddYears()
    {
        $calendar = new Calendar();
        $lunar = $calendar->lunar(2018, 12, 30, false);
        $newLunar = $calendar->addYears($lunar, 6, false);
        $this->assertEquals(2024, $newLunar['lunar_year']);
        $this->assertEquals(12, $newLunar['lunar_month']);
        $this->assertEquals(29, $newLunar['lunar_day']);
        $this->assertEquals(false, $newLunar['is_leap']);
    }

    public function testLeapMonthAddYearsToLeapMonth()
    {
        $calendar = new Calendar();
        $lunar = $calendar->lunar(1998, 5, 29, true);
        $newLunar = $calendar->addYears($lunar, 11, false);
        $this->assertEquals(2009, $newLunar['lunar_year']);
        $this->assertEquals(5, $newLunar['lunar_month']);
        $this->assertEquals(29, $newLunar['lunar_day']);
        $this->assertEquals(true, $newLunar['is_leap']);
    }

    public function testNormalMonthAddYearsToNormalMonth()
    {
        $calendar = new Calendar();
        $lunar = $calendar->lunar(1998, 5, 29, false);
        $newLunar = $calendar->addYears($lunar, 11, false);
        $this->assertEquals(2009, $newLunar['lunar_year']);
        $this->assertEquals(5, $newLunar['lunar_month']);
        $this->assertEquals(29, $newLunar['lunar_day']);
        $this->assertEquals(false, $newLunar['is_leap']);
    }

    //endregion addYears

    //region subYears

    public function testLastDayOfLeapMonthOverFlowSubYears()
    {
        $calendar = new Calendar();
        $lunar = $calendar->lunar(2017, 6, 30, true);
        $newLunar = $calendar->subYears($lunar, 9, true);
        $this->assertEquals(2008, $newLunar['lunar_year']);
        $this->assertEquals(7, $newLunar['lunar_month']);
        $this->assertEquals(1, $newLunar['lunar_day']);
        $this->assertEquals(false, $newLunar['is_leap']);
    }

    public function testLastDayOfLeapMonthNotOverFlowSubYears()
    {
        $calendar = new Calendar();
        $lunar = $calendar->lunar(2017, 6, 30, true);
        $newLunar = $calendar->subYears($lunar, 9, false);
        $this->assertEquals(2008, $newLunar['lunar_year']);
        $this->assertEquals(6, $newLunar['lunar_month']);
        $this->assertEquals(29, $newLunar['lunar_day']);
        $this->assertEquals(false, $newLunar['is_leap']);
    }

    public function testLastDayOfYearOverFlowSubYears()
    {
        $calendar = new Calendar();
        $lunar = $calendar->lunar(2018, 12, 30, false);
        $newLunar = $calendar->subYears($lunar, 7, true);
        $this->assertEquals(2012, $newLunar['lunar_year']);
        $this->assertEquals(1, $newLunar['lunar_month']);
        $this->assertEquals(1, $newLunar['lunar_day']);
        $this->assertEquals(false, $newLunar['is_leap']);
    }

    public function testLastDayOfYearNotOverFlowSubYears()
    {
        $calendar = new Calendar();
        $lunar = $calendar->lunar(2018, 12, 30, false);
        $newLunar = $calendar->subYears($lunar, 7, false);
        $this->assertEquals(2011, $newLunar['lunar_year']);
        $this->assertEquals(12, $newLunar['lunar_month']);
        $this->assertEquals(29, $newLunar['lunar_day']);
        $this->assertEquals(false, $newLunar['is_leap']);
    }

    public function testLeapMonthSubYearsToLeapMonth()
    {
        $calendar = new Calendar();
        $lunar = $calendar->lunar(2009, 5, 29, true);
        $newLunar = $calendar->subYears($lunar, 11, false);
        $this->assertEquals(1998, $newLunar['lunar_year']);
        $this->assertEquals(5, $newLunar['lunar_month']);
        $this->assertEquals(29, $newLunar['lunar_day']);
        $this->assertEquals(true, $newLunar['is_leap']);
    }

    //endregion subYears

    //region addMonths

    public function testAddMonthsLesserThanLeapMonth()
    {
        $calendar = new Calendar();
        $lunar = $calendar->lunar(2017, 1, 1, false);
        $newLunar = $calendar->addMonths($lunar, 2);
        $this->assertEquals(2017, $newLunar['lunar_year']);
        $this->assertEquals(3, $newLunar['lunar_month']);
        $this->assertEquals(1, $newLunar['lunar_day']);
        $this->assertEquals(false, $newLunar['is_leap']);
    }

    public function testNormalMonthAddMonthsToSameLeapMonth()
    {
        $calendar = new Calendar();
        $lunar = $calendar->lunar(2017, 6, 29, false);
        $newLunar = $calendar->addMonths($lunar);
        $this->assertEquals(2017, $newLunar['lunar_year']);
        $this->assertEquals(6, $newLunar['lunar_month']);
        $this->assertEquals(29, $newLunar['lunar_day']);
        $this->assertEquals(true, $newLunar['is_leap']);
    }

    public function testLastDayOfLeapMonthOverFlowAddMonthsOverLeapMonthToLeapMonth()
    {
        $calendar = new Calendar();
        $lunar = $calendar->lunar(2017, 6, 30, true);
        $newLunar = $calendar->addMonths($lunar, 70, true);
        $this->assertEquals(2023, $newLunar['lunar_year']);
        $this->assertEquals(3, $newLunar['lunar_month']);
        $this->assertEquals(1, $newLunar['lunar_day']);
        $this->assertEquals(false, $newLunar['is_leap']);
    }

    public function testLastDayOfLeapMonthNotOverFlowAddMonthsOverLeapMonthToLeapMonth()
    {
        $calendar = new Calendar();
        $lunar = $calendar->lunar(2017, 6, 30, true);
        $newLunar = $calendar->addMonths($lunar, 70, false);
        $this->assertEquals(2023, $newLunar['lunar_year']);
        $this->assertEquals(2, $newLunar['lunar_month']);
        $this->assertEquals(29, $newLunar['lunar_day']);
        $this->assertEquals(true, $newLunar['is_leap']);
    }

    public function testLastDayOfLeapMonthOverFlowAddMonthsOverLeapMonthToNormalMonth()
    {
        $calendar = new Calendar();
        $lunar = $calendar->lunar(2017, 6, 30, true);
        $newLunar = $calendar->addMonths($lunar, 71, true);
        $this->assertEquals(2023, $newLunar['lunar_year']);
        $this->assertEquals(4, $newLunar['lunar_month']);
        $this->assertEquals(1, $newLunar['lunar_day']);
        $this->assertEquals(false, $newLunar['is_leap']);
    }

    public function testLastDayOfLeapMonthNotOverFlowAddMonthsOverLeapMonthToNormalMonth()
    {
        $calendar = new Calendar();
        $lunar = $calendar->lunar(2017, 6, 30, true);
        $newLunar = $calendar->addMonths($lunar, 71, false);
        $this->assertEquals(2023, $newLunar['lunar_year']);
        $this->assertEquals(3, $newLunar['lunar_month']);
        $this->assertEquals(29, $newLunar['lunar_day']);
        $this->assertEquals(false, $newLunar['is_leap']);
    }

    public function testLastDayOfNormalMonthOverFlowAddMonthsOverLeapMonthToLeapMonth()
    {
        $calendar = new Calendar();
        $lunar = $calendar->lunar(2017, 4, 30, false);
        $newLunar = $calendar->addMonths($lunar, 73, true);
        $this->assertEquals(2023, $newLunar['lunar_year']);
        $this->assertEquals(3, $newLunar['lunar_month']);
        $this->assertEquals(1, $newLunar['lunar_day']);
        $this->assertEquals(false, $newLunar['is_leap']);
    }

    public function testLastDayOfNormalMonthNotOverFlowAddMonthsOverLeapMonthToLeapMonth()
    {
        $calendar = new Calendar();
        $lunar = $calendar->lunar(2017, 4, 30, false);
        $newLunar = $calendar->addMonths($lunar, 73, false);
        $this->assertEquals(2023, $newLunar['lunar_year']);
        $this->assertEquals(2, $newLunar['lunar_month']);
        $this->assertEquals(29, $newLunar['lunar_day']);
        $this->assertEquals(true, $newLunar['is_leap']);
    }

    public function testLastDayOfNormalMonthOverFlowAddMonthsOverLeapMonthToNormalMonth()
    {
        $calendar = new Calendar();
        $lunar = $calendar->lunar(2017, 4, 30, false);
        $newLunar = $calendar->addMonths($lunar, 74, true);
        $this->assertEquals(2023, $newLunar['lunar_year']);
        $this->assertEquals(4, $newLunar['lunar_month']);
        $this->assertEquals(1, $newLunar['lunar_day']);
        $this->assertEquals(false, $newLunar['is_leap']);
    }

    public function testLastDayOfNormalMonthNotOverFlowAddMonthsOverLeapMonthToNormalMonth()
    {
        $calendar = new Calendar();
        $lunar = $calendar->lunar(2017, 4, 30, false);
        $newLunar = $calendar->addMonths($lunar, 74, false);
        $this->assertEquals(2023, $newLunar['lunar_year']);
        $this->assertEquals(3, $newLunar['lunar_month']);
        $this->assertEquals(29, $newLunar['lunar_day']);
        $this->assertEquals(false, $newLunar['is_leap']);
    }

    //endregion addMonths

    //region subMonths

    public function testSubMonthsGreaterThanLeapMonth()
    {
        $calendar = new Calendar();
        $lunar = $calendar->lunar(2017, 9, 1, false);
        $newLunar = $calendar->subMonths($lunar, 2);
        $this->assertEquals(2017, $newLunar['lunar_year']);
        $this->assertEquals(7, $newLunar['lunar_month']);
        $this->assertEquals(1, $newLunar['lunar_day']);
        $this->assertEquals(false, $newLunar['is_leap']);
    }

    public function testLeapMonthSubMonthsToSameNormalMonth()
    {
        $calendar = new Calendar();
        $lunar = $calendar->lunar(2017, 6, 29, true);
        $newLunar = $calendar->subMonths($lunar);
        $this->assertEquals(2017, $newLunar['lunar_year']);
        $this->assertEquals(6, $newLunar['lunar_month']);
        $this->assertEquals(29, $newLunar['lunar_day']);
        $this->assertEquals(false, $newLunar['is_leap']);
    }

    public function testSubMonthsToLeapMonth()
    {
        $calendar = new Calendar();
        $lunar = $calendar->lunar(2017, 9, 1, false);
        $newLunar = $calendar->subMonths($lunar, 3);
        $this->assertEquals(2017, $newLunar['lunar_year']);
        $this->assertEquals(6, $newLunar['lunar_month']);
        $this->assertEquals(1, $newLunar['lunar_day']);
        $this->assertEquals(true, $newLunar['is_leap']);
    }

    public function testSubMonthsToNormalMonth()
    {
        $calendar = new Calendar();
        $lunar = $calendar->lunar(2017, 9, 1, false);
        $newLunar = $calendar->subMonths($lunar, 4);
        $this->assertEquals(2017, $newLunar['lunar_year']);
        $this->assertEquals(6, $newLunar['lunar_month']);
        $this->assertEquals(1, $newLunar['lunar_day']);
        $this->assertEquals(false, $newLunar['is_leap']);
    }

    public function testLastDayOfLeapMonthOverFlowSubMonthsOverLeapMonthToLeapMonth()
    {
        $calendar = new Calendar();
        $lunar = $calendar->lunar(2017, 6, 30, true);
        $newLunar = $calendar->subMonths($lunar, 64, true);
        $this->assertEquals(2012, $newLunar['lunar_year']);
        $this->assertEquals(5, $newLunar['lunar_month']);
        $this->assertEquals(1, $newLunar['lunar_day']);
        $this->assertEquals(false, $newLunar['is_leap']);
    }

    public function testLastDayOfLeapMonthNotOverFlowSubMonthsOverLeapMonthToLeapMonth()
    {
        $calendar = new Calendar();
        $lunar = $calendar->lunar(2017, 6, 30, true);
        $newLunar = $calendar->subMonths($lunar, 64, false);
        $this->assertEquals(2012, $newLunar['lunar_year']);
        $this->assertEquals(4, $newLunar['lunar_month']);
        $this->assertEquals(29, $newLunar['lunar_day']);
        $this->assertEquals(true, $newLunar['is_leap']);
    }

    public function testLastDayOfLeapMonthOverFlowSubMonthsOverLeapMonthToNormalMonth()
    {
        $calendar = new Calendar();
        $lunar = $calendar->lunar(2017, 6, 30, true);
        $newLunar = $calendar->subMonths($lunar, 67, true);
        $this->assertEquals(2012, $newLunar['lunar_year']);
        $this->assertEquals(3, $newLunar['lunar_month']);
        $this->assertEquals(1, $newLunar['lunar_day']);
        $this->assertEquals(false, $newLunar['is_leap']);
    }

    public function testLastDayOfLeapMonthNotOverFlowSubMonthsOverLeapMonthToNormalMonth()
    {
        $calendar = new Calendar();
        $lunar = $calendar->lunar(2017, 6, 30, true);
        $newLunar = $calendar->subMonths($lunar, 67, false);
        $this->assertEquals(2012, $newLunar['lunar_year']);
        $this->assertEquals(2, $newLunar['lunar_month']);
        $this->assertEquals(29, $newLunar['lunar_day']);
        $this->assertEquals(false, $newLunar['is_leap']);
    }

    //endregion subMonths

    //region addDays

    public function testAddDaysOverYears()
    {
        $calendar = new Calendar();
        $lunar = $calendar->lunar(2018, 7, 11, false);
        $newLunar = $calendar->addDays($lunar, 4655, false);
        $this->assertEquals(2031, $newLunar['lunar_year']);
        $this->assertEquals(3, $newLunar['lunar_month']);
        $this->assertEquals(29, $newLunar['lunar_day']);
        $this->assertEquals(true, $newLunar['is_leap']);
    }

    //endregion addDays

    //region subDays

    public function testSubDaysOverYears()
    {
        $calendar = new Calendar();
        $lunar = $calendar->lunar(2031, 3, 29, true);
        $newLunar = $calendar->subDays($lunar, 4655, false);
        $this->assertEquals(2018, $newLunar['lunar_year']);
        $this->assertEquals(7, $newLunar['lunar_month']);
        $this->assertEquals(11, $newLunar['lunar_day']);
        $this->assertEquals(false, $newLunar['is_leap']);
    }

    //endregion subDays

    //region getAnimal

    public function testMouseGetAnimal()
    {
        $calendar = new Calendar();
        $animal = $calendar->getAnimal(1984);
        $this->assertEquals('鼠', $animal);
    }

    public function testPigGetAnimal()
    {
        $calendar = new Calendar();
        $animal = $calendar->getAnimal(1983);
        $this->assertEquals('猪', $animal);
    }

    //region solar2lunar

    public function testSolar2LunarChinaDaylightSavingTimeStart1986()
    {
        $calendar = new Calendar();

        // 1986 年中国夏令时自 5 月 4 日 02:00 开始（见 issue #52）
        $this->assertEquals(25, $calendar->solar2lunar(1986, 5, 3)['lunar_day']);
        $this->assertEquals(26, $calendar->solar2lunar(1986, 5, 4)['lunar_day']);
        $this->assertEquals(27, $calendar->solar2lunar(1986, 5, 5)['lunar_day']);
        $this->assertEquals(28, $calendar->solar2lunar(1986, 5, 6)['lunar_day']);
    }

    public function testSolar2LunarChinaDaylightSavingTimeEnd1986()
    {
        $calendar = new Calendar();

        // 1986 年夏令时于 9 月 14 日 02:00 结束
        $this->assertEquals(10, $calendar->solar2lunar(1986, 9, 13)['lunar_day']);
        $this->assertEquals(11, $calendar->solar2lunar(1986, 9, 14)['lunar_day']);
        $this->assertEquals(12, $calendar->solar2lunar(1986, 9, 15)['lunar_day']);
        $this->assertEquals(13, $calendar->solar2lunar(1986, 9, 16)['lunar_day']);
    }

    public function testSolar2LunarChinaDaylightSavingTime1987()
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

    public function testSolar2LunarChinaDaylightSavingTime1991()
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

    public function testSolar2LunarDayContinuityDuringChinaDaylightSavingTime()
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

    //endregion solar2lunar

    //region lunar2solar

    public function testLunar2SolarFirstLunarMonthOf1900()
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

    public function testLunar2SolarUpperBound()
    {
        $calendar = new Calendar();

        // 农历 2100 年腊月初一 = 公历 2100-12-31，是数据表的最后一天
        $this->assertSame(
            ['solar_year' => '2100', 'solar_month' => '12', 'solar_day' => '31'],
            $calendar->lunar2solar(2100, 12, 1)
        );
        $this->assertSame(-1, $calendar->lunar2solar(2100, 12, 2));
    }

    public function testLunar2SolarIsIndependentOfDefaultTimezone()
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

    public function testLunar2SolarRoundTripForEveryLunarMonth()
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

    //endregion lunar2solar

    //region solar

    public function testSolarIsTodayOnlyForToday()
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

    //endregion solar

    //region ganzhi_year & animal

    public function testGanZhiYearAndAnimalAreNotShiftedOnSolarTermDays()
    {
        $calendar = new Calendar();

        // 早期版本会在小寒、大寒、立春当天把干支年加一（issue #50），结果与任何分界约定都不符
        $cases = [
            [2022, 1, 20, '大寒', '辛丑', '牛'],
            [2023, 2, 4, '立春', '癸卯', '兔'],
            [2024, 1, 6, '小寒', '癸卯', '兔'],
            [2025, 1, 5, '小寒', '甲辰', '龙'],
            [2025, 1, 20, '大寒', '甲辰', '龙'],
            [2025, 2, 3, '立春', '乙巳', '蛇'],
            [2017, 2, 3, '立春', '丁酉', '鸡'],
        ];

        foreach ($cases as list($year, $month, $day, $term, $ganZhiYear, $animal)) {
            $solar = $calendar->solar($year, $month, $day);
            $message = "{$year}-{$month}-{$day}";

            $this->assertSame($term, $solar['term'], $message);
            $this->assertSame($ganZhiYear, $solar['ganzhi_year'], $message);
            $this->assertSame($animal, $solar['animal'], $message);
        }
    }

    public function testGanZhiYearAndAnimalFollowLunarNewYear()
    {
        $calendar = new Calendar();

        // 2024 年立春（2 月 4 日）早于正月初一（2 月 10 日）：分界以正月初一为准，与 lunar_year 一致
        $cases = [
            [2024, 2, 4, '2023', '癸卯', '兔'],
            [2024, 2, 9, '2023', '癸卯', '兔'],
            [2024, 2, 10, '2024', '甲辰', '龙'],
            [2018, 2, 4, '2017', '丁酉', '鸡'],
            [2018, 2, 16, '2018', '戊戌', '狗'],
        ];

        foreach ($cases as list($year, $month, $day, $lunarYear, $ganZhiYear, $animal)) {
            $solar = $calendar->solar($year, $month, $day);
            $message = "{$year}-{$month}-{$day}";

            $this->assertSame($lunarYear, $solar['lunar_year'], $message);
            $this->assertSame($ganZhiYear, $solar['ganzhi_year'], $message);
            $this->assertSame($animal, $solar['animal'], $message);
        }
    }

    public function testGanZhiYearAndAnimalAreConsistentWithLunarYearEveryDay()
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

    //endregion ganzhi_year & animal

    //region data tables

    public function testLunarMonthsMatchHongKongObservatoryTables()
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

    public function testSolarTermsMatchHongKongObservatoryTables()
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

    public function testLunarMonthLengthsOf1933()
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

    public function testLunarMonthLengthsOf2060()
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

    public function testLunarMonthLengthsOf2057FollowHongKongObservatory()
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

    //endregion data tables

    //region ganzhi_day & ganzhi_hour

    public function testEightCharactersDuringChinaDaylightSavingTime()
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

    //endregion ganzhi_day & ganzhi_hour

    //region helpers

    /**
     * 读取 tests/fixtures 下的 CSV（忽略以 # 开头的注释行），返回按逗号切分后的行.
     *
     * @param string $name
     *
     * @return array
     */
    private function loadFixture($name)
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
    private function withDefaultTimezone($timezone, callable $callback)
    {
        $previous = date_default_timezone_get();
        date_default_timezone_set($timezone);

        try {
            $callback();
        } finally {
            date_default_timezone_set($previous);
        }
    }

    //endregion helpers
}
