<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class ListingController extends Controller
{
    // public function __construct()
    // {
    //     $this->authorizeResource(
    //         Listing::class,
    //         'listing'
    //     );
    // }

    public function index(Request $request): Response
    {

        //var_dump($request);

        //    Gate::authorize(
        //     'viewAny',
        //     Listing::class
        // );
        $filters = $request->only([
            'priceFrom',
            'priceTo',
            'beds',
            'baths',
            'areaFrom',
            'areaTo'
        ]);

        return Inertia::render(

          'Dev/Listing',
            [
                'filters' => $filters,
                'listings' => Listing::mostRecent()
                    ->filter($filters)
                    ->withoutSold()
                    ->paginate(10)
                    ->withQueryString()
            ]
        );
    }


    public function mylist(){
        return Inertia::render('Dev/Listing',['listings'=>Listing::all()]);
    }

    public function show(Listing $listing): Response
    {
        // Gate::authorize(
        //     'view',
        //     $listing
        // );
        $listing->load(['images']);
        $offer = !Auth::user() ?
            null : $listing->offers()->byMe()->first();

        return Inertia::render(
            'Listing/Show',
            [
                'listing' => $listing,
                'offerMade' => $offer
            ]
        );
    }

    public function create()
    {
       $fields= [
        'beds', 'baths', 'area', 'city', 'code', 'street', 'street_nr', 'price'
    ];
     //  $fields = (new Listing())->getFillable();

        return inertia('Dev/Create',['fields'=>$fields]);
    }

    public function store(Request $request){
      //  dd($request->all());

        Listing::create($request->all());
        return redirect()->route('mylist')->with('success','Listing  created');
    }
}
