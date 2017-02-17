<?php $this->load->view('partials/header'); ?>
<div id="container" class="container">
    <div class="logo">
        <img src="/img/logo.png" alt="<?= i18n('the_exchange');?>" title="<?= i18n('the_exchange');?>" class="center-block img-responsive" />
    </div>
    <div id="about" class="jumbotron">
        <div class="text-center copy about_copy">
            <p><?= i18n('profile_signup'); ?></p>
		<div class="alert alert-info">
		    <p class="smalltext"><?= i18n('your_role');?></p>
		</div>
            <p><?= i18n('profile_signup2'); ?></p>
            <img src="img/avatars/neutral/avatar02.jpg" alt="Mountain View" style="width:84px;height:75px;">
            <img src="img/avatars/neutral/avatar02.jpg" alt="Mountain View" style="width:84px;height:75px;">
            <img src="img/avatars/neutral/avatar02.jpg" alt="Mountain View" style="width:84px;height:75px;">
            <img src="img/avatars/neutral/avatar02.jpg" alt="Mountain View" style="width:84px;height:75px;">
            <img src="img/avatars/neutral/avatar02.jpg" alt="Mountain View" style="width:84px;height:75px;">
            <p><?= i18n('profile_signup3'); ?></p>
            <div class="getstarted">
                <form action="/account/signup" method="POST">
                    <input type="hidden" name="token" value="<?=$token;?>">
                    <input type="hidden" name="email" value="<?=$username;?>">
                    <div class="submit">
                        <input class="btn btn-teal btn-lg" type="submit" name="submit" value="<?= i18n('sign_up');?>" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('partials/footer'); ?>
