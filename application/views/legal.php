<?php $this->load->view('partials/header'); ?>
<div id="container" class="container">
    <div class="logo">
        <img src="/img/logo.png" alt="<?= i18n('the_exchange');?>" title="<?= i18n('the_exchange');?>" class="center-block img-responsive" />
    </div>

    <div id="about">
        <h3><?= i18n('legal');?></h3>

        <div class="copy">
            <?= i18n('legal_copy');?>
        </div>
    </div>
</div>
<?php $this->load->view('partials/footer'); ?>
