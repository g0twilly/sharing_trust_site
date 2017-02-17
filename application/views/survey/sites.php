<?php $this->load->view('partials/header'); ?>
<div id="container" class="container">
    <div class="logo">
        <img src="/img/logo.png" alt="<?= i18n('the_exchange');?>" title="<?= i18n('the_exchange');?>" class="center-block img-responsive" />
    </div>

    <div id="survey">
        <h3 class="survey_title"><?= i18n('please_answer_these_questions'); ?></h3>
<?php if (validation_errors()) : ?>
<div class="alert alert-danger">
<strong><?= i18n('signup_errors'); ?></strong>
</div>
<?php endif; ?>
        <?= form_open('survey/sites') ?>
            <? foreach ($sites as $id => $site) : ?>
                <div class="survey_site">
                   <div class="survey_item">
                        <h3 class="lavender underline"><?= $site; ?></h3>
                        <input type="hidden" name="site[<?= $id ;?>][site_id]" value="<?= $id ?>" />
<!--Phase 1 Question--> 
<!--
                        <label class="site_question"><?= i18n('membership_length');?></label>
                        <div class="show_bigger">
                            <div class="btn-group btn-group-sm" data-toggle="buttons">
                            <? foreach ($length as $l) : ?>
                                <label class="frequency_button btn btn-default <? if (set_radio('site['.$id.'][length]', $l)) :
                                ?>active<?
                                endif;?>"><input type="radio" name="site[<?= $id; ?>][length]" <?= set_radio('site['.$id.'][length]', $l);?> value="<?=$l;?>" /> <?= i18n($l); ?> </label>
                            <? endforeach; ?>
                            </div>
                        </div>
                        <div class="show_smaller">
                            <div class="btn-group btn-group-vertical frequency_button_group" data-toggle="buttons">
                            <? foreach ($length as $l) : ?>
                                <label class="frequency_button btn btn-default <? if (set_radio('site['.$id.'][length]', $l)) :
                                ?>active<?
                                endif;?>"><input type="radio" name="site[<?= $id; ?>][length]" <?= set_radio('site['.$id.'][length]', $l);?> value="<?=$l;?>" /> <?= i18n($l); ?> </label>
                            <? endforeach; ?>
                            </div>
                        </div>
                        <?= form_error('site['.$id.'][length]'); ?>
-->
                    </div>
<!--Phase 1 Question -->    
<!--
                    <div class="survey_item">
                        <label class="site_question"><?= i18n('how_often_do_you_use_the_site');?></label>
                        <div class="show_bigger">
                            <div class="btn-group btn-group-sm" data-toggle="buttons">
                            <? foreach ($frequency as $f) : ?>
                                <label class="frequency_button btn btn-default <? if (set_radio('site['.$id.'][frequency]', $f)) :
                                ?>active<?
                                endif;?>"><input type="radio" name="site[<?= $id; ?>][frequency]" <?= set_radio('site['.$id.'][frequency]', $f);?> value="<?=$f;?>" /> <?= i18n($f); ?> </label>
                            <? endforeach; ?>
                            </div>
                        </div>
                        <div class="show_smaller">
                            <div class="btn-group btn-group-vertical frequency_button_group" data-toggle="buttons">
                            <? foreach ($frequency as $f) : ?>
                                <label class="frequency_button btn btn-default <? if (set_radio('site['.$id.'][frequency]', $f)) :
                                ?>active<?
                                endif;?>"><input type="radio" name="site[<?= $id; ?>][frequency]" <?= set_radio('site['.$id.'][frequency]', $f);?> value="<?=$f;?>" /> <?= i18n($f); ?> </label>
                            <? endforeach; ?>
                            </div>
                        </div>
                        <?= form_error('site['.$id.'][how_often_do_you_use_the_site]'); ?>
                    </div>
