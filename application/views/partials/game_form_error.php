<?= form_open('game/play', array('class' => 'game_form')); ?>
    <input type="hidden" name="game_id" value="<?=$game_id;?>" />
    <? $this->load->view('partials/game_players.php'); ?>
    <div id="game_form_controls">
        <? $this->load->view('partials/game_form_controls');?>
    </div>
</form>