<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  @php(wp_head())

  @if ($typekitId)
    <script src="{{ esc_url('https://use.typekit.net/' . rawurlencode($typekitId) . '.js') }}"></script>
    <script>try{Typekit.load();}catch(e){}</script>
  @endif
</head>
