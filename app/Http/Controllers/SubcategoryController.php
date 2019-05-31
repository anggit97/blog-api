<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Subcategory;

class SubcategoryController extends Controller
{

    public function __construct(){
        $this->middleware('auth:api', ['except'=>['index', 'show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subcategories = Subcategory::paginate(10);
        return response()->json($subcategories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'name' => 'required|min:3',
            'description' => 'sometimes|min:10',
            'foto' => 'sometimes'
        ]);

        $subcategory = Subcategory::create($validateData);

        return response()->json([
            'message' => 'Berhasil tambah data subcategory',
            'subcategory' => $subcategory
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $subcategory = Subcategory::findOrFail($id);
        return response()->json($subcategory);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validateData = $request->validate([
            'name' => 'required|min:3',
            'description' => 'sometimes|min:10',
            'foto' => 'sometimes'
        ]);

        $subcategory = Subcategory::findOrFail($id);
        $subcategory->name = $request->name;
        $subcategory->description = $request->description;
        $subcategory->foto = $request->foto;

        if($subcategory->save()){
            return response()->json([
                'message' => 'Berhasil perbarui subkategori',
                'subcategory' => $subcategory
            ]);
        }

        return response()->json([
            'message' => 'Gagal perbarui subkategori',
        ], 503);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Subcategory::destroy($id);
        return response()->response([
            'message' => 'Berhasil hapus subkategori'
        ], 204);
    }
}
