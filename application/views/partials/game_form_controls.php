<div class="row">
     <div class="game_block col-md-6 col-sm-6">
        <div class="form_block">
            <div class="current_holdings right-side-pad">
                <h5><?= i18n('current_holdings');?></h5>
                <h3 class="holdings"><span class="myholdings"><?= $current_holdings; ?></span> <?= i18n('credits');?></h3>
            </div>
        </div>
    </div>
    <div class="game_block col-md-6 col-sm-6">
        <div class="form_block">
            <div class="current_lendings left-side-pad">
                    <h5 class="game_label lavender"><?= i18n('amount_to_invest', 'Player 1');?></h5>
                    <div class="input-group game_input_group">
                        <input type="hidden" name="investment_stamp[<?=$id;?>]" class="timestamp" value="<?= set_value('investment_stamp['.$id.']');?>" />
                        <input type="number" min="0" max="<?= $current_holdings;?>" class="form-control game_input activate_submit<?= (form_error('investment['.$id.']')) ? ' error' : ''; ?>" name="investment[<?= $id;?>]" value="<?= set_value('investment['.$id.']'); ?>">
                        <span class="input-group-addon game_credit_label"><?= i18n('credits');?></span>
                    </div>
                    <?= form_error('investment['.$id.']'); ?>
            </div>
        </div>
    </div>
</div>