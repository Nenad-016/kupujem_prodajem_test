<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ad;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminAdController extends Controller
{
    /**
     * Lista svih oglasa u admin panelu.
     */
    public function index(Request $request)
    {
        $perPage = (int) $request->get('per_page', 20);

        $ads = Ad::query()
            ->with(['user', 'category'])
            ->orderByDesc('created_at')
            ->paginate($perPage);

        return view('admin.ads.index', compact('ads'));
    }

    /**
     * Forma za kreiranje novog oglasa.
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $users = User::orderBy('name')->get();

        return view('admin.ads.create', compact('categories', 'users'));
    }

    /**
     * Snimanje novog oglasa.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'location' => ['nullable', 'string', 'max:255'],
            'status' => ['required', Rule::in(['draft', 'active', 'archived'])],
            'condition' => ['required', Rule::in(['new', 'used'])],
            'category_id' => ['required', 'exists:categories,id'],
            'user_id' => ['required', 'exists:users,id'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('ads', 'public');
            $data['image_path'] = $path;
        }

        $ad = Ad::create($data);

        return redirect()
            ->route('admin.ads.edit', $ad)
            ->with('success', 'Oglas je uspešno kreiran.');
    }

    /**
     * Forma za uređivanje postojeće oglasa.
     */
    public function edit(Ad $ad)
    {
        $categories = Category::orderBy('name')->get();
        $users = User::orderBy('name')->get();

        return view('admin.ads.edit', compact('ad', 'categories', 'users'));
    }

    /**
     * Ažuriranje oglasa.
     */
    public function update(Request $request, Ad $ad)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'location' => ['nullable', 'string', 'max:255'],
            'status' => ['required', Rule::in(['draft', 'active', 'archived'])],
            'condition' => ['required', Rule::in(['new', 'used'])],
            'category_id' => ['required', 'exists:categories,id'],
            'user_id' => ['required', 'exists:users,id'],
        ]);

        $ad->update($data);

        return redirect()
            ->route('admin.ads.edit', $ad)
            ->with('success', 'Oglas je uspešno ažuriran.');
    }

    /**
     * Brisanje oglasa.
     */
    public function destroy(Ad $ad)
    {
        $ad->delete();

        return redirect()
            ->route('admin.ads.index')
            ->with('success', 'Oglas je uspešno obrisan.');
    }
}
