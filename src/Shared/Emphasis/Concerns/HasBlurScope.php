<?php

namespace Conquest\Chart\Shared\Emphasis\Concerns;

trait HasBlurScope
{
    protected ?string $blurScope = null;

    public const SCOPES = [
        'coordinateSystem',
        'series',
        'global',
    ];

    public function blurScope(string $blurScope): self
    {
        $this->setBlurScope($blurScope);
        return $this;
    }

    public function setBlurScope(string|null $blurScope): void
    {
        if (is_null($blurScope)) return;
        if (!in_array($blurScope, self::SCOPES)) {
            throw new \Exception("Invalid blurScope given {$blurScope} does not match valid blurScopes.");
        }
        
        $this->blurScope = $blurScope;
    }

    public function getBlurScope(): ?string
    {
        return $this->blurScope;
    }

    public function lacksBlurScope(): bool
    {
        return is_null($this->blurScope);
    }

    public function hasBlurScope(): bool
    {
        return !$this->lacksBlurScope();
    }

    public function getBlurScopeOption(): array
    {
        return $this->hasBlurScope() ? [
            'blurScope' => $this->getBlurScope()
        ] : [];
    
    }
    
}