# Chinese calendar

[![CI](https://github.com/overtrue/chinese-calendar/actions/workflows/ci.yml/badge.svg)](https://github.com/overtrue/chinese-calendar/actions/workflows/ci.yml)
[![Latest Stable Version](https://poser.pugx.org/overtrue/chinese-calendar/v/stable.svg)](https://packagist.org/packages/overtrue/chinese-calendar)
[![Total Downloads](https://poser.pugx.org/overtrue/chinese-calendar/downloads)](https://packagist.org/packages/overtrue/chinese-calendar)
[![License](https://poser.pugx.org/overtrue/chinese-calendar/license)](https://packagist.org/packages/overtrue/chinese-calendar)

:date: 中国农历（阴历）与阳历（公历）转换与查询工具，支持公历 1900-01-31 ~ 2100-12-31。

- 所有计算固定按北京时间（`Asia/Shanghai`）进行，与进程默认时区（`date_default_timezone_set()`）无关；
- 纯整数儒略日算法，不依赖 `ext-calendar` 等非默认扩展；
- 农历大小月与二十四节气数据已逐日对照香港天文台《公历与农历日期对照表》（1901-2100）校验，
  并以 fixture 形式纳入测试（见 `tests/fixtures/`）。

## 环境要求

- PHP >= 8.5（`2.x`）
- ext-mbstring

| 版本 | PHP 要求 | 分支 | 说明 |
| ---- | -------- | ---- | ---- |
| 2.x  | >= 8.5   | `master` | 当前开发版本 |
| 1.x  | >= 5.5.9 | `1.x` | 仅接受缺陷修复 |

## Installing

```shell
composer require overtrue/chinese-calendar
```

## Usage

```php
use Overtrue\ChineseCalendar\Calendar;

$calendar = new Calendar();

$result = $calendar->solar(2017, 5, 5);     // 阳历
$result = $calendar->lunar(2017, 4, 10);    // 阴历
$result = $calendar->solar(2017, 5, 5, 23); // 阳历，带 $hour 参数
```

结果：

```php
array(
    'lunar_year' => '2017',              // 农历年
    'lunar_month' => '04',               // 农历月
    'lunar_day' => '10',                 // 农历日
    'lunar_hour' => NULL,                // 农历时
    'lunar_year_chinese' => '二零一七',   // (汉字)农历年
    'lunar_month_chinese' => '四月',      // (汉字)农历月
    'lunar_day_chinese' => '初十',        // (汉字)农历日
    'lunar_hour_chinese' => NULL,        // (汉字)农历时辰
    'ganzhi_year' => '丁酉',             // (干支)年柱
    'ganzhi_month' => '乙巳',            // (干支)月柱
    'ganzhi_day' => '壬辰',              // (干支)日柱
    'ganzhi_hour' => NULL,               // (干支)时柱
    'wuxing_year' => '火金',             // (五行)年
    'wuxing_month' => '木火',            // (五行)月
    'wuxing_day' => '水土',              // (五行)日
    'wuxing_hour' => NULL,               // (五行)时
    'color_year' => '红',                // (颜色)年
    'color_month' => '青',               // (颜色)月
    'color_day' => '黑',                 // (颜色)日
    'color_hour' => NULL,                // (颜色)时
    'animal' => '鸡',                    // 生肖
    'term' => '立夏',                    // 节气
    'is_leap' => false,                  // 是否为闰月
    'gregorian_year' => '2017',          // 公历年
    'gregorian_month' => '05',           // 公历月
    'gregorian_day' => '05',             // 公历日
    'gregorian_hour' => NULL,            // 公历时
    'week_no' => 5,                      // (数字)星期几
    'week_name' => '星期五',             // (汉字)星期几
    'is_today' => false,                 // 是否为今天
    'constellation' => '金牛',           // 星座
    'is_same_year' => true,              // 农历年与公历年是否同年
);
```

> - 传入 `$hour = 23` 时按「晚子时」归入次日（结果为 `四月十一` 而非 `四月初十`），具体见 #13；
> - `ganzhi_year` 与 `animal` 以农历正月初一为分界，与 `lunar_year` 一致；命理学中以立春为界的口径请自行换算。

## 常用 API

| 方法 | 说明 |
| ---- | ---- |
| `solar($year, $month, $day, $hour = null)` | 阳历转农历，返回完整信息数组 |
| `lunar($year, $month, $day, $isLeapMonth = false, $hour = null)` | 农历转阳历，返回完整信息数组 |
| `solar2lunar($year, $month, $day, $hour = null)` | 阳历转农历（仅农历信息） |
| `lunar2solar($year, $month, $day, $isLeapMonth = false)` | 农历转阳历（仅公历年月日） |
| `leapMonth($year)` / `leapDays($year)` | 某农历年闰几月 / 闰月天数 |
| `lunarDays($year, $month)` / `daysOfYear($year)` / `monthsOfYear($year)` | 农历月天数 / 年总天数 / 年总月数 |
| `solarDays($year, $month)` | 公历某月天数 |
| `getTerm($year, $no)` | 某年第 n 个节气（1 = 小寒）的公历日 |
| `diffInDays($lunar1, $lunar2, $absolute = true)` | 两个农历日期相差的天数（同类还有 `diffInMonths` / `diffInYears`） |
| `addDays` / `subDays` / `addMonths` / `subMonths` / `addYears` / `subYears` | 农历日期加减 |

更多 API 请查看源码。

## 从 1.x 升级

2.0 的计算结果与修复后的 1.x 完全一致，但有以下不兼容变更：

- 要求 PHP >= 8.5，源码启用了 `strict_types` 并为所有方法补全了参数与返回类型；
- `ganZhiYear()` 与 `getAnimal()` 移除了已废弃的第二个参数 `$termIndex`；
- `diffInDays()` 返回 `int`（原为数字字符串）；`getTerm()` 返回 `int`（原为数字字符串）；
- 无效入参会抛出 `TypeError` / `InvalidArgumentException`，不再静默产生错误结果。

## 测试

```shell
composer test        # PHPUnit（含香港天文台全量对照 fixture）
composer check-style # laravel/pint --test
composer phpstan     # 静态分析
```

## Reference

- [1900年至2100年公历、农历互转Js代码 - 晶晶的博客](http://blog.jjonline.cn/userInterFace/173.html) - 数据与部分算法来源
- [香港天文台：公历与农历日期对照表](https://www.hko.gov.hk/tc/gts/time/conversion.htm) - 农历与节气数据校验来源
- [中国历法 - 维基百科](https://zh.wikipedia.org/wiki/Category:%E4%B8%AD%E5%9B%BD%E5%8E%86%E6%B3%95)
- [农历 - 维基百科](https://zh.wikipedia.org/wiki/%E8%BE%B2%E6%9B%86)
- [干支 - 维基百科](https://zh.wikipedia.org/wiki/%E5%B9%B2%E6%94%AF)
- [星座 - 维基百科](https://zh.wikipedia.org/wiki/%E6%98%9F%E5%BA%A7)
- [生肖 - 维基百科](https://zh.wikipedia.org/wiki/%E7%94%9F%E8%82%96)

## PHP 扩展包开发

> 想知道如何从零开始构建 PHP 扩展包？
>
> 请关注我的实战课程，我会在此课程中分享一些扩展开发经验 —— [《PHP 扩展包实战教程 - 从入门到发布》](https://learnku.com/courses/creating-package)

## License

MIT
