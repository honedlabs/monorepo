<?php

namespace Illuminate\Contracts\Foundation {

    /**
     * @method bool bindersAreCached() Determine if the binders are cached.
     * @method string getCachedBindersPath() Get the path to the binders cache file.
     */
    interface Application {}
}

namespace Illuminate\Support\Facades {

    /**
     * @method bool bindersAreCached() Determine if the binders are cached.
     * @method string getCachedBindersPath() Get the path to the binders cache file.
     */
    class App {}
}

namespace Illuminate\Foundation {

    /**
     * @method bool bindersAreCached() Determine if the binders are cached.
     * @method string getCachedBindersPath() Get the path to the binders cache file.
     */
    class Application {}
}