<div>
    @if ($posts->count())
        <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach ($posts as $post)
                <div class="bg-white rounded-lg shadow-xl">
                    <a href="{{ route('posts.show', ['post' => $post, 'user' => $post->user]) }}" class="">
                        <img src="{{ asset('uploads').'/'.$post->imagen }}" alt="Imagen del post {{ $post->titulo }}" >
                    </a>
                    <p class="text 2xl text-center font-bold mt-3 mb-3">{{ $post->titulo }}</p>
                </div>
            @endforeach
        </div>
        <div>
            {{ $posts->links() }}
        </div>
    @else
        <p class="text-center">No Hay Posts, sigue a alguien para poder mostrar sus posts</p>
    @endif
</div>