<?php

namespace App\Http\Controllers;

use App\Models\Np;
use App\Models\Telepules;
use App\Models\Ut;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TrailController extends Controller
{
    public function home(): View
    {
        return view('home', [
            'trailCount' => Ut::count(),
            'townCount' => Telepules::count(),
            'parkCount' => Np::count(),
            'featuredTrails' => Ut::with('telepules.np')->orderBy('nev')->take(3)->get(),
        ]);
    }

    public function index(Request $request): View
    {
        $filters = $request->validate([
            'q' => ['nullable', 'string', 'max:100'],
            'park' => ['nullable', 'integer', 'exists:np,id'],
            'guided' => ['nullable', 'in:0,1'],
            'sort' => ['nullable', 'in:nev,hossz,ido'],
            'direction' => ['nullable', 'in:asc,desc'],
        ]);

        $trails = Ut::query()
            ->with('telepules.np')
            ->when($filters['q'] ?? null, function ($query, string $search): void {
                $query->where(function ($nested) use ($search): void {
                    $nested->where('nev', 'like', "%{$search}%")
                        ->orWhereHas('telepules', fn ($town) => $town->where('nev', 'like', "%{$search}%"));
                });
            })
            ->when(isset($filters['park']), fn ($query) => $query->whereHas('telepules', fn ($town) => $town->where('npid', $filters['park'])))
            ->when(isset($filters['guided']), fn ($query) => $query->where('vezetes', (bool) $filters['guided']))
            ->orderBy($filters['sort'] ?? 'nev', $filters['direction'] ?? 'asc')
            ->paginate(12)
            ->withQueryString();

        return view('trails.index', [
            'trails' => $trails,
            'parks' => Np::orderBy('nev')->get(),
            'filters' => $filters,
        ]);
    }

    public function chart(): View
    {
        $parks = Np::query()
            ->withCount('telepulesek')
            ->with('telepulesek.utak')
            ->orderBy('nev')
            ->get();

        return view('chart', [
            'chartLabels' => $parks->pluck('nev'),
            'trailCounts' => $parks->map(fn (Np $park) => $park->telepulesek->sum(fn (Telepules $town) => $town->utak->count())),
            'townCounts' => $parks->pluck('telepulesek_count'),
        ]);
    }
}