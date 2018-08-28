<?php
/**
 * User: hao.li
 * Date: 2018/8/21
 * Time: 8:54 AM.
 */

namespace Overtrue\ChineseCalendar\Tests;

use Overtrue\ChineseCalendar\Calendar;
use PHPUnit\Framework\TestCase;

class CalendarTest extends TestCase
{
    //region diffInYears

    public function testSameNormalDateDiffInYears()
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 29, false);
        $lunar2 = $calendar->lunar(2017, 6, 29, false);
        $diff1 = $calendar->diffInYears($lunar1, $lunar2);
        $diff2 = $calendar->diffInYears($lunar2, $lunar1);
        $this->assertEquals(0, $diff1);
        $this->assertEquals(0, $diff2);
    }

    public function testSameLeapDateDiffInYears()
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 30, true);
        $lunar2 = $calendar->lunar(2017, 6, 30, true);
        $diff1 = $calendar->diffInYears($lunar1, $lunar2);
        $diff2 = $calendar->diffInYears($lunar2, $lunar1);
        $this->assertEquals(0, $diff1);
        $this->assertEquals(0, $diff2);
    }

    //region less month

    public function testLessMonthLessDayNormalDateAndNormalDateDiffInYears()
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, false);
        $lunar2 = $calendar->lunar(2027, 8, 20, false);
        $diff1 = $calendar->diffInYears($lunar1, $lunar2);
        $diff2 = $calendar->diffInYears($lunar2, $lunar1);
        $diff2a = $calendar->diffInYears($lunar2, $lunar1, true);
        $this->assertEquals(10, $diff1);
        $this->assertEquals(-10, $diff2);
        $this->assertEquals(10, $diff2a);
    }

    public function testLessMonthLessDayNormalDateAndLeapDateDiffInYears()
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2007, 5, 10, false);
        $lunar2 = $calendar->lunar(2017, 6, 20, true);
        $diff1 = $calendar->diffInYears($lunar1, $lunar2);
        $diff2 = $calendar->diffInYears($lunar2, $lunar1);
        $diff2a = $calendar->diffInYears($lunar2, $lunar1, true);
        $this->assertEquals(10, $diff1);
        $this->assertEquals(-10, $diff2);
        $this->assertEquals(10, $diff2a);
    }

    public function testLessMonthLessDayLeapDateAndNormalDateDiffInYears()
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, true);
        $lunar2 = $calendar->lunar(2027, 7, 20, false);
        $diff1 = $calendar->diffInYears($lunar1, $lunar2);
        $diff2 = $calendar->diffInYears($lunar2, $lunar1);
        $diff2a = $calendar->diffInYears($lunar2, $lunar1, true);
        $this->assertEquals(10, $diff1);
        $this->assertEquals(-10, $diff2);
        $this->assertEquals(10, $diff2a);
    }

    public function testLessMonthLessDayLeapDateAndLeapDateDiffInYears()
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, true);
        $lunar2 = $calendar->lunar(2052, 8, 20, true);
        $diff1 = $calendar->diffInYears($lunar1, $lunar2);
        $diff2 = $calendar->diffInYears($lunar2, $lunar1);
        $diff2a = $calendar->diffInYears($lunar2, $lunar1, true);
        $this->assertEquals(35, $diff1);
        $this->assertEquals(-35, $diff2);
        $this->assertEquals(35, $diff2a);
    }

    public function testLessMonthEqualDayNormalDateAndNormalDateDiffInYears()
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, false);
        $lunar2 = $calendar->lunar(2027, 8, 10, false);
        $diff1 = $calendar->diffInYears($lunar1, $lunar2);
        $diff2 = $calendar->diffInYears($lunar2, $lunar1);
        $diff2a = $calendar->diffInYears($lunar2, $lunar1, true);
        $this->assertEquals(10, $diff1);
        $this->assertEquals(-10, $diff2);
        $this->assertEquals(10, $diff2a);
    }

    public function testLessMonthEqualDayNormalDateAndLeapDateDiffInYears()
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2007, 5, 10, false);
        $lunar2 = $calendar->lunar(2017, 6, 10, true);
        $diff1 = $calendar->diffInYears($lunar1, $lunar2);
        $diff2 = $calendar->diffInYears($lunar2, $lunar1);
        $diff2a = $calendar->diffInYears($lunar2, $lunar1, true);
        $this->assertEquals(10, $diff1);
        $this->assertEquals(-10, $diff2);
        $this->assertEquals(10, $diff2a);
    }

    public function testLessMonthEqualDayLeapDateAndNormalDateDiffInYears()
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, true);
        $lunar2 = $calendar->lunar(2027, 7, 10, false);
        $diff1 = $calendar->diffInYears($lunar1, $lunar2);
        $diff2 = $calendar->diffInYears($lunar2, $lunar1);
        $diff2a = $calendar->diffInYears($lunar2, $lunar1, true);
        $this->assertEquals(10, $diff1);
        $this->assertEquals(-10, $diff2);
        $this->assertEquals(10, $diff2a);
    }

    public function testLessMonthEqualDayLeapDateAndLeapDateDiffInYears()
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, true);
        $lunar2 = $calendar->lunar(2052, 8, 10, true);
        $diff1 = $calendar->diffInYears($lunar1, $lunar2);
        $diff2 = $calendar->diffInYears($lunar2, $lunar1);
        $diff2a = $calendar->diffInYears($lunar2, $lunar1, true);
        $this->assertEquals(35, $diff1);
        $this->assertEquals(-35, $diff2);
        $this->assertEquals(35, $diff2a);
    }

    public function testLessMonthGreaterDayNormalDateAndNormalDateDiffInYears()
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, false);
        $lunar2 = $calendar->lunar(2027, 8, 1, false);
        $diff1 = $calendar->diffInYears($lunar1, $lunar2);
        $diff2 = $calendar->diffInYears($lunar2, $lunar1);
        $diff2a = $calendar->diffInYears($lunar2, $lunar1, true);
        $this->assertEquals(10, $diff1);
        $this->assertEquals(-10, $diff2);
        $this->assertEquals(10, $diff2a);
    }

    public function testLessMonthGreaterDayNormalDateAndLeapDateDiffInYears()
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2007, 5, 10, false);
        $lunar2 = $calendar->lunar(2017, 6, 1, true);
        $diff1 = $calendar->diffInYears($lunar1, $lunar2);
        $diff2 = $calendar->diffInYears($lunar2, $lunar1);
        $diff2a = $calendar->diffInYears($lunar2, $lunar1, true);
        $this->assertEquals(10, $diff1);
        $this->assertEquals(-10, $diff2);
        $this->assertEquals(10, $diff2a);
    }

    public function testLessMonthGreaterDayLeapDateAndNormalDateDiffInYears()
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, true);
        $lunar2 = $calendar->lunar(2027, 7, 1, false);
        $diff1 = $calendar->diffInYears($lunar1, $lunar2);
        $diff2 = $calendar->diffInYears($lunar2, $lunar1);
        $diff2a = $calendar->diffInYears($lunar2, $lunar1, true);
        $this->assertEquals(10, $diff1);
        $this->assertEquals(-10, $diff2);
        $this->assertEquals(10, $diff2a);
    }

    public function testLessMonthGreaterDayLeapDateAndLeapDateDiffInYears()
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, true);
        $lunar2 = $calendar->lunar(2052, 8, 1, true);
        $diff1 = $calendar->diffInYears($lunar1, $lunar2);
        $diff2 = $calendar->diffInYears($lunar2, $lunar1);
        $diff2a = $calendar->diffInYears($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInYears($lunar1, $lunar2);
        $diff2 = $calendar->diffInYears($lunar2, $lunar1);
        $diff2a = $calendar->diffInYears($lunar2, $lunar1, true);
        $this->assertEquals(10, $diff1);
        $this->assertEquals(-10, $diff2);
        $this->assertEquals(10, $diff2a);
    }

    public function testEqualMonthLessDayNormalDateAndLeapDateDiffInYears()
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2007, 6, 10, false);
        $lunar2 = $calendar->lunar(2017, 6, 20, true);
        $diff1 = $calendar->diffInYears($lunar1, $lunar2);
        $diff2 = $calendar->diffInYears($lunar2, $lunar1);
        $diff2a = $calendar->diffInYears($lunar2, $lunar1, true);
        $this->assertEquals(10, $diff1);
        $this->assertEquals(-10, $diff2);
        $this->assertEquals(10, $diff2a);
    }

    public function testEqualMonthLessDayLeapDateAndNormalDateDiffInYears()
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, true);
        $lunar2 = $calendar->lunar(2027, 6, 20, false);
        $diff1 = $calendar->diffInYears($lunar1, $lunar2);
        $diff2 = $calendar->diffInYears($lunar2, $lunar1);
        $diff2a = $calendar->diffInYears($lunar2, $lunar1, true);
        $this->assertEquals(9, $diff1);
        $this->assertEquals(-9, $diff2);
        $this->assertEquals(9, $diff2a);
    }

    public function testEqualMonthLessDayLeapDateAndLeapDateDiffInYears()
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, true);
        $lunar2 = $calendar->lunar(2025, 6, 20, true);
        $diff1 = $calendar->diffInYears($lunar1, $lunar2);
        $diff2 = $calendar->diffInYears($lunar2, $lunar1);
        $diff2a = $calendar->diffInYears($lunar2, $lunar1, true);
        $this->assertEquals(8, $diff1);
        $this->assertEquals(-8, $diff2);
        $this->assertEquals(8, $diff2a);
    }

    public function testEqualMonthEqualDayNormalDateAndNormalDateDiffInYears()
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, false);
        $lunar2 = $calendar->lunar(2027, 6, 10, false);
        $diff1 = $calendar->diffInYears($lunar1, $lunar2);
        $diff2 = $calendar->diffInYears($lunar2, $lunar1);
        $diff2a = $calendar->diffInYears($lunar2, $lunar1, true);
        $this->assertEquals(10, $diff1);
        $this->assertEquals(-10, $diff2);
        $this->assertEquals(10, $diff2a);
    }

    public function testEqualMonthEqualDayNormalDateAndLeapDateDiffInYears()
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2007, 6, 10, false);
        $lunar2 = $calendar->lunar(2017, 6, 10, true);
        $diff1 = $calendar->diffInYears($lunar1, $lunar2);
        $diff2 = $calendar->diffInYears($lunar2, $lunar1);
        $diff2a = $calendar->diffInYears($lunar2, $lunar1, true);
        $this->assertEquals(10, $diff1);
        $this->assertEquals(-10, $diff2);
        $this->assertEquals(10, $diff2a);
    }

    public function testEqualMonthEqualDayLeapDateAndNormalDateDiffInYears()
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, true);
        $lunar2 = $calendar->lunar(2027, 6, 10, false);
        $diff1 = $calendar->diffInYears($lunar1, $lunar2);
        $diff2 = $calendar->diffInYears($lunar2, $lunar1);
        $diff2a = $calendar->diffInYears($lunar2, $lunar1, true);
        $this->assertEquals(9, $diff1);
        $this->assertEquals(-9, $diff2);
        $this->assertEquals(9, $diff2a);
    }

    public function testEqualMonthEqualDayLeapDateAndLeapDateDiffInYears()
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, true);
        $lunar2 = $calendar->lunar(2025, 6, 10, true);
        $diff1 = $calendar->diffInYears($lunar1, $lunar2);
        $diff2 = $calendar->diffInYears($lunar2, $lunar1);
        $diff2a = $calendar->diffInYears($lunar2, $lunar1, true);
        $this->assertEquals(8, $diff1);
        $this->assertEquals(-8, $diff2);
        $this->assertEquals(8, $diff2a);
    }

    public function testEqualMonthGreaterDayNormalDateAndNormalDateDiffInYears()
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, false);
        $lunar2 = $calendar->lunar(2027, 6, 1, false);
        $diff1 = $calendar->diffInYears($lunar1, $lunar2);
        $diff2 = $calendar->diffInYears($lunar2, $lunar1);
        $diff2a = $calendar->diffInYears($lunar2, $lunar1, true);
        $this->assertEquals(9, $diff1);
        $this->assertEquals(-9, $diff2);
        $this->assertEquals(9, $diff2a);
    }

    public function testEqualMonthGreaterDayNormalDateAndLeapDateDiffInYears()
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2007, 6, 10, false);
        $lunar2 = $calendar->lunar(2017, 6, 1, true);
        $diff1 = $calendar->diffInYears($lunar1, $lunar2);
        $diff2 = $calendar->diffInYears($lunar2, $lunar1);
        $diff2a = $calendar->diffInYears($lunar2, $lunar1, true);
        $this->assertEquals(10, $diff1);
        $this->assertEquals(-10, $diff2);
        $this->assertEquals(10, $diff2a);
    }

    public function testEqualMonthGreaterDayLeapDateAndNormalDateDiffInYears()
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, true);
        $lunar2 = $calendar->lunar(2027, 6, 1, false);
        $diff1 = $calendar->diffInYears($lunar1, $lunar2);
        $diff2 = $calendar->diffInYears($lunar2, $lunar1);
        $diff2a = $calendar->diffInYears($lunar2, $lunar1, true);
        $this->assertEquals(9, $diff1);
        $this->assertEquals(-9, $diff2);
        $this->assertEquals(9, $diff2a);
    }

    public function testEqualMonthGreaterDayLeapDateAndLeapDateDiffInYears()
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, true);
        $lunar2 = $calendar->lunar(2025, 6, 1, true);
        $diff1 = $calendar->diffInYears($lunar1, $lunar2);
        $diff2 = $calendar->diffInYears($lunar2, $lunar1);
        $diff2a = $calendar->diffInYears($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInYears($lunar1, $lunar2);
        $diff2 = $calendar->diffInYears($lunar2, $lunar1);
        $diff2a = $calendar->diffInYears($lunar2, $lunar1, true);
        $this->assertEquals(9, $diff1);
        $this->assertEquals(-9, $diff2);
        $this->assertEquals(9, $diff2a);
    }

    public function testGreaterMonthLessDayNormalDateAndLeapDateDiffInYears()
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, false);
        $lunar2 = $calendar->lunar(2027, 5, 20, true);
        $diff1 = $calendar->diffInYears($lunar1, $lunar2);
        $diff2 = $calendar->diffInYears($lunar2, $lunar1);
        $diff2a = $calendar->diffInYears($lunar2, $lunar1, true);
        $this->assertEquals(9, $diff1);
        $this->assertEquals(-9, $diff2);
        $this->assertEquals(9, $diff2a);
    }

    public function testGreaterMonthLessDayLeapDateAndNormalDateDiffInYears()
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, true);
        $lunar2 = $calendar->lunar(2027, 5, 20, false);
        $diff1 = $calendar->diffInYears($lunar1, $lunar2);
        $diff2 = $calendar->diffInYears($lunar2, $lunar1);
        $diff2a = $calendar->diffInYears($lunar2, $lunar1, true);
        $this->assertEquals(9, $diff1);
        $this->assertEquals(-9, $diff2);
        $this->assertEquals(9, $diff2a);
    }

    public function testGreaterMonthLessDayLeapDateAndLeapDateDiffInYears()
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, true);
        $lunar2 = $calendar->lunar(2020, 4, 20, true);
        $diff1 = $calendar->diffInYears($lunar1, $lunar2);
        $diff2 = $calendar->diffInYears($lunar2, $lunar1);
        $diff2a = $calendar->diffInYears($lunar2, $lunar1, true);
        $this->assertEquals(2, $diff1);
        $this->assertEquals(-2, $diff2);
        $this->assertEquals(2, $diff2a);
    }

    public function testGreaterMonthEqualDayNormalDateAndNormalDateDiffInYears()
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, false);
        $lunar2 = $calendar->lunar(2027, 5, 10, false);
        $diff1 = $calendar->diffInYears($lunar1, $lunar2);
        $diff2 = $calendar->diffInYears($lunar2, $lunar1);
        $diff2a = $calendar->diffInYears($lunar2, $lunar1, true);
        $this->assertEquals(9, $diff1);
        $this->assertEquals(-9, $diff2);
        $this->assertEquals(9, $diff2a);
    }

    public function testGreaterMonthEqualDayNormalDateAndLeapDateDiffInYears()
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, false);
        $lunar2 = $calendar->lunar(2027, 5, 10, true);
        $diff1 = $calendar->diffInYears($lunar1, $lunar2);
        $diff2 = $calendar->diffInYears($lunar2, $lunar1);
        $diff2a = $calendar->diffInYears($lunar2, $lunar1, true);
        $this->assertEquals(9, $diff1);
        $this->assertEquals(-9, $diff2);
        $this->assertEquals(9, $diff2a);
    }

    public function testGreaterMonthEqualDayLeapDateAndNormalDateDiffInYears()
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, true);
        $lunar2 = $calendar->lunar(2027, 5, 10, false);
        $diff1 = $calendar->diffInYears($lunar1, $lunar2);
        $diff2 = $calendar->diffInYears($lunar2, $lunar1);
        $diff2a = $calendar->diffInYears($lunar2, $lunar1, true);
        $this->assertEquals(9, $diff1);
        $this->assertEquals(-9, $diff2);
        $this->assertEquals(9, $diff2a);
    }

    public function testGreaterMonthEqualDayLeapDateAndLeapDateDiffInYears()
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, true);
        $lunar2 = $calendar->lunar(2020, 4, 10, true);
        $diff1 = $calendar->diffInYears($lunar1, $lunar2);
        $diff2 = $calendar->diffInYears($lunar2, $lunar1);
        $diff2a = $calendar->diffInYears($lunar2, $lunar1, true);
        $this->assertEquals(2, $diff1);
        $this->assertEquals(-2, $diff2);
        $this->assertEquals(2, $diff2a);
    }

    public function testGreaterMonthGreaterDayNormalDateAndNormalDateDiffInYears()
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, false);
        $lunar2 = $calendar->lunar(2027, 5, 1, false);
        $diff1 = $calendar->diffInYears($lunar1, $lunar2);
        $diff2 = $calendar->diffInYears($lunar2, $lunar1);
        $diff2a = $calendar->diffInYears($lunar2, $lunar1, true);
        $this->assertEquals(9, $diff1);
        $this->assertEquals(-9, $diff2);
        $this->assertEquals(9, $diff2a);
    }

    public function testGreaterMonthGreaterDayNormalDateAndLeapDateDiffInYears()
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, false);
        $lunar2 = $calendar->lunar(2027, 5, 1, true);
        $diff1 = $calendar->diffInYears($lunar1, $lunar2);
        $diff2 = $calendar->diffInYears($lunar2, $lunar1);
        $diff2a = $calendar->diffInYears($lunar2, $lunar1, true);
        $this->assertEquals(9, $diff1);
        $this->assertEquals(-9, $diff2);
        $this->assertEquals(9, $diff2a);
    }

    public function testGreaterMonthGreaterDayLeapDateAndNormalDateDiffInYears()
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, true);
        $lunar2 = $calendar->lunar(2027, 5, 1, false);
        $diff1 = $calendar->diffInYears($lunar1, $lunar2);
        $diff2 = $calendar->diffInYears($lunar2, $lunar1);
        $diff2a = $calendar->diffInYears($lunar2, $lunar1, true);
        $this->assertEquals(9, $diff1);
        $this->assertEquals(-9, $diff2);
        $this->assertEquals(9, $diff2a);
    }

    public function testGreaterMonthGreaterDayLeapDateAndLeapDateDiffInYears()
    {
        $calendar = new Calendar();
        $lunar1 = $calendar->lunar(2017, 6, 10, true);
        $lunar2 = $calendar->lunar(2020, 4, 1, true);
        $diff1 = $calendar->diffInYears($lunar1, $lunar2);
        $diff2 = $calendar->diffInYears($lunar2, $lunar1);
        $diff2a = $calendar->diffInYears($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInMonths($lunar1, $lunar2);
        $diff1a = $calendar->diffInMonths($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInMonths($lunar2, $lunar1);
        $diff2a = $calendar->diffInMonths($lunar2, $lunar1, true);
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
        $diff1 = $calendar->diffInDays($lunar1, $lunar2);
        $diff1a = $calendar->diffInDays($lunar1, $lunar2, true);
        $diff2 = $calendar->diffInDays($lunar2, $lunar1);
        $diff2a = $calendar->diffInDays($lunar2, $lunar1, true);
        $this->assertEquals(9509, $diff1);
        $this->assertEquals(9509, $diff1a);
        $this->assertEquals(-9509, $diff2);
        $this->assertEquals(9509, $diff2a);
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
}
