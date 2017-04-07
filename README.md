# Chinese calendar

:date: 中国农历（阴历）与阳历（公历）转换与查询工具

# Installing

```shell
$ composer require overtrue/chinese-calendar -vvv
```

# Usage

```php
use Overtrue\ChineseCalendar\Calendar;

$result = $calendar->solar(2017, 5, 5); // 阳历
$result = $calendar->lunlar(2017, 4, 10); // 阴历

```

结果：

```
{
    "lunar_year": 2017,                 // 农历年
    "lunar_month": 4,                   // 农历月
    "lunar_day": 10,                    // 农历日
    "lunar_month_chinese": "四月",       // (汉字)农历月
    "lunar_day_chinese": "初十",         // (汉字)农历日  
    "ganzhi_year": "丁酉",               // (干支)年
    "ganzhi_month": "乙巳",              // (干支)月
    "ganzhi_day": "壬辰",                // (干支)日
    "animal": "鸡",                      // 生肖
    "term": "立夏",                      // 节气
    "is_leap": false,                    // 是否为闰月
    "gregorian_year": 2017,              // 公历年
    "gregorian_month": 5,                // 公历月
    "gregorian_day": 5,                  // 公历日
    "week_no": 5,                        // (数字)星期几
    "week_name": "星期五",                // (汉字)星期几
    "is_today": false,                   // 是否为今天
    "constellation": "金牛"               // 星座
}
```

更多 API 请查看源码。

# Reference

- [1900年至2100年公历、农历互转Js代码 - 晶晶的博客](http://blog.jjonline.cn/userInterFace/173.html) - 数据与部分算法来源
- [中国历法 - 维基百科](https://zh.wikipedia.org/wiki/Category:%E4%B8%AD%E5%9B%BD%E5%8E%86%E6%B3%95)
- [农历 - 维基百科](https://zh.wikipedia.org/wiki/%E8%BE%B2%E6%9B%86)
- [阴历 - 维基百科](https://zh.wikipedia.org/wiki/%E9%98%B4%E5%8E%86)
- [阳历 - 维基百科](https://zh.wikipedia.org/wiki/%E9%98%B3%E5%8E%86)
- [干支 - 维基百科](https://zh.wikipedia.org/wiki/%E5%B9%B2%E6%94%AF)
- [星座 - 维基百科](https://zh.wikipedia.org/wiki/%E6%98%9F%E5%BA%A7)
- [生肖 - 维基百科](https://zh.wikipedia.org/wiki/%E7%94%9F%E8%82%96)

# License

MIT
