<?php $this->load->view('partials/header'); ?>
<div id="container" class="container">
    <div class="logo">
        <img src="/img/logo.png" alt="<?= i18n('the_exchange');?>" title="<?= i18n('the_exchange');?>" class="center-block img-responsive" />
    </div>

    <div id="game" data-initial="<?= $current_holdings;?>">
        <div class="jumbotron game_instructions col-md-8 col-md-offset-2 text-left">
			 <button class="full_width btn btn-teal btn-lg" onclick="goBack()"><b>Show me the Instructions</b></button>

			<script>
			function goBack() {
			    window.history.back();
			}
			</script>
        </div>

        <hr class="thinline full_width">
        <?php if (validation_errors()) : ?>
            <div class="alert alert-danger">
                <strong><?= i18n('signup_errors'); ?></strong>
                <?= form_error();?><?= validation_errors();?>
            </div>
        <?php endif; ?>
        <div id="game_box">
            <?= form_open('game/play', array('class' => 'game_form')); ?>
            <input type="hidden" name="investment_sum" value="">
            <? foreach (range(1,$robot_count) as $i): ?>
                <? $this->load->view('partials/game_form', array('user' => $user, 'robot' => $robots[($i-1)], 'active' => ($i == 1), 'id' => $i)); ?>
                <hr class="thinline">
            <? endforeach; ?>
                <div class="row">
                    <div class="center-block top_space">
                        <input id="submit_btn" class="btn btn-lg btn-teal" data-todo="<?= i18n('more_values_to_go');?>" data-continue="<?=i18n('make_investment');?>" disabled="disabled" type="submit" name="submit" value="<?=i18n('make_investment');?>" />
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $this->load->view('partials/idleness_check'); ?>
<?php $this->load->view('partials/footer'); ?>
