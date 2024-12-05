<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Inertia\Inertia;

class IndexController extends Controller
{
    public function index()
    {

        //dd(Listing::all());
        return Inertia::render(
            'Index/Index',
            [
                'message' => 'Hello frtttom Laravel!'
            ]
        );
    }

    public function show()
    {
        return Inertia::render('Index/Show');
    }

    public function myself(){
        return Inertia::render('Index/MySelf');
    }

    public function letsgo(){
        return Inertia::render('Index/LetsGo');
    //   return inertia('Index/LetsGo');
    }
}
