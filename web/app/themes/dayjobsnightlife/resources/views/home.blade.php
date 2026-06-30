@extends('layouts.app')

@section('content')
  <div class="wrap" role="document">
    <div class="content row">
      <main class="main">
        @include('partials.home.mobile')

        @if (! have_posts())
          <div class="row">
            <div class="col-12">
              <x-alert type="warning">
                {!! __('Sorry, no results were found.', 'dayjobsnightlife') !!}
              </x-alert>
              {!! get_search_form(false) !!}
            </div>
          </div>
        @endif

        @include('partials.home.banner-posts', ['section' => $sections['recent_banner']])
        @include('partials.home.divider')
        @include('partials.home.nav-primary')
        @include('partials.home.divider')
        @include('partials.home.feature-section', ['section' => $sections['feature_1']])
        @include('partials.home.divider')
        @include('partials.home.banner-posts', ['section' => $sections['trending_banner']])
        @include('partials.home.divider')
        @include('partials.home.feature-section', ['section' => $sections['feature_2']])

        <hr>

        @include('partials.home.feature-section', ['section' => $sections['feature_3']])
      </main>
    </div>
  </div>
@endsection
