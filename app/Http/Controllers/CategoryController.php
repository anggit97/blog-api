<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categories;

class CategoryController extends Controller
{

    public function __construct(){
        $this->middleware('auth:api', ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Categories::paginate(20);
        return response()->json($categories);
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
        $validatedData = $request->validate([
            'name' => 'required|min:3',
            'description' => 'sometimes|min:10',
            'foto' => 'required'
        ]);

        $category = Categories::create($validatedData);

        return response()->json(['message' => 'Berhasil Tambah Kategori', 'category' => $category], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Categories::findOrFail($id);
        return response()->json($category);
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
        $validatedData = $request->validate([
            'name' => 'required|min:3',
            'description' => 'sometimes|min:10',
            'foto' => 'required'
        ]);
        
        $category = Categories::find($id);

        $category->name = $request->name;
        $category->description = $request->description;
        $category->foto = $request->foto;

        if($category->save()){
            return response()->json([
                'message' => "Berhasil update kategori",
                'category' => $category
            ]);
        }else{
            return response()->json([
                'message' => "Gagal update kategori",
            ], 503);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Categories::destroy($id);
        return response()->json([
            'message' => 'success delete'
        ], 204);
    }
}
