<div class="col-md-10">
          @if(session('message'))
          <div class='alert alert-success'>
            {{ session('message') }}
          </div>
        @endif

        @if(session('message_error'))
          <div class='alert alert-danger'>
            {{ session('message_error') }}
          </div>
        @endif

@foreach($articles as $article)
        <div style="background: #e9ecef; border-radius: 10px; padding: 10 0 10 1" class="row">
        <div class="col-md-12">
          <h5 class="text-center">{{ $article->name }}</h5>
          <img class="mx-auto d-block" style="width:90%; max-width: 850px; max-height: 500px; min-height: 200px" src="{{ asset('storage/images/'.$article->img) }}" alt="{{ route('show_image', ['filename'=>$article->img]) }}"><br>
          <p>{{ $article->text_short }}</p>
          <div class="row">
            <div class='col-md-6'>
				<a class="btn btn-secondary btn-sm" href="/category/{{ $article->category }}" role="button">{{ $article->category }}</a>
            @foreach($article->tags as $tag)
              <a class="btn btn-outline-dark btn-sm" href="/tag/{{ $tag['name'] }}" role="button">{{ $tag->name }}</a>
            @endforeach
            </div>
            <p class="col-md-3">{{ $article->created_at }}</p>
            <div class="col-md-3">

          <p><a class="btn btn-dark btn-sm float-right" href="/article/{{ $article->id }}/{{ $article->name_translit }}" role="button">Подробнее &raquo;</a></p>
          </div>
          </div>
        </div>
         </div>
         <hr>
@endforeach
{{ $articles->links() }}