<?php $this->load->view('partials/header'); ?>
<div id="container" class="container">
    <div class="logo">
        <img src="/img/logo.png" alt="<?= i18n('the_exchange');?>" title="<?= i18n('the_exchange');?>" class="center-block img-responsive" />
    </div>
    <? if ($this->session->flashdata('logged_out') != ''): ?>
    <div class="alert alert-info timeout">
        <?= i18n('you_have_been_logged_out');?>
    </div>
    <? elseif (isset($token_check) and $token_check !== 'token_valid') : ?>
    <div class="alert alert-danger">
        <?= i18n($token_check);?>
    </div>
    <? elseif ($this->session->flashdata('duplicate_username') != '') : ?>
        <div class="alert alert-danger">
            <?= i18n('duplicate_username');?>
        </div>
    <? elseif ($this->session->flashdata('invalid_email') != '') : ?>
        <div class="alert alert-danger">
            <?= i18n('invalid_email');?>
        </div>
    <? elseif (validation_errors()) : ?>
        <div class="alert alert-warning">
            <?= validation_errors();?>
        </div>
    <? endif; ?>
    <div id="about" class="jumbotron">
        <div class="text-center copy about_copy">
            <?= i18n('welcome_copy');?>
            <div class="getstarted">
                <?php if ((!$this->user->is_logged_in()) and (isset($token_check) and ($token_check == 'token_valid'))) : ?>
				<?php if ($token) : ?>
				<script type="text/javascript">
				    mixpanel.identify("<?= $token;?>");
				</script>
				<?php endif; ?>
                <form action="/welcome" method="POST">
                    <input type="hidden" name="token" value="<?=$token;?>">
                    <?= i18n('enter_email_to_start');?>:
                    <div class="signup_item">
                        <input type="text" class="text_input" name="username" value="<?= set_value('username'); ?>" placeholder="<?= i18n('eg_email_address');?>">
                        <div class="alert alert-info">
                            <p class="smalltext"><?= i18n('email_required');?></p>
                        </div>
                    </div>
                    <div class="more_information col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1">
                        <p></p>
                        <h4><?= i18n('more_information');?></h4>
                        <div class="more_information_info">
                            <?= i18n('more_information_copy');?>
                        </div>
                    </div>
                    <div class="submit spacer wide_width">
<p>By clicking "Sign In" I confirm that I read and accept the 
"Consent to Participate in a Reseach Study"</p>
                        <input class="btn btn-teal btn-lg" type="submit" name="submit" value="<?= i18n('sign_in');?>" />
                    </div>
                        <div class="alert alert-info">
                            <p class="smalltext"><?= i18n('one_time_only');?></p>
                        </div>
                </form>
                <?php else: ?>
                    <div class="more_information col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1">
                        <p></p>
                        <h4><?= i18n('more_information');?></h4>
                        <div class="more_information_info">
                            <?= i18n('more_information_copy');?>
                        </div>
                    </div>
                    <div class="submit spacer wide_width">
                    <? if ($this->user->is_logged_in()) : ?>
                    <a href="/account/next/" class="btn btn-teal btn-lg white">
                        <?= i18n('get_started');?>
                    </a>
                    <?php else : ?>
                    <?= i18n('sign_in_to_play_copy'); ?>
                    <p><?= i18n('invite_only', safe_mailto($this->config->config['contact_email']));?></p>
                    <a href="/account/login" class="btn btn-teal btn-lg white">
                        <?= i18n('sign_in!'); ?>
                    </a>
      <hr class="full_width">

        <div class="interested col-md-6 col-md-offset-3">
            <div class="panel panel-info">
                <?= form_open('account/interested') ?>
                    <h4><?= i18n('interested_in_playing');?></h4>
                    <div class="signup_item">
                        <label for="email"><?= i18n('email_address'); ?>:</label>
                        <input type="text" class="text_input" name="email" value="<?= set_value('email'); ?>" placeholder="<?= i18n('eg_email_address');?>">
                        <?= form_error('email'); ?>
                    </div>
                    <div class="submit">
                        <input class="btn btn-teal" type="submit" name="submit" value="<?=i18n('submit');?>" />
                    </div>
                </form>
            </div>
        </div>

                    <? endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('partials/footer'); ?>
