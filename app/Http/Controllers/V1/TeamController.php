<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Laravel\Sanctum\PersonalAccessToken;
class TeamController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('auth:sanctum'),
        ];
    }

    public function createTeam(Request $request)
    {
        $tokenFromRequest = PersonalAccessToken::findToken($request->bearerToken());
        $team = Team::create([
            'name' => $request->name,
            'owner_id' => $tokenFromRequest->tokenable_id,
        ]);

        // return response()->json($team, 201);
        return $team;
    }

    public function addMember(Request $request)
    {
        $tokenFromRequest = PersonalAccessToken::findToken($request->bearerToken());
        $team = Team::where('owner_id', $tokenFromRequest->tokenable_id)->first();
        // dd($request->user_id);
        $user = User::where('phone_number',$request->phone_number)->first();
        $owner = User::find($tokenFromRequest->tokenable_id);
        
        if (!$user) {
            return ['message' => 'Ce User n\'existe pas',  'status'=>  404];
        }
        if ($team === null) {
            // print("No team found, creating team");
            $team = Team::create([
            'name' => "Team" . $owner->name,
            'owner_id' => $tokenFromRequest->tokenable_id,
        ]);
     //$this->createTeam($request);
        }
        // print("Team: $team");

        // print("Updating team_id user");
        // User::where('id', $request->user_id)->update(['team_id' => $team->id]);
        $user->team_id = $team->id;
        $user->save();
        // print($user);

        // attach the user to the team
        // $ownerTeam->users()->attach($user->id);

        return ['user' => $user, 'message' => 'Membre ajouté avec succés', 'status' => 201];
    }

    public function listMembers(Request $request)
    {
        $tokenable = PersonalAccessToken::findToken($request->bearerToken());
        $team = Team::where(['owner_id' => $tokenable->tokenable_id])->first();
        if($team){
            return ['users' => $team->users, 'status' => 201];
        }else{
            return ['users' => null, 'status' => 201];
        }
    }
    
    public function removeUserFromTeam($userId)
{
    $user = User::find($userId);
    if (!$user) return ['message' => 'User not found'];

    $teamId = $user->team_id; // prevent losing team reference
    $user->team_id = null;
    $user->save();

    return [
        'users' => User::where('team_id', $teamId)->get(),
        'status' => 200
    ];
}
}