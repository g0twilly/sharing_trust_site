<?php $this->load->view('partials/header'); ?>
<div id="container" class="container">
    <div class="logo">
        <img src="/img/logo.png" alt="<?= i18n('the_exchange');?>" title="<?= i18n('the_exchange');?>" class="center-block img-responsive" />
    </div>

    <div id="overview">
        <div class="panel col-md-8 col-md-offset-2">
            <div class="panel-body">
                <h3><?= i18n('ready_to_play');?></h3>
                <hr class="full_width">
                <?= i18n('game_overview', $this->config->item('credits'));?>
            </div>
        </div>
        <div class="action_buttons">
            <div class="row">
                <div class="col-md-4 col-md-offset-4 col-sm-8 col-sm-offset-2 col-xs-10 col-xs-offset-1">
                    <h5><?= i18n('must_complete_info');?></h5>
                    <a href="/game/instructions/" class="full_width btn btn-teal btn-lg"><?= i18n('get_started');?></a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('partials/footer'); ?>
