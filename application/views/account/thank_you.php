<?php $this->load->view('partials/header'); ?>
<div id="container" class="container">
    <div class="logo">
        <img src="/img/logo.png" alt="<?= i18n('the_exchange');?>" title="<?= i18n('the_exchange');?>" class="center-block img-responsive" />
    </div>

    <div id="account_info">
        <div class="alert alert-success">
            <p><?= i18n('thank_you_for_your_interest'); ?></p>
        </div>
    </div>
</div>
<?php $this->load->view('partials/footer'); ?>