-->                    
<!--Phase 2 and 3 Question -->     
                    <div class="survey_item">
                        <label class="site_question"><?= i18n('freq_last_1');?></label>
                        <div class="show_bigger">
                            <div class="btn-group btn-group-sm" data-toggle="buttons">
                            <? foreach ($frequency as $f) : ?>
                                <label class="frequency_button btn btn-default <? if (set_radio('site['.$id.'][freq_last_1]', $f)) :
                                ?>active<?
                                endif;?>"><input type="radio" name="site[<?= $id; ?>][freq_last_1]" <?= set_radio('site['.$id.'][freq_last_1]', $f);?> value="<?=$f;?>" /> <?= i18n($f); ?> </label>
                            <? endforeach; ?>
                            </div>
                        </div>
                        <div class="show_smaller">
                            <div class="btn-group btn-group-vertical frequency_button_group" data-toggle="buttons">
                            <? foreach ($frequency as $f) : ?>
                                <label class="frequency_button btn btn-default <? if (set_radio('site['.$id.'][freq_last_1]', $f)) :
                                ?>active<?
                                endif;?>"><input type="radio" name="site[<?= $id; ?>][freq_last_1]" <?= set_radio('site['.$id.'][freq_last_1]', $f);?> value="<?=$f;?>" /> <?= i18n($f); ?> </label>
                            <? endforeach; ?>
                            </div>
                        </div>
                        <?= form_error('site['.$id.'][freq_last_1]'); ?>
                    </div>
<!-- Phase 1 2 and 3 Question -->                    
                    <div class="survey_item satisfaction">
                        <label class="site_question"><?= i18n('how_satisfied_are_you');?></label>
                        <span class="grey satisfaction_label"><?= i18n('unsatisfied');?></span>
                        <div class="btn-group btn-group-sm" data-toggle="buttons">
                        <? for ($i=1;$i<=5;$i++) : ?>
                            <label class="btn btn-default <? if (set_radio('site['.$id.'][satisfaction]', $i)) :
                            ?>active<?
                            endif;?>"><input type="radio" name="site[<?= $id; ?>][satisfaction]" <?= set_radio('site['.$id.'][satisfaction]', $i);?> value="<?=$i;?>" /> <?= $i; ?> </label>
                        <? endfor; ?>
                        </div>
                        <span class="grey satisfaction_label"><?= i18n('satisfied'); ?></span>
                        <?= form_error('site['.$id.'][satisfaction]'); ?>
                    </div>
<!-- Phase 1 Question -->   
<!--
                   <div class="survey_item">
                        <label class="site_question"><?= i18n('negative_experience');?></label>
                        <div class="show_bigger">
                            <div class="btn-group btn-group-sm" data-toggle="buttons">
                            <? foreach ($negative as $n) : ?>
                                <label class="frequency_button btn btn-default <? if (set_radio('site['.$id.'][negative]', $n)) :
                                ?>active<?
                                endif;?>"><input type="radio" name="site[<?= $id; ?>][negative]" <?= set_radio('site['.$id.'][negative]', $n);?> value="<?=$n;?>" /> <?= i18n($n); ?> </label>
                            <? endforeach; ?>
                            </div>
                        </div>
                        <div class="show_smaller">
                            <div class="btn-group btn-group-vertical frequency_button_group" data-toggle="buttons">
                            <? foreach ($negative as $n) : ?>
                                <label class="frequency_button btn btn-default <? if (set_radio('site['.$id.'][negative]', $n)) :
                                ?>active<?
                                endif;?>"><input type="radio" name="site[<?= $id; ?>][negative]" <?= set_radio('site['.$id.'][negative]', $n);?> value="<?=$n;?>" /> <?= i18n($n); ?> </label>
                            <? endforeach; ?>
                            </div>
                        </div>
                        <?= form_error('site['.$id.'][negative]'); ?>
                    </div>
-->                    
<!-- Phase 2 and 3 Question -->                    
                   <div class="survey_item">
                        <label class="site_question"><?= i18n('neg_last_1');?></label>
                        <div class="show_bigger">
                            <div class="btn-group btn-group-sm" data-toggle="buttons">
                            <? foreach ($negative as $n) : ?>
                                <label class="frequency_button btn btn-default <? if (set_radio('site['.$id.'][neg_last_1]', $n)) :
                                ?>active<?
                                endif;?>"><input type="radio" name="site[<?= $id; ?>][neg_last_1]" <?= set_radio('site['.$id.'][neg_last_1]', $n);?> value="<?=$n;?>" /> <?= i18n($n); ?> </label>
                            <? endforeach; ?>
                            </div>
                        </div>
                        <div class="show_smaller">
                            <div class="btn-group btn-group-vertical frequency_button_group" data-toggle="buttons">
                            <? foreach ($negative as $n) : ?>
                                <label class="frequency_button btn btn-default <? if (set_radio('site['.$id.'][neg_last_1]', $n)) :
                                ?>active<?
                                endif;?>"><input type="radio" name="site[<?= $id; ?>][neg_last_1]" <?= set_radio('site['.$id.'][neg_last_1]', $n);?> value="<?=$n;?>" /> <?= i18n($n); ?> </label>
                            <? endforeach; ?>
                            </div>
                        </div>
                        <?= form_error('site['.$id.'][neg_last_1]'); ?>
                    </div>
