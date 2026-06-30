<form role="search" method="get" class="search-form" action="{{ esc_url(home_url('/')) }}">
  <label class="screen-reader-text" for="s">{{ _x('Search for:', 'label', 'dayjobsnightlife') }}</label>
  <input type="search" value="{{ esc_attr(get_search_query()) }}" name="s" id="s">
  <button type="submit">{{ _x('Search', 'submit button', 'dayjobsnightlife') }}</button>
</form>
