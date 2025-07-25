<?php

namespace App\Http\Controllers\V1;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produit;
use App\Http\Requests\Admin\ProduitFormRequest;
use Illuminate\Support\Facades\File;

class ProduitController extends Controller
{
    public function index()
    {
        $produit =Produit::orderBy("created_at", "DESC");
        return [
            "produits" => $produit,
        ];
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProduitFormRequest $request)
    {
        $fields = $request->validated();
        $vente = $produit = Produit::create($fields);

        return [
            "vente" => $produit,
        ];
        // $data = $request->validated();
        // if (request()->hasFile('image')) {
        //     if($image = $request->file('image')){
        //         $filename = $image->getClientOriginalName();
        //         $imageName = time().'-'.uniqid().'_'.$filename;
        //         $path = 'pictures/produit/';
        //         $data['image'] = $path.$imageName;
        //         // $image->storeAs($path, $imageName, 'public'); 
        //         $image->move($path, $imageName);
        //     }
        // }
        // $produit = Produit::create($data);
        // // $produit->types()->sync($request->validated('types'));
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
        // $produit->types()->sync($request->validated('types'));
        return to_route('admin.produit.index')->with('success', 'Le produit a été modifié');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Produit $produit)
    {
        if (File::exists($produit->image)) {
            File::delete($produit->image);
        }
        //dd($produit->image);
        //$produit->delete();
        return to_route('admin.produit.index')->with('success', 'Le produit a été supprimé');
    }

    public function destroyImage($produit)
    {
        $produitImage = Produit::where('id', $produit)->first();
        if (File::exists($produitImage->image)) {
            File::delete($produitImage->image);
        }
        $produitImage->update(['image'=> '']);
        return to_route('admin.produit.index')->with('success', 'Le produit a été supprimé');
    }
}
