<?php $this->load->view('partials/header'); ?>
<div id="container" class="container">
    <div class="logo">
        <img src="/img/logo.png" alt="<?= i18n('the_exchange');?>" title="<?= i18n('the_exchange');?>" class="center-block img-responsive" />
    </div>

    <div id="survey">
        <h3 class="survey_title"><?= i18n('answer_the_following_question'); ?></h5>

<?= form_open('survey/trust') ?>

    <?php foreach ($question as $q => $as) : ?>
    <div class="survey_item">
        <div class="question_text"><p><?= i18n($q); ?></p></div>
        <input type="hidden" name="question" value="<?= i18n($q)?>" />
                <div class="btn-group btn-group-vertical answer_button_group" data-toggle="buttons">
                <? foreach ($as as $answer) :
                    $a = i18n($answer); ?>
                    <label class="answer_button btn btn-default <? if (set_radio('answer', $a)) :?>active<?endif;?>">
                    <input type="radio" class="answer_button_radio" name="answer" <?= set_radio('answer', $a);?> value="<?=$a;?>" /> <?= $a; ?>
                    </label>
                <? endforeach; ?>
                </div>
        <?= form_error('answer'); ?>
    </div>
    <?php endforeach; ?>
    <div class="submit">
        <input class="btn btn-teal" id="survey_btn" type="submit" name="submit"  disabled="disabled" value="<?=i18n('continue');?>" />
    </div>
</form>
    </div>
</div>
<?php $this->load->view('partials/footer'); ?>