<div class="row d-none d-md-block">
  <div class="col-11 col-sm-10 offset-sm-1">
    <nav class="nav-primary">
      <?php if (has_nav_menu('primary_navigation')) : ?>
        <?php
        wp_nav_menu([
          'theme_location' => 'primary_navigation',
          'menu_class' => 'nav',
        ]);
        ?>
      <?php endif; ?>
    </nav>
  </div>
</div>
