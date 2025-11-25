<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminAdRequest;
use App\Models\Ad;
use App\Services\Admin\AdminAdService;
use Illuminate\Http\Request;

class AdminAdController extends Controller
{
    public function __construct(
        protected readonly AdminAdService $service,
    ) {}

    /**
     * Lista svih oglasa u admin panelu.
     */
    public function index(Request $request)
    {
        $perPage = (int) $request->get('per_page', 20);

        $ads = $this->service->listAds($perPage, true);

        return view('admin.ads.index', compact('ads'));
    }

    /**
     * Forma za kreiranje novog oglasa.
     */
    public function create()
    {
        $formData = $this->service->getFormData();

        return view('admin.ads.create', $formData);
    }

    /**
     * Snimanje novog oglasa.
     */
    public function store(AdminAdRequest $request)
    {
        $data = $request->validated();
        $image = $request->file('image');

        $ad = $this->service->create($data, $image);

        return redirect()
            ->route('ads.edit', $ad)
            ->with('success', 'Oglas je uspešno kreiran.');
    }

    /**
     * Forma za uređivanje postojeće oglasa.
     */
    public function edit(Ad $ad)
    {
        $formData = $this->service->getFormData();

        return view('admin.ads.edit', array_merge($formData, [
            'ad' => $ad,
        ]));
    }

    /**
     * Ažuriranje oglasa.
     */
    public function update(AdminAdRequest $request, Ad $ad)
    {
        $data = $request->validated();
        $image = $request->file('image');

        $this->service->update($ad, $data, $image);

        return redirect()
            ->route('admin.ads.edit', $ad)
            ->with('success', 'Oglas je uspešno ažuriran.');
    }

    /**
     * Brisanje oglasa.
     */
    public function destroy(Ad $ad)
    {
        $this->service->delete($ad);

        return redirect()
            ->route('admin.ads.index')
            ->with('success', 'Oglas je uspešno obrisan.');
    }

    /**
     * Vracanje obrisanih oglasa.
     */
    public function restore(int $id)
    {
        $ad = Ad::withTrashed()->findOrFail($id);

        $ad->restore();

        return redirect()
            ->route('admin.ads.index')
            ->with('success', 'Oglas je uspešno vraćen.');
    }
}
