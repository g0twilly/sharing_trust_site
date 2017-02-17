<?php $this->load->view('partials/header'); ?>
<div id="container" class="container">
    <div class="logo">
        <img src="/img/logo.png" alt="<?= i18n('the_exchange');?>" title="<?= i18n('the_exchange');?>" class="center-block img-responsive" />
    </div>

    <div id="complete">
<? if ($phase == 1) : ?>
        <h3><?= i18n('congratulations_phase_1'); ?></h3>
<? else : ?> 


<? if (1) : ?>

          <br><h3>Here are your investment results from Phase 1...</h3>
<style>
table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
}
th, td {
    padding: 15px;
}
</style>

<center>
<h3>
 <table border="3" style="width:60%">
  <tr>
    <td>In Phase 1, you invested</td>
    <td> <b><?php echo $user->get_my_investment(1) ?></b> credits </td>
  </tr>
  <tr>
    <td>Your partners returned</td>
    <td><b><?php echo $user->get_my_return(1) ?> </b>credits</td>
  </tr>
  <tr>
    <td>Your current balance is</td>
    <td><h2><b><font color='green'><?php echo $user->get_my_game_score(1) ?> credits</b></td>
  </tr>
</table>
</center>
</h3>

<h3><br><p>Here is your placement in Phase 1 compared to other investors...</p></h3> 

<center>
<h3>
 <table border="3" style="width:60%">
  <tr>
    <td>The highest score among all users </td>
    <td> <b><font color='blue'><?php echo $user->get_top_score(1) ?></b> credits </td>
  </tr>
  <tr>
    <td>The 100th highest score is </td>
    <td><b><font color='red'><?php echo $user->get_bottom_score(1) ?></b> credits</td>
  </tr>
</table>
</center>
</h3>
<h3><?= i18n('phase2_complete_message');?></h3>
<!--

<? endif; ?>
      <div class="next_steps col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
            <? if (strlen($this->config->item('phase_1_postgame_survey_url'))&&1==1): ?>
                    <h3><?= i18n('next_steps_phase1');?></h3>
                    <a href="<?= $this->config->item('phase_2_postgame_survey_url').$user->get_my_game_score(1)."&token=".$user->token;?>" class="btn btn-teal btn-lg white">
                        <?= i18n('continue');?>
                    </a>
            <? endif; ?>
        </div>
<? endif; ?>
-->
<!--        <div class="more_information col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1">
            <p><?= i18n('more_information');?></p>
            <div class="more_information_info">
                <?= i18n('more_information_copy');?>
            </div>
        </div>
-->
    </div>
</div>
<?php $this->load->view('partials/footer'); ?>
