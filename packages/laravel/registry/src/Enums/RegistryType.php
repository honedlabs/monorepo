<?php

namespace Honed\Registry\Enums;

enum RegistryType: string
{
    case Block = 'registry:block';
    case Component = 'registry:component';
    case Composable = 'registry:composable';
    case Lib = 'registry:lib';
    case Hook = 'registry:hook';
    case Ui = 'registry:ui';
    case Page = 'registry:page';
    case File = 'registry:file';
    case Style = 'registry:style';
    case Theme = 'registry:theme';
}