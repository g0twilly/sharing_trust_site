<? if ($role == 'investor') : ?>
    <? $this->load->view('partials/investor_summary_breakdown'); ?>
<? else : ?>
    <? $this->load->view('partials/recipient_summary_breakdown'); ?>
<? endif;?>

<div class="row">
    <a href="/game/play" class="btn btn-teal"><?= i18n('next_round');?></a>
</div>
