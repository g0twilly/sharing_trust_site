<?php $this->load->view('partials/header'); ?>
<div id="container" class="container">
    <div class="logo">
        <img src="/img/logo.png" alt="<?= i18n('the_exchange');?>" title="<?= i18n('the_exchange');?>" class="center-block img-responsive" />
    </div>

    <div id="game">
            <?php if (validation_errors()) : ?>
            <div class="alert alert-danger">
                <strong><?= i18n('signup_errors'); ?></strong>
                <?= i18n('you_must_understand');?>
            </div>
        <?php endif; ?>
        <div class="jumbotron game_instructions col-md-8 col-md-offset-2 text-left">
            <? if ($this->config->item('phase') == 1) : ?>
            <?= i18n('choose_what_to_give_phase_1');?>
            <? else : ?>
            <?= i18n('choose_what_to_give_phase_1');?>
            <? endif; ?>
            <div class="action_buttons">
                <?= form_open('game/instructions', array('class' => 'game_form'), array('instructions' => 'yes')); ?>
                    <div class="row">
                        <div class="col-md-4 col-md-offset-4 col-sm-8 col-sm-offset-2 col-xs-10 col-xs-offset-1">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" value="yes" name="understand"><?= i18n('i_understand');?>
                                </label>
                            </div>
                            <button type="submit" class="full_width btn btn-teal btn-lg"><?= i18n('get_started');?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('partials/footer'); ?>
