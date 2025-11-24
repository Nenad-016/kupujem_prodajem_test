<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdRequest;
use App\Models\Ad;
use App\Models\Category;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Services\AdService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

class AdController extends Controller
{
    public function __construct(
        protected readonly AdService $service,
        protected readonly CategoryRepositoryInterface $categories,
    ) {}

   public function index(Request $request)
    {
        $ads  = $this->service->listPublicAds(15, $this->buildFilters($request));
        $cats = $this->categories->getAllWithCounts();

        return view('ads.index', compact('ads', 'cats'));
    }

    public function show(Request $request, Ad $ad)
    {
        $user = $request->user();

        $status = is_string($ad->status) ? $ad->status : $ad->status->value;

        if ($status !== 'active') {
            if (! $user || ($user->role !== 'admin' && $ad->user_id !== $user->id)) {
                abort(404);
            }
        }

        $moreFromUser = Ad::query()
            ->with('category.parent.parent')
            ->where('user_id', $ad->user_id)
            ->where('id', '!=', $ad->id)
            ->orderByDesc('created_at')
            ->limit(4)
            ->get();

        return view('ads.show', [
            'ad' => $ad,
            'moreFromUser' => $moreFromUser,
        ]);
    }

    public function myAds(Request $request)
    {
        $ads = $this->service->listUserAds($request->user());

        return view('ads.my', compact('ads'));
    }

    public function create()
    {
        $categories = $this->categories->all();

        return view('ads.create', compact('categories'));
    }

    public function store(AdRequest $request)
    {
        try {
            $data = $request->validated();

            if ($request->hasFile('image')) {
                $data['image_path'] = $request->file('image')->store('ads', 'public');
            }

            $ad = $this->service->createForUser($request->user(), $data);

            return redirect()
                ->route('ads.show', $ad)
                ->with('success', 'Oglas je uspešno kreiran.');
        } catch (Throwable $e) {
            Log::error('Greška pri kreiranju oglasa', ['error' => $e->getMessage()]);

            return back()
                ->withInput()
                ->with('error', 'Došlo je do greške pri kreiranju oglasa. Pokušajte ponovo.');
        }
    }

    public function edit(Request $request, Ad $ad)
    {
        if ($request->user()->id !== $ad->user_id && $request->user()->role !== 'admin') {
            abort(403);
        }

        $categories = $this->categories->all();

        return view('ads.edit', compact('ad', 'categories'));
    }

    public function update(AdRequest $request, Ad $ad)
    {
        try {
            $data = $request->validated();

            if ($request->hasFile('image')) {
                $data['image_path'] = $request->file('image')->store('ads', 'public');
            }

            $this->service->updateAd($ad, $request->user(), $data);

            return redirect()
                ->route('ads.show', $ad)
                ->with('success', 'Oglas je uspešno ažuriran.');
        } catch (Throwable $e) {
            Log::error('Greška pri ažuriranju oglasa', ['error' => $e->getMessage()]);

            return back()
                ->withInput()
                ->with('error', 'Došlo je do greške pri ažuriranju oglasa.');
        }
    }

    public function destroy(Request $request, Ad $ad)
    {
        try {
            $this->service->deleteAd($ad, $request->user());

            return redirect()
                ->route('ads.my')
                ->with('success', 'Oglas je uspešno obrisan.');
        } catch (Throwable $e) {
            Log::error('Greška pri brisanju oglasa', ['error' => $e->getMessage()]);

            return back()
                ->with('error', 'Došlo je do greške pri brisanju oglasa.');
        }
    }

    public function byCategory(Request $request, Category $category)
    {
        $ads  = $this->service->listPublicAds(15, $this->buildFilters($request, $category->id));
        $cats = $this->categories->getAllWithCounts();

        return view('ads.index', [
            'ads'             => $ads,
            'cats'            => $cats,
            'currentCategory' => $category,
        ]);
    }

    private function buildFilters(Request $request, ?int $forcedCategoryId = null): array
    {
        return [
            'q'          => $request->get('q'),
            'location'   => $request->get('location'),
            'category_id'=> $forcedCategoryId ?? $request->get('category_id'),
            'price_min'  => $request->get('price_min'),
            'price_max'  => $request->get('price_max'),
        ];
    }
}
