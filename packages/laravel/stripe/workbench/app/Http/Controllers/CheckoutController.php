<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Honed\Billing\Billing;
use Illuminate\Routing\Controller;

class CheckoutController extends Controller
{
    public function checkout(Billing $billing)
    {
        return $billing;
    }
}
