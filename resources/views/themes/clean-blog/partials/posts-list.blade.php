@if( count($posts) == 0 )
    <div class="post-preview">
        <h2 class="post-title">
            Whoops, there are no posts here yet :/
        </h2>
    </div>
@endif
@foreach($posts as $post)
    <div class="post-preview">
        <a href="{{route('web.post', $post->slug)}}">
            <h2 class="post-title">
                {{ $post->title }}
            </h2>
            <h3 class="post-subtitle">
                {{ $post->description }}
            </h3>
        </a>
        <p class="post-meta">Posted by <a href="#">{{$post->owner->name}}</a> {{$post->moderated_at->diffForHumans()}}</p>
    </div>
    <hr>
@endforeach

{{ $posts->render() }}