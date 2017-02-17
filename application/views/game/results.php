<?php $this->load->view('partials/header'); ?>
<div id="container" class="container">
    <div class="logo">
        <img src="/img/logo.png" alt="<?= i18n('the_exchange');?>" title="<?= i18n('the_exchange');?>" class="center-block img-responsive" />
    </div>

    <div id="gameover">
        <div class="col-md-8 col-md-offset-2">
            <div>
                <? if ($this->config->item('phase') == 1) : ?>
		    <h3 class="game_title"><?= i18n('completed_the_game'); ?></h3>
		    <hr class="full_width">
                    <h4 class="spacer"><?= i18n('will_you_come_back'); ?><h4>
                    <?= form_open('game/complete', array('class' => 'col-md-6 text-center'), array('answer' => 'yes')) ?>
                        <button type="submit" class="btn btn-lg btn-default btn-block"><span><?= i18n('yes') ?></span></button>
                        <?= form_error('answer'); ?>
                    </form>
                    <?= form_open('game/complete', array('class' => 'col-md-6 text-center'), array('answer' => 'no')) ?>
                        <button type="submit" class="btn btn-lg btn-default btn-block"><span><?= i18n('no') ?></span></button>
                        <?= form_error('answer'); ?>
                    </form>
                <? else : ?>
                    <h3><?= i18n('next_steps_phase1');?></h3>
                    <a href="<?= $this->config->item('phase_1_postgame_survey_url').$user->token;?>" class="btn btn-teal btn-lg white">
                        <?= i18n('continue');?>
                    </a>

		    <h3 class="game_title"><?= i18n('completed_the_game2'); ?></h3>
		    <hr class="full_width">
                    <a href="/account/next/" class="btn btn-teal btn-lg white">
                        <?= i18n('continue');?>
                    </a>
                <? endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('partials/footer'); ?>
