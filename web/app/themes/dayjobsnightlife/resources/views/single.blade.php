@extends('layouts.app')

@section('content')
  <div class="wrap" role="document">
    <div class="content row">
      <main class="main">
        @while(have_posts()) @php(the_post())
          @include('partials.content-single')
        @endwhile
      </main>

      @if (\App\display_sidebar())
        <aside class="sidebar">
          @include('sections.sidebar')
        </aside>
      @endif
    </div>
  </div>
@endsection
