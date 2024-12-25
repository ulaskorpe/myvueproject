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

    public function index(Request $request)
    {


        //return "ok";
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
    //    $fields= [
    //     'beds', 'baths', 'area', 'city', 'code', 'street', 'street_nr', 'price'
    // ];
     //  $fields = (new Listing())->getFillable();
     $fields = [
        ['name' => 'beds', 'type' => 'number'],
        ['name' => 'baths', 'type' => 'number'],
        ['name' => 'area', 'type' => 'number'],
        ['name' => 'city', 'type' => 'text'],
        ['name' => 'code', 'type' => 'text'],
        ['name' => 'street', 'type' => 'text'],
        ['name' => 'street_nr', 'type' => 'text'],
        ['name' => 'price', 'type' => 'number'],
        // You can add hidden or other types as needed
        ['name' => 'by_user_id', 'type' => 'hidden'],
        //['name' => 'pix', 'type' => 'file'],
    ];
        return inertia('Dev/Create',['fields'=>$fields]) ;
    }

    public function store(Request $request){
       //dd($request->all());
       //$fields = (new Listing())->getFillable();
        // Listing::create($request->all());
        // Listing::create([
        //     ... $request->all(),
        //     ... $request->validate([
        //         'beds'=>'required|integer|min:0|max:20',
        //         'baths'=>'required|integer|min:0|max:20',
        //         'area'=>'required|integer|min:10|max:2000',
        //         'street'=>'required|integer|min:0|max:20',
        //         'price'=>'required|integer|min:0|max:20',
        //     ])
        // ]);




        // If validation passes, create the Listing
        // Listing::create([
        //     ... $request->all(),
        //     ... $validatedData

        // ]);

        Listing::create(
            $request->validate([
                'beds' => 'required|integer|min:0|max:20',
                'baths' => 'required|integer|min:0|max:20',
                'area' => 'required|integer|min:15|max:1500',
                'city' => 'required',
                'code' => 'required',
                'street' => 'required',
                'street_nr' => 'required|min:1|max:1000',
                'price' => 'required|integer|min:1|max:20000000',
                'by_user_id' => 'required|integer|min:1|max:100',
            ])
        );
        return redirect()->route('mylist')->with('success','Listing  created');
    }


    public function edit(Listing $listing)
    {


        return inertia(
            'Dev/Edit',
            [
                'listing' => $listing
            ]
        );
    }

    public function update(Request $request, Listing $listing)
    {
        //
        $listing->update(
            $request->validate([
                'beds' => 'required|integer|min:0|max:20',
                'baths' => 'required|integer|min:0|max:20',
                'area' => 'required|integer|min:15|max:1500',
                'city' => 'required',
                'code' => 'required',
                'street' => 'required',
                'street_nr' => 'required|min:1|max:1000',
                'price' => 'required|integer|min:1|max:20000000',
            ])
        );
        return redirect()->route('mylist')
            ->with('success', 'Listing was changed!');
    }


    public function destroy(Listing $listing){
        $listing->delete();


        return redirect()->back()
        ->with('success', 'Listing was deleted!');
    }
}
