<?php

namespace App\Http\Controllers\V1;

use App\Http\Requests\DepenseFormRequest;
use Illuminate\Http\Request;
use App\Models\Depense;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
class DepenseController extends Controller implements HasMiddleware
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
    public function index(Request $request)
    {
        // $tokenFromRequest = PersonalAccessToken::findToken($token->plainTextToken);
        $tokenFromRequest = PersonalAccessToken::findToken($request->bearerToken());
        //$tokenFromRequest = Auth::user()->currentAccessToken();
        
        //$userId = Auth::user()->id;
        $startDate = now()->startOfDay();
        $endDate = now()->endOfDay();
        $query = Depense::query()->whereBetween('created_at', [$startDate, $endDate])->where('user_id', $tokenFromRequest->tokenable_id)->orderBy('created_at', 'desc');
        $totalOfTheDay = 0;
        $getQuery = $query->get();
        foreach ($getQuery as $q) {
            $totalOfTheDay = $q->montant + $totalOfTheDay;
        }
       
        return [
            "depenses" => $query->get(),
            "totalOfTheDay" => $totalOfTheDay,
            "status" => "200",
        ];
    }
    

    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //     $depense = new Depense();
    //     $depense->fill([
    //         'user_id' => User::first()->id,
    //     ]);
    // //     return view("depenses.form",[
    // //         "depense" => $depense,
    // //     ]);
    // }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DepenseFormRequest $request)
    {
        $depense = Depense::create($request->validated());
        return [
            "depenses" => $depense,
            "status" => "200", // Created: Indicates that the request has been fulfilled and resulted in a new resource being created.
        ];
        // return to_route('depense.depense.index')->with('success', 'La dépense a été créée');
    }

    /**
     * Display the specified resource.
     */
    public function show(Depense $depense)
    {
        return [
            "depenses" => $depense,
            "status" => "200", // OK: Indicates that the request has succeeded.
        ];
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(Depense $depense)
    // {
    //     // return view('depenses.form', ['depense' => $depense]);
    // }

    /**
     * Update the specified resource in storage.
     */
    public function update(DepenseFormRequest $request, Depense $depense)
    {
        $request->bearerToken(); // Ensure the request has a bearer token
        $tokenFromRequest = PersonalAccessToken::findToken($request->bearerToken());
        if($tokenFromRequest->tokenable_id !== $depense->user_id) {
            return ['message' => 'Unproccessable, user or ddepense does not exist', 'status' => '422']; // Forbidden: Indicates that the server understood the request but refuses to authorize it.
        }else{
            $depense->update($request->validated());
            return [
                "depenses" => $depense,
                "status" => "200", // OK: Indicates that the request has succeeded.
            ];
        }
        // return to_route('depense.depense.index')->with('success', 'La dépense a été modifiée');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Depense $depense)
    {
        $request->bearerToken(); // Ensure the request has a bearer token
        $tokenFromRequest = PersonalAccessToken::findToken($request->bearerToken());
        if($tokenFromRequest->tokenable_id !== $depense->user_id) {
            return ['errMessage' => 'Unauthorized', 'status' => '422']; // Forbidden: Indicates that the server understood the request but refuses to authorize it.
        }else{
            $depense->delete();
            return [
                'message' => 'La dépense a été supprimée',
                'status' => '200', // OK: Indicates that the request has succeeded.
            ];
        }
        // return to_route('depense.depense.index')->with('success', 'Le type a été supprimé');
    }
}
