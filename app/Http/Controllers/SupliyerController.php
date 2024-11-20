<?php

namespace App\Http\Controllers;

use App\Models\Supliyer;
use Illuminate\Http\Request;

class SupliyerController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search', '');
        $entries = $request->get('entries', 10);
        $supliyers = Supliyer::when($search, function ($query, $search) {
            $query->where('nama', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%')
                ->orWhere('telepon', 'like', '%' . $search . '%')
                ->orWhere('alamat', 'like', '%' . $search . '%');
        })->paginate($entries);
        $supliyers->appends([
            'search' => $search,
            'entries' => $entries,
        ]);
        return view('supliyer.index', compact('supliyers', 'search', 'entries'));
    }


    public function create()
    {
        return view('supliyer.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|max:255',
            'email' => 'nullable|email|max:255',
            'telepon' => 'nullable|max:50',
            'alamat' => 'nullable',
        ]);

        Supliyer::create($request->all());

        return redirect()->route('supliyer.index')->with('success', 'Supliyer created successfully!');
    }

    public function edit($id)
    {
        $supliyer = Supliyer::findOrFail($id);
        return view('supliyer.edit', compact('supliyer'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|max:255',
            'email' => 'nullable|email|max:255',
            'telepon' => 'nullable|max:50',
            'alamat' => 'nullable',
        ]);

        $supliyer = Supliyer::findOrFail($id);
        $supliyer->update($request->all());

        return redirect()->route('supliyer.index')->with('success', 'Supliyer updated successfully!');
    }

    public function destroy($id)
    {
        $supliyer = Supliyer::findOrFail($id);
        $supliyer->delete();

        return redirect()->route('supliyer.index')->with('success', 'Supliyer deleted successfully!');
    }
}
