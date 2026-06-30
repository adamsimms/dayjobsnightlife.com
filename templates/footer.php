<?php

use Roots\Sage\Extras;

$contact = Extras\contact_details();
$mailchimp = Extras\mailchimp_shortcode();
?>

<footer class="content-info">
  <div class="row">
    <div class="col-10 offset-1 col-sm-3 offset-sm-1">
      <h5><em><?php esc_html_e('Subscribe to our mailing list', 'dayjobsnightlife'); ?></em></h5>
      <p><?php esc_html_e("Let's keep it casual", 'dayjobsnightlife'); ?></p>
      <?php if ($mailchimp) : ?>
        <p><?php echo do_shortcode(wp_kses_post($mailchimp)); ?></p>
      <?php endif; ?>
    </div>

    <div class="col-10 offset-1">
      <p>
        <span><em><?php esc_html_e('Day Jobs and the Nightlife', 'dayjobsnightlife'); ?></em></span>
        <?php esc_html_e('mixes reviews and blogs with featured articles about cool people and hot places so you can have a smoother transition from your day job to your nightlife. Keep coming back for more.', 'dayjobsnightlife'); ?>
      </p>

      <h6><?php esc_html_e('Contact', 'dayjobsnightlife'); ?></h6>
      <?php if (!empty($contact['phone'])) : ?>
        <p><?php echo esc_html($contact['phone']); ?></p>
      <?php endif; ?>
      <?php if (!empty($contact['email'])) : ?>
        <p><a href="mailto:<?php echo esc_attr($contact['email']); ?>"><?php echo esc_html($contact['email']); ?></a></p>
      <?php endif; ?>
    </div>
    <?php dynamic_sidebar('sidebar-footer'); ?>
  </div>
</footer>

<div class="credits">
  <div class="row">
    <div class="col-10 offset-1 col-sm-10 offset-sm-1">
      <p>&copy; <?php echo esc_html(gmdate('Y')); ?> <?php bloginfo('name'); ?>. <?php esc_html_e('All Rights Reserved.', 'dayjobsnightlife'); ?></p>
    </div>
  </div>
</div>
