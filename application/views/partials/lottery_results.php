<div id="lottery_info">
    <div class="row">
        <div class="risk_item col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
            <p><?= i18n("lottery_chosen");?></p>
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="pie_image_lg">
                        <img src="<?= $this->config->item('pie_img_url').'pie-lg-'.$options[$lottery]['max'].'.jpg';?>"
                            title="<?=$options[$lottery]['max'].'%';?>" class="pie_lg" />
                    </div>
                    <div class="risk_options">
                        <span class="lavender risk_option<?= ($maxmin == 'max') ? ' win' : '';?>">
                        <?= $options[$lottery]['max'].'% '.
                             i18n('chance_to_win').' '.
                             i18n('option_'.$pick.'_max'); ?>
                        </span><br />
                        <span class="or"><?= i18n('or'); ?><br />
                        <span class="purple risk_option<?= ($maxmin == 'min') ? ' win' : '';?>">
                         <?= $options[$lottery]['min'].'% '.
                            i18n('chance_to_win').' '.
                            i18n('option_'.$pick.'_min'); ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="lottery_value">
        <div class="row">
            <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
                <div class="alert alert-success">
                    <h4><?= i18n('you_have_won');?></h4>
                    <h2><?= $winnings;?> <?= i18n('credits');?>!</h2>
                </div>
            </div>
        </div>
        <div class="top_space">
            <a href="/account/" class="btn btn-teal btn-lg"><?=i18n('continue');?></a>
        </div>
    </div>
</div>