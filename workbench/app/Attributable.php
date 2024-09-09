<?php

namespace Workbench\App;

use Conquest\Table\Actions\Attributes\Key;
use Conquest\Table\Actions\Attributes\Name;
use Conquest\Table\Actions\Attributes\Type;
use Conquest\Table\Actions\Attributes\Label;
use Conquest\Table\Actions\Attributes\Title;
use Conquest\Table\Actions\Attributes\Value;
use Conquest\Table\Actions\Attributes\Format;
use Conquest\Table\Actions\Attributes\Property;
use Conquest\Table\Actions\Attributes\Description;
use Conquest\Table\Actions\Attributes\Placeholder;

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
class Attributable extends Component
{

}
