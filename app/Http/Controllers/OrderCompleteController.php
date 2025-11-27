<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class OrderCompleteController extends Controller
{
    public function __invoke(Request $request, Order $order): View
    {
        if (! $request->hasValidSignature()) {
            abort(401);
        }

        return view('orders.complete', compact('order'));
    }
}
