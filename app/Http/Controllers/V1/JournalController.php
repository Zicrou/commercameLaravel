<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\Vente;
use App\Models\Depense;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Laravel\Sanctum\PersonalAccessToken;

class JournalController extends Controller
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
        $token = PersonalAccessToken::findToken($request->bearerToken());

        $depenseTotal = 0;
       
        $journal = [];
        
        $vents = Vente::where('user_id', $token->tokenable_id)->orderBy('created_at', 'desc')->get();;
        $ventes = $vents->groupBy(function($m) {
            return $m->created_at->format('d-m-Y');
        });

        $deps = Depense::where('user_id', $token->tokenable_id)->orderBy('created_at', 'desc')->get();
        $allDepenses = $deps->groupBy(function($m) {
            return $m->created_at->format('d-m-Y');
        });
        
        foreach ($allDepenses as $date => $depenses) {
            $journal[$date]['depenses'] = $depenses;
            $journal[$date]['ventes'] = collect();
        }

        foreach ($ventes as $date => $ventesDuJour) {
            if (isset($journal[$date])) {
                $journal[$date]['ventes'] = $ventesDuJour;
            } else {
                $journal[$date]['depenses'] = collect();
                $journal[$date]['ventes'] = $ventesDuJour;
            }
            
        }
        
        foreach ($journal as $date => $data) {
            $totalVentes = 0;
            $totalDepenses = 0;

            // total ventes
            foreach ($data['ventes'] as $vente) {
                $totalVentes += $vente->prix * $vente->nombre;
            }
            $journal[$date]['ventes']['totalVentes'] = $totalVentes;

            // total depenses
            foreach ($data['depenses'] as $depense) {
                $totalDepenses += $depense->montant;
            }
            $journal[$date]['depenses']['totalDepenses'] = $totalDepenses;
        }
        //dd( $journal[$date]['depenses']);
        // $vents_year = Vente::where('statut', 1)->get();
        $ventes_year = $vents->groupBy(function($m) {
            return $m->created_at->format('Y');
        });
        
        return [
            //'ventes' =>   $ventes, 
            'journal' => $journal, 
            //'depenses' => $allDepenses, 
        ];
    }

    
}
