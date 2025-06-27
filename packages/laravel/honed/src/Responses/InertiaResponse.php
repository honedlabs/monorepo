<?php

declare(strict_types=1);

namespace Honed\Honed\Responses;

use Inertia\Inertia;
use Illuminate\Contracts\Support\Responsable;
use RuntimeException;

abstract class InertiaResponse implements Responsable
{
        /**
     * The title for the page.
     * 
     * @var string|null
     */
    protected $title;

    /**
     * The head of the page.
     * 
     * @var string|null
     */
    protected $head;

    /**
     * The props for the view.
     * 
     * @var array<string, mixed>
     */
    protected $props = [];

    /**
     * The page to be rendered.
     * 
     * @var string|null
     */
    protected $page;

    /**
     * The modal to be rendered.
     * 
     * @var string|null
     */
    protected $modal;

    /**
     * The base url to be used for modals.
     * 
     * @var string|null
     */
    protected $base;

    /**
     * Define the response.
     * 
     * @param $this $response
     * @return $this
     */
    abstract protected function definition(self $response): self;

    /**
     * Set the title for the page.
     * 
     * @param string $title
     * 
     * @return $this
     */
    public function title($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the title of the page.
     * 
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the head of the page.
     * 
     * @param string $head
     * 
     * @return $this
     */
    public function head($head)
    {
        $this->head = $head;

        return $this;
    }

    /**
     * Get the head of the page.
     * 
     * @return string
     */
    public function getHead()
    {
        return $this->head ??= $this->getTitle();
    }

    /**
     * Set the props for the view.
     * 
     * @param array<string, mixed> $props
     */
    public function props($props)
    {
        $this->props = $props;

        return $this;
    }

    /**
     * Get the props for the view.
     * 
     * @return array<string, mixed>
     */
    public function getProps()
    {
        return $this->props;
    }

    /**
     * The page to be rendered.
     * 
     * @param string $page
     * 
     * @return $this
     */
    public function page($page)
    {
        $this->page = $page;

        return $this;
    }

    /**
     * Get the page to be rendered.
     * 
     * @return string|null
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * The modal to be rendered.
     * 
     * @param string $modal
     * 
     * @return $this
     */
    public function modal($modal)
    {
        $this->modal = $modal;

        return $this;
    }

    /**
     * Get the modal to be rendered.
     * 
     * @return string|null
     */
    public function getModal()
    {
        return $this->modal;
    }

    /**
     * Set the base url to be used for modals.
     * 
     * @param string $base
     * 
     * @return $this
     */
    public function base($base)
    {
        $this->base = $base;

        return $this;
    }

    /**
     * Get the base url to be used for modals.
     * 
     * @return string|null
     */
    public function getBaseUrl()
    {
        return $this->base;
    }
    /**
     * Create an HTTP response that represents the object.
     * 
     * @param \Illuminate\Http\Request $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request)
    {
        $this->setUp();

        $this->definition($this);

        return $this->render()->toResponse($request);
    }

    /**
     * Provide the instance with any necessary setup.
     * 
     * @return void
     */
    protected function setUp()
    {
        //
    }

    /**
     * Render the page or modal.
     * 
     * @return \Illuminate\Contracts\Support\Responsable
     */
    protected function render()
    {
        return match (true) {
            (bool) ($page = $this->getPage()) => $this->renderPage($page),
            (bool) ($modal = $this->getModal()) => $this->renderModal($modal),
            default => throw new RuntimeException(
                'No page or modal was set, the Inertia response cannot be rendered.'
            )
        };
    }

    /**
     * Render the page.
     * 
     * @param string $page
     * @return \Inertia\Response
     */
    protected function renderPage($page)
    {
        return Inertia::render($page, $this->generateProps());
    }

    /**
     * Render the modal.
     * 
     * @param string $modal
     * @return \Inertia\Response
     */
    protected function renderModal($modal)
    {
        $base = $this->getBaseUrl();

        if (! $base) {
            throw new RuntimeException(
                'Modals require a base url to be set.'
            );
        }

        return Inertia::render($modal, $this->generateProps());
    }

    /**
     * Generate the props for the view.
     * 
     * @return array<string, mixed>
     */
    protected function generateProps()
    {
        return [
            'title' => $this->getTitle(),
            'head' => $this->getHead(),
            ...$this->getProps(),
        ];
    }
}
