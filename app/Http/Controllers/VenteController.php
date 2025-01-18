<?php

namespace App\Http\Controllers;

use App\Models\Vente;
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
        $vente = new Vente();
        return view('ventes.create', [
            'vente' => new Vente(),
        ]);
    }

    public function store(Request $request)
    {
        $vente = new Vente();
        
    }
}
