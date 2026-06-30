<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php wp_head(); ?>

  <?php
  $typekit_id = Roots\Sage\Extras\typekit_id();
  if ($typekit_id) :
    ?>
    <script src="<?php echo esc_url('https://use.typekit.net/' . rawurlencode($typekit_id) . '.js'); ?>"></script>
    <script>try{Typekit.load();}catch(e){}</script>
  <?php endif; ?>
</head>
