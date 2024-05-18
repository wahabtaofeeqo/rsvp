<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Rsvp;

class IndexController extends Controller
{
    public function index() {
        return Inertia::render('Index');
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string',
            'phone' => 'required|string',
            'children' => 'required|array',
            'children.*.name' => 'required|string'
        ]);

        $payload = $request->all();
        $children = '';
        foreach ($request->children as $key => $value) {
           $children = $children . $value['name'] . ', ';
        }

        $payload['children'] = trim($children);
        Rsvp::create($payload);

        //
        return redirect()->back()->with('message', 'Thank you for RSVP-ing');
    }

    public function dashboard() {
        return Inertia::render('Dashboard', [
            'models' => Rsvp::latest()->paginate(10)
        ]);
    }
}
