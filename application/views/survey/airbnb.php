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
        <h3 class="survey_title"><?= i18n('please_answer_the_following1'); ?></h3>
        <div class="teal"><p><?= i18n('eligibility_contingency'); ?></p></div>
        <?= form_open('survey/airbnb') ?>

           <div class="survey_item">
                <label class="site_question"><?= i18n('host_or_guest');?></label>
                <div class="btn-group btn-group-sm" data-toggle="buttons">
                <? foreach (array("yes", "no") as $a) : ?>
                    <label class="frequency_button btn btn-default <? if (set_radio('host_or_guest', $a)) :
                    ?>active<?
                    endif;?>"><input type="radio" class="activate_submit show_hide_btn" name="host_or_guest" <?= set_radio('host_or_guest', $a); ?> value="<?=$a;?>" /> <?= i18n($a); ?> </label>
                <? endforeach; ?>
                </div>
                <?= form_error('host_or_guest'); ?>
            </div>
            <div class="show_if_yes" data-qid="host_or_guest">
                <div class="survey_item">
                    <label class="site_question"><?= i18n('interact_with_host');?></label>
                    <div class="btn-group btn-group-sm" data-toggle="buttons">
                    <? foreach (array("yes", "no") as $a) : ?>
                        <label class="frequency_button btn btn-default <? if (set_radio('interact_with_host', $a)) :
                        ?>active<?
                        endif;?>"><input type="radio" class="activate_submit show_hide_btn" name="interact_with_host" <?= set_radio('interact_with_host', $a); ?> value="<?=$a;?>" /> <?= i18n($a); ?> </label>
                    <? endforeach; ?>
                    </div>
                    <?= form_error('interact_with_host'); ?>
                </div>

                <div class="show_if_yes" data-qid="interact_with_host">

                    <div class="survey_item">
                        <label class="site_question"><?= i18n('describe_interaction');?></label>
                        <div data-toggle="buttons">
                        <? foreach (array("checking_in_to_a_hotel", "talking_with_a_friend") as $a) : ?>
                            <label class="survey_button btn btn-default <? if (set_radio('first_interaction', i18n($a))) :
                            ?>active<?
                            endif;?>"><input type="radio" class="activate_submit" name="first_interaction" <?= set_radio('first_interaction', i18n($a)); ?> value="<?=i18n($a);?>" /> <?= i18n($a); ?> </label>
                        <? endforeach; ?>
                        </div>
                        <?= form_error('first_interaction'); ?>
                    </div>

                    <div class="survey_item">
                        <label class="site_question"><?= i18n('hangout_with_host');?></label>
                        <div class="btn-group btn-group-sm" data-toggle="buttons">
                        <? foreach (array("yes", "no") as $a) : ?>
                            <label class="frequency_button btn btn-default <? if (set_radio('hangout', $a)) :
                            ?>active<?
                            endif;?>"><input type="radio" class="activate_submit" name="hangout" <?= set_radio('hangout', $a); ?> value="<?=$a;?>" /> <?= i18n($a); ?> </label>
                        <? endforeach; ?>
                        </div>
                        <?= form_error('hangout'); ?>
                    </div>

                </div>
            </div>

            <div class="submit">
                <input class="btn btn-teal" id="survey_btn" type="submit" name="submit"  disabled="disabled" value="<?=i18n('continue');?>" />
            </div>
        </form>
    </div>
</div>
<?php $this->load->view('partials/footer'); ?>
