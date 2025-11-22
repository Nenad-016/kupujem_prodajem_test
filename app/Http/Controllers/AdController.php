<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdRequest;
use App\Models\Ad;
use App\Models\Category;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Services\AdService;
use Illuminate\Http\Request;

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

        $ads = $this->service->listPublicAds($perPage);
        $cats = $this->categories->getAllWithCounts();

        return view('ads.index', compact('ads', 'cats'));
    }

    /**
     * Oglasi po kategoriji.
     */
    public function byCategory(Request $request, Category $category)
    {
        $perPage = (int) $request->get('per_page', 15);

        $ads = $this->service->listPublicAdsByCategory($category, $perPage);

        return view('ads.by-category', compact('ads', 'category'));
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
        $ad = $this->service->createForUser($request->user(), $request->validated());

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
        $this->service->updateAd($ad, $request->user(), $request->validated());

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
