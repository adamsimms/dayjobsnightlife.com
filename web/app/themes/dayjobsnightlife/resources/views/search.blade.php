@extends('layouts.app')

@section('content')
  <div class="wrap" role="document">
    <div class="content row">
      <main class="main">
        @include('partials.page-header')

        @if (! have_posts())
          <x-alert type="warning">
            {!! __('Sorry, no results were found.', 'dayjobsnightlife') !!}
          </x-alert>
          {!! get_search_form(false) !!}
        @endif

        @while(have_posts()) @php(the_post())
          @include('partials.content-search')
        @endwhile

        {!! get_the_posts_navigation() !!}
      </main>
    </div>
  </div>
@endsection
