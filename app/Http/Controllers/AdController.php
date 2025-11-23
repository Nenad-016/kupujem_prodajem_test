<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdRequest;
use App\Models\Ad;
use App\Models\Category;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Services\AdService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdController extends Controller
{
    public function __construct(
        protected readonly AdService $service,
        protected readonly CategoryRepositoryInterface $categories,
    ) {}

    /**
     * Početna strana – javni oglasi.
     */
    public function index(Request $request)
    {
        $perPage = (int) $request->get('per_page', 15);

        $filters = [
            'q' => $request->get('q'),
            'location' => $request->get('location'),
            'category_id' => $request->get('category_id'),
            'price_min' => $request->get('price_min'),
            'price_max' => $request->get('price_max'),
        ];

        $ads = $this->service->listPublicAds($perPage, $filters);
        $cats = $this->categories->getAllWithCounts();

        return view('ads.index', compact('ads', 'cats'));
    }

    /**
     * Oglasi po kategoriji.
     */
    public function byCategory(Request $request, Category $category)
    {
        $perPage = (int) $request->get('per_page', 15);

        $filters = [
            'q' => $request->get('q'),
            'location' => $request->get('location'),
            'price_min' => $request->get('price_min'),
            'price_max' => $request->get('price_max'),
            'category_id' => $category->id,
        ];

        $ads = $this->service->listPublicAds($perPage, $filters);

        $cats = Category::query()
            ->withCount('ads')
            ->orderBy('name')
            ->get();

        return view('ads.index', [
            'ads' => $ads,
            'cats' => $cats,
            'currentCategory' => $category,
        ]);
    }

    /**
     * Prikaz pojedinačnog oglasa.
     * Ako nije active → samo vlasnik i admin mogu da vide.
     */
    public function show(Request $request, Ad $ad)
    {
        $user = $request->user();

        if ($ad->status->value !== 'active') {
            if (! $user || ($user->role !== 'admin' && $ad->user_id !== $user->id)) {
                abort(404);
            }
        }

        return view('ads.show', compact('ad'));
    }

    /**
     * Moji oglasi (dashboard).
     */
    public function myAds(Request $request)
    {
        $ads = $this->service->listUserAds($request->user());

        return view('ads.my', compact('ads'));
    }

    /**
     * Forma za kreiranje.
     */
    public function create()
    {
        $categories = $this->categories->all();

        return view('ads.create', compact('categories'));
    }

    /**
     * Snimanje novog oglasa.
     */
    public function store(AdRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('ads', 'public');
        }

        $ad = $this->service->createForUser($request->user(), $data);

        return redirect()
            ->route('ads.show', $ad)
            ->with('success', 'Oglas je uspešno kreiran.');
    }

    /**
     * Forma za edit.
     */
    public function edit(Request $request, Ad $ad)
    {
        if ($request->user()->id !== $ad->user_id && $request->user()->role !== 'admin') {
            abort(403);
        }

        $categories = $this->categories->all();

        return view('ads.edit', compact('ad', 'categories'));
    }

    /**
     * Update oglasa.
     */
    public function update(AdRequest $request, Ad $ad)
    {
        $data = $request->validated();

        // Ako korisnik uploaduje novu sliku
        if ($request->hasFile('image')) {
            // Po želji obriši staru sliku
            if ($ad->image_path) {
                Storage::disk('public')->delete($ad->image_path);
            }

            $data['image_path'] = $request->file('image')->store('ads', 'public');
        }

        $this->service->updateAd($ad, $request->user(), $data);

        return redirect()
            ->route('ads.show', $ad)
            ->with('success', 'Oglas je uspešno ažuriran.');
    }

    /**
     * Brisanje oglasa.
     */
    public function destroy(Request $request, Ad $ad)
    {
        $this->service->deleteAd($ad, $request->user());

        return redirect()
            ->route('ads.my')
            ->with('success', 'Oglas je uspešno obrisan.');
    }
}