<!--Phase 1 Question --> 
<!--
                    <div class="survey_item monetary">
                        <label class="site_question"><?= i18n('monetary_reason');?></label>
                        <span class="grey satisfaction_label"><?= i18n('completely_disagree');?></span>
                        <div class="btn-group btn-group-sm" data-toggle="buttons">
                        <? for ($i=1;$i<=5;$i++) : ?>
                            <label class="btn btn-default <? if (set_radio('site['.$id.'][monetary]', $i)) :
                            ?>active<?
                            endif;?>"><input type="radio" name="site[<?= $id; ?>][monetary]" <?= set_radio('site['.$id.'][monetary]', $i);?> value="<?=$i;?>" /> <?= $i; ?> </label>
                        <? endfor; ?>
                        </div>
                        <span class="grey satisfaction_label"><?= i18n('completely_agree'); ?></span>
                        <?= form_error('site['.$id.'][monetary]'); ?>
                    </div>                    
                </div>
-->                
<!--Phase 2 and 3 Question -->
                   <div class="survey_item">
                        <label class="site_question"><?= i18n('future_user');?></label>
                        <div class="show_bigger">
                            <div class="btn-group btn-group-sm" data-toggle="buttons">
                            <? foreach ($negative as $n) : ?>
                                <label class="frequency_button btn btn-default <? if (set_radio('site['.$id.'][future_user]', $n)) :
                                ?>active<?
                                endif;?>"><input type="radio" name="site[<?= $id; ?>][future_user]" <?= set_radio('site['.$id.'][future_user]', $n);?> value="<?=$n;?>" /> <?= i18n($n); ?> </label>
                            <? endforeach; ?>
                            </div>
                        </div>
                        <div class="show_smaller">
                            <div class="btn-group btn-group-vertical frequency_button_group" data-toggle="buttons">
                            <? foreach ($negative as $n) : ?>
                                <label class="frequency_button btn btn-default <? if (set_radio('site['.$id.'][future_user]', $n)) :
                                ?>active<?
                                endif;?>"><input type="radio" name="site[<?= $id; ?>][future_user]" <?= set_radio('site['.$id.'][future_user]', $n);?> value="<?=$n;?>" /> <?= i18n($n); ?> </label>
                            <? endforeach; ?>
                            </div>
                        </div>
                        <?= form_error('site['.$id.'][future_user]'); ?>
                    </div>
<!-- Phase 2 and 3 Question -->                    
                   <div class="survey_item">
                        <label class="site_question"><?= i18n('community');?></label>
                        <div class="show_bigger">
                            <div class="btn-group btn-group-sm" data-toggle="buttons">
                            <? foreach ($negative as $n) : ?>
                                <label class="frequency_button btn btn-default <? if (set_radio('site['.$id.'][community]', $n)) :
                                ?>active<?
                                endif;?>"><input type="radio" name="site[<?= $id; ?>][community]" <?= set_radio('site['.$id.'][community]', $n);?> value="<?=$n;?>" /> <?= i18n($n); ?> </label>
                            <? endforeach; ?>
                            </div>
                        </div>
                        <div class="show_smaller">
                            <div class="btn-group btn-group-vertical frequency_button_group" data-toggle="buttons">
                            <? foreach ($negative as $n) : ?>
                                <label class="frequency_button btn btn-default <? if (set_radio('site['.$id.'][community]', $n)) :
                                ?>active<?
                                endif;?>"><input type="radio" name="site[<?= $id; ?>][community]" <?= set_radio('site['.$id.'][community]', $n);?> value="<?=$n;?>" /> <?= i18n($n); ?> </label>
                            <? endforeach; ?>
                            </div>
                        </div>
                        <?= form_error('site['.$id.'][community]'); ?>
                    </div>
                </div>
            <? endforeach; ?>
            <div class="submit">
                <input class="btn btn-teal" id="survey_btn" type="submit" name="submit" value="<?=i18n('continue');?>" />
            </div>
        </form>
    </div>
</div>
<?php $this->load->view('partials/footer'); ?>
