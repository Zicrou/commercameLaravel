<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vente;
use Illuminate\Http\Request;

class JournalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Query all ventes and group them by month
        // Query all ventes and group them by year and month
        // $ventes = Vente::query()
        //     ->selectRaw('strftime("%Y", created_at) as year, strftime("%m", created_at) as month, id, nombre, prix, statut, user_id, produit_id, probleme')
        //     ->groupBy('year', 'month')
        //     ->orderBy('year', 'desc')
        //     ->orderBy('month', 'desc'); //->get(['id', 'nombre', 'prix', 'statut', 'user_id', 'produit_id', 'probleme']);

        // $ventes = Vente::selectRaw('strftime("%Y", created_at) as year, strftime("%m", created_at) as month, COUNT(*) as count')
        //     ->groupBy('year', 'month')
        //     ->orderBy('year', 'desc')
        //     ->orderBy('month', 'desc');
        //  dd($ventes->first()->year);
        return view("admin.journaux.index", [
            'ventes' =>  Vente::where('statut', 1)->orderBy('year', 'desc')->orderBy('month', 'desc')->paginate(10),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
