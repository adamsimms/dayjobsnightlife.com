<div class="d-md-none mobile-home-section">
  <h2><em>{{ __('Latest', 'dayjobsnightlife') }}</em></h2>

  @php($mobileQuery = new WP_Query(['posts_per_page' => 6]))

  @while ($mobileQuery->have_posts())
    @php($mobileQuery->the_post())
    <article class="mobile-post-card">
      <a href="{{ get_permalink() }}">
        {!! get_the_post_thumbnail(null, 'medium', ['loading' => 'lazy']) !!}
        <h3>{{ get_the_title() }}</h3>
        @if ($tagline)
          <p><em>{{ $tagline }}</em></p>
        @endif
      </a>
    </article>
  @endwhile

  @php(wp_reset_postdata())

  @if (has_nav_menu('primary_navigation'))
    <nav class="mobile-nav-primary" aria-label="{{ __('Primary navigation', 'dayjobsnightlife') }}">
      {!! wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'nav', 'echo' => false]) !!}
    </nav>
  @endif

  {!! get_search_form(false) !!}
</div>
