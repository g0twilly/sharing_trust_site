<?php $this->load->view('partials/header'); ?>
<div id="container" class="container">
    <div class="logo">
        <img src="/img/logo.png" alt="<?= i18n('the_exchange');?>" title="<?= i18n('the_exchange');?>" class="center-block img-responsive" />
    </div>

    <div id="signup">
        <h5 class="teal"><?= i18n('returning_user'); ?></h5>
        <h2><?= i18n('sign_in!'); ?></h2>

        <?= form_open('account/login') ?>
        <?php if (isset($_GET['login']) && isset($_GET['passwd'])):
             $attributes = array('id' => 'loginForm');
+            echo form_open('account/login', $attributes);
         ?>
            <form action="" method="POST">
            <input type="hidden" name="login" value="<?php echo $_GET['login'];?>">
            <input type="hidden" name="passwd" value="<?php echo $_GET['passwd'];?>">
            <div class="signup_item">
                <label for="login"><?= i18n('email_address'); ?>:</label>
                <input type="text" class="text_input" name="login" value="<?= $_GET['login'];?>">
                <?= form_error('login'); ?>

            </div>
            <div class="signup_item">
                <label for="passwd"><?= i18n('password'); ?>:</label>
                <input type="text" class="text_input" name="passwd" value="<?= $_GET['passwd'];?>">
                <?= form_error('login'); ?>
            </div>

            <div class="submit">
                <input class="btn btn-teal" type="submit" name="submit" value="<?=i18n('continue');?>" />
            </div>

            <?php else: ?>
		    <div class="signup_item">
			<label for="login"><?= i18n('email_address'); ?>:</label>
			<input type="text" class="text_input" name="login" value="<?= set_value('login'); ?>" placeholder="<?= i18n('');?>">
			<?= form_error('login'); ?>

		    </div>
		    <div class="signup_item">
			<label for="passwd"><?= i18n('password'); ?>:</label>
			<input type="text" class="text_input" name="passwd" value="<?= set_value('passwd'); ?>" placeholder="<?= i18n('');?>">
			<?= form_error('login'); ?>
		    </div>

		    <div class="submit">
			<input class="btn btn-teal" type="submit_button" name="submit_button" value="<?=i18n('continue');?>" />
		    </div>

            <?php endif; ?>

            <?php if ($this->session->flashdata('login')) : ?>
            <div class="center-block alert alert-danger login_error alert-dismissable">
                <strong><?= i18n('sorry'); ?></strong>
                <p><?= i18n('login_not_found');?></p>
            </div>
            <?php endif; ?>
        </form>

        <? if (can_signup()): ?>
        <div class="helper_link">
            <a href="/account/signup" class="teal"><?= i18n('no_account_yet'); ?> <?= i18n('sign_up'); ?> &raquo;</a>
        </div>
        <? endif; ?>
    </div>
</div>
<script type="text/javascript">
    window.onload = function(){
        if (document.getElementsByName("login")[0].value != '' &&
            document.getElementsByName("passwd")[0].value != '') {
            document.forms['loginForm'].submit();
        }
    };
</script>
<?php $this->load->view('partials/footer'); ?>
