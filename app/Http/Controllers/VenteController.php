<?php

namespace App\Http\Controllers;;

use App\Http\Controllers\Controller;
use App\Http\Requests\VenteFormRequest;
use App\Http\Requests\SearchVentesRequest;
use App\Models\Produit;
use App\Models\Type;
use App\Models\User;
use App\Models\Vente;
use Illuminate\Http\Request;

class VenteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SearchVentesRequest $request)
    {
        
        
        $startDate = now()->startOfDay();
        $endDate = now()->endOfDay();
        $query = Vente::query()->whereBetween('created_at', [$startDate, $endDate])->where('statut', 1)->orderBy('created_at', 'desc');
        if ($price = $request->validated('price')) {
			$query->where('prix', '<=', $price);
		}
        if ($title = $request->validated('title')) {
            $query->with('produit')->whereHas('produit', function ($query) use ($title) {
                $query->where('titre', 'like', "%{$title}%");
            });
		}
        //  $totalOfTheDay = $query->sum("prix");
         $totalOfTheDay = 0;
         $totalVenteOfTheDay= 0;
         $totalReparationOfTheDay= 0;
         $totalVenteEtReparationOfTheDay= 0;
        $ventes = $query->get();
        foreach ($ventes as $vente){
            $total = $vente->prix * $vente->nombre;
            $totalOfTheDay += $total;
            $type_vente = $vente->types()->get();
            foreach ($type_vente as $tv) {
                // dd($tv->name);
                if($tv->id == 1){
                    $total = $vente->prix * $vente->nombre;
                    $totalVenteOfTheDay += $total;
                }elseif ($tv->id == 2) {
                    $total = $vente->prix * $vente->nombre;
                    $totalReparationOfTheDay += $total;
                }elseif ($tv->id == 4) {
                    $total = $vente->prix * $vente->nombre;
                    $totalVenteEtReparationOfTheDay += $total;
                }
            }
        }
		
        return view('ventes.index', [
			'ventes' => $query->paginate(3),
			'input'      => $request->validated(),
            'totalOfTheDay' => $totalOfTheDay,
            'totalVenteOfTheDay' => $totalVenteOfTheDay,
            'totalReparationOfTheDay' => $totalReparationOfTheDay,
            'totalVenteEtReparationOfTheDay' => $totalVenteEtReparationOfTheDay,
		]);

    //     $ventes = Vente::orderBy('created_at', 'desc')->paginate(1);
    //     return view("ventes.index",
    // ["ventes" => $ventes ]);
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
        $produits = Produit::pluck('titre', 'id');
        return view('ventes.form', [
            'vente' => $vente,
            'produits' => $produits,
            'types' => Type::pluck('name', 'id'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(VenteFormRequest $request)
    {
        $vente = Vente::create($request->validated());
        $vente->types()->sync($request->validated('types'));
        return to_route('boutique.vente.index')->with('success', 'La vente a été créée');
    }

    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vente $vente)
    {
        return view('ventes.form', [
            'vente' => $vente, 
            'types' => Type::pluck('name', 'id'),
            'produits' => Produit::pluck('titre', 'id'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(VenteFormRequest $request, Vente $vente)
    {
        $vente->update($request->validated());
        $vente->types()->sync($request->validated('types'));
        return to_route('boutique.vente.index')->with('success', 'La vente a été modifiée');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vente $vente)
    {
        $vente->update(['statut' => 0]);
        return to_route('boutique.vente.index')->with('success', 'La vente a été supprimée');
    }
}
