<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Rsvp;
use App\Models\Guest;
use App\Imports\GuestsImport;
use Maatwebsite\Excel\Facades\Excel;

class IndexController extends Controller
{
    public function init() {
        Excel::import(new GuestsImport, 'list.xlsx');
        return "Uploaded";
    }

    public function index() {
        return Inertia::render('Index');
    }

    public function thanks() {
        return Inertia::render('ThankYou');
    }

    public function store(Request $request) {

        // Alter phone number
        $payload = $request->all();
        $payload['phone'] = $request->code . '' . $request->phone;
        $request->replace($payload);

        $request->validate([
            'name' => 'required|string',
            'phone' => 'required|unique:rspvs',
            'phone' => 'required|exists:guests',
            'children' => 'required|array',
            'children.*.name' => 'required|string'
        ]);
        
        $guest = Guest::where('phone', $request->phone)->first();
        if(count($request->children) > $guest->total) {
            return redirect()->back()->withErrors(['children' => ['You can only enter max of ' . $guest->total . ' children']]);
        }

        $payload = $request->all();
        $children = '';
        foreach ($request->children as $key => $value) {
           $children = $children . $value['name'] . ', ';
        }

        $payload['children'] = trim($children);
        Rsvp::create($payload);

        //
        return redirect()->route('thanks')->with('message', 'Thank you for RSVP-ing');
    }

    public function dashboard() {
        return Inertia::render('Dashboard', [
            'models' => Rsvp::latest()->paginate(10)
        ]);
    }
}
