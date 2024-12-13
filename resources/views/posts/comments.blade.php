{{-- Formulaire pour ajouter un commentaire --}}
<form action="{{ route('comments.store', $post->id) }}" method="POST">
    @csrf
    <div class="form-group">
        <textarea name="content" class="form-control" rows="4" placeholder="Votre commentaire"></textarea>
    </div>
    <button type="submit" class="btn btn-primary mt-2">Ajouter le commentaire</button>
</form>

{{-- Affichage des commentaires --}}
<h3>Commentaires pour : {{ $post->title }}</h3>
<ul>
    @foreach($post->comments as $comment)
        <li>{{ $comment->content }}</li>
    @endforeach
</ul>

{{-- Lien pour afficher les commentaires --}}
<a href="{{ route('posts.comments', $post->id) }}">Voir les commentaires</a>
