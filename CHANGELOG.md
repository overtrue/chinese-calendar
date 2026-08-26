# Changelog

本文件记录每个版本的重要变更，格式参考 [Keep a Changelog](https://keepachangelog.com/zh-CN/1.1.0/)。

## [Unreleased]（2.0）

### 变更（不兼容）

- 要求 PHP >= 8.5；源码启用 `strict_types`，全部属性、常量与方法签名补全类型
- `ganZhiYear()` / `getAnimal()` 移除已废弃的第二个参数 `$termIndex`
- `diffInDays()` 与 `getTerm()` 返回 `int`（原为数字字符串）
- 非法入参抛出 `TypeError` / `InvalidArgumentException`，不再静默产生错误结果
  （`lunar2solar()` 新增 `day < 1` 与年份越界校验）

### 新增

- GitHub Actions CI：PHPUnit 三时区矩阵（UTC / Asia/Shanghai / America/New_York）、
  覆盖率（pcov）、PHP nightly、laravel/pint、PHPStan
- `AGENTS.md`（AI 代理与自动化工具的项目须知）

### 工具链

- PHPUnit ^12.5、laravel/pint ^1.30、PHPStan ^2.1

## [1.1.0] - 2026-08-26

### 修复

- `lunar2solar()` / `diffInDays()` / `is_today` 不再依赖进程默认时区与 `DateTime::diff()`（#29 #37 #47）；
  农历 1900 年正月不再错误地返回 -1
- 干支年与生肖不再在小寒、大寒、立春当天被错误地加一（#28 #50 #55 #56 #57）
- 修正 1933、2057、2060 年农历大小月数据（#46 #49）；新增香港天文台 1901-2100 全量对照 fixture 测试

### 变更

- `diffInDays()` 返回 `int`（原为数字字符串，文档本就声明为 int）

## [1.0.3] - 2026-08-22

### 修复

- 默认时区标识 `PRC` 改为 `Asia/Shanghai`，兼容 Debian 13+ / Ubuntu 24.04+（#58）
- PHP < 8.1 在中国夏令时期间（1919、1940-1949、1986-1991）农历日期少算一天（#52，PR #59）

### 变更

- 用纯 PHP 儒略日算法替代 `gregoriantojd()`，去除对非默认扩展 ext-calendar 的隐性依赖

## [1.0.2] - 2020-03-09

- 增加农历年与公历年是否同年的判断 `is_same_year`（#43）

## [1.0.1] - 2019-09-02

- 修复节气取值传参与索引判断（#39）

## [1.0.0] - 2019-03-04

- 首个稳定版本（更早的 0.x 历史见 [Releases](https://github.com/overtrue/chinese-calendar/releases)）
