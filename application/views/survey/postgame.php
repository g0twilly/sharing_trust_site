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
    <div id="survey"><br><br>
        <div class="teal"><p><h3><?= i18n('voluntary_questions'); ?></p></div>
        <?= form_open('survey/postgame') ?>

            <div class="survey_item satisfaction">
                <label class="site_question"><?= i18n('rate_your_experience');?></label>
                <span class="blue satisfaction_label hidden-xs">Very Unsatisfied</span>
                <div class="btn-group btn-group-sm" data-toggle="buttons">
                <? foreach (range(1,10) as $a) : ?>
                    <label class="btn btn-default <? if (set_radio('rate_your_experience', $a)) :
                    ?>active<?
                    endif;?>"><input type="radio" name="rate_your_experience" <?= set_radio('rate_your_experience', $a); ?> value="<?=$a;?>" /> <?= $a; ?> </label>
                <? endforeach; ?>
                </div>
                <span class="blue satisfaction_label hidden-xs">Very Satisfied</span>
                <?= form_error('rate_your_experience'); ?>
            </div>
            <p />
            <div class="survey_item">
                <label class="site_question"><?= i18n('trust_question'); ?></label>
                <div class="btn-group btn-group-vertical answer_button_group" data-toggle="buttons">
                <? foreach ($trust_answers as $answer) :
                    $a = i18n($answer); ?>
                    <label class="answer_button btn btn-default <? if (set_radio('answer', $a)) :?>active<?endif;?>">
                    <input type="radio" class="answer_button_radio" name="trust_question" <?= set_radio('answer', $a);?> value="<?=$a;?>" /> <?= $a; ?>
                    </label>
                <? endforeach; ?>
                </div>
                <?= form_error('trust_question'); ?>
            </div>
            <div class="submit">
                <input class="btn btn-teal" type="submit" name="submit"  value="<?=i18n('continue');?>" />
            </div>
        </form>
    </div>
</div>
<?php $this->load->view('partials/footer'); ?>
