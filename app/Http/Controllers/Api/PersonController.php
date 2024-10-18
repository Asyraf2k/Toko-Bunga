<?php

namespace App\Http\Controllers\Api;

use App\Models\Person;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PersonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $person = Person::all();

        return response()->json([
            'status' => true,
            'message' => 'Data Berhasil dikeluarkan',
            'data' => $person
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi error',
                'errors' => $validator->errors()
            ], 422);
        }

        $person = Person::create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil ditambahkan',
            'data' => $person
        ], 201);
    }

    /**
     * Display the specified resource.
     */ 
    public function show(string $id)
    {
        $person = Person::find($id);

        if (!$person) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data ditemukan',
            'data' => $person
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $person = Person::find($id);

        if (!$person) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required',
            'email' => 'sometimes|required|email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi error',
                'errors' => $validator->errors()
            ], 422);
        }

        $person->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil diperbarui',
            'data' => $person
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $person = Person::find($id);

        if (!$person) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        $person->delete();

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil dihapus'
        ]);
    }
}
