@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold mb-4">Modifier l’Article</h1>
    <form action="{{ route('posts.update', $post) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="title" class="block font-bold mb-1">Titre</label>
            <input type="text" id="title" name="title" class="w-full border-gray-300 rounded" value="{{ $post->title }}" required>
            @error('title')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="content" class="block font-bold mb-1">Contenu</label>
            <textarea id="content" name="content" class="w-full border-gray-300 rounded" rows="5" required>{{ $post->content }}</textarea>
            @error('content')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>
        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">Mettre à jour</button>
    </form>
</div>
@endsection
