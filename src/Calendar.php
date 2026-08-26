<?php

declare(strict_types=1);

/*
 * This file is part of the overtrue/chinese-calendar.
 * (c) overtrue <i@overtrue.me>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Overtrue\ChineseCalendar;

use DateInterval;
use DateTime;
use DateTimeZone;
use InvalidArgumentException;

/**
 * Class Calendar.
 *
 * 中国农历（阴历）与阳历（公历）转换与查询工具，支持范围：公历 1900-01-31 ~ 2100-12-31。
 * 所有计算固定按北京时间（Asia/Shanghai）进行，与进程默认时区无关。
 *
 * @author overtrue <i@overtrue.me>
 */
class Calendar
{
    /**
     * 1900-01-31（农历 1900 年正月初一，本历法的起点）的儒略日序数.
     */
    public const int JULIAN_DAY_1900_01_31 = 2415051;

    /**
     * 1900-01-01 的儒略日序数，日柱（干支日）的计算基准.
     */
    public const int JULIAN_DAY_1900_01_01 = 2415021;

    /**
     * 农历 1900-2100 的润大小信息.
     *
     * 每年一个整数：低 4 位为闰月月份（0 表示无闰月），第 5~16 位从高到低依次为 1~12 月的大小（1 为大月 30 天），
     * 第 17 位为闰月的大小。1901-2100 年的数据已逐月与香港天文台《公历与农历日期对照表》核对一致
     * （见 tests/fixtures/lunar-months-1901-2100.csv）。其中 2057 年八月、九月的分界（新月发生在 2057-09-28
     * 北京时间 23:59 左右，距午夜仅十余秒）各家算法有分歧，此处采用香港天文台的结果：九月初一为 2057-09-28。
     *
     * @var list<int>
     */
    protected array $lunars = [
        0x04BD8, 0x04AE0, 0x0A570, 0x054D5, 0x0D260, 0x0D950, 0x16554, 0x056A0, 0x09AD0, 0x055D2, // 1900-1909
        0x04AE0, 0x0A5B6, 0x0A4D0, 0x0D250, 0x1D255, 0x0B540, 0x0D6A0, 0x0ADA2, 0x095B0, 0x14977, // 1910-1919
        0x04970, 0x0A4B0, 0x0B4B5, 0x06A50, 0x06D40, 0x1AB54, 0x02B60, 0x09570, 0x052F2, 0x04970, // 1920-1929
        0x06566, 0x0D4A0, 0x0EA50, 0x16A95, 0x05AD0, 0x02B60, 0x186E3, 0x092E0, 0x1C8D7, 0x0C950, // 1930-1939
        0x0D4A0, 0x1D8A6, 0x0B550, 0x056A0, 0x1A5B4, 0x025D0, 0x092D0, 0x0D2B2, 0x0A950, 0x0B557, // 1940-1949
        0x06CA0, 0x0B550, 0x15355, 0x04DA0, 0x0A5B0, 0x14573, 0x052B0, 0x0A9A8, 0x0E950, 0x06AA0, // 1950-1959
        0x0AEA6, 0x0AB50, 0x04B60, 0x0AAE4, 0x0A570, 0x05260, 0x0F263, 0x0D950, 0x05B57, 0x056A0, // 1960-1969
        0x096D0, 0x04DD5, 0x04AD0, 0x0A4D0, 0x0D4D4, 0x0D250, 0x0D558, 0x0B540, 0x0B6A0, 0x195A6, // 1970-1979
        0x095B0, 0x049B0, 0x0A974, 0x0A4B0, 0x0B27A, 0x06A50, 0x06D40, 0x0AF46, 0x0AB60, 0x09570, // 1980-1989
        0x04AF5, 0x04970, 0x064B0, 0x074A3, 0x0EA50, 0x06B58, 0x05AC0, 0x0AB60, 0x096D5, 0x092E0, // 1990-1999
        0x0C960, 0x0D954, 0x0D4A0, 0x0DA50, 0x07552, 0x056A0, 0x0ABB7, 0x025D0, 0x092D0, 0x0CAB5, // 2000-2009
        0x0A950, 0x0B4A0, 0x0BAA4, 0x0AD50, 0x055D9, 0x04BA0, 0x0A5B0, 0x15176, 0x052B0, 0x0A930, // 2010-2019
        0x07954, 0x06AA0, 0x0AD50, 0x05B52, 0x04B60, 0x0A6E6, 0x0A4E0, 0x0D260, 0x0EA65, 0x0D530, // 2020-2029
        0x05AA0, 0x076A3, 0x096D0, 0x04AFB, 0x04AD0, 0x0A4D0, 0x1D0B6, 0x0D250, 0x0D520, 0x0DD45, // 2030-2039
        0x0B5A0, 0x056D0, 0x055B2, 0x049B0, 0x0A577, 0x0A4B0, 0x0AA50, 0x1B255, 0x06D20, 0x0ADA0, // 2040-2049
        0x14B63, 0x09370, 0x049F8, 0x04970, 0x064B0, 0x168A6, 0x0EA50, 0x06AA0, 0x1A6C4, 0x0AAE0, // 2050-2059
        0x092E0, 0x0D2E3, 0x0C960, 0x0D557, 0x0D4A0, 0x0DA50, 0x05D55, 0x056A0, 0x0A6D0, 0x055D4, // 2060-2069
        0x052D0, 0x0A9B8, 0x0A950, 0x0B4A0, 0x0B6A6, 0x0AD50, 0x055A0, 0x0ABA4, 0x0A5B0, 0x052B0, // 2070-2079
        0x0B273, 0x06930, 0x07337, 0x06AA0, 0x0AD50, 0x14B55, 0x04B60, 0x0A570, 0x054E4, 0x0D160, // 2080-2089
        0x0E968, 0x0D520, 0x0DAA0, 0x16AA6, 0x056D0, 0x04AE0, 0x0A9D4, 0x0A2D0, 0x0D150, 0x0F252, // 2090-2099
        0x0D520, // 2100
    ];

