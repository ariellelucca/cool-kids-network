<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
  <?php if (file_exists(get_template_directory() . "/assets/img/new-logo.jpg" )) { ?>
      <a class="navbar-brand" href="/">
        <img src="<?php echo get_template_directory_uri() ?>/assets/img/new-logo.jpg" width="250" height="100" alt="Cool Kids Network Logo" />
      </a>
    <?php } ?>
    <?php if (is_user_logged_in()) { ?>
      <a id="logout" href="<?php echo wp_logout_url(); ?>">Logout</a>
    <?php } ?>
  </div>
</nav>



