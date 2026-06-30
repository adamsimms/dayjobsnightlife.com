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
          @includeFirst(['partials.content-' . get_post_type(), 'partials.content'])
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
