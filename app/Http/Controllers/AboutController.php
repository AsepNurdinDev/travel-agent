<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Destination;
use App\Models\TourPackage;

class AboutController extends Controller
{
    public function __invoke()
    {
        $customerCount = Customer::count();

        $stats = [
            'travelers'       => $customerCount,
            'happy_customers' => $customerCount,
            'destinations'    => Destination::count(),
            'tours'           => TourPackage::count(),
            'rating'          => 4.8,
            'avg_rating'      => 4.8, 
        ];

        return view('about', compact('stats'));
    }
}