# Operation System Enum

[English](README.md) | [中文](README.zh-CN.md)

一个用于表示不同操作系统平台的 PHP 8.1+ 枚举包，支持标签显示、数组转换和前端参数兼容性。

## 安装

```bash
composer require tourze/operation-system-enum
```

## 快速开始

### 基本用法

```php
use Tourze\OperationSystemEnum\Platform;

// 获取所有平台枚举
$platforms = Platform::cases();

// 通过值获取平台
$platform = Platform::from('WINDOWS');

// 带回退的获取平台
$platform = Platform::tryFrom('INVALID'); // 返回 null

// 获取平台标签
echo Platform::WINDOWS->getLabel(); // "Windows"
echo Platform::ANDROID->getLabel(); // "安卓"
```

### 高级用法

```php
use Tourze\OperationSystemEnum\Platform;

// 混合输入支持，兼容性处理
$platform = Platform::mixFrom('mac');     // 返回 Platform::MACOS
$platform = Platform::mixFrom('darwin');  // 返回 Platform::MACOS
$platform = Platform::mixFrom('win');     // 返回 Platform::WINDOWS
$platform = Platform::mixFrom('win32');   // 返回 Platform::WINDOWS

// 转换为数组格式
$data = Platform::WINDOWS->toArray();
// 返回: ['value' => 'WINDOWS', 'label' => 'Windows']

// 为前端生成选择选项
$options = Platform::genOptions();
// 返回包含 ['label' => '...', 'text' => '...', 'value' => '...', 'name' => '...'] 的数组
```

### 可用平台

- `Platform::EMPTY` - 空/未知平台
- `Platform::WINDOWS` - 微软 Windows
- `Platform::ANDROID` - 安卓系统
- `Platform::IOS` - 苹果 iOS
- `Platform::MACOS` - 苹果 macOS
- `Platform::ROUTER` - 路由器系统

### 特性

- **类型安全**: 基于 PHP 8.1+ 枚举，严格类型检查
- **标签化**: 实现 `Labelable` 接口，提供显示标签
- **项目化**: 实现 `Itemable` 接口，支持数组转换
- **可选择**: 实现 `Selectable` 接口，生成前端选项
- **兼容性**: 通过 `mixFrom()` 方法支持多种输入格式
- **国际化**: 多语言标签支持（英文/中文）

## 配置

此包无需额外配置，开箱即用。要求：

- PHP 8.1 或更高版本
- `tourze/enum-extra` 包用于 trait 实现

## API 参考

### 方法

- `getLabel(): string` - 获取平台的显示标签
- `toArray(): array` - 转换为包含值和标签的数组
- `toSelectItem(): array` - 转换为选择选项格式
- `static mixFrom(string $value): ?Platform` - 从混合输入创建平台
- `static genOptions(): array` - 为前端生成所有平台选项

### 接口

- `Labelable` - 提供标签显示功能
- `Itemable` - 提供数组转换功能
- `Selectable` - 提供选择选项生成功能

## 许可证

MIT
