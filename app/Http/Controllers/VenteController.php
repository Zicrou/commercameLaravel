<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VenteController extends Controller
{
    public function index()
    {
        return view('ventes.index', [
            // 'cours' => $query->paginate(16),
            // 'input' => $request->validated()
        ]);
    }

    public function create()
    {
        $cour = new Vente();
        return view('admin.cours.form', [
            'cour' => new Vente(),
        ]);
    }
}
