<article @php(post_class())>
  <a href="{{ get_permalink() }}">{!! get_the_post_thumbnail(null, 'large', ['loading' => 'lazy']) !!}</a>
  <h2 class="entry-title">
    <a href="{{ get_permalink() }}">
      {{ get_the_title() }}
      @if ($tagline)
        <span>/ <em>{{ $tagline }}</em></span>
      @endif
    </a>
  </h2>
  <p>{!! get_the_excerpt() !!}</p>
</article>
