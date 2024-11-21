<?php

namespace Workbench\App;

use Honed\Core\Attributes\Description;
use Honed\Core\Attributes\Format;
use Honed\Core\Attributes\Id;
use Honed\Core\Attributes\Key;
use Honed\Core\Attributes\Label;
use Honed\Core\Attributes\Name;
use Honed\Core\Attributes\Placeholder;
use Honed\Core\Attributes\Property;
use Honed\Core\Attributes\Title;
use Honed\Core\Attributes\Type;
use Honed\Core\Attributes\Value;

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
