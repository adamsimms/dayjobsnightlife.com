<div class="row">
  <div class="col-10 offset-1 col-sm-7 offset-sm-1">
    @php($featureQuery = App\HomeSections::queryPosts([
      'meta_key' => $section['meta_key'] ?? '',
      'meta_value' => $section['meta_value'] ?? '',
      'posts_per_page' => 1,
    ]))

    @if ($featureQuery->have_posts())
      @while ($featureQuery->have_posts())
        @php($featureQuery->the_post())
        @includeFirst(['partials.content-' . get_post_type(), 'partials.content'])
      @endwhile
      @php(wp_reset_postdata())
    @else
      <p>{{ __('Sorry, no posts matched your criteria.', 'dayjobsnightlife') }}</p>
    @endif
  </div>

  @if (! empty($section['sidebar']))
    <div class="col-sm-3 d-none d-md-block">
      <div class="sidebar-posts">
        <h4>
          <a href="{{ $section['sidebar']['link'] ?? '#' }}">
            <em>{{ $section['sidebar']['title'] ?? '' }}</em>
            <span class="btn-arrow">&#8594;</span>
          </a>
        </h4>

        @php($sidebarQuery = App\HomeSections::queryPosts(App\HomeSections::sidebarQueryArgs($section['sidebar'])))

        @if ($sidebarQuery->have_posts())
          <ul>
            @while ($sidebarQuery->have_posts())
              @php($sidebarQuery->the_post())
              <li>
                <a href="{{ get_permalink() }}" rel="bookmark">
                  <div class="thumbnail">{!! get_the_post_thumbnail(null, 'small', ['loading' => 'lazy']) !!}</div>
                  <h6>{{ get_the_title() }}</h6>
                  @if ($tagline)
                    <p><em>{{ $tagline }}</em></p>
                  @endif
                </a>
              </li>
            @endwhile
          </ul>
          @php(wp_reset_postdata())
        @endif
      </div>
    </div>
  @endif
</div>
