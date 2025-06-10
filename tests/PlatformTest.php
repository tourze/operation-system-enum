<?php

namespace Tourze\OperationSystemEnum\Tests;

use PHPUnit\Framework\TestCase;
use Tourze\EnumExtra\Itemable;
use Tourze\EnumExtra\Labelable;
use Tourze\EnumExtra\Selectable;
use Tourze\OperationSystemEnum\Platform;

class PlatformTest extends TestCase
{
    public function test_enum_values_are_correct(): void
    {
        $this->assertEquals('', Platform::EMPTY->value);
        $this->assertEquals('WINDOWS', Platform::WINDOWS->value);
        $this->assertEquals('ANDROID', Platform::ANDROID->value);
        $this->assertEquals('IOS', Platform::IOS->value);
        $this->assertEquals('ROUTER', Platform::ROUTER->value);
        $this->assertEquals('MACOS', Platform::MACOS->value);
    }

    public function test_all_cases_exist(): void
    {
        $expectedCases = [
            'EMPTY',
            'WINDOWS',
            'ANDROID',
            'IOS',
            'ROUTER',
            'MACOS'
        ];

        $actualCases = array_map(fn($case) => $case->name, Platform::cases());

        $this->assertEquals($expectedCases, $actualCases);
        $this->assertCount(6, Platform::cases());
    }

    public function test_getLabel_returns_correct_labels(): void
    {
        $this->assertEquals('Windows', Platform::WINDOWS->getLabel());
        $this->assertEquals('安卓', Platform::ANDROID->getLabel());
        $this->assertEquals('iOS', Platform::IOS->getLabel());
        $this->assertEquals('MacOS', Platform::MACOS->getLabel());
        $this->assertEquals('路由器', Platform::ROUTER->getLabel());
        $this->assertEquals('未知', Platform::EMPTY->getLabel());
    }

    public function test_mixFrom_with_standard_values(): void
    {
        $this->assertEquals(Platform::WINDOWS, Platform::mixFrom('WINDOWS'));
        $this->assertEquals(Platform::ANDROID, Platform::mixFrom('ANDROID'));
        $this->assertEquals(Platform::IOS, Platform::mixFrom('IOS'));
        $this->assertEquals(Platform::MACOS, Platform::mixFrom('MACOS'));
        $this->assertEquals(Platform::ROUTER, Platform::mixFrom('ROUTER'));
        $this->assertEquals(Platform::EMPTY, Platform::mixFrom(''));
    }

    public function test_mixFrom_with_lowercase_input(): void
    {
        $this->assertEquals(Platform::WINDOWS, Platform::mixFrom('windows'));
        $this->assertEquals(Platform::ANDROID, Platform::mixFrom('android'));
        $this->assertEquals(Platform::IOS, Platform::mixFrom('ios'));
        $this->assertEquals(Platform::MACOS, Platform::mixFrom('macos'));
        $this->assertEquals(Platform::ROUTER, Platform::mixFrom('router'));
    }

    public function test_mixFrom_with_mac_compatibility(): void
    {
        $this->assertEquals(Platform::MACOS, Platform::mixFrom('MAC'));
        $this->assertEquals(Platform::MACOS, Platform::mixFrom('mac'));
        $this->assertEquals(Platform::MACOS, Platform::mixFrom('DARWIN'));
        $this->assertEquals(Platform::MACOS, Platform::mixFrom('darwin'));
    }

    public function test_mixFrom_with_windows_compatibility(): void
    {
        $this->assertEquals(Platform::WINDOWS, Platform::mixFrom('WIN'));
        $this->assertEquals(Platform::WINDOWS, Platform::mixFrom('win'));
        $this->assertEquals(Platform::WINDOWS, Platform::mixFrom('WIN32'));
        $this->assertEquals(Platform::WINDOWS, Platform::mixFrom('win32'));
    }

    public function test_mixFrom_with_invalid_values(): void
    {
        $this->assertNull(Platform::mixFrom('INVALID'));
        $this->assertNull(Platform::mixFrom('LINUX'));
        $this->assertNull(Platform::mixFrom('UNKNOWN'));
        $this->assertNull(Platform::mixFrom('123'));
        $this->assertNull(Platform::mixFrom('!@#'));
    }

    public function test_mixFrom_with_special_characters(): void
    {
        $this->assertNull(Platform::mixFrom(' '));
        $this->assertNull(Platform::mixFrom('\t'));
        $this->assertNull(Platform::mixFrom('\n'));
        $this->assertNull(Platform::mixFrom('WIN DOWS'));
        $this->assertNull(Platform::mixFrom('MAC-OS'));
    }

