<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\PostResource;
use App\Models\Post;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
            return PostResource::collection(Post::with('user', 'comments')->paginate(10));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $post = Post::create($validated); // Créer un post avec les données validées
        return new PostResource($post);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::find($id); // Trouver un post par son ID
        if ($post) {
            return new PostResource($post); // Retourner le post avec la ressource
        }
        return response()->json(['message' => 'Post not found'], 404); // Si le post n'existe pas
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $post = Post::find($id); // Trouver le post par son ID
        if ($post) {
            $validated = $request->validate([
                'title' => 'string|max:255',
                'content' => 'string',
            ]);

            $post->update($validated); // Mettre à jour le post
            return new PostResource($post); // Retourner le post mis à jour avec la ressource
        }
        return response()->json(['message' => 'Post not found'], 404); // Si le post n'existe pas
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::find($id); // Trouver le post par son ID
        if ($post) {
            $post->delete(); // Supprimer le post
            return response()->json(['message' => 'Post deleted successfully']); // Confirmer la suppression
        }
        return response()->json(['message' => 'Post not found'], 404); // Si le post n'existe pas
    }
}