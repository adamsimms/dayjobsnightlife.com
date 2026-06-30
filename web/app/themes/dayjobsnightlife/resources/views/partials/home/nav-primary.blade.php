<div class="row d-none d-md-block">
  <div class="col-11 col-sm-10 offset-sm-1">
    <nav class="nav-primary" aria-label="{{ __('Primary navigation', 'dayjobsnightlife') }}">
      @if (has_nav_menu('primary_navigation'))
        {!! wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'nav', 'echo' => false]) !!}
      @endif
    </nav>
  </div>
</div>