    public function test_mixFrom_with_mixed_case(): void
    {
        $this->assertEquals(Platform::WINDOWS, Platform::mixFrom('Windows'));
        $this->assertEquals(Platform::ANDROID, Platform::mixFrom('Android'));
        $this->assertEquals(Platform::IOS, Platform::mixFrom('iOS'));
        $this->assertEquals(Platform::MACOS, Platform::mixFrom('MacOS'));
        $this->assertEquals(Platform::MACOS, Platform::mixFrom('Mac'));
        $this->assertEquals(Platform::WINDOWS, Platform::mixFrom('Win'));
    }

    public function test_toSelectItem_returns_correct_format(): void
    {
        $expected = [
            'label' => 'Windows',
            'text' => 'Windows',
            'value' => 'WINDOWS',
            'name' => 'Windows',
        ];

        $this->assertEquals($expected, Platform::WINDOWS->toSelectItem());

        $expectedEmpty = [
            'label' => '未知',
            'text' => '未知',
            'value' => '',
            'name' => '未知',
        ];

        $this->assertEquals($expectedEmpty, Platform::EMPTY->toSelectItem());
    }

    public function test_toArray_returns_correct_format(): void
    {
        $expected = [
            'value' => 'WINDOWS',
            'label' => 'Windows',
        ];

        $this->assertEquals($expected, Platform::WINDOWS->toArray());

        $expectedAndroid = [
            'value' => 'ANDROID',
            'label' => '安卓',
        ];

        $this->assertEquals($expectedAndroid, Platform::ANDROID->toArray());
    }

    public function test_genOptions_returns_all_cases(): void
    {
        $options = Platform::genOptions();

        $this->assertCount(6, $options);

        // 验证每个选项的格式
        foreach ($options as $option) {
            $this->assertArrayHasKey('label', $option);
            $this->assertArrayHasKey('text', $option);
            $this->assertArrayHasKey('value', $option);
            $this->assertArrayHasKey('name', $option);
        }

        // 验证第一个选项（EMPTY）
        $firstOption = $options[0];
        $this->assertEquals('未知', $firstOption['label']);
        $this->assertEquals('', $firstOption['value']);
    }

    public function test_genOptions_with_environment_filter(): void
    {
        // 测试环境变量过滤功能
        $envKey = 'enum-display:' . Platform::class . '-WINDOWS';
        $_ENV[$envKey] = false;

        $options = Platform::genOptions();

        // 检查 WINDOWS 是否被过滤掉
        $windowsOptions = array_filter($options, fn($option) => $option['value'] === 'WINDOWS');
        $this->assertEmpty($windowsOptions);

        // 清理环境变量
        unset($_ENV[$envKey]);
    }

    public function test_implements_required_interfaces(): void
    {
        $reflection = new \ReflectionClass(Platform::class);

        $this->assertTrue($reflection->implementsInterface(Labelable::class));
        $this->assertTrue($reflection->implementsInterface(Itemable::class));
        $this->assertTrue($reflection->implementsInterface(Selectable::class));
    }

    public function test_uses_required_traits(): void
    {
        $reflection = new \ReflectionClass(Platform::class);
        $traitNames = array_keys($reflection->getTraits());

        $this->assertContains('Tourze\EnumExtra\ItemTrait', $traitNames);
        $this->assertContains('Tourze\EnumExtra\SelectTrait', $traitNames);
    }

    public function test_all_labels_are_not_empty(): void
    {
        foreach (Platform::cases() as $case) {
            $this->assertNotEmpty($case->getLabel(), "Label for {$case->name} should not be empty");
        }
    }

    public function test_all_values_are_string(): void
    {
        foreach (Platform::cases() as $case) {
            $this->assertIsString($case->value, "Value for {$case->name} should be string");
        }
    }

    public function test_enum_is_backed_enum(): void
    {
        $this->assertInstanceOf(\BackedEnum::class, Platform::WINDOWS);
    }

    public function test_mixFrom_preserves_case_insensitive_matching(): void
    {
        // 测试大小写不敏感的匹配
        $testCases = [
            'windows' => Platform::WINDOWS,
            'WINDOWS' => Platform::WINDOWS,
            'Windows' => Platform::WINDOWS,
            'WiNdOwS' => Platform::WINDOWS,
            'android' => Platform::ANDROID,
            'ANDROID' => Platform::ANDROID,
            'AnDrOiD' => Platform::ANDROID,
        ];

        foreach ($testCases as $input => $expected) {
            $this->assertEquals($expected, Platform::mixFrom($input));
        }
    }
}
