<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class PostController extends Controller
{

    public function __construct(){
        $this->middleware('auth:api',['except'=>['index','show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::paginate(20);
        foreach($posts as $post){
            $post->foto = url('/images/'.$post->foto);
        }
        return response()->json($posts);
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
            'title' => 'required|min:5',
            'subtitle' => 'sometimes|min:5',
            'body' => 'required|min:10',
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'category_id' => 'required|numeric',
            'user_id' => 'required|numeric'
        ]);
        
        if($request->has('foto')){
            $imageName = time().'.'.$request->foto->getClientOriginalExtension();
            $request->foto->move(public_path('images'), $imageName);
            $request->foto = $imageName;
            $validateData['foto'] = $imageName;
        }

        $post = Post::create($validateData);

        $post->foto = url('/images/'.$imageName);

        return response()->json([
            'message' => 'Berhasil tambah post',
            'post' => $post
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
        $post = Post::findOrFail($id);
        $post->foto = url('/images/'.$post->foto);
        return response()->json($post);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
