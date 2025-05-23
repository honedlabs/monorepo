<?php

namespace Honed\Modal\Concerns;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;
use Inertia\Support\Header;

trait RespondsWithInertia
{
    /**
     * The component view.
     *
     * @var string
     */
    protected $component;

    /**
     * The props to pass to the modal.
     *
     * @var array<string, mixed>
     */
    protected $props;

    /**
     * The current request instance
     *
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * Set the component view.
     *
     * @param string $component
     * @return void
     */
    public function setComponent($component)
    {
        $this->component = $component;
    }

    /**
     * Set the props to pass to the view.
     * 
     * @param  array<string, mixed>|\Illuminate\Contracts\Support\Arrayable<string, mixed>  $props
     * @return void
     */
    public function props($props)
    {
        if ($props instanceof Arrayable) {
            $props = $props->toArray();
        }

        $this->props = $props;
    }

    /**
     * Add props to the view.
     *
     * @param  string|array<string, mixed>  $key
     * @param  mixed  $value
     * @return $this
     */
    public function with($key, $value = null)
    {
        if (is_array($key)) {
            $this->props = array_merge($this->props, $key);
        } else {
            $this->props[$key] = $value;
        }

        return $this;
    }

    /**
     * Set the request instance to be the given request instance.
     * 
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function request($request)
    {
        $this->request = $request;
    }

    /**
     * Set the request instance to be the application request instance.
     * 
     * @return void
     */
    public function newRequest()
    {
        /** @var \Illuminate\Http\Request */
        $request = App::make('request');

        $this->request($request);
    }

    /**
     * Copy the request instance to a new request at the given URI.
     * 
     * @param string $uri
     * @return \Illuminate\Http\Request
     */
    public function copyRequest($uri)
    {
        return Request::create(
            $uri,
            Request::METHOD_GET,
            $this->request->query->all(),
            $this->request->cookies->all(),
            $this->request->files->all(),
            $this->request->server->all(),
            $this->request->getContent()
        );
    }

    /**
     * Determine if the request is an Inertia request.
     * 
     * @return bool
     */
    public function isInertia()
    {
        return (bool) $this->request->header(Header::INERTIA);
    }

    /**
     * Determine if the request is a partial request.
     * 
     * @return bool
     */
    public function isPartial()
    {
        return $this->isInertia() && (bool) $this->getPartial();
    }

    /**
     * Get the partial component from the request.
     * 
     * @return string|null
     */
    public function getPartial()
    {
        /** @var string|null */
        return $this->request->header(Header::PARTIAL_COMPONENT);
    }

    /**
     * Get the referer from the request, only if it is an Inertia request.
     * 
     * @return string|null
     */
    public function getReferer()
    {
        $referer = $this->request->headers->get('referer');

        if ($this->isInertia() 
            && $referer 
            && $referer !== url()->current()
        ) {
            return $referer;
        }

        return null;
    }
}
