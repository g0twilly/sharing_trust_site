<div class="playerblock <?=($active) ? 'active' : '';?>">
    <input type="hidden" name="game_id[<?=$id;?>]" value="<?=$robot['id'];?>" />
        <? $this->load->view('partials/game_players.php'); ?>
    <div id="game_form_controls">
        <? $this->load->view('partials/game_form_controls');?>
    </div>
</div>