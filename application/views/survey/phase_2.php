<?php $this->load->view('partials/header'); ?>
<div id="container" class="container">
    <div class="logo">
        <img src="/img/logo.png" alt="<?= i18n('the_exchange');?>" title="<?= i18n('the_exchange');?>" class="center-block img-responsive" />
    </div>

    <div id="gameover">
        <div class="col-md-8 col-md-offset-2">
            <div>
      <h3 class="survey_title"><?= i18n('please_answer_the_following'); ?></h3>
        <h3 class="survey_title"><?= i18n('please_answer_the_following0'); ?></h3>

                    <a href="/survey/airbnb/" class="btn btn-teal btn-lg white">
                        <?= i18n('continue');?>
                    </a>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('partials/footer'); ?>
