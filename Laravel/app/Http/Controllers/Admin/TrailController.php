<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Telepules;
use App\Models\Ut;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TrailController extends Controller
{
    public function index(): View
    {
        return view('admin.trails.index', [
            'trails' => Ut::with('telepules')->orderBy('nev')->paginate(15),
        ]);
    }

    public function create(): View
    {
        return view('admin.trails.form', [
            'trail' => new Ut(),
            'towns' => Telepules::orderBy('nev')->get(),
            'heading' => 'Új tanösvény',
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        Ut::create($this->validated($request));

        return redirect()->route('admin.utak.index')->with('status', 'A tanösvényt elmentettük.');
    }

    public function edit(Ut $ut): View
    {
        return view('admin.trails.form', [
            'trail' => $ut,
            'towns' => Telepules::orderBy('nev')->get(),
            'heading' => 'Tanösvény szerkesztése',
        ]);
    }

    public function update(Request $request, Ut $ut): RedirectResponse
    {
        $ut->update($this->validated($request));

        return redirect()->route('admin.utak.index')->with('status', 'A módosításokat elmentettük.');
    }

    public function destroy(Ut $ut): RedirectResponse
    {
        $ut->delete();

        return redirect()->route('admin.utak.index')->with('status', 'A tanösvényt töröltük.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'nev' => ['required', 'string', 'max:255'],
            'hossz' => ['required', 'numeric', 'min:0', 'max:999999'],
            'allomas' => ['required', 'integer', 'min:0', 'max:65535'],
            'ido' => ['required', 'numeric', 'min:0', 'max:9999'],
            'vezetes' => ['required', 'boolean'],
            'telepulesid' => ['required', 'integer', 'exists:telepules,id'],
        ]);
    }
}