<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Package;
use App\Models\Event;
use App\Models\HomePageSlide;

class HomeController extends Controller
{
    public function index()
    {
        $heroSlides = HomePageSlide::query()
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        $packages = Package::query()
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->take(9) // same count as your static grid
            ->get();

        $activeEvents = Event::where('status', 'active')
            ->orderBy('start_date')
            ->get();

        $upcomingEvents = Event::where('status', 'upcoming')
            ->orderBy('start_date')
            ->get();

        return view('client.home', compact('heroSlides', 'packages', 'activeEvents', 'upcomingEvents'));
    }


    public function packages()
    {
        $packages = Package::where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->paginate(12);



        return view('client.packages.index', compact('packages'));
    }

    // public function show(Package $package)
    // {
    //     abort_unless($package->is_active, 404);

    //     $package->load(['gallery', 'form.fields']);

    //     $sections = null;

    //     if ($package->form) {
    //         $sections = $package->form->fields
    //             ->sortBy('sort_order')
    //             ->groupBy(fn ($f) => $f->section_title ?: 'Form');
    //     }

    //     return view('client.packages.show', compact('package', 'sections'));
    // }

    public function show(Package $package)
{
    $form = null;
    $sections = collect();

    if ($package->form_id) {
        $form = $package->form()
            ->where('is_active', true)
            ->first();

        if ($form) {
            $sections = $form->fields()
                ->orderBy('sort_order')
                ->get()
                ->groupBy(fn ($f) => $f->section_title ?: 'Form');
        }
    }

    return view('client.packages.show', compact(
        'package',
        'form',
        'sections'
    ));
}





}
