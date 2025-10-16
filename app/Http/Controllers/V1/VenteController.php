<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\VenteFormRequest;
use App\Http\Requests\SearchVentesRequest;
use App\Models\Produit;
use App\Models\Type;
use App\Models\User;
use App\Models\Vente;
use App\Models\Depense;
//use GuzzleHttp\Middleware;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;
use Laravel\Sanctum\PersonalAccessToken;


class VenteController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('auth:sanctum'),
        ];
    }
    
    /**
     * Display a listing of the resource.
     */
    // public function index(SearchVentesRequest $request)
    // {
    //     return Vente::all();
    // }
    public function index(Request $request)
   {        

    
    $req = $request->validate([
            'price' => ['numeric', 'gte:0', 'nullable'],
            // 'surface' => ['numeric', 'gte:0', 'nullable'],
            // 'rooms' => ['numeric', 'gte:0', 'nullable'],
            'title' => ['string', 'nullable'],
        
        ]);

        $tokenFromRequest = PersonalAccessToken::findToken($request->bearerToken());
      
        //$personalAccessToken = PersonalAccessToken::findToken($request->bearerToken());

   //     $session = session('user_id');
        $depenseTotal = 0;
        $startDate = now()->startOfDay();
        $endDate = now()->endOfDay();
        $queryDepenses = Depense::query()->whereBetween('created_at', [$startDate, $endDate])->where('user_id', $tokenFromRequest->tokenable_id)->orderBy('created_at', 'desc')->get();
        foreach ($queryDepenses as $qd ) {
            $depenseTotal += $qd->montant;
        }
        // dd($depenseTotal);
        
        $query = Vente::query()->whereBetween('created_at', [$startDate, $endDate])->where('user_id', $tokenFromRequest->tokenable_id)->orderBy('created_at', 'desc');

        if ($price = $request->validate(['price'])) {
			$query->where('prix', '<=', $price);
		}
        if ($title = $request->validate(['title'])) {
            $query->with('produit')->whereHas('produit', function ($query) use ($title) {
                $query->where('designation', 'like', "%{$title}%");
            });
		}

        $query = $query->with('types')->whereHas('types', function ($query) use ($request) {
            if ($typeId = $request->validate(['type_id'])) {
                $query->where('id', $typeId);
            }
        });

        $query = $query->with('produit');
        // ->whereHas('produit', function ($query) use ($request) {
        //     if ($produitID = $request->validate(['produit_id'])) {
        //         $query->where('id', $produitID);
        //     }
        // });
        //         $query->where('designation', 'like', "%{$title}%");
        //  $totalOfTheDay = $query->sum("prix");
        $totalOfTheDay = 0;
        $totalVenteOfTheDay= 0;
        $totalReparationOfTheDay= 0;
        
        $ventesAll = $query->get(); // Add Types in Query for GetListVentes
        $ventes = $ventesAll; // Get Types names for each Vente
        foreach ($ventesAll as $vente){
            $total = $vente->prix * $vente->nombre;
            $type_vente = $vente->types()->get(); // use $vente->types() pour get types of vente
            foreach ($type_vente as $tv) {
                
                if($tv->id == 0){
                    $totalVente = $vente->prix * $vente->nombre;
                    $totalVenteOfTheDay += $totalVente;
                }elseif ($tv->id == 1) {
                    $totalReparation = $vente->prix * $vente->nombre;
                    $totalReparationOfTheDay += $totalReparation;
                }
            }
        }
        
       $totalOfTheDay = $totalOfTheDay + $totalVenteOfTheDay + $totalReparationOfTheDay;
        return[
        //'personalAccessToken' =>  $tokenFromRequest->tokenable_id,
        // 'userSession' => Auth::id(), // or Auth::id(), //== $personalAccessToken->tokenable_id,
        'ventes' => $ventes, // Get Types names for each Vente
        'input'      => $req,
        'totalOfTheDay' => $totalOfTheDay,
        'totalVenteOfTheDay' => $totalVenteOfTheDay,
        'totalReparationOfTheDay' => $totalReparationOfTheDay,
        'depenseTotal' => $depenseTotal,
        "status" => "200",
		];
		
    //     return view('ventes.index', [
	// 		'ventes' => $query->paginate(2),
	// 		'input'      => $request->validated(),
    //         'totalOfTheDay' => $totalOfTheDay,
    //         'totalVenteOfTheDay' => $totalVenteOfTheDay,
    //         'totalReparationOfTheDay' => $totalReparationOfTheDay,
    //         'depenseTotal' => $depenseTotal,
	// 	]);

    //     $ventes = Vente::orderBy('created_at', 'desc')->paginate(1);
    //     return view("ventes.index",
    // ["ventes" => $ventes ]);
   }

    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //     $vente = new Vente();
    //     $vente->fill([
    //         'user_id' => User::first()->id,
    //     ]);
    //     $produits = Produit::pluck('designation', 'id');
        
    //     return view('ventes.form', [
    //         'vente' => $vente,
    //         'produits' => $produits,
    //         'types' => Type::pluck('name', 'id'),
    //         'produits' => $produits,
    //     ]);
    // }

    /**
     * Store a newly created resource in storage.
     */
    public function store(VenteFormRequest $request)
    {
        $request->validate([
            'nombre' => ['required', 'integer', 'min:1'],
            'prix' => ['required', 'integer', 'min:3'],
            'user_id' => ['exists:users,id', 'required'],
            'designation' => ['string', 'nullable'],
            'produit_id' => ['integer',  'nullable'],
            'type_id' => [ 'exists:types,id', 'required'],
            'image' => ['mimes:jpg,jpeg,png,webp'],
        ]); 

        //return $request->validated();
        
        $produit = Produit::where('id', $request->validated('produit_id'))->first();
        // $vente = $request->user()->vente()->create($field);
        // return $vente;
        
        if($request->validated(key: 'designation') and $produit){
            return ["message" => "Choisir entre Stock et Désignation"];
            //return redirect()->route('boutique.vente.create')->with('error', 'Choisir entre Stock et Désignation');
        }elseif ($request->validated('designation') or $produit) {
            if ($produit) {
                if ($produit->nombre < $request->validated('nombre')){
                    return [
                        "message" => "Pas assez de produit de le stock",
                        "status" => "503",];
                }else{
                    $vente = Vente::create($request->validated());
                    $produit->nombre -= $request->validated('nombre');
                    $produit->save();
                    //$vente->type_id = $request->validated('type_id');
                    return ["message" => "La vente a été créée avec succès",
                    "status" => "200",];
                }
            }else{

                $vente = Vente::create($request->validated());
                //$vente->type_id = $request->validated('type_id');
                return [
                    // "message" => "La vente a été créée avec succès",
                    "vente" => $vente,
                    "status" => "200",
                ];
            }
        }
    }

    

    public function show(Vente $vente){
        return $vente;
    }


    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(Vente $vente)
    // {
    //     return view('ventes.form', [
    //         'vente' => $vente, 
    //         'types' => Type::pluck('name', 'id'),
    //         'produits' => Produit::pluck('designation', 'id'),
    //     ]);
    // }

    /**
     * Update the specified resource in storage.
     */
    public function update(VenteFormRequest $request, Vente $vente)
    {  
        Gate::authorize('modify', $vente);

        $venteFromrequest = $request->validated();
        // $field = $request->validate([
        //     'nombre' => ['required', 'integer', 'min:1'],
        //     'prix' => ['required', 'integer', 'min:3'],
        //     'user_id' => ['exists:users,id', 'required'],
        //     'designation' => ['string', 'nullable'],
        //     'produit_id' => ['integer',  'nullable'],
        //     'types' => ['required'],
        //     'image' => ['mimes:jpg,jpeg,png,webp'],
        // ]);

        // $vente->update($field);
        // return $vente;

        //dd($request->validated()) ;
        if ($request->validated('produit_id')) {
            $produit = Produit::where('id', $request->validated('produit_id'))->where('nombre', '>', 0)->first();
            //return $produit;
            if ($produit->nombre < ($request->validated('nombre') - $vente->nombre)) {
                    return ["message" => "Pas assez de produit de le stock"];
                }
            if ($request->validated('nombre') > $vente->nombre) {
                $produit->nombre = $produit->nombre - ($request->validated('nombre') - $vente->nombre);
            }elseif ($request->validated('nombre') < $vente->nombre) {
                $produit->nombre = $produit->nombre + ($vente->nombre - $request->validated('nombre'));
            }
            $produit->save();
        }
        $vente->update($request->validated());
        // $vente->types()->sync($request->validated('types'));
        return [
            //'VenteFromRequest' => $venteFromrequest,
            'vente' => $vente,
            "status" => "200",
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vente $vente)
    {
        Gate::authorize('modify', $vente);
        $produit = Produit::find(id: $vente->produit_id);
        if($produit){
            $produit->nombre += $vente->nombre;
            $produit->save();
        }
        $vente->delete();
        return ['message' => 'La vente a été annulée',"status" => "200"];
    }
}
