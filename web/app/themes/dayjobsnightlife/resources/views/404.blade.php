@extends('layouts.app')

@section('content')
  <div class="wrap" role="document">
    <div class="content row">
      <main class="main">
        @include('partials.page-header')
        <x-alert type="warning">
          {!! __('Sorry, but the page you were trying to view does not exist.', 'dayjobsnightlife') !!}
        </x-alert>
        {!! get_search_form(false) !!}
      </main>
    </div>
  </div>
@endsection
