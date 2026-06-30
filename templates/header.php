<?php

use Roots\Sage\Extras;

$contact = Extras\contact_details();
?>

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
      <a class="logotype" href="<?php echo esc_url(home_url('/')); ?>">
        <img src="<?php echo Extras\asset_uri('images/logotype.png'); ?>" alt="<?php bloginfo('name'); ?>" />
      </a>
    </div>
    <div class="col-12 col-md-3 offset-md-2 d-none d-md-block">
      <ul class="social-media">
        <?php
        Extras\render_social_link('facebook', 'icon-facebook.png', 'Facebook');
        Extras\render_social_link('twitter', 'icon-twitter.png', 'Twitter');
        Extras\render_social_link('instagram', 'icon-instagram.png', 'Instagram');
        ?>
      </ul>
      <div class="search">
        <button type="button" class="btn-search" aria-expanded="false" aria-controls="site-search">
          <img src="<?php echo Extras\asset_uri('images/icon-search.svg'); ?>" alt="<?php esc_attr_e('Search', 'dayjobsnightlife'); ?>" />
        </button>
        <a class="btn-concierge d-none d-md-inline-block" href="mailto:<?php echo esc_attr($contact['email']); ?>">
          <img src="<?php echo Extras\asset_uri('images/icon-bell.svg'); ?>" alt="<?php esc_attr_e('Concierge', 'dayjobsnightlife'); ?>" />
        </a>
      </div>
      <div id="site-search" class="site-search" hidden>
        <?php get_search_form(); ?>
      </div>
    </div>
  </div>
</header>

<hr />
