<header class="branding">
  <div class="container-fluid">
    <div class="row">
          <div class="col-xs-10 offset-xs-1">
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
          <div class="col-xs-12">
            <a class="logotype" href="<?= esc_url(home_url('/')); ?>"><img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/logotype.png" alt="<?php bloginfo('name'); ?>" /></a>
          </div>
        </div>
        <div class="row hidden-xs-down" sticky"">
          <div class="col-xs-12 col-sm-10 offset-sm-1">
            <nav class="nav-primary">
              <?php
                if (has_nav_menu('primary_navigation')) : wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'nav']);
                endif;
              ?>
            </nav>
          </div>
        </div>
  </div>
</header>
