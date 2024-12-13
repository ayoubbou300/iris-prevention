<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;
use App\Http\Resources\CommentResource;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($postId)
    {
        $post = Post::find($postId); // Trouver le post
        if ($post) {
            return CommentResource::collection($post->comments); // Retourner les commentaires du post
        }
        return response()->json(['message' => 'Post not found'], 404); // Si le post n'existe pas
    }
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $postId)
    {
         $validated = $request->validate([
            'content' => 'required|string',
        ]);

        $post = Post::find($postId); // Trouver le post auquel ajouter le commentaire
        if ($post) {
            $comment = $post->comments()->create([
                'content' => $validated['content'],
            ]);
            return new CommentResource($comment); // Retourner le commentaire créé avec la ressource
        }
        return response()->json(['message' => 'Post not found'], 404); // Si le post n'existe pas
    }

    /**
     * Display the specified resource.
     */
    public function show($postId, $commentId)
    {
        $post = Post::find($postId); // Trouver le post
        if ($post) {
            $comment = $post->comments()->find($commentId); // Trouver le commentaire
            if ($comment) {
                return new CommentResource($comment); // Retourner le commentaire avec la ressource
            }
            return response()->json(['message' => 'Comment not found'], 404); // Si le commentaire n'existe pas
        }
        return response()->json(['message' => 'Post not found'], 404); // Si le post n'existe pas
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $postId, $commentId)
    {
         $validated = $request->validate([
            'content' => 'required|string',
        ]);

        $post = Post::find($postId); // Trouver le post
        if ($post) {
            $comment = $post->comments()->find($commentId); // Trouver le commentaire
            if ($comment) {
                $comment->update($validated); // Mettre à jour le commentaire
                return new CommentResource($comment); // Retourner le commentaire mis à jour avec la ressource
            }
            return response()->json(['message' => 'Comment not found'], 404); // Si le commentaire n'existe pas
        }
        return response()->json(['message' => 'Post not found'], 404); // Si le post n'existe pas
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(  $postId, $commentId )
    {
        $post = Post::find($postId); // Trouver le post
        if ($post) {
            $comment = $post->comments()->find($commentId); // Trouver le commentaire
            if ($comment) {
                $comment->delete(); // Supprimer le commentaire
                return response()->json(['message' => 'Comment deleted successfully']); // Confirmer la suppression
            }
            return response()->json(['message' => 'Comment not found'], 404); // Si le commentaire n'existe pas
        }
        return response()->json(['message' => 'Post not found'], 404); // Si le post n'existe pas
    }
}