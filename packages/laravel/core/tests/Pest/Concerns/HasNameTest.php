<?php

use Honed\Core\Concerns\Evaluable;
use Honed\Core\Concerns\HasName;

class A
{
    
}

class B extends A
{

}

interface C extends D
{

}

interface D
{

}

interface E
{

}

class F extends B implements C, E
{

}

test('xx', function () {
    $f = new F();
    dd($f instanceof E);
});