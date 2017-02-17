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
            <div class="question_text"><p><?= i18n('risk_question2'); ?></p></div>
            <div class="risk2_buttons">
                <?= form_open('risk2', array('class' => 'col-md-6 col-md-offset-3 text-center risk2_form')) ?>
                    <div class="input-group bigspacer smaller-input">
                        <div class="input-group-addon">$</div>
                        <input type="number" class="form-control" name="answer" value="<?= set_value('answer');?>" placeholder="Amount">
                    </div>
                    <?= form_error('answer'); ?>
                    <div class="submit">
                        <input class="btn btn-teal" type="submit" name="submit" value="<?=i18n('continue');?>" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('partials/footer'); ?>
