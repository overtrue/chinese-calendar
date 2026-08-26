# 贡献指南

感谢参与！提交前请花两分钟读完本文件与 [AGENTS.md](AGENTS.md)（后者列出了本库的硬性约束，人类与 AI 贡献者同样适用）。

## 开发环境

```shell
composer install
composer test        # PHPUnit（含香港天文台全量对照 fixture，约 3 秒）
composer check-style # laravel/pint --test
composer fix-style   # laravel/pint
composer phpstan     # 静态分析
```

CI 会在 UTC / Asia/Shanghai / America/New_York 三个默认时区下跑测试——所有计算必须与进程默认时区无关。

## 提交缺陷修复

- 涉及**农历/节气数据**（`$lunars` / `$solarTerms`）的改动：必须给出权威依据
  （首选[香港天文台对照表](https://www.hko.gov.hk/tc/gts/time/conversion.htm)），
  并同步更新 `tests/fixtures/` 与对应断言；
- 涉及**计算逻辑**的改动：请附上能证明行为正确（或与改动前等价）的测试；
  天数计算一律使用儒略日整数运算，不要引入 `date()` / 时间戳 / `DateTime::diff()->days`；
- 新增测试请使用 PHPUnit 12 风格（`#[DataProvider]`、`: void`）。

## 分支与版本

- `master` = 2.x（PHP >= 8.5）；`1.x` = 维护分支（PHP >= 5.5.9，仅缺陷修复，禁用 PHP 7+ 语法）；
- 修复先落 `master`，需要时再 cherry-pick 到 `1.x`。

## 约定

- 源码注释与提交信息使用中文；
- 行为口径（干支年/生肖以正月初一为界、23 点归入次日等）见 [AGENTS.md](AGENTS.md)，调整需先在 issue 中讨论。
