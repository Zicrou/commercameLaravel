<?php

namespace App\Http\Controllers\V1;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produit;
use App\Http\Requests\Admin\ProduitFormRequest;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\File;

use Illuminate\Routing\Controllers\Middleware;
use Laravel\Sanctum\PersonalAccessToken;

use App\Models\Vente;
use Illuminate\Support\Facades\Storage;

class ProduitController extends Controller implements HasMiddleware
{

   public static function middleware()
    {
        return [
            new Middleware('auth:sanctum'),
        ];
    }

    public function index(Request $request)
    {
        $tokenFromRequest = PersonalAccessToken::findToken($request->bearerToken());
        
        $query = Produit::query()->where('user_id', $tokenFromRequest->tokenable_id)->orderBy('created_at', 'desc');

        $produits = $query->get();
        
        return [
            "token" => $request->bearerToken(),
            "produits" => $produits,
            "status" => "200", // OK: Indicates that the request has succeeded.
        ];
    }

    public function supeAZero(Request $request)
    {
        $tokenFromRequest = PersonalAccessToken::findToken($request->bearerToken());
        
        // $query = Produit::query()->where('user_id', $tokenFromRequest->tokenable_id)->where('quantite', '>', 0)->orderBy('created_at', 'desc');
       
        
        $produits = Produit::supeAZero($tokenFromRequest->tokenable_id)->get(); //->where('user_id', $tokenFromRequest->tokenable_id)->orderBy('created_at', 'desc')->get();
        
        return [
            "token" => $request->bearerToken(),
            "produits" => $produits,
            "status" => "200", // OK: Indicates that the request has succeeded.
        ];
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProduitFormRequest $request): array
    {
        // dd($request->all());
        // $fields = $request->validated();
        // $produit = Produit::create($fields);

        $data = $request->validated();
        if (request()->hasFile('image')) {
            
            
            $image = $request->file('image');
            $filename = $image->getClientOriginalName();
            $imageName = time().'-'.uniqid().'_'.$filename;
            dd( $imageName);
            $path = 'pictures/produit/'. $request->user_id;
           
            $imageS3 = $image->storeAs($path, $imageName,  's3'); 
            $url = env('AWS_URL') . '/' . $imageS3;
            
            // $imageS3 = env('AWS_URL').'/'.$imageS3;
            // dd($imageS3);
            $data ['image'] = $url; // 👈 Make it publicly accessible
        }
        $produit = Produit::create($data);
        return [
            "produit" => $produit,
            "status" => "200", // OK: Indicates that the request has succeeded.
        ];
        // $produit->types()->sync($request->validated('types'));
        // return to_route('admin.produit.index')->with('success', 'Le produit a été créé');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProduitFormRequest $request, Produit $produit)
    {
        $data = $request->validated();
        if (request()->hasFile('image')) {
            if($image = $request->file('image')){
                $filename = $image->getClientOriginalName();
                $imageName = time().'-'.uniqid().'_'.$filename;
                $path = 'pictures/produit/';
                $data['image'] = $path.$imageName;
                // $image->storeAs($path, $imageName, 'public'); 
                $image->move($path, $imageName);
            }
        }
        if (File::exists($produit->image)) {
            File::delete($produit->image);
        }
         $produit->update($data);
        return[
            "produit" => $produit,
            "status" => "200", // OK: Indicates that the request has succeeded.
        ];
        // $produit->types()->sync($request->validated('types'));

    }

    public function show(Produit $produit)
    {
        
        return [
            "produit" => $produit,
            "status" => "200", // OK: Indicates that the request has succeeded.
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Produit $produit)
    {
        $vente = Vente::where('produit_id', $produit->id)->first();
        // dd($vente);
        if ($vente != null){
            return ['errMessage' => "Ce produit a une vente"];
        }

        if (File::exists($produit->image)) {
            File::delete($produit->image);
        }
        $produit->delete();
        return [
            "message" => "Le produit a été supprimé",
            "status" => "200", // OK: Indicates that the request has succeeded.
        ];
    }

    public function destroyImage($produit)
    {
        $produitImage = Produit::where('id', $produit)->first();
        if (File::exists($produitImage->image)) {
            File::delete($produitImage->image);
        }
        $produitImage->update(['image'=> '']);
        return [
            "message" => "L'image du produit a été supprimée",
            "status" => "200", // OK: Indicates that the request has succeeded.
        ];
    }
}
