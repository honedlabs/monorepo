<?php

namespace Honed\Registry\Concerns;

use Honed\Registry\Enums\RegistryType;

trait HasRegistryType
{
    /**
     * The type of the registry component.
     * 
     * @var string|\Honed\Registry\Enums\RegistryType
     */
    protected $type;

    /**
     * Set the type of the registry component.
     * 
     * @param string|\Honed\Registry\Enums\RegistryType $type
     * @return $this
     */
    public function type($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get the type of the registry instance.
     * 
     * @return string
     */
    public function getType()
    {
        if ($this->type instanceof RegistryType) {
            return $this->type->value;
        }

        return $this->type;
    }

    /**
     * Register as a block.
     * 
     * @return $this
     */
    public function block()
    {
        return $this->type(RegistryType::Block);
    }

    /**
     * Register as a component.
     * 
     * @return $this
     */
    public function component()
    {
        return $this->type(RegistryType::Component);
    }

    /**
     * Register as a composable.
     * 
     * @return $this
     */
    public function composable()
    {
        return $this->type(RegistryType::Composable);
    }

    /**
     * Register as a lib.
     * 
     * @return $this
     */
    public function lib()
    {
        return $this->type(RegistryType::Lib);
    }

    /**
     * Register as a hook.
     * 
     * @return $this
     */
    public function hook()
    {
        return $this->type(RegistryType::Hook);
    }

    /**
     * Register as ui.
     * 
     * @return $this
     */
    public function ui()
    {
        return $this->type(RegistryType::Ui);
    }

    /**
     * Register as a page.
     * 
     * @return $this
     */
    public function page()
    {
        return $this->type(RegistryType::Page);
    }

    /**
     * Register as a file.
     * 
     * @return $this
     */
    public function file()
    {
        return $this->type(RegistryType::File);
    }

    /**
     * Register as a style.
     * 
     * @return $this
     */
    public function style()
    {
        return $this->type(RegistryType::Style);
    }

    /**
     * Register as a theme.
     * 
     * @return $this
     */
    public function theme()
    {
        return $this->type(RegistryType::Theme);
    }
}