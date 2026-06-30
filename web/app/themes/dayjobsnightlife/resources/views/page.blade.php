@extends('layouts.app')

@section('content')
  <div class="wrap" role="document">
    <div class="content row">
      <main class="main">
        @while(have_posts()) @php(the_post())
          @include('partials.page-header')
          @include('partials.content-page')
        @endwhile
      </main>
    </div>
  </div>
@endsection
