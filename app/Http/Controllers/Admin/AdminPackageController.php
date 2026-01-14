<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\PackageGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Form;
use Illuminate\Support\Facades\Storage;

class AdminPackageController extends Controller
{


       /* ===============================
     * INDEX
     * =============================== */
    public function index()
    {
        $packages = Package::latest()->paginate(12);

 

        return view('admin.packages.index', compact('packages'));
    }

    /* ===============================
     * CREATE
     * =============================== */
    public function create()
    {
        return view('admin.packages.create', [
            'package' => new Package(),
            'forms'   => Form::where('is_active', true)->get(),
        ]);
    }



    public function show(Package $package)
    {
        // $package->load('gallery');
        $package->gallery()->latest()->get();


        $itinerary = collect($package->itinerary ?? []);

        return view('admin.packages.show', compact('package', 'itinerary'));
    }

    /* ===============================
     * STORE
     * =============================== */
    public function store(Request $request)
    {


        // dd($request->all());
        // exit;
 
        $data = $this->validatedData($request);

        // Images
        if ($request->hasFile('thumbnail_image')) {
            $data['thumbnail_image'] = $request->file('thumbnail_image')
                ->store('packages/thumbnails', 'public');
        }

        if ($request->hasFile('hero_image')) {
            $data['hero_image'] = $request->file('hero_image')
                ->store('packages/heroes', 'public');
        }

        // Itinerary
        $data['itinerary'] = $request->filled('itinerary_json')
            ? json_decode($request->itinerary_json, true)
            : [];

        //Form
        //$data['form_id'] = $request->form_id;


        $package = Package::create($data);

        // Gallery images
        $this->storeGalleryImages($request, $package);

        return redirect()
            ->route('admin.packages.index')
            ->with('success', 'Package created successfully.');
    }

    /* ===============================
     * EDIT
     * =============================== */
    public function edit(Package $package)
    {
        // $package->load('gallery');

        // return view('admin.packages.edit', compact('package'));


        $package->load('gallery');

        // itinerary stored as JSON
        $package->itinerary = $package->itinerary ?? [];
        

        $forms =  Form::where('is_active', true)->get();

        return view('admin.packages.edit', compact('package','forms'));




    }

    /* ===============================
     * UPDATE
     * =============================== */
    public function update(Request $request, Package $package)
    {

        //  dd($request->all());
        // exit;
        $data = $this->validatedData($request);

        // Replace thumbnail
        if ($request->hasFile('thumbnail_image')) {
            if ($package->thumbnail_image) {
                Storage::disk('public')->delete($package->thumbnail_image);
            }

            $data['thumbnail_image'] = $request->file('thumbnail_image')
                ->store('packages/thumbnails', 'public');
        }

        // Replace hero
        if ($request->hasFile('hero_image')) {
            if ($package->hero_image) {
                Storage::disk('public')->delete($package->hero_image);
            }

            $data['hero_image'] = $request->file('hero_image')
                ->store('packages/heroes', 'public');
        }

        // Itinerary
        $data['itinerary'] = $request->filled('itinerary_json')
            ? json_decode($request->itinerary_json, true)
            : [];
        
        //Form
       // $data['form_id'] = $request->form_id;


        $package->update($data);

        // Delete selected gallery images
        if ($request->filled('delete_gallery_ids')) {
            $images = PackageGallery::whereIn('id', $request->delete_gallery_ids)->get();

            foreach ($images as $img) {
                Storage::disk('public')->delete($img->image_path);
                $img->delete();
            }
        }

        // Add new gallery images
        $this->storeGalleryImages($request, $package);

        return redirect()
            ->route('admin.packages.index')
            ->with('success', 'Package updated successfully.');
    }

    /* ===============================
     * DESTROY
     * =============================== */
    public function destroy(Package $package)
    {
        // Delete images
        if ($package->thumbnail_image) {
            Storage::disk('public')->delete($package->thumbnail_image);
        }

        if ($package->hero_image) {
            Storage::disk('public')->delete($package->hero_image);
        }

        foreach ($package->gallery as $img) {
            Storage::disk('public')->delete($img->image_path);
            $img->delete();
        }

        $package->delete();

        return redirect()
            ->route('admin.packages.index')
            ->with('success', 'Package deleted successfully.');
    }

    /* ===============================
     * HELPERS
     * =============================== */

    protected function validatedData(Request $request): array
    {
        return $request->validate([
            'name'           => 'required|string|max:255',
            'subtitle'       => 'nullable|string|max:255',
            'description'    => 'nullable|string',
            'duration_days'  => 'nullable|integer|min:1',
            'is_active'      => 'nullable|boolean',
            'itinerary_json'      => 'nullable|json',
            'form_id'       => ['nullable', 'exists:forms,id'], // ✅ REQUIRED
        ]);
    }

    protected function storeGalleryImages(Request $request, Package $package): void
    {
        if (!$request->hasFile('gallery_images')) return;

        foreach ($request->file('gallery_images') as $file) {
            $path = $file->store('packages/gallery', 'public');

            $package->gallery()->create([
                'image_path' => $path,
            ]);
        }
    }



}
