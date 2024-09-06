<?php

declare(strict_types=1);

namespace Conquest\Core\Enums;

enum Method: string
{
    case Index = 'Index';
    case Show = 'Show';
    case Create = 'Create';
    case Store = 'Store';
    case Edit = 'Edit';
    case Update = 'Update';
    case Delete = 'Delete';
    case Destroy = 'Destroy';

    public function getHttpMethod(): string
    {
        return match ($this) {
            self::Store => 'post',
            self::Update => 'patch',
            self::Destroy => 'delete',
            default => 'get'
        };
    }

    public function isPage(): bool
    {
        return match ($this) {
            self::Index, self::Show, self::Create, self::Edit => true,
            default => false
        };
    }

    public function isModal(): bool
    {
        return match ($this) {
            self::Delete => true,
            default => false
        };
    }

    public function isForm(): bool
    {
        return match ($this) {
            self::Edit, self::Create => true,
            default => false
        };
    }

    public function isResourceless(): bool
    {
        return match ($this) {
            self::Store, self::Update, self::Destroy => true,
            default => false
        };
    }

    public function isScoped(): bool
    {
        return match ($this) {
            self::Show, self::Edit, self::Update, self::Destroy, self::Delete => true,
            default => false
        };
    }

    public function policy(): string
    {
        return match ($this) {
            self::Index => 'viewAny',
            self::Show => 'view',
            self::Create, self::Store => 'create',
            self::Edit, self::Update => 'update',
            self::Destroy, self::Delete => 'delete',
        };
    }
}