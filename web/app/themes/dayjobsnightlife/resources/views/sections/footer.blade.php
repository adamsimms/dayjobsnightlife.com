<footer class="content-info">
  <div class="row">
    <div class="col-10 offset-1 col-sm-3 offset-sm-1">
      <h5><em>{{ __('Subscribe to our mailing list', 'dayjobsnightlife') }}</em></h5>
      <p>{{ __("Let's keep it casual", 'dayjobsnightlife') }}</p>
      @if ($mailchimpShortcode)
        <p>{!! do_shortcode($mailchimpShortcode) !!}</p>
      @endif
    </div>

    <div class="col-10 offset-1">
      <p>
        <span><em>{{ __('Day Jobs and the Nightlife', 'dayjobsnightlife') }}</em></span>
        {{ __('mixes reviews and blogs with featured articles about cool people and hot places so you can have a smoother transition from your day job to your nightlife. Keep coming back for more.', 'dayjobsnightlife') }}
      </p>

      <h6>{{ __('Contact', 'dayjobsnightlife') }}</h6>
      @if (! empty($contact['phone']))
        <p>{{ $contact['phone'] }}</p>
      @endif
      @if (! empty($contact['email']))
        <p><a href="mailto:{{ esc_attr($contact['email']) }}">{{ $contact['email'] }}</a></p>
      @endif
    </div>

    @php(dynamic_sidebar('sidebar-footer'))
  </div>
</footer>

<div class="credits">
  <div class="row">
    <div class="col-10 offset-1 col-sm-10 offset-sm-1">
      <p>&copy; {{ date('Y') }} {{ $siteName }}. {{ __('All Rights Reserved.', 'dayjobsnightlife') }}</p>
    </div>
  </div>
</div>
