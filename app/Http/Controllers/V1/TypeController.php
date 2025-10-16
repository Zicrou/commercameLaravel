<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TypeFormRequest;
use App\Models\Type;
use App\Models\Vente;
use Faker\Provider\ar_EG\Person;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Laravel\Sanctum\PersonalAccessToken;

class TypeController extends Controller implements HasMiddleware
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
    public function index()
    {   
        return ["types" => Type::all(),"status" => "200",];
    }

    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //     $type = new Type();
    //     return view('admin.types.form', [
    //         'type' => $type
    //     ]);
    // }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TypeFormRequest $request)
    {
        $type = Type::create($request->validated());
        return [
            "status" => "200",
            "type" => $type
        ];
    }

    

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(Type $type)
    // {
    //     return view('admin.types.form', ['type' => $type]);
    // }

    /**
     * Update the specified resource in storage.
     */
    public function update(TypeFormRequest $request, Type $type)
    {
        $type->update($request->validated());
        return [
            "status" => "200",
            "type" => $type
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Type $type)
    {
        $vente = Vente::where('type_id', $type->id);
        if($vente != null){
            return ['errMessage' => 'Ce type a une vente'];
        }
        if($type->delete()){
            return [
                "status" => "200",
            ];
        }else{
            return [
                "status" => "500",
                "errMessage" => "Failed to delete type"
            ];
        }
        
        
    }
}
