<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="/">
      <img src="<?php echo get_template_directory_uri() ?>/assets/img/cool-kids-network-high-resolution-logo-transparent.png" width="250" height="100" alt="Cool Kids Network Logo" />
    </a>
    <?php if (is_user_logged_in()) { ?>
      <a id="logout" href="<?php echo wp_logout_url(); ?>">Logout</a>
    <?php } ?>
  </div>
</nav>



