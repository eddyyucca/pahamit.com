<?php

namespace App\Http\Controllers;

use App\Models\Series;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SeriesController extends Controller
{
    public function index(): View
    {
        $series = Series::withCount('posts')->latest()->paginate(20);
        return view('dashboard.series.index', compact('series'));
    }

    public function create(): View
    {
        return view('dashboard.series.form', ['series' => new Series(), 'method' => 'POST', 'formAction' => route('dashboard.series.store')]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'status'      => ['required', 'in:active,archived'],
        ]);
        $data['slug'] = Series::uniqueSlug($data['title']);
        Series::create($data);
        return redirect()->route('dashboard.series.index')->with('status', 'Seri berhasil ditambahkan.');
    }

    public function edit(Series $series): View
    {
        return view('dashboard.series.form', ['series' => $series, 'method' => 'PUT', 'formAction' => route('dashboard.series.update', $series)]);
    }

    public function update(Request $request, Series $series): RedirectResponse
    {
        $data = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'status'      => ['required', 'in:active,archived'],
        ]);
        $data['slug'] = Series::uniqueSlug($data['title'], $series->id);
        $series->update($data);
        return redirect()->route('dashboard.series.index')->with('status', 'Seri berhasil diperbarui.');
    }

    public function destroy(Series $series): RedirectResponse
    {
        $series->delete();
        return redirect()->route('dashboard.series.index')->with('status', 'Seri dihapus.');
    }
}
