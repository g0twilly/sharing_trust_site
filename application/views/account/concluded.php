<?php $this->load->view('partials/header'); ?>
<div id="container" class="container">
    <div class="logo">
        <img src="/img/logo.png" alt="<?= i18n('the_exchange');?>" title="<?= i18n('the_exchange');?>" class="center-block img-responsive" />
    </div>

    <div id="account_info">
        <div class="alert alert-danger">
            <p><?= i18n('study_expired'); ?></p>
        </div>
    </div>
</div>
<?php $this->load->view('partials/footer'); ?>