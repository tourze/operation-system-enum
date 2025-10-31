<?php

namespace Tourze\OperationSystemEnum;

use Tourze\EnumExtra\Itemable;
use Tourze\EnumExtra\ItemTrait;
use Tourze\EnumExtra\Labelable;
use Tourze\EnumExtra\Selectable;
use Tourze\EnumExtra\SelectTrait;

enum Platform: string implements Labelable, Itemable, Selectable
{
    use ItemTrait;
    use SelectTrait;

    case EMPTY = '';
    case WINDOWS = 'WINDOWS';
    case ANDROID = 'ANDROID';
    case IOS = 'IOS';
    case ROUTER = 'ROUTER';
    case MACOS = 'MACOS';

    public function getLabel(): string
    {
        return match ($this) {
            self::WINDOWS => 'Windows',
            self::ANDROID => '安卓',
            self::IOS => 'iOS',
            self::MACOS => 'MacOS',
            self::ROUTER => '路由器',
            self::EMPTY => '未知',
        };
    }

    /**
     * 前端传入的参数，格式要兼容下
     */
    public static function mixFrom(string $value): ?Platform
    {
        $value = strtoupper($value);
        if ('MAC' === $value || 'DARWIN' === $value) {
            return Platform::MACOS;
        }
        if ('WIN' === $value || 'WIN32' === $value) {
            return Platform::WINDOWS;
        }

        $platform = Platform::tryFrom($value);
        if (null !== $platform) {
            return $platform;
        }

        return null;
    }
}
