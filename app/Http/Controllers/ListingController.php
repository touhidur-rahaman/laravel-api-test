<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{
    // show all listings
    public function index(){
        // dd(request('tag'));

        return view('listings.index', [
        'listings' => Listing::latest()->filter(request(['tag', 'search']))->paginate(6)
    ]);
    }

    // show single listing
    public function show(Listing $listing){
        return view('listings.show', [
            'listing'=>$listing
         ]);
    }

    // show create listing
    public function create(){
        return view('listings.create');
    }

    // store listing
    public function store(Request $request){
        // dd($request->file('logo')->store('file'));
        $formFields = $request->validate([
            'title' => 'required',
            'company' => ['required', Rule::unique('listings','company')],
            'location' => 'required',
            'email' => ['required', 'email'], 
            'website' => 'required',
            'tags' => 'required',
            'description' => 'required',
        ]);

        if($request->hasFile('logo')){
            $formFields['logo']= $request->file('logo')->store('logos','public');
        }

        $formFields['user_id'] = auth()->id();
        // dd($formFields);

        Listing::create($formFields);

        return redirect('/')->with('message',"Listing created successfully!");
    }

    // Show Edit Form
    public function edit(Listing $listing){
        return view('listings.edit',['listing' => $listing]);
    }

    // update listing
    public function update(Request $request, Listing $listing){
        // dd($request->file('logo')->store('file'));
        $formFields = $request->validate([
            'title' => 'required',
            'company' => ['required'],
            'location' => 'required',
            'email' => ['required', 'email'], 
            'website' => 'required',
            'tags' => 'required',
            'description' => 'required',
        ]);

        if($request->hasFile('logo')){
            $formFields['logo']= $request->file('logo')->store('logos','public');
        }
        // dd($formFields);

        $listing->update($formFields);

        return back()->with('message',"Listing updated");
    }

    // 
    public function destroy(Listing $listing){
        $listing->delete();
        return redirect('/')->with('message','Listing Deleted');
    }
}
