<?php $this->load->view('partials/header'); ?>
<div id="container" class="container">
    <div class="logo">
        <img src="/img/logo.png" alt="<?= i18n('the_exchange');?>" title="<?= i18n('the_exchange');?>" class="center-block img-responsive" />
    </div>

    <div id="signup">
<?php if (validation_errors()) : ?>
        <div class="alert alert-danger">
            <strong><?= i18n('signup_errors'); ?></strong>
        </div>
<?php endif; ?>
        <h3><?= i18n('choose_an_avatar');?></h3>

    <?= form_open('account/avatar', '', $hidden) ?>
        <input type="hidden" id="avatar_choice" name="avatar" value="<?= set_value('avatar'); ?>" />
        <div class="text-center">
            <label for="avatar"><img src="<?= (set_value('avatar')) ? set_value('avatar') : '/img/avatars/avatar_default.png';?>" class="avatar_thumb" title="avatar"/></label>
        </div>
        <div class="submit">
            <input id="submit" class="btn btn-teal" disabled="disabled" type="submit" name="submit" value="<?=i18n('continue');?>" />
        </div>
        <hr class="full_width">
        <div class="col-sm-10 col-sm-offset-1">
            <div class="avatar_options">
            <?php foreach ($avatars as $avatar) : ?>
                <div class="avatar_option"><input class="avatar_option_img" type="image" src="<?=$avatar;?>" name="avatar" value="<?=$avatar;?>" /></div>
             <?php endforeach; ?>
            </div>
        </div>
    </form>
    </div>
</div>
<?php $this->load->view('partials/footer'); ?>