<?php

namespace Honed\Modal\Concerns;

use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Support\Header;

trait RespondsWithInertia
{
    /**
     * The current request instance
     *
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * Set the request instance to be the application request instance.
     * 
     * @return void
     */
    public function newRequest()
    {
        /** @var \Illuminate\Http\Request */
        $this->request = App::make('request');
    }

    /**
     * Copy the request instance to a new request at a different URI.
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