    /**
     * 公历每个月份的天数表.
     *
     * @var list<int>
     */
    protected array $solarMonth = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];

    /**
     * 天干地支之天干速查表.
     *
     * @var list<string>
     */
    protected array $gan = ['甲', '乙', '丙', '丁', '戊', '己', '庚', '辛', '壬', '癸'];

    /**
     * 天干地支之天干速查表 <=> 色彩.
     *
     * @var list<string>
     */
    protected array $colors = ['青', '青', '红', '红', '黄', '黄', '白', '白', '黑', '黑'];

    /**
     * 天干地支之天干速查表 <=> 五行.
     *
     * @var list<string>
     */
    protected array $wuXing = ['木', '木', '火', '火', '土', '土', '金', '金', '水', '水'];

    /**
     * 地支 <=> 五行.
     *
     * @var list<string>
     */
    protected array $zhiWuxing = ['水', '土', '木', '木', '土', '火', '火', '土', '金', '金', '土', '水'];

    /**
     * 天干地支之地支速查表.
     *
     * @var list<string>
     */
    protected array $zhi = ['子', '丑', '寅', '卯', '辰', '巳', '午', '未', '申', '酉', '戌', '亥'];

    /**
     * 天干地支之地支速查表 <=> 生肖.
     *
     * @var list<string>
     */
    protected array $animals = ['鼠', '牛', '虎', '兔', '龙', '蛇', '马', '羊', '猴', '鸡', '狗', '猪'];

    /**
     * 24节气速查表.
     *
     * @var list<string>
     */
    protected array $solarTerm = [
        '小寒', '大寒', '立春', '雨水', '惊蛰', '春分',
        '清明', '谷雨', '立夏', '小满', '芒种', '夏至',
        '小暑', '大暑', '立秋', '处暑', '白露', '秋分',
        '寒露', '霜降', '立冬', '小雪', '大雪', '冬至',
    ];

    /**
     * 1900-2100 各年的 24 节气日期速查表.
     *
     * 数据已与香港天文台《公历与农历日期对照表》1901-2100 年逐一核对（见 tests/fixtures/solar-terms-1901-2100.csv）。
     *
     * @var list<string>
     */
    protected array $solarTerms = [
        '9778397bd097c36b0b6fc9274c91aa', '97b6b97bd19801ec9210c965cc920e', '97bcf97c3598082c95f8c965cc920f',
        '97bd0b06bdb0722c965ce1cfcc920f', 'b027097bd097c36b0b6fc9274c91aa', '97b6b97bd19801ec9210c965cc920e',
        '97bcf97c359801ec95f8c965cc920f', '97bd0b06bdb0722c965ce1cfcc920f', 'b027097bd097c36b0b6fc9274c91aa',
        '97b6b97bd19801ec9210c965cc920e', '97bcf97c359801ec95f8c965cc920f', '97bd0b06bdb0722c965ce1cfcc920f',
        'b027097bd097c36b0b6fc9274c91aa', '9778397bd19801ec9210c965cc920e', '97b6b97bd19801ec95f8c965cc920f',
        '97bd09801d98082c95f8e1cfcc920f', '97bd097bd097c36b0b6fc9210c8dc2', '9778397bd197c36c9210c9274c91aa',
        '97b6b97bd19801ec95f8c965cc920e', '97bd09801d98082c95f8e1cfcc920f', '97bd097bd097c36b0b6fc9210c8dc2',
        '9778397bd097c36c9210c9274c91aa', '97b6b97bd19801ec95f8c965cc920e', '97bcf97c3598082c95f8e1cfcc920f',
        '97bd097bd097c36b0b6fc9210c8dc2', '9778397bd097c36c9210c9274c91aa', '97b6b97bd19801ec9210c965cc920e',
        '97bcf97c3598082c95f8c965cc920f', '97bd097bd097c35b0b6fc920fb0722', '9778397bd097c36b0b6fc9274c91aa',
        '97b6b97bd19801ec9210c965cc920e', '97bcf97c3598082c95f8c965cc920f', '97bd097bd097c35b0b6fc920fb0722',
        '9778397bd097c36b0b6fc9274c91aa', '97b6b97bd19801ec9210c965cc920e', '97bcf97c359801ec95f8c965cc920f',
        '97bd097bd097c35b0b6fc920fb0722', '9778397bd097c36b0b6fc9274c91aa', '97b6b97bd19801ec9210c965cc920e',
        '97bcf97c359801ec95f8c965cc920f', '97bd097bd097c35b0b6fc920fb0722', '9778397bd097c36b0b6fc9274c91aa',
        '97b6b97bd19801ec9210c965cc920e', '97bcf97c359801ec95f8c965cc920f', '97bd097bd07f595b0b6fc920fb0722',
        '9778397bd097c36b0b6fc9210c8dc2', '9778397bd19801ec9210c9274c920e', '97b6b97bd19801ec95f8c965cc920f',
        '97bd07f5307f595b0b0bc920fb0722', '7f0e397bd097c36b0b6fc9210c8dc2', '9778397bd097c36c9210c9274c920e',
        '97b6b97bd19801ec95f8c965cc920f', '97bd07f5307f595b0b0bc920fb0722', '7f0e397bd097c36b0b6fc9210c8dc2',
        '9778397bd097c36c9210c9274c91aa', '97b6b97bd19801ec9210c965cc920e', '97bd07f1487f595b0b0bc920fb0722',
        '7f0e397bd097c36b0b6fc9210c8dc2', '9778397bd097c36b0b6fc9274c91aa', '97b6b97bd19801ec9210c965cc920e',
        '97bcf7f1487f595b0b0bb0b6fb0722', '7f0e397bd097c35b0b6fc920fb0722', '9778397bd097c36b0b6fc9274c91aa',
        '97b6b97bd19801ec9210c965cc920e', '97bcf7f1487f595b0b0bb0b6fb0722', '7f0e397bd097c35b0b6fc920fb0722',
        '9778397bd097c36b0b6fc9274c91aa', '97b6b97bd19801ec9210c965cc920e', '97bcf7f1487f531b0b0bb0b6fb0722',
        '7f0e397bd097c35b0b6fc920fb0722', '9778397bd097c36b0b6fc9274c91aa', '97b6b97bd19801ec9210c965cc920e',
        '97bcf7f1487f531b0b0bb0b6fb0722', '7f0e397bd07f595b0b6fc920fb0722', '9778397bd097c36b0b6fc9274c91aa',
        '97b6b97bd19801ec9210c9274c920e', '97bcf7f0e47f531b0b0bb0b6fb0722', '7f0e397bd07f595b0b0bc920fb0722',
        '9778397bd097c36b0b6fc9210c91aa', '97b6b97bd197c36c9210c9274c920e', '97bcf7f0e47f531b0b0bb0b6fb0722',
        '7f0e397bd07f595b0b0bc920fb0722', '9778397bd097c36b0b6fc9210c8dc2', '9778397bd097c36c9210c9274c920e',
        '97b6b7f0e47f531b0723b0b6fb0722', '7f0e37f5307f595b0b0bc920fb0722', '7f0e397bd097c36b0b6fc9210c8dc2',
        '9778397bd097c36b0b70c9274c91aa', '97b6b7f0e47f531b0723b0b6fb0721', '7f0e37f1487f595b0b0bb0b6fb0722',
        '7f0e397bd097c35b0b6fc9210c8dc2', '9778397bd097c36b0b6fc9274c91aa', '97b6b7f0e47f531b0723b0b6fb0721',
        '7f0e27f1487f595b0b0bb0b6fb0722', '7f0e397bd097c35b0b6fc920fb0722', '9778397bd097c36b0b6fc9274c91aa',
        '97b6b7f0e47f531b0723b0b6fb0721', '7f0e27f1487f531b0b0bb0b6fb0722', '7f0e397bd097c35b0b6fc920fb0722',
        '9778397bd097c36b0b6fc9274c91aa', '97b6b7f0e47f531b0723b0b6fb0721', '7f0e27f1487f531b0b0bb0b6fb0722',
        '7f0e397bd097c35b0b6fc920fb0722', '9778397bd097c36b0b6fc9274c91aa', '97b6b7f0e47f531b0723b0b6fb0721',
        '7f0e27f1487f531b0b0bb0b6fb0722', '7f0e397bd07f595b0b0bc920fb0722', '9778397bd097c36b0b6fc9274c91aa',
        '97b6b7f0e47f531b0723b0787b0721', '7f0e27f0e47f531b0b0bb0b6fb0722', '7f0e397bd07f595b0b0bc920fb0722',
        '9778397bd097c36b0b6fc9210c91aa', '97b6b7f0e47f149b0723b0787b0721', '7f0e27f0e47f531b0723b0b6fb0722',
        '7f0e397bd07f595b0b0bc920fb0722', '9778397bd097c36b0b6fc9210c8dc2', '977837f0e37f149b0723b0787b0721',
        '7f07e7f0e47f531b0723b0b6fb0722', '7f0e37f5307f595b0b0bc920fb0722', '7f0e397bd097c35b0b6fc9210c8dc2',
        '977837f0e37f14998082b0787b0721', '7f07e7f0e47f531b0723b0b6fb0721', '7f0e37f1487f595b0b0bb0b6fb0722',
        '7f0e397bd097c35b0b6fc9210c8dc2', '977837f0e37f14998082b0787b06bd', '7f07e7f0e47f531b0723b0b6fb0721',
        '7f0e27f1487f531b0b0bb0b6fb0722', '7f0e397bd097c35b0b6fc920fb0722', '977837f0e37f14998082b0787b06bd',
        '7f07e7f0e47f531b0723b0b6fb0721', '7f0e27f1487f531b0b0bb0b6fb0722', '7f0e397bd097c35b0b6fc920fb0722',
        '977837f0e37f14998082b0787b06bd', '7f07e7f0e47f531b0723b0b6fb0721', '7f0e27f1487f531b0b0bb0b6fb0722',
        '7f0e397bd07f595b0b0bc920fb0722', '977837f0e37f14998082b0787b06bd', '7f07e7f0e47f531b0723b0b6fb0721',
        '7f0e27f1487f531b0b0bb0b6fb0722', '7f0e397bd07f595b0b0bc920fb0722', '977837f0e37f14998082b0787b06bd',
        '7f07e7f0e47f149b0723b0787b0721', '7f0e27f0e47f531b0b0bb0b6fb0722', '7f0e397bd07f595b0b0bc920fb0722',
        '977837f0e37f14998082b0723b06bd', '7f07e7f0e37f149b0723b0787b0721', '7f0e27f0e47f531b0723b0b6fb0722',
        '7f0e397bd07f595b0b0bc920fb0722', '977837f0e37f14898082b0723b02d5', '7ec967f0e37f14998082b0787b0721',
        '7f07e7f0e47f531b0723b0b6fb0722', '7f0e37f1487f595b0b0bb0b6fb0722', '7f0e37f0e37f14898082b0723b02d5',
        '7ec967f0e37f14998082b0787b0721', '7f07e7f0e47f531b0723b0b6fb0722', '7f0e37f1487f531b0b0bb0b6fb0722',
        '7f0e37f0e37f14898082b0723b02d5', '7ec967f0e37f14998082b0787b06bd', '7f07e7f0e47f531b0723b0b6fb0721',
        '7f0e37f1487f531b0b0bb0b6fb0722', '7f0e37f0e37f14898082b072297c35', '7ec967f0e37f14998082b0787b06bd',
        '7f07e7f0e47f531b0723b0b6fb0721', '7f0e27f1487f531b0b0bb0b6fb0722', '7f0e37f0e37f14898082b072297c35',
        '7ec967f0e37f14998082b0787b06bd', '7f07e7f0e47f531b0723b0b6fb0721', '7f0e27f1487f531b0b0bb0b6fb0722',
        '7f0e37f0e366aa89801eb072297c35', '7ec967f0e37f14998082b0787b06bd', '7f07e7f0e47f149b0723b0787b0721',
        '7f0e27f1487f531b0b0bb0b6fb0722', '7f0e37f0e366aa89801eb072297c35', '7ec967f0e37f14998082b0723b06bd',
        '7f07e7f0e47f149b0723b0787b0721', '7f0e27f0e47f531b0723b0b6fb0722', '7f0e37f0e366aa89801eb072297c35',
        '7ec967f0e37f14998082b0723b06bd', '7f07e7f0e37f14998083b0787b0721', '7f0e27f0e47f531b0723b0b6fb0722',
        '7f0e37f0e366aa89801eb072297c35', '7ec967f0e37f14898082b0723b02d5', '7f07e7f0e37f14998082b0787b0721',
        '7f07e7f0e47f531b0723b0b6fb0722', '7f0e36665b66aa89801e9808297c35', '665f67f0e37f14898082b0723b02d5',
        '7ec967f0e37f14998082b0787b0721', '7f07e7f0e47f531b0723b0b6fb0722', '7f0e36665b66a449801e9808297c35',
        '665f67f0e37f14898082b0723b02d5', '7ec967f0e37f14998082b0787b06bd', '7f07e7f0e47f531b0723b0b6fb0721',
        '7f0e36665b66a449801e9808297c35', '665f67f0e37f14898082b072297c35', '7ec967f0e37f14998082b0787b06bd',
        '7f07e7f0e47f531b0723b0b6fb0721', '7f0e26665b66a449801e9808297c35', '665f67f0e37f1489801eb072297c35',
        '7ec967f0e37f14998082b0787b06bd', '7f07e7f0e47f531b0723b0b6fb0721', '7f0e27f1487f531b0b0bb0b6fb0722',
    ];

    /**
     * 数字转中文速查表.
     *
     * @var list<string>
     */
    protected array $weekdayAlias = ['日', '一', '二', '三', '四', '五', '六', '七', '八', '九', '十'];

    /**
     * 日期转农历称呼速查表.
     *
     * @var list<string>
     */
    protected array $dateAlias = ['初', '十', '廿', '卅'];

    /**
     * 月份转农历称呼速查表.
     *
     * @var list<string>
     */
    protected array $monthAlias = ['正', '二', '三', '四', '五', '六', '七', '八', '九', '十', '冬', '腊'];

    /**
     * 传入阳历年月日获得详细的公历、农历信息.
     *
     * @return array<string, mixed>
     */
    public function solar(int $year, int $month, int $day, ?int $hour = null): array
    {
        $date = $this->makeDate("{$year}-{$month}-{$day}");
        $lunar = $this->solar2lunar($year, $month, $day, $hour);
        $week = (int) $date->format('w'); // 0 ~ 6，星期日为 0

        return array_merge(
            $lunar,
            [
                'gregorian_year' => (string) $year,
                'gregorian_month' => sprintf('%02d', $month),
                'gregorian_day' => sprintf('%02d', $day),
                'gregorian_hour' => null === $hour || $hour < 0 || $hour > 23 ? null : sprintf('%02d', $hour),
                'week_no' => $week, // 在周日时将会传回 0
                'week_name' => '星期'.$this->weekdayAlias[$week],
                'is_today' => $this->makeDate('now')->format('Y-m-d') === $date->format('Y-m-d'),
                'constellation' => $this->toConstellation($month, $day),
                'is_same_year' => (int) $lunar['lunar_year'] === $year,
            ]
        );
    }

    /**
     * 传入农历年月日以及传入的月份是否闰月获得详细的公历、农历信息.
     *
     * @param int  $year        lunar year
     * @param int  $month       lunar month
     * @param int  $day         lunar day
     * @param bool $isLeapMonth lunar month is leap or not.[如果是农历闰月第四个参数赋值true即可]
     * @param ?int $hour        birth hour.[0~23]
     *
     * @return array<string, mixed>
     */
    public function lunar(int $year, int $month, int $day, bool $isLeapMonth = false, ?int $hour = null): array
    {
        $solar = $this->lunar2solar($year, $month, $day, $isLeapMonth);

        if (!is_array($solar)) {
            throw new InvalidArgumentException('传入的参数不合法');
        }

        return $this->solar((int) $solar['solar_year'], (int) $solar['solar_month'], (int) $solar['solar_day'], $hour);
    }

    /**
     * 返回农历指定年的总天数.
     */
    public function daysOfYear(int $year): int
    {
        $sum = 348;

        for ($i = 0x8000; $i > 0x8; $i >>= 1) {
            $sum += ($this->lunars[$year - 1900] & $i) ? 1 : 0;
        }

        return $sum + $this->leapDays($year);
    }

    /**
     * 返回农历指定年的总月数.
     */
    public function monthsOfYear(int $year): int
    {
        return 0 < $this->leapMonth($year) ? 13 : 12;
    }

    /**
     * 返回农历 y 年闰月是哪个月；若 y 年没有闰月 则返回0.
     */
    public function leapMonth(int $year): int
    {
        // 闰字编码 闰
        return $this->lunars[$year - 1900] & 0xF;
    }

    /**
     * 返回农历y年闰月的天数 若该年没有闰月则返回 0.
     */
    public function leapDays(int $year): int
    {
        if ($this->leapMonth($year)) {
            return ($this->lunars[$year - 1900] & 0x10000) ? 30 : 29;
        }

        return 0;
    }

    /**
     * 返回农历 y 年 m 月（非闰月）的总天数，计算 m 为闰月时的天数请使用 leapDays 方法.
     */
    public function lunarDays(int $year, int $month): int
    {
        // 月份参数从 1 至 12，参数错误返回 -1
        if ($month > 12 || $month < 1) {
            return -1;
        }

        return ($this->lunars[$year - 1900] & (0x10000 >> $month)) ? 30 : 29;
    }

    /**
     * 返回公历 y 年 m 月的天数.
     */
    public function solarDays(int $year, int $month): int
    {
        // 若参数错误 返回-1
        if ($month > 12 || $month < 1) {
            return -1;
        }

        $ms = $month - 1;

        if (1 == $ms) { // 2 月份的闰平规律测算后确认返回 28 或 29
            return ((0 === $year % 4) && (0 !== $year % 100) || (0 === $year % 400)) ? 29 : 28;
        }

        return $this->solarMonth[$ms];
    }

    /**
     * 农历年份转换为干支纪年.
     *
     * 以农历正月初一为干支年的分界，与 lunar_year 保持一致（据维基百科干支词条：
     * 『在西历新年后，华夏新年或干支历新年之前，则续用上一年之干支』）。
     * 命理学中以立春为界的算法不在此处处理。
     */
    public function ganZhiYear(int $lunarYear): string
    {
        $ganKey = ($lunarYear - 4) % 10;
        $zhiKey = ($lunarYear - 4) % 12;

        return $this->gan[$ganKey].$this->zhi[$zhiKey];
    }

    /**
     * 公历月、日判断所属星座.
     */
    public function toConstellation(int $gregorianMonth, int $gregorianDay): string
    {
        $constellations = '魔羯水瓶双鱼白羊金牛双子巨蟹狮子处女天秤天蝎射手魔羯';
        $arr = [20, 19, 21, 21, 21, 22, 23, 23, 23, 23, 22, 22];

        return mb_substr(
            $constellations,
            $gregorianMonth * 2 - ($gregorianDay < $arr[$gregorianMonth - 1] ? 2 : 0),
            2,
            'UTF-8'
        );
    }

    /**
     * 传入offset偏移量返回干支.
     *
     * @param int $offset 相对甲子的偏移量
     */
    public function toGanZhi(int $offset): string
    {
        return $this->gan[$offset % 10].$this->zhi[$offset % 12];
    }

    /**
     * 传入公历年获得该年第n个节气的公历日期
     *
     * @param int $year 公历年(1900-2100)；
     * @param int $no   二十四节气中的第几个节气(1~24)；从n=1(小寒)算起
     *
     * @example
     * <pre>
     *  $_24 = $this->getTerm(1987,3) ;// _24 = 4; 意即 1987 年 2 月 4 日立春
     * </pre>
     */
    public function getTerm(int $year, int $no): int
    {
        if ($year < 1900 || $year > 2100) {
            return -1;
        }
        if ($no < 1 || $no > 24) {
            return -1;
        }
        $solarTermsOfYear = array_map('hexdec', str_split($this->solarTerms[$year - 1900], 5));
        $positions = [
            0 => [0, 1],
            1 => [1, 2],
            2 => [3, 1],
            3 => [4, 2],
        ];
        $group = intdiv($no - 1, 4);
        [$offset, $length] = $positions[($no - 1) % 4];

        return (int) substr((string) $solarTermsOfYear[$group], $offset, $length);
    }

    /**
     * 传入农历年份数字返回汉字表示法.
     */
    public function toChinaYear(int $year): string
    {
        $lunarYear = '';
        $digits = (string) $year;

        for ($i = 0, $l = strlen($digits); $i < $l; ++$i) {
            $lunarYear .= '0' !== $digits[$i] ? $this->weekdayAlias[(int) $digits[$i]] : '零';
        }

        return $lunarYear;
    }

    /**
     * 传入农历数字月份返回汉语通俗表示法.
     */
    public function toChinaMonth(int $month): string
    {
        // 若参数错误 抛出异常
        if ($month > 12 || $month < 1) {
            throw new InvalidArgumentException("错误的月份:{$month}");
        }

        return $this->monthAlias[$month - 1].'月';
    }

    /**
     * 传入农历日期数字返回汉字表示法.
     */
    public function toChinaDay(int $day): string
    {
        return match ($day) {
            10 => '初十',
            20 => '二十',
            30 => '三十',
            default => $this->dateAlias[intdiv($day, 10)].$this->weekdayAlias[$day % 10],
        };
    }

    /**
     * 农历年份转生肖.
     *
     * 以农历正月初一为生肖的分界，与 lunar_year、ganzhi_year 保持一致；
     * 命理学中以立春为界的算法不在此处处理。
     */
    public function getAnimal(int $year): string
    {
        return $this->animals[($year - 4) % 12];
    }

    /**
     * 干支转色彩.
     */
    protected function getColor(?string $ganZhi): ?string
    {
        if (!$ganZhi) {
            return null;
        }

        $gan = substr($ganZhi, 0, 3);
        $index = array_search($gan, $this->gan, true);

        if (false === $index) {
            return null;
        }

        return $this->colors[$index];
    }

    /**
     * 干支转五行.
     */
    protected function getWuXing(?string $ganZhi): ?string
    {
        if (!$ganZhi) {
            return null;
        }

        $gan = substr($ganZhi, 0, 3);
        $zhi = substr($ganZhi, 3);

        $ganIndex = array_search($gan, $this->gan, true);
        $zhiIndex = array_search($zhi, $this->zhi, true);

        if (false === $ganIndex || false === $zhiIndex) {
            return null;
        }

        return $this->wuXing[$ganIndex].$this->zhiWuxing[$zhiIndex];
    }

    /**
     * 阳历转阴历.
     *
     * @param int  $year  公历年
     * @param int  $month 公历月
     * @param int  $day   公历日
     * @param ?int $hour  小时（0~23），传 23 时按晚子时归入次日，见 README
     *
     * @return array<string, mixed>
     */
    public function solar2lunar(int $year, int $month, int $day, ?int $hour = null): array
    {
        if (23 === $hour) {
            // 23点过后算子时，农历以子时为一天的起始
            $date = $this->makeDate("{$year}-{$month}-{$day} +1day");
        } else {
            $date = $this->makeDate("{$year}-{$month}-{$day}");
        }

        [$year, $month, $day] = array_map('intval', explode('-', $date->format('Y-n-j')));

        // 参数区间1900.1.31~2100.12.31
        if ($year < 1900 || $year > 2100) {
            throw new InvalidArgumentException("不支持的年份:{$year}");
        }

        // 年份限定、上限
        if (1900 == $year && 1 == $month && $day < 31) {
            throw new InvalidArgumentException("不支持的日期:{$year}-{$month}-{$day}");
        }

        // 用儒略日序数计算天数差，不经过 DateTime::diff()：
        // PHP < 8.1 在中国夏令时期间（1919、1940-1949、1986-1991）会少算一天，见 issue #52
        $offset = $this->toJulianDay($year, $month, $day) - self::JULIAN_DAY_1900_01_31;

        $daysOfYear = 0;
        for ($i = 1900; $i < 2101 && $offset > 0; ++$i) {
            $daysOfYear = $this->daysOfYear($i);
            $offset -= $daysOfYear;
        }

        if ($offset < 0) {
            $offset += $daysOfYear;
            --$i;
        }

        // 农历年
        $lunarYear = $i;

        $leap = $this->leapMonth($i); // 闰哪个月
        $isLeap = false;

        // 用当年的天数 offset,逐个减去每月（农历）的天数，求出当天是本月的第几天
        $daysOfMonth = 0;
        for ($i = 1; $i < 13 && $offset > 0; ++$i) {
            // 闰月
            if ($leap > 0 && $i == ($leap + 1) && !$isLeap) {
                --$i;
                $isLeap = true;
                $daysOfMonth = $this->leapDays($lunarYear); // 计算农历月天数
            } else {
                $daysOfMonth = $this->lunarDays($lunarYear, $i); // 计算农历普通月天数
            }

            // 解除闰月
            if (true === $isLeap && $i == ($leap + 1)) {
                $isLeap = false;
            }

            $offset -= $daysOfMonth;
        }
        // offset为0时，并且刚才计算的月份是闰月，要校正
        if (0 === $offset && $leap > 0 && $i == $leap + 1) {
            if ($isLeap) {
                $isLeap = false;
            } else {
                $isLeap = true;
                --$i;
            }
        }

        if ($offset < 0) {
            $offset += $daysOfMonth;
            --$i;
        }

        // 农历月
        $lunarMonth = $i;

        // 农历日
        $lunarDay = $offset + 1;

        // 月柱 1900 年 1 月小寒以前为 丙子月(60进制12)
        $firstNode = $this->getTerm($year, $month * 2 - 1); // 返回当月「节气」为几日开始
        $secondNode = $this->getTerm($year, $month * 2); // 返回当月「节气」为几日开始

        // 依据 12 节气修正干支月
        $ganZhiMonth = $this->toGanZhi(($year - 1900) * 12 + $month + 11);

        if ($day >= $firstNode) {
            $ganZhiMonth = $this->toGanZhi(($year - 1900) * 12 + $month + 12);
        }

        // 获取该天的节气
        $termIndex = null;
        if ($firstNode == $day) {
            $termIndex = $month * 2 - 2;
        }

        if ($secondNode == $day) {
            $termIndex = $month * 2 - 1;
        }

        $term = null !== $termIndex ? $this->solarTerm[$termIndex] : null;

        // 日柱 当月一日与 1900/1/1 相差天数（儒略日序数计算，不受时区与夏令时影响）
        $dayCyclical = $this->toJulianDay($year, $month, 1) - self::JULIAN_DAY_1900_01_01 + 10;
        $dayCyclical += $day - 1;
        $ganZhiDay = $this->toGanZhi($dayCyclical);

        // 时柱和时辰
        [$ganZhiHour, $lunarHour, $hourString] = $this->ganZhiHour($hour, $dayCyclical);

        $ganZhiYear = $this->ganZhiYear($lunarYear);

        return [
            'lunar_year' => (string) $lunarYear,
            'lunar_month' => sprintf('%02d', $lunarMonth),
            'lunar_day' => sprintf('%02d', $lunarDay),
            'lunar_hour' => $hourString,
            'lunar_year_chinese' => $this->toChinaYear($lunarYear),
            'lunar_month_chinese' => ($isLeap ? '闰' : '').$this->toChinaMonth($lunarMonth),
            'lunar_day_chinese' => $this->toChinaDay($lunarDay),
            'lunar_hour_chinese' => $lunarHour,
            'ganzhi_year' => $ganZhiYear,
            'ganzhi_month' => $ganZhiMonth,
            'ganzhi_day' => $ganZhiDay,
            'ganzhi_hour' => $ganZhiHour,
            'wuxing_year' => $this->getWuXing($ganZhiYear),
            'wuxing_month' => $this->getWuXing($ganZhiMonth),
            'wuxing_day' => $this->getWuXing($ganZhiDay),
            'wuxing_hour' => $this->getWuXing($ganZhiHour),
            'color_year' => $this->getColor($ganZhiYear),
            'color_month' => $this->getColor($ganZhiMonth),
            'color_day' => $this->getColor($ganZhiDay),
            'color_hour' => $this->getColor($ganZhiHour),
            'animal' => $this->getAnimal($lunarYear),
            'term' => $term,
            'is_leap' => $isLeap,
        ];
    }

    /**
     * 阴历转阳历.
     *
     * @param int  $year        农历年
     * @param int  $month       农历月
     * @param int  $day         农历日
     * @param bool $isLeapMonth 是否闰月
     *
     * @return array<string, string>|int 超出数据表范围时返回 -1
     */
    public function lunar2solar(int $year, int $month, int $day, bool $isLeapMonth = false): array|int
    {
        // 参数区间（农历）1900.1.1 ~ 2100.12.1，对应公历 1900-01-31 ~ 2100-12-31
        if ($year < 1900 || $year > 2100) {
            throw new InvalidArgumentException('传入的参数不合法');
        }

        $leapMonth = $this->leapMonth($year);

        // 传参要求计算该闰月公历 但该年得出的闰月与传参的月份并不同
        if ($isLeapMonth && ($leapMonth != $month)) {
            $isLeapMonth = false;
        }

        // 超出了最大极限值：农历 2100 年腊月初一即公历 2100-12-31，再往后就超出数据表范围了
        if (2100 == $year && 12 == $month && $day > 1) {
            return -1;
        }

        $maxDays = $days = $this->lunarDays($year, $month);

        // if month is leap, _day use leapDays method
        if ($isLeapMonth) {
            $maxDays = $this->leapDays($year);
        }

        // 参数合法性效验
        if ($day < 1 || $day > $maxDays) {
            throw new InvalidArgumentException('传入的参数不合法');
        }

        // 计算农历的时间差
        $offset = 0;

        for ($i = 1900; $i < $year; ++$i) {
            $offset += $this->daysOfYear($i);
        }

        $isAdd = false;
        for ($i = 1; $i < $month; ++$i) {
            $leap = $this->leapMonth($year);
            if (!$isAdd) {// 处理闰月
                if ($leap <= $i && $leap > 0) {
                    $offset += $this->leapDays($year);
                    $isAdd = true;
                }
            }
            $offset += $this->lunarDays($year, $i);
        }

        // 转换闰月农历 需补充该年闰月的前一个月的时差
        if ($isLeapMonth) {
            $offset += $days;
        }

        // 农历 1900 年正月初一即公历 1900-01-31（本历法的起始点），在它的儒略日序数上加天数差即得公历日期；
        // 全程整数运算，不经过时间戳与 DateTime，因此与进程默认时区无关
        [$solarYear, $solarMonth, $solarDay] = $this->fromJulianDay(self::JULIAN_DAY_1900_01_31 + $offset + $day - 1);

        return [
            'solar_year' => (string) $solarYear,
            'solar_month' => sprintf('%02d', $solarMonth),
            'solar_day' => sprintf('%02d', $solarDay),
        ];
    }

    /**
     * 获取两个日期之间的距离.
     *
     * 这是 DateTime::diff() 的简单封装（默认按北京时间解析字符串）。注意 PHP < 8.1 的 DateInterval::$days
     * 在两个日期的 UTC 偏移不同时可能少算一天（如 1901 年以前的 LMT 日期与中国夏令时期间的日期做差），
     * 库内部的天数计算已全部改用儒略日序数，不再依赖此方法.
     */
    public function dateDiff(DateTime|string $date1, DateTime|string $date2): DateInterval|false
    {
        if (!$date1 instanceof DateTime) {
            $date1 = $this->makeDate($date1);
        }

        if (!$date2 instanceof DateTime) {
            $date2 = $this->makeDate($date2);
        }

        return $date1->diff($date2);
    }

    /**
     * 公历日期转儒略日序数.
     *
     * 纯整数运算，不依赖 ext/calendar 的 gregoriantojd()，也不经过 DateTime，
     * 因此不受时区、夏令时以及 PHP 版本差异的影响.
     *
     * @see https://en.wikipedia.org/wiki/Julian_day#Converting_Gregorian_calendar_date_to_Julian_Day_Number
     */
    protected function toJulianDay(int $year, int $month, int $day): int
    {
        $a = intdiv(14 - $month, 12);
        $y = $year + 4800 - $a;
        $m = $month + 12 * $a - 3;

        return $day
            + intdiv(153 * $m + 2, 5)
            + 365 * $y
            + intdiv($y, 4)
            - intdiv($y, 100)
            + intdiv($y, 400)
            - 32045;
    }

    /**
     * 儒略日序数转公历日期.
     *
     * toJulianDay() 的逆运算，同样是纯整数运算.
     *
     * @return array{0: int, 1: int, 2: int} [年, 月, 日]
     *
     * @see https://en.wikipedia.org/wiki/Julian_day#Julian_or_Gregorian_calendar_from_Julian_day_number
     */
    protected function fromJulianDay(int $julianDay): array
    {
        $a = $julianDay + 32044;
        $b = intdiv(4 * $a + 3, 146097);
        $c = $a - intdiv(146097 * $b, 4);
        $d = intdiv(4 * $c + 3, 1461);
        $e = $c - intdiv(1461 * $d, 4);
        $m = intdiv(5 * $e + 2, 153);

        $day = $e - intdiv(153 * $m + 2, 5) + 1;
        $month = $m + 3 - 12 * intdiv($m, 10);
        $year = 100 * $b + $d - 4800 + intdiv($m, 10);

        return [$year, $month, $day];
    }

    /**
     * 将农历信息数组转换为公历年月日三元组（内部辅助方法）.
     *
     * @param array<string, mixed> $lunar
     *
     * @return array{0: int, 1: int, 2: int} [年, 月, 日]
     */
    protected function lunarArrayToSolar(array $lunar): array
    {
        $solar = $this->lunar2solar(
            (int) $lunar['lunar_year'],
            (int) $lunar['lunar_month'],
            (int) $lunar['lunar_day'],
            (bool) $lunar['is_leap']
        );

        if (!is_array($solar)) {
            throw new InvalidArgumentException('传入的参数不合法');
        }

        return [(int) $solar['solar_year'], (int) $solar['solar_month'], (int) $solar['solar_day']];
    }

    /**
     * 获取两个日期之间以年为单位的距离.
     *
     * @param array<string, mixed> $lunar1
     * @param array<string, mixed> $lunar2
     */
    public function diffInYears(array $lunar1, array $lunar2, bool $absolute = true): int
    {
        [$y1, $m1, $d1] = $this->lunarArrayToSolar($lunar1);
        $date1 = $this->makeDate("{$y1}-{$m1}-{$d1}");

        [$y2, $m2, $d2] = $this->lunarArrayToSolar($lunar2);
        $date2 = $this->makeDate("{$y2}-{$m2}-{$d2}");

        if ($date1 < $date2) {
            $lessLunar = $lunar1;
            $greaterLunar = $lunar2;
            $changed = false;
        } else {
            $lessLunar = $lunar2;
            $greaterLunar = $lunar1;
            $changed = true;
        }

        $monthAdjustFactor = $greaterLunar['lunar_day'] >= $lessLunar['lunar_day'] ? 0 : 1;
        if ($greaterLunar['lunar_month'] == $lessLunar['lunar_month']) {
            if ($greaterLunar['is_leap'] && !$lessLunar['is_leap']) {
                $monthAdjustFactor = 0;
            } elseif (!$greaterLunar['is_leap'] && $lessLunar['is_leap']) {
                $monthAdjustFactor = 1;
            }
        }
        $yearAdjustFactor = $greaterLunar['lunar_month'] - $monthAdjustFactor >= $lessLunar['lunar_month'] ? 0 : 1;
        $diff = (int) $greaterLunar['lunar_year'] - $yearAdjustFactor - (int) $lessLunar['lunar_year'];

        return $absolute ? $diff : ($changed ? -1 * $diff : $diff);
    }

    /**
     * 获取两个日期之间以月为单位的距离.
     *
     * @param array<string, mixed> $lunar1
     * @param array<string, mixed> $lunar2
     */
    public function diffInMonths(array $lunar1, array $lunar2, bool $absolute = true): int
    {
        [$y1, $m1, $d1] = $this->lunarArrayToSolar($lunar1);
        $date1 = $this->makeDate("{$y1}-{$m1}-{$d1}");

        [$y2, $m2, $d2] = $this->lunarArrayToSolar($lunar2);
        $date2 = $this->makeDate("{$y2}-{$m2}-{$d2}");

        if ($date1 < $date2) {
            $lessLunar = $lunar1;
            $greaterLunar = $lunar2;
            $changed = false;
        } else {
            $lessLunar = $lunar2;
            $greaterLunar = $lunar1;
            $changed = true;
        }

        $diff = 0;

        if ($lessLunar['lunar_year'] == $greaterLunar['lunar_year']) {
            $leapMonth = $this->leapMonth((int) $lessLunar['lunar_year']);
            $lessLunarAdjustFactor =
                $lessLunar['is_leap'] || (0 < $leapMonth && $leapMonth < $lessLunar['lunar_month']) ? 1 : 0;
            $greaterLunarAdjustFactor =
                $greaterLunar['is_leap'] || (0 < $leapMonth && $leapMonth < $greaterLunar['lunar_month']) ? 1 : 0;
            $diff =
                $greaterLunar['lunar_month'] + $greaterLunarAdjustFactor - $lessLunar['lunar_month'] - $lessLunarAdjustFactor;
        } else {
            $lessLunarLeapMonth = $this->leapMonth((int) $lessLunar['lunar_year']);
            $greaterLunarLeapMonth = $this->leapMonth((int) $greaterLunar['lunar_year']);

            $lessLunarAdjustFactor =
                (!$lessLunar['is_leap'] && $lessLunarLeapMonth == $lessLunar['lunar_month']) || $lessLunarLeapMonth > $lessLunar['lunar_month'] ? 1 : 0;
            $diff += 12 + $lessLunarAdjustFactor - $lessLunar['lunar_month'];
            for ($i = (int) $lessLunar['lunar_year'] + 1; $i < $greaterLunar['lunar_year']; ++$i) {
                $diff += $this->monthsOfYear($i);
            }
            $greaterLunarAdjustFactor =
                $greaterLunar['is_leap'] || (0 < $greaterLunarLeapMonth && $greaterLunarLeapMonth < $greaterLunar['lunar_month']) ? 1 : 0;
            $diff += $greaterLunarAdjustFactor + $greaterLunar['lunar_month'];
        }

        $diff -= $greaterLunar['lunar_day'] >= $lessLunar['lunar_day'] ? 0 : 1;

        return $absolute ? (int) $diff : ($changed ? -1 * (int) $diff : (int) $diff);
    }

    /**
     * 获取两个日期之间以日为单位的距离.
     *
     * @param array<string, mixed> $lunar1
     * @param array<string, mixed> $lunar2
     */
    public function diffInDays(array $lunar1, array $lunar2, bool $absolute = true): int
    {
        [$y1, $m1, $d1] = $this->lunarArrayToSolar($lunar1);
        [$y2, $m2, $d2] = $this->lunarArrayToSolar($lunar2);

        // 用儒略日序数相减，不经过 DateTime::diff()：
        // 后者在 PHP < 8.1 上对 1900 年（LMT +08:05:43）日期与夏令时日期做差会少算一天
        $diff = $this->toJulianDay($y2, $m2, $d2) - $this->toJulianDay($y1, $m1, $d1);

        return $absolute ? abs($diff) : $diff;
    }

    /**
     * 增加年数.
     *
     * @param array<string, mixed> $lunar
     *
     * @return array<string, mixed>
     */
    public function addYears(array $lunar, int $value = 1, bool $overFlow = true): array
    {
        $newYear = (int) $lunar['lunar_year'] + $value;
        $newMonth = (int) $lunar['lunar_month'];
        $newDay = (int) $lunar['lunar_day'];
        $isLeap = (bool) $lunar['is_leap'];
        $needOverFlow = false;

        $leapMonth = $this->leapMonth($newYear);
        $isLeap = $isLeap && $newMonth == $leapMonth;
        $maxDays = $isLeap ? $this->leapDays($newYear) : $this->lunarDays($newYear, $newMonth);

        if ($newDay > $maxDays) {
            if ($overFlow) {
                $newDay = 1;
                $needOverFlow = true;
            } else {
                $newDay = $maxDays;
            }
        }
        $ret = $this->lunar($newYear, $newMonth, $newDay, $isLeap);
        if ($needOverFlow) {
            $ret = $this->addMonths($ret, 1, $overFlow);
        }

        return $ret;
    }

    /**
     * 减少年数.
     *
     * @param array<string, mixed> $lunar
     *
     * @return array<string, mixed>
     */
    public function subYears(array $lunar, int $value = 1, bool $overFlow = true): array
    {
        return $this->addYears($lunar, -1 * $value, $overFlow);
    }

    /**
     * 增加月数.
     *
     * @param array<string, mixed> $lunar
     *
     * @return array<string, mixed>
     */
    public function addMonths(array $lunar, int $value = 1, bool $overFlow = true): array
    {
        if (0 > $value) {
            return $this->subMonths($lunar, -1 * $value, $overFlow);
        }

        $newYear = (int) $lunar['lunar_year'];
        $newMonth = (int) $lunar['lunar_month'];
        $newDay = (int) $lunar['lunar_day'];
        $isLeap = (bool) $lunar['is_leap'];

        while (0 < $value) {
            $leapMonth = $this->leapMonth($newYear);
            if (0 < $leapMonth) {
                $currentIsLeap = $isLeap;
                $isLeap = $newMonth + $value == $leapMonth + ($isLeap ? 0 : 1);

                if ((!$currentIsLeap && $leapMonth == $newMonth) || ($newMonth < $leapMonth && $newMonth + $value > $leapMonth)) {
                    --$value;
                }
            } else {
                $isLeap = false;
            }

            if (13 > $newMonth + $value) {
                $newMonth += $value;
                $value = 0;
            } else {
                $value = $value + $newMonth - 13;
                ++$newYear;
                $newMonth = 1;
            }

            if (0 == $value) {
                $maxDays = $isLeap ? $this->leapDays($newYear) : $this->lunarDays($newYear, $newMonth);
                if ($newDay > $maxDays) {
                    if ($overFlow) {
                        $newDay = 1;
                        ++$value;
                    } else {
                        $newDay = $maxDays;
                    }
                }
            }
        }

        return $this->lunar($newYear, $newMonth, $newDay, $isLeap);
    }

    /**
     * 减少月数.
     *
     * @param array<string, mixed> $lunar
     *
     * @return array<string, mixed>
     */
    public function subMonths(array $lunar, int $value = 1, bool $overFlow = true): array
    {
        if (0 > $value) {
            return $this->addMonths($lunar, -1 * $value, $overFlow);
        }

        $newYear = (int) $lunar['lunar_year'];
        $newMonth = (int) $lunar['lunar_month'];
        $newDay = (int) $lunar['lunar_day'];
        $isLeap = (bool) $lunar['is_leap'];
        $needOverFlow = false;

        while (0 < $value) {
            $leapMonth = $this->leapMonth($newYear);

            if (0 < $leapMonth) {
                $isLeap = $newMonth - $value == $leapMonth;

                if ($newMonth >= $leapMonth && $newMonth - $value < $leapMonth) {
                    --$value;
                }
            } else {
                $isLeap = false;
            }

            if ($newMonth > $value) {
                $newMonth -= $value;
                $value = 0;
            } else {
                $value = $value - $newMonth;
                --$newYear;
                $newMonth = 12;
            }

            if (0 == $value) {
                $maxDays = $isLeap ? $this->leapDays($newYear) : $this->lunarDays($newYear, $newMonth);
                if ($newDay > $maxDays) {
                    $newDay = $maxDays;
                    $needOverFlow = $overFlow;
                }
            }
        }

        $ret = $this->lunar($newYear, $newMonth, $newDay, $isLeap);
        if ($needOverFlow) {
            $ret = $this->addDays($ret, 1);
        }

        return $ret;
    }

    /**
     * 增加天数.
     *
     * @param array<string, mixed> $lunar
     *
     * @return array<string, mixed>
     */
    public function addDays(array $lunar, int $value = 1): array
    {
        [$y, $m, $d] = $this->lunarArrayToSolar($lunar);
        $date = $this->makeDate("{$y}-{$m}-{$d}");
        $date->modify($value.' day');

        return $this->solar2lunar((int) $date->format('Y'), (int) $date->format('n'), (int) $date->format('j'));
    }

    /**
     * 减少天数.
     *
     * @param array<string, mixed> $lunar
     *
     * @return array<string, mixed>
     */
    public function subDays(array $lunar, int $value = 1): array
    {
        return $this->addDays($lunar, -1 * $value);
    }

    /**
     * 创建日期对象.
     */
    protected function makeDate(string $string = 'now', string $timezone = 'Asia/Shanghai'): DateTime
    {
        return new DateTime($string, new DateTimeZone($timezone));
    }

    /**
     * 获取时柱.
     *
     * @param ?int $hour      0~23 小时格式
     * @param int  $ganZhiDay 干支日期
     *
     * @return array{0: ?string, 1: ?string, 2: ?string} [时柱, 时辰, 两位数小时]
     *
     * @see https://baike.baidu.com/item/%E6%97%B6%E6%9F%B1/6274024
     */
    protected function ganZhiHour(?int $hour, int $ganZhiDay): array
    {
        if (null === $hour || $hour < 0 || $hour > 23) {
            return [null, null, null];
        }

        $zhiHour = intdiv($hour + 1, 2);
        $zhiHour = 12 === $zhiHour ? 0 : $zhiHour;

        return [
            $this->gan[($ganZhiDay % 10 % 5 * 2 + $zhiHour) % 10].$this->zhi[$zhiHour],
            $this->zhi[$zhiHour].'时',
            sprintf('%02d', $hour),
        ];
    }
}
