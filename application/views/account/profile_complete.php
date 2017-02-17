<?php $this->load->view('partials/header'); ?>
<div id="container" class="container">
    <div class="logo">
        <img src="/img/logo.png" alt="<?= i18n('the_exchange');?>" title="<?= i18n('the_exchange');?>" class="center-block img-responsive" />
    </div>
    <div id="about" class="jumbotron">
        <div class="text-center copy about_copy">
            <h3><?= i18n('profile_complete');?></h3>

            <div class="profile_complete">
                <div class="info_block text-center">
                    <div class="user_avatar center-block">
                        <img src="<?=$user->get_avatar();?>" />
                    </div>
                    <div class="user_info center-block">
				<div class="info_line"><strong><?= i18n('age');?> : </strong> <?= $user->age;?> <?= i18n('year_old');?></div>
                                <div class="info_line"><strong><?= i18n('status');?> : </strong> <?= i18n($user->marital_status);?></div>
                	       <div class="info_line"><strong><?= i18n('gender');?> : </strong> <?= i18n($user->gender);?> </div>
                               <div class="info_line"><strong><?= i18n('from');?> : </strong> <?= ($user->get_state_from_zip($user->zip));?></div>
                <div class="role"><strong><?= i18n('role');?> : </strong> <?= i18n('investor');?></div>
                    </div>
                </div>

                <hr class="full_width">
                <a href="/account/next/" class="btn btn-teal btn-lg white">
                    <?= i18n('continue');?>
                </a>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('partials/footer'); ?>
