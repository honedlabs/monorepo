#!/usr/bin/env php
<?php

require __DIR__ . '/../vendor/autoload.php';

use Honed\Honed\PackageMake;

$command = new PackageMake();
$command->handle();

