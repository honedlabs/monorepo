<?php

trait HasLayout
{
    const TABLE_LAYOUT = 'table';
    const GRID_LAYOUT = 'grid';

    /**
     * The display mode of the table.
     * 
     * @param string $displayMode
     */
    protected $layout = self::TABLE_LAYOUT;

    

    /**
     * Set the display mode of the table.
     *
     * @param string $layout
     * @return $this
     */
    public function layout($layout)
    {
        $this->layout = $layout;

        return $this;
    }

    /**
     * Get the layout of the table.
     *
     * @return string
     */
    public function getLayout()
    {
        return $this->layout;
    }

    public function persistLayout()
    {

    }

    public function persistLayoutInSession()
    {

    }

    public function persistLayoutInCookie()
    {

    }

    /**
     * 
     */
}