<?php

namespace App\Http\Controllers;;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\VenteFormRequest;
use App\Models\Type;
use App\Models\User;
use App\Models\Vente;
use Illuminate\Http\Request;

class VenteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ventes = Vente::orderBy('created_at', 'desc')->paginate(25);
        return view("ventes.index",
    ["ventes" => $ventes ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $vente = new Vente();
        $vente->fill([
            'user_id' => User::first()->id,
        ]);
        return view('ventes.form', [
            'vente' => $vente,
            //'types' => Type::pluck('name', 'id'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(VenteFormRequest $request)
    {
        
        $vente = Vente::create($request->validated());
        //$vente->types()->sync($request->validated('types'));
        return to_route('boutique.vente.index')->with('success', 'La vente a été créée');
    }

    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vente $vente)
    {
        return view('ventes.form', [
            'vente' => $vente, 
            'types' => Type::pluck('name', 'id'),]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(VenteFormRequest $request, Vente $vente)
    {
        $vente->update($request->validated());
        //$vente->types()->sync($request->validated('types'));
        return to_route('boutique.vente.index')->with('success', 'La vente a été modifiée');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vente $vente)
    {
        $vente->delete();
        return to_route('boutique.vente.index')->with('success', 'La vente a été supprimée');
    }
}
