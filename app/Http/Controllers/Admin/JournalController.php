<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vente;
use App\Models\Depense;
use Illuminate\Http\Request;

class JournalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $depenseTotal = 0;
        $queryDepenses = Depense::where('user_id', 1)->where('statut', 1)->orderBy('created_at', 'desc')->get();
        $queryDepensess = $queryDepenses->groupBy(function($m) {
            return $m->created_at->format('m-Y');
        });

        $vents = Vente::where('statut', 1)->get();
        $ventes = $vents->groupBy(function($m) {
            return $m->created_at->format('m-Y');
        });

        // $vents_year = Vente::where('statut', 1)->get();
        $ventes_year = $vents->groupBy(function($m) {
            return $m->created_at->format('Y');
        });
        
        return view("admin.journaux.index", [
            'ventes' =>   $ventes, 
            'ventes_year' =>   $ventes_year,
            'depenses' => $queryDepensess, 
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
