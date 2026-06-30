<!doctype html>
<html @php(language_attributes())>
  @include('partials.head')
  <body @php(body_class())>
    @php(wp_body_open())
    @php(do_action('get_header'))

    @include('sections.header')

    @yield('content')

    @php(do_action('get_footer'))
    @include('sections.footer')
    @php(wp_footer())
  </body>
</html>
