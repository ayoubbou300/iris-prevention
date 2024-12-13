<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function __construct()
    {
        // Assurez-vous que l'utilisateur est authentifié pour certaines actions
        $this->middleware('auth');
    }
    
    public function index()
    {
        
        // Récupérer tous les posts avec les relations nécessaires
    $posts = Post::with(['user', 'comments'])->get();

    // Retourner les posts à une vue
    return view('posts.index', compact('posts'));
    }
    public function showComments($postId)
    {
        // Récupérer le post avec ses commentaires associés
        $post = Post::with('comments')->findOrFail($postId);
        
        // Retourner la vue avec les commentaires
        return view('posts.comments', compact('post'));
    }
    
    // Afficher le formulaire de création d'un post
    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $post = Post::create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'user_id' => auth()->id(),
        ]);

        // return new PostResource($post->load('user', 'comments'));
        return redirect()->route('posts.index')->with('success', 'Post créé avec succès.');

    }

    public function show($id)
    {
        // return new PostResource($post->load('user', 'comments'));
        $post = Post::with('comments.user')->findOrFail($id);
        return view('posts.show', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        
        if ($post->user_id !== Auth::id()) {
            return redirect()->route('posts.index')->with('error', 'Accès interdit.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $post->update([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        return redirect()->route('posts.index')->with('success', 'Post mis à jour avec succès.');
    }

    public function destroy(Post $post)
    {
       
        if ($post->user_id !== Auth::id()) {
            return redirect()->route('posts.index')->with('error', 'Accès interdit.');
        }

        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Post supprimé avec succès.');
        
    }
}