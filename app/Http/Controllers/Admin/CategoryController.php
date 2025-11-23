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
        $parents = $this->service->getAllForParentSelect();

        return view('admin.categories.create', compact('parents'));
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
     * Prikazi pojedinacne kategorije
     */
    public function show(Category $category)
    {
        $category->load([
            'parent',
            'parent.parent',
            'children',
            'children.children',
            'ads' => function ($query) {
                $query->latest()->limit(10); 
            },
        ]);

        return view('admin.categories.show', compact('category'));
    }

    /**
     * Forma za edit postojeće kategorije.
     */
    public function edit(Category $category)
    {
        $parents = $this->service->getAllForParentSelect($category);

        return view('admin.categories.edit', compact('category', 'parents'));
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
