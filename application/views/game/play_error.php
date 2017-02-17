<?php $this->load->view('partials/header'); ?>
<div id="container" class="container">
    <div class="logo">
        <img src="/img/logo.png" alt="<?= i18n('the_exchange');?>" title="<?= i18n('the_exchange');?>" class="center-block img-responsive" />
    </div>

    <div id="game">
        <h1 class="game_title"><?= i18n('round');?> <?= $round; ?></h1>
        <div id="game_box_error">
            <? $this->load->view('partials/game_form_error'); ?>
        </div>
        <? $this->load->view('partials/game_previous'); ?>

    </div>
</div>
<?php $this->load->view('partials/idleness_check'); ?>
<?php $this->load->view('partials/footer'); ?>