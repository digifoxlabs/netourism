<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PackageCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PackageCategoryController extends Controller
{
    public function index(): View
    {
        $categories = PackageCategory::query()
            ->withCount('packages')
            ->orderBy('name')
            ->get();

        return view('admin.packages.categories.index', [
            'categories' => $categories,
            'category' => new PackageCategory(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);

        PackageCategory::create($data);

        return redirect()
            ->route('admin.package-categories.index')
            ->with('success', 'Category created successfully.');
    }

    public function edit(PackageCategory $packageCategory): View
    {
        return view('admin.packages.categories.edit', [
            'category' => $packageCategory,
        ]);
    }

    public function update(Request $request, PackageCategory $packageCategory): RedirectResponse
    {
        $data = $this->validatedData($request, $packageCategory->id);

        $packageCategory->update($data);

        return redirect()
            ->route('admin.package-categories.index')
            ->with('success', 'Category updated successfully.');
    }

    public function destroy(PackageCategory $packageCategory): RedirectResponse
    {
        $fallbackCategory = null;

        if ($packageCategory->packages()->exists()) {
            $fallbackCategory = PackageCategory::query()
                ->whereKeyNot($packageCategory->id)
                ->orderByRaw("CASE WHEN slug = ? THEN 0 ELSE 1 END", [Str::slug('India Trip')])
                ->orderBy('name')
                ->first();

            if (!$fallbackCategory) {
                $fallbackCategory = PackageCategory::defaultCategory();
            }

            $packageCategory->packages()->update([
                'category_id' => $fallbackCategory->id,
            ]);
        }

        $packageCategory->delete();

        return redirect()
            ->route('admin.package-categories.index')
            ->with('success', 'Category deleted successfully.');
    }

    protected function validatedData(Request $request, ?int $ignoreId = null): array
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('package_categories', 'name')->ignore($ignoreId),
            ],
        ]);

        $slug = Str::slug($request->input('name'));

        validator(
            ['slug' => $slug],
            [
                'slug' => [
                    'required',
                    Rule::unique('package_categories', 'slug')->ignore($ignoreId),
                ],
            ]
        )->validate();

        return [
            'name' => $request->input('name'),
            'slug' => $slug,
        ];
    }
}
