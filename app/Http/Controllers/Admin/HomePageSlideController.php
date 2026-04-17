<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomePageSlide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class HomePageSlideController extends Controller
{
    public function index()
    {
        $slides = HomePageSlide::query()
            ->orderBy('sort_order')
            ->orderBy('id')
            ->paginate(12);

        return view('admin.home-page-slides.index', compact('slides'));
    }

    public function create()
    {
        $slide = new HomePageSlide();

        return view('admin.home-page-slides.create', compact('slide'));
    }

    public function store(Request $request)
    {
        $data = $this->validateSlide($request, true);
        $data['image_path'] = $this->storeSlideImage($request);

        HomePageSlide::create($data);

        return redirect()
            ->route('admin.home-page-slides.index')
            ->with('success', 'Home page slide created.');
    }

    public function edit(HomePageSlide $home_page_slide)
    {
        $slide = $home_page_slide;

        return view('admin.home-page-slides.edit', compact('slide'));
    }

    public function update(Request $request, HomePageSlide $home_page_slide)
    {
        $data = $this->validateSlide($request, false);
        $newImagePath = $this->storeSlideImage($request);

        if ($newImagePath) {
            if ($home_page_slide->image_path) {
                Storage::disk('public')->delete($home_page_slide->image_path);
            }

            $data['image_path'] = $newImagePath;
        }

        $home_page_slide->update($data);

        return redirect()
            ->route('admin.home-page-slides.index')
            ->with('success', 'Home page slide updated.');
    }

    public function destroy(HomePageSlide $home_page_slide)
    {
        if ($home_page_slide->image_path) {
            Storage::disk('public')->delete($home_page_slide->image_path);
        }

        $home_page_slide->delete();

        return redirect()
            ->route('admin.home-page-slides.index')
            ->with('success', 'Home page slide deleted.');
    }

    protected function validateSlide(Request $request, bool $isCreate): array
    {
        $photoRule = $isCreate ? 'required_without:cropped_image' : 'nullable';

        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:500'],
            'sort_order' => ['required', 'integer', 'min:0'],
            'photo' => [$photoRule, 'nullable', 'image', 'max:5120'],
            'cropped_image' => ['nullable', 'string'],
        ]);
    }

    protected function storeSlideImage(Request $request): ?string
    {
        $croppedImage = $request->input('cropped_image');

        if ($croppedImage) {
            return $this->storeCroppedImage($croppedImage);
        }

        if ($request->hasFile('photo')) {
            return $request->file('photo')->store('home-page-slides', 'public');
        }

        return null;
    }

    protected function storeCroppedImage(string $dataUrl): string
    {
        if (!preg_match('/^data:image\/(png|jpe?g|webp);base64,/', $dataUrl, $matches)) {
            throw ValidationException::withMessages([
                'photo' => 'The cropped image format is invalid.',
            ]);
        }

        $binary = base64_decode(substr($dataUrl, strpos($dataUrl, ',') + 1), true);

        if ($binary === false || !@getimagesizefromstring($binary)) {
            throw ValidationException::withMessages([
                'photo' => 'The cropped image data could not be processed.',
            ]);
        }

        $extension = $matches[1] === 'jpeg' ? 'jpg' : $matches[1];
        $path = 'home-page-slides/' . Str::uuid() . '.' . $extension;

        Storage::disk('public')->put($path, $binary);

        return $path;
    }
}
