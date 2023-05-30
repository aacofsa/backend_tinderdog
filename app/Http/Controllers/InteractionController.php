<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Dog;
use App\Models\Interaction;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InteractionController extends Controller
{
    public function create(Request $req): JsonResponse
    {
        $req->validate([
            'action' => 'required|string|in:aprobar,rechazar',
            'dog_id' => 'required|int',
            'target_dog_id' => 'required|int',
        ]);

        $action = $req->action;
        $dogId = $req->dog_id;
        $targetDogId = $req->target_dog_id;
        
        if($action != 'aprobar' && $action != 'rechazar'){
            return response()->json([
                'error' =>"Bad Request",
                'message' =>"Action must be 'aprobar' or 'rechazar'",
            ],400);
        }
        $dog = Dog::where("id", $dogId)
            ->where("active", true)
            ->first();
        
        if(!$dog){
            return response()->json([
                'error' =>"Not Found",
                'message' =>"Dog #".$dogId." not found"
            ],404);
        }

        $target_dog = Dog::where("id", $targetDogId)
            ->where("active", true)
            ->first();
        
        if(!$target_dog){
            return response()->json([
                'error' =>"Not Found",
                'message' =>"Dog to interact #".$targetDogId." not found"
            ],404);
        }

        $interaction = new Interaction();
        $interaction->dog_id = $dogId;
        $interaction->target_dog_id = $targetDogId;
        $interaction->action = $action;
        $interaction->save();

        return response()->json($interaction);
    }

    public function findAll(Request $req)
    {
        $dog = $req->query("dog");
        $targetDog = $req->query("targetDog");

        $query = Interaction::query();
        if($dog){
            $query =  $query->where("dog_id", $dog);
        }
        if($targetDog){
            $query =  $query->where("target_dog_id", $targetDog);
        }

        $interactions = $query->get();
        return response()->json([
            'interactions' => $interactions,
            'count' => $interactions->count()
        ]);
    }

    public function update(Request $req, $id): JsonResponse
    {
        $req->validate([
            'action' => 'string|in:aprobar,rechazar',
        ]);

        $interaction = Interaction::find($id);
    
        if(!$interaction){
            return response()->json([
                'error' =>"Not Found",
                'message' =>"Interaction #".$id." not found"
            ],404);
        }

        $interaction->fill($req->only(["action"]));
        $interaction->save();
        return response()->json($interaction);
    }

    public function delete($id): JsonResponse
    {
        $interaction = Interaction::find($id);
    
        if(!$interaction){
            return response()->json([
                'error' =>"Not Found",
                'message' =>"Interaction #".$id." not found"
            ],404);
        }

        try{
            $interaction->delete();
            return response()->json([
                "message" => "Interaction #".$id." was deleted successfully",
                "status" => 200
            ]);
        }catch(Exception $e){
            return response()->json([
                "message" => "Error on delete: ".$e,
                "status" => 500
            ],500);
        }

    }
}
