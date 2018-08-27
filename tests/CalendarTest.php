<?php
/**
 * User: hao.li
 * Date: 2018/8/21
 * Time: 8:54 AM
 */

namespace Overtrue\ChineseCalendar\Tests;

use Overtrue\ChineseCalendar\Calendar;
use PHPUnit\Framework\TestCase;

class CalendarTest extends TestCase
{
    #region diffInYears

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

    #region less month

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

    #endregion less month

    #region equal month

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

    #endregion equal month

    #region greater month

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

    #endregion greater month

    #endregion diffInYears

    #region addYears

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

    #endregion addYears

    #region subYears

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

    #endregion subYears

    #region addMonths

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

    #endregion addMonths

    #region subMonths

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

    #endregion subMonths

    #region addDays

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

    #endregion addDays

    #region subDays

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

    #endregion subDays
}
