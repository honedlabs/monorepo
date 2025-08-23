<?php

namespace Honed\Widget\Drivers;

use Illuminate\Contracts\Events\Dispatcher;

class ArrayDriver extends Driver
{
    /**
     * {@inheritdoc}
     */
    public function get($scope, $group = null)
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function exists($widget, $scope, $group = null)
    {

    }

    /**
     * {@inheritdoc}
     */
    public function set($widget, $scope, $group = null, $order = 0)
    {

    }

    /**
     * {@inheritdoc}
     */
    public function update($widget, $scope, $group = null, $order = 0)
    {

    }

    /**
     * {@inheritdoc}
     */
    public function delete($widget, $scope, $group = null)
    {

    }    
}
