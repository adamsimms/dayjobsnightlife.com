<header class="branding">
  <div class="row">
    <div class="col-10 offset-1">
      <ul class="swatches">
        <li class="blue"></li>
        <li class="green"></li>
        <li class="pink"></li>
        <li class="orange"></li>
        <li class="grey"></li>
      </ul>
    </div>
  </div>
  <div class="row">
    <div class="col-10 offset-1 col-md-5 offset-md-1">
      <a class="logotype" href="{{ esc_url(home_url('/')) }}">
        <img src="{{ \Roots\asset('images/logotype.png')->uri() }}" alt="{{ $siteName }}" loading="eager">
      </a>
    </div>
    <div class="col-12 col-md-3 offset-md-2 d-none d-md-block">
      <ul class="social-media">
        @foreach ($socialLinks as $network => $url)
          @if ($url)
            <li>
              <a href="{{ esc_url($url) }}" target="_blank" rel="noopener noreferrer">
                <img src="{{ \Roots\asset('images/icon-' . $network . '.png')->uri() }}" alt="{{ ucfirst($network) }}">
              </a>
            </li>
          @endif
        @endforeach
      </ul>
      <div class="search">
        <button type="button" class="btn-search" aria-expanded="false" aria-controls="site-search">
          <img src="{{ \Roots\asset('images/icon-search.svg')->uri() }}" alt="{{ __('Search', 'dayjobsnightlife') }}">
        </button>
        <a class="btn-concierge d-none d-md-inline-block" href="mailto:{{ esc_attr($contact['email']) }}">
          <img src="{{ \Roots\asset('images/icon-bell.svg')->uri() }}" alt="{{ __('Concierge', 'dayjobsnightlife') }}">
        </a>
      </div>
      <div id="site-search" class="site-search" hidden>
        {!! get_search_form(false) !!}
      </div>
    </div>
  </div>
</header>

<hr>
