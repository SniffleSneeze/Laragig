<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{
    // show all listing
    public function index(): Factory|View|Application
    {
        return view('listings.index', [
            'listings' => Listing::latest()
                ->filter(request(['tag', 'search']))
                ->paginate(6) // paginate will give you number for the pagination, we can also use simplePaginate()
        ]);
    }

    // show single listing
    public function show(Listing $job): Factory|View|Application
    {
        return view('listings.show', ['job' => $job]);
    }

    // show create form
    public function create(): Factory|View|Application
    {
        return view('listings.create');
    }

    // store listing data
    public function store(Request $request): Redirector|Application|RedirectResponse
    {
        $formFields = $request->validate([
            'title' => 'required',
            'company' => [
                'required',
                Rule::unique('listings', 'company')
            ],
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required'
        ]);

        if($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }
        $formFields['user_id'] = auth()->id();

        Listing::create($formFields);

        // below is one way of doing the flash message
//        Session::flash('message', 'Listing Created');

        return redirect('/')->with('message', 'Listing created successfully!');
    }

    // show edit form
    public function edit(Listing $job): Factory|View|Application
    {
        return view('listings.edit', ['job' => $job]);
    }

    // update listing data
    public function update(Request $request, Listing $job): Redirector|Application|RedirectResponse
    {
        $formFields = $request->validate([
            'title'       => 'required',
            'company'     => 'required',
            'location'    => 'required',
            'website'     => 'required',
            'email'       => ['required', 'email'],
            'tags'        => 'required',
            'description' => 'required'
        ]);

        if($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }
//        dd($formFields);
        $job->update($formFields);

        // below is one way of doing the flash message
//        Session::flash('message', 'Listing Created');

        return back()->with('message', 'Listing updated successfully!');
    }

    // delete job
    public function destroy(Listing $job): Redirector|Application|RedirectResponse
    {
        $job->delete();
        return redirect('/')->with('message', 'Job delete successfully!');
    }

    // manage jobs
    public function manage(){
        return view('listings.manage', ['listings' => auth()->user()->listing()->get()]);
    }
}
