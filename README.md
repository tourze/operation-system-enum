# Operation System Enum

[English](README.md) | [中文](README.zh-CN.md)

A PHP 8.1+ enum package for representing different operating system platforms with support for label display, array conversion, and compatibility with frontend parameters.

## Installation

```bash
composer require tourze/operation-system-enum
```

## Quick Start

### Basic Usage

```php
use Tourze\OperationSystemEnum\Platform;

// Get all platform cases
$platforms = Platform::cases();

// Get platform by value
$platform = Platform::from('WINDOWS');

// Get platform with fallback
$platform = Platform::tryFrom('INVALID'); // returns null

// Get platform label
echo Platform::WINDOWS->getLabel(); // "Windows"
echo Platform::ANDROID->getLabel(); // "安卓"
```

### Advanced Usage

```php
use Tourze\OperationSystemEnum\Platform;

// Mixed input support with compatibility
$platform = Platform::mixFrom('mac');     // returns Platform::MACOS
$platform = Platform::mixFrom('darwin');  // returns Platform::MACOS
$platform = Platform::mixFrom('win');     // returns Platform::WINDOWS
$platform = Platform::mixFrom('win32');   // returns Platform::WINDOWS

// Convert to array format
$data = Platform::WINDOWS->toArray();
// Returns: ['value' => 'WINDOWS', 'label' => 'Windows']

// Generate select options for frontend
$options = Platform::genOptions();
// Returns array of ['label' => '...', 'text' => '...', 'value' => '...', 'name' => '...']
```

### Available Platforms

- `Platform::EMPTY` - Empty/Unknown platform
- `Platform::WINDOWS` - Microsoft Windows
- `Platform::ANDROID` - Android OS
- `Platform::IOS` - Apple iOS
- `Platform::MACOS` - Apple macOS
- `Platform::ROUTER` - Router systems

### Features

- **Type Safety**: Built on PHP 8.1+ enums with strict typing
- **Labelable**: Implements `Labelable` interface for display labels
- **Itemable**: Implements `Itemable` interface for array conversion
- **Selectable**: Implements `Selectable` interface for frontend options
- **Compatibility**: Support for various input formats via `mixFrom()` method
- **Internationalization**: Labels in multiple languages (English/Chinese)

## Configuration

This package requires no additional configuration. It works out of the box with:

- PHP 8.1 or higher
- `tourze/enum-extra` package for trait implementations

## API Reference

### Methods

- `getLabel(): string` - Get display label for the platform
- `toArray(): array` - Convert to array with value and label
- `toSelectItem(): array` - Convert to select option format
- `static mixFrom(string $value): ?Platform` - Create platform from mixed input
- `static genOptions(): array` - Generate all platform options for frontend

### Interfaces

- `Labelable` - Provides label display functionality
- `Itemable` - Provides array conversion functionality  
- `Selectable` - Provides select option generation functionality

## License

MIT