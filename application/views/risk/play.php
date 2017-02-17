<?php $this->load->view('partials/header'); ?>
<div id="container" class="container">
    <div class="logo">
        <img src="/img/logo.png" alt="<?= i18n('the_exchange');?>" title="<?= i18n('the_exchange');?>" class="center-block img-responsive" />
    </div>
    <? if ($this->session->flashdata('save_error') != ''): ?>
    <div class="alert alert-danger">
        <?= i18n('save_error');?>
    </div>
    <? elseif (validation_errors()) : ?>
    <div class="alert alert-danger">
        <strong><?= i18n('signup_errors'); ?></strong>
    </div>
    <? endif; ?>
    <div id="survey">
        <h3 class="survey_title teal"><?= i18n('consider_the_following'); ?></h3>
        <div class="survey_item col-md-8 col-md-offset-2">
            <div class="question_text"><p><?= i18n('risk_question'); ?></p></div>
            <div class="risk_buttons">
            <? foreach (array('a', 'b', 'c') as $answer) :
                $a = i18n('risk_answer_'.$answer); ?>
                <?= form_open('risk', array('class' => 'col-md-10 col-md-offset-1 text-center risk_form'), array('answer' => $a)) ?>
                    <button type="submit" class="btn btn-lg btn-default btn-block"><span><?= $a; ?></span></button>
                    <?= form_error('answer'); ?>
                </form>
            <? endforeach; ?>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('partials/footer'); ?>