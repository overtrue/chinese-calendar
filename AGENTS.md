# AGENTS.md

给 AI 代理与自动化工具的项目须知（人类贡献者同样适用）。

## 项目概览

- 中国农历（阴历）与阳历转换库，单类实现：[src/Calendar.php](src/Calendar.php)（`Overtrue\ChineseCalendar\Calendar`）。
- 支持范围：公历 1900-01-31 ~ 2100-12-31。
- 所有计算固定按北京时间（`Asia/Shanghai`）进行，**必须与进程默认时区无关**。
- 分支模型：`master` = 2.x（PHP >= 8.5，`strict_types`）；`1.x` = 维护分支（PHP >= 5.5.9，仅缺陷修复，禁用 PHP 7+ 语法）。

## 常用命令

```shell
composer install
composer test        # PHPUnit 12，约 3 秒，含香港天文台全量对照 fixture
composer check-style # laravel/pint --test
composer fix-style   # laravel/pint
composer phpstan     # PHPStan level 6
```

## 硬性约束（改代码前必读）

1. **时区独立**：任何改动后，测试必须在多个默认时区下通过（CI 矩阵：UTC / Asia/Shanghai / America/New_York）。
   天数计算一律走儒略日整数运算（`toJulianDay()` / `fromJulianDay()`），禁止让 `date()`、时间戳或
   `DateTime::diff()->days` 参与——后者在 PHP < 8.1 上对 UTC 偏移不同的日期会少算一天（issue #37 / #52）。
2. **数据表**：`$lunars`（农历大小月，位编码见属性注释）与 `$solarTerms`（二十四节气）以香港天文台
   《公历与农历日期对照表》为准；1901-2100 全量对照 fixture 在 [tests/fixtures/](tests/fixtures/)，
   任何一位数据写错测试都会失败。改动数据必须同步核对 fixture 并在提交信息里写明依据。
   已知分歧点：2057 年九月初一（新月距北京时间午夜仅十余秒），本库采用香港天文台的 2057-09-28，
   6tail/lunar 与 ICU 为 09-29——不要"顺手修正"。
3. **口径约定**（刻意决策，调整需维护者明确同意）：
   - `ganzhi_year` / `animal` 以农历正月初一为界，与 `lunar_year` 一致（不按立春）；
   - `$hour = 23` 按晚子时归入次日（issue #13），农历日期与四柱随之整体后移。
4. **行为等价**：重构必须证明输出不变。本仓库的标准做法是对 1900-01-31 ~ 2100-12-31 全区间
   逐日 dump（`solar2lunar` × 多个 `$hour`、每个农历月的 `lunar2solar`）与改动前逐字节对比。
5. **公开契约**：返回数组的键名与取值类型（多为零填充字符串，如 `lunar_month => '04'`）不可改动。

## 风格与提交

- 风格：pint（preset `symfony` + [pint.json](pint.json) 中的规则）；源码注释与提交信息用中文。
- `src/` 启用 `declare(strict_types=1)`；`tests/` 刻意不启用（模拟用户以数字字符串传参的场景）。
- 不新增运行时依赖；目前唯一的扩展依赖是 `ext-mbstring`。

## 发版与协作

- 2.x 从 `master` 打 tag；1.x 的修复先在 `master` 落地，再 cherry-pick 到 `1.x` 发补丁版本。
- 贡献者 PR 原样合并（merge commit，与仓库历史一致）；需要后续调整时由维护者在合并后单独提交，
  不向贡献者的分支推送。
