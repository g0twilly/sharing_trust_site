<?php $this->load->view('partials/header'); ?>
<div id="container" class="container">
    <div class="logo">
        <img src="/img/logo.png" alt="<?= i18n('the_exchange');?>" title="<?= i18n('the_exchange');?>" class="center-block img-responsive" />
    </div>

    <div id="account_info">
    <? if (isset($user)) : ?>
        <div class="alert alert-info">
            <p><strong><?= i18n('logged_in_as', $user->username); ?></strong></p>
            <p><?= i18n('not_you_sign_out');?></p>
        </div>
        <? if (is_devel($user->getMyId())) : ?>
        <div class="alert alert-warning">
            <h3>For Testing Purposes</h3>
            <p>The final functionality should be able to determine where a user is at in the process [game, risk assessment, survey, etc] in case they leave and come back, or an error is encountered.  While that functionality is being finalized, these links have been added as a convenience for testing and debugging</p>
            <ul style="text-align: left">
                <li><a href="/">Overview/Home Page</a></li>
                <? foreach ($this->config->config['order'] as $steps) : ?>
                <li><a href="<?=$this->config->config['step_routes'][$steps];?>"><?= ucwords(str_replace('_', ' ', $steps));?></a></li>
                <? endforeach ;?>
                <li><a href="/complete">Final Results</a></li>
            </ul>
        </div>
        <? endif; ?>
        <? if (is_devel($user->getMyId())) : ?>
        <div class="alert alert-danger">
            <h3>For Debugging Purposes Only</h3>
            <p>Testing the functionality responsible for determining what should be the next step for a user:<br />
                <ul style="text-align: left">
                    <li>Player Grouping: <?= $user->grouping;?></li>
                    <li>Current Step: <?= $user->step;?></li>
                    <li>Next Step: <?= $user->get_next_step();?></li>
                    <li>Random Test: <?php for ($i=0; $i<10; $i++) { echo "! ".$user->set_user_grouping()."! "; } ?></li>
                </ul>
            </p>
        </div>
        <div class="alert alert-success">
                <p><a href="/account/restart/" class="btn btn-success btn-lg">RESTART USER!</a><p>
        </div>
        <? endif; ?>

    <? else : ?>
        <div class="alert alert-warning">
            <p><strong><?= i18n('not_logged_in'); ?></strong></p>
            <p><?= (can_signup()) ? i18n('please_create_or_sign_in') : i18n('please_sign_in'); ?></p>
        </div>
    <? endif; ?>
    </div>
</div>
<?php $this->load->view('partials/footer'); ?>