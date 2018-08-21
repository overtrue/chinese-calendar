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
