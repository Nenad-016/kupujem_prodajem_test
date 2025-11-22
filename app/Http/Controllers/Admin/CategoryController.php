<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct(
        protected readonly CategoryService $service,
    ) {}

    /**
     * Lista kategorija u admin panelu.
     */
    public function index(Request $request)
    {
        $perPage = (int) $request->get('per_page', 15);

        $categories = $this->service->paginateForAdmin($perPage);

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Forma za kreiranje kategorije.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Snimanje nove kategorije.
     */
    public function store(CategoryRequest $request)
    {
        $category = $this->service->create($request->validated());

        return redirect()
            ->route('admin.categories.edit', $category)
            ->with('success', 'Kategorija je uspešno kreirana.');
    }

    /**
     * Forma za edit postojeće kategorije.
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Ažuriranje kategorije.
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $this->service->update($category, $request->validated());

        return redirect()
            ->route('admin.categories.edit', $category)
            ->with('success', 'Kategorija je uspešno ažurirana.');
    }

    /**
     * Brisanje kategorije.
     */
    public function destroy(Category $category)
    {
        $this->service->delete($category);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Kategorija je uspešno obrisana.');
    }
}
