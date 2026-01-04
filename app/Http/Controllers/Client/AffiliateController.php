<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Form;

class AffiliateController extends Controller
{
public function index()
{
    $form = Form::where('slug', 'affiliate-form')
        ->where('is_active', true)
        ->first(); // ❌ remove firstOrFail()

    $sections = collect();

    if ($form) {
        $sections = $form->fields()
            ->orderBy('sort_order')
            ->get()
            ->groupBy(fn ($f) => $f->section_title ?: 'Form');
    }

    return view('client.affiliate-program.index', compact('form', 'sections'));
}

}
