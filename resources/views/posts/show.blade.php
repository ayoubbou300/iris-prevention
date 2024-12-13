@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $post->title }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>{{ $post->title }}</h1>
        <p>{{ $post->content }}</p>

        <h2>Commentaires</h2>
        <ul>
            @foreach($post->comments as $comment)
                <li><strong>{{ $comment->user->name }} :</strong> {{ $comment->content }}</li>
            @endforeach
        </ul>

        <h3>Ajouter un Commentaire</h3>
        <form action="{{ route('comments.store', $post->id) }}" method="POST">
            @csrf
            <div class="mb-3">
                <textarea name="content" class="form-control" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Ajouter un Commentaire</button>
        </form>
    </div>
</body>
</html>
@endsection
