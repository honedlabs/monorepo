<?php

namespace Workbench\App;

use Conquest\Core\Attributes\Description;
use Conquest\Core\Attributes\Format;
use Conquest\Core\Attributes\Id;
use Conquest\Core\Attributes\Key;
use Conquest\Core\Attributes\Label;
use Conquest\Core\Attributes\Name;
use Conquest\Core\Attributes\Placeholder;
use Conquest\Core\Attributes\Property;
use Conquest\Core\Attributes\Title;
use Conquest\Core\Attributes\Type;
use Conquest\Core\Attributes\Value;

#[Id('unique')]
#[Description('Description')]
#[Format('d M y')]
#[Key('id')]
#[Label('Label')]
#[Name(('Name'))]
#[Placeholder('Placeholder')]
#[Property('property')]
#[Title('Title')]
#[Type('type')]
#[Value('value')]
class Attributable extends Component {}
