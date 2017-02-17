<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="sr-only"><?= i18n('toggle_navigation');?></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    </div>
    <div class="collapse navbar-collapse">
      <ul class="nav navbar-nav">
        <li><a class="navlinks" href="/"><?= i18n('overview');?></a></li>
      <?php if ($this->user->is_logged_in()) : ?>
        <li><a class="navlinks" href="/account/logout"><?= i18n('sign_out');?></a></li>
        <?php if (is_devel($this->user->getMyId())) : ?><li><a class="navlinks" href="/account/info">Account Info</a></li><? endif ?>
      <?php else : ?>
        <li><a class="navlinks" href="/account/login"><?= i18n('sign_in');?></a></li>
      <?php endif; ?>
        <li class="navlogowrapper">
          <a href="http://www.stanford.edu/"><img class="navlogo" src="/img/stanford_logo.png" alt="Stanford Seal" title="Stanford Seal"></a>
        </li>
      </ul>
    </div>
  </div>
</div>
