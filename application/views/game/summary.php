<?php $this->load->view('partials/header'); ?>
<div id="container" class="container">
    <div class="logo">
        <img src="/img/logo.png" alt="<?= i18n('the_exchange');?>" title="<?= i18n('the_exchange');?>" class="center-block img-responsive" />
    </div>

    <div id="summary" data-game_key="<?= $game_key;?>">
        <h1 class="game_title"><?= i18n('round');?> <?= $round; ?> <?= i18n('summary');?></h1>

        <? $this->load->view('partials/game_players'); ?>
        <div id="activity">
            <? if ($role == 'investor') : ?>
                <? $this->load->view('partials/investor_summary_load'); ?>
            <? else : ?>
                <? $this->load->view('partials/recipient_summary_load'); ?>
            <? endif;?>
        </div>
    </div>
</div>
<?php $this->load->view('partials/footer'); ?>