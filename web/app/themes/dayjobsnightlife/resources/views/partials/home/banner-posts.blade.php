@php($query = App\HomeSections::queryPosts([
  'posts_per_page' => (int) ($section['posts_per_page'] ?? 5),
  'orderby' => $section['orderby'] ?? 'date',
]))

<div class="row d-none d-md-block">
  <div class="col-10 offset-1">
    <div class="banner-posts">
      <h3><em>{{ $section['title'] ?? '' }}</em></h3>
      <ul>
        @if ($query->have_posts())
          @while ($query->have_posts())
            @php($query->the_post())
            <li>
              <a href="{{ get_permalink() }}">
                {!! get_the_post_thumbnail(null, 'small', ['loading' => 'lazy']) !!}
                <span>{{ get_the_title() }}</span>
              </a>
            </li>
          @endwhile
          @php(wp_reset_postdata())
        @else
          <li>{{ __('Sorry, no posts matched your criteria.', 'dayjobsnightlife') }}</li>
        @endif
      </ul>
    </div>
  </div>
</div>
