<?php

declare(strict_types=1);

namespace Honed\Action;

use Honed\Core\Primitive;
use Honed\Core\Concerns\HasTitle;
use Honed\Core\Concerns\HasDescription;
use Honed\Core\Contracts\ResolvesClosures;
use Honed\Core\Concerns\EvaluableDependency;

class Confirm extends Primitive implements ResolvesClosures
{
    use HasTitle;
    use HasDescription;
    use EvaluableDependency;

    /**
     * @var string
     */
    protected $dismiss = 'Cancel';
    
    /**
     * @var string
     */
    protected $submit = 'Confirm';

    /**
     * @var string|null
     */
    protected $intent = null;

    public function __construct(
        string|\Closure $title = null, 
        string|\Closure $description = null, 
        string $dismiss = 'Cancel', 
        string $submit = 'Confirm', 
        string $intent = null
    ) {
        $this->title($title);
        $this->description($description);
        $this->dismiss($dismiss);
        $this->submit($submit);
        $this->intent($intent);
    }

    /**
     * Make a new confirm instance.
     */
    public static function make(
        string|\Closure $title = null, 
        string|\Closure $description = null, 
        string $dismiss = 'Cancel', 
        string $submit = 'Confirm', 
        string $intent = null
    ): static {
        return new static($title, $description, $dismiss, $submit, $intent);
    }

    public function toArray()
    {
        return [
            'title' => $this->getTitle(),
            'description' => $this->getDescription(),
            'dismiss' => $this->getDismiss(),
            'submit' => $this->getSubmit(),
            'intent' => $this->getIntent(),
        ];
    }

    public function resolve($parameters = null, $typed = null)
    {
        $this->getTitle($parameters, $typed);
        $this->getDescription($parameters, $typed);
    }
}