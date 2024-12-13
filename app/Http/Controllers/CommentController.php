<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index(Post $post)
    {
        return CommentResource::collection($post->comments()->with('user')->paginate(10));
    }

    /**
     * Crée un commentaire pour un article.
     */
    public function store(Request $request, $postId)
    {
        $request->validate([
            'content' => 'required|string|max:500',
        ]);

        $post = Post::findOrFail($postId);

        $comment = new Comment();
        $comment->content = $request->content;
        $comment->user_id = auth()->id(); // Assuming you are using authenticated users
        $comment->post_id = $post->id;
        $comment->save();

        return redirect()->route('posts.index', $post->id)->with('success', 'Commentaire ajouté avec succès.');
    }

    /**
     * Affiche un commentaire spécifique.
     */
    public function show(Comment $comment)
    {
        return new CommentResource($comment->load('user', 'post'));
    }

    /**
     * Met à jour un commentaire.
     */
    public function update(Request $request, Comment $comment)
    {
        $this->authorize('update', $comment);

        $validated = $request->validate([
            'content' => 'sometimes|required|string|max:500',
        ]);

        $comment->update($validated);

        return new CommentResource($comment->load('user', 'post'));
    }

    /**
     * Supprime un commentaire.
     */
    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);

        $comment->delete();

        return response()->noContent();
    }
}