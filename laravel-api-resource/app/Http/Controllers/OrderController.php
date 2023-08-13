<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function all()
    {
        $orders = Order::with('user');
        return OrderResource::collection($orders->paginate(5))->response();
    }
}