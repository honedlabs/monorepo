<?php

namespace Honed\Registry\Enums;

enum RegistryType: string
{
    /* Use for complex components with multiple files. */
    case Block = 'registry:block';
    /* Use for simple components. */
    case Component = 'registry:component';
    /* Use for composables. */
    case Composable = 'registry:composable';
    /* 	Use for lib and utils.. */
    case Lib = 'registry:lib';
    /* 	Use for hooks.. */
    case Hook = 'registry:hook';
    /* Use for UI components and single-file primitives */
    case Ui = 'registry:ui';
    /* Use for page or file-based routes.. */
    case Page = 'registry:page';
    /* 	Use for miscellaneous files.. */
    case File = 'registry:file';
    /* Use for registry styles. eg. new-york */
    case Style = 'registry:style';
    /* Use for themes. */
    case Theme = 'registry:theme';
}