<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Dog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DogController extends Controller
{
    
    public function create(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'avatar_url' => 'required|string',
            'description' => 'required|string',
        ]);

        $dog = new Dog;
        $dog->fill($validated);
        $dog->save();

        return response()->json($dog);
    }

    public function findAll(): JsonResponse
    {
        $dogs = Dog::where("active",true)->get();

        return response()->json([
            'dogs' => $dogs,
            'count' => $dogs->count()
        ]);
    }

    public function findOne($id): JsonResponse
    {
        $dog = Dog::where("id", $id)
            ->where("active", true)
            ->first();

        if(!$dog){
            return response()->json([
                'error' =>"Not Found",
                'message' =>"Dog ".$id." not found"
            ],404);
        }

        return response()->json($dog);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'string',
            'avatar_url' => 'string',
            'description' => 'string',
            'active' => 'boolean',
        ]);

        $dog = Dog::where("id", $id)
            ->where("active", true)
            ->first();

        if(!$dog){
            return response()->json([
                'error' =>"Not Found",
                'message' =>"Dog ".$id." not found"
            ],404);
        }

        $dog->fill($validated);
        $dog->save();

        return response()->json($dog);
    }

    public function delete($id): JsonResponse
    {
        $dog = Dog::where("id", $id)
            ->where("active", true)
            ->first();

        if(!$dog){
            return response()->json([
                'error' =>"Not Found",
                'message' =>"Dog ".$id." not found"
            ],404);
        }

        $dog->active = false;
        $dog->save();

        return response()->json([
            "message" => "Dog deleted successfully"
        ]);
    }

}
