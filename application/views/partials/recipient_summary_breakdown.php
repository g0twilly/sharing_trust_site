<div class="row alert alert-white" id="activity_breakdown">
    <div class="summary_title"><h4><?= i18n('activity');?></h4></div>
    <div class="summary_item col-md-10 col-md-offset-1">
        <div class="summary_info">
            <div class="row">
                <div class="col-md-6 col-sm-6 col-sm-offset-6 text-left">
                    <div class="user_avatar">
                        <img src="<?=$participant->get_avatar();?>" />
                    </div>
                    <div class="text">
                        <?= i18n('x_invested', $participant->username) ?> <strong><?= $invested_sum;?></strong> <?= i18n('credits'); ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="text-center">
                    <div class="alert alert-info"><?= i18n('credits_multiplied', array($invested_sum, $multiplier, $total_investment)); ?></div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-6 text-right">
                    <div class="user_avatar">
                        <img src="<?=$user->get_avatar();?>" />
                    </div>
                    <div class="text">
                        <?= i18n('x_received', $user->username) ?> <strong><?= $total_investment;?></strong> <?= i18n('credits'); ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-6 text-right">
                    <div class="user_avatar">
                        <img src="<?=$user->get_avatar();?>" />
                    </div>
                    <div class="text">
                        <?= i18n('x_returned', $user->username) ?> <strong><?= $returned_sum;?></strong> <?= i18n('credits'); ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-6 text-right breakdown">
                    <div class="user_avatar">
                        <img src="<?=$user->get_avatar();?>" />
                    </div>
                    <div class="text">
                        <?  $value = ($total_investment - $returned_sum);
                        if ($value > 0) { $value = ' + '.$value; } ?>
                        <?= i18n('recipient_breakdown', array($user->username, $total_investment, $returned_sum, $value)); ?>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 text-left breakdown">
                    <div class="user_avatar">
                        <img src="<?=$participant->get_avatar();?>" />
                    </div>
                    <div class="text">
                        <?  $value = ($returned_sum - $invested_sum);
                        if ($value > 0) { $value = ' + '.$value; } ?>
                        <?= i18n('investor_breakdown', array($participant->username, $invested_sum, $returned_sum, $value)); ?>
                    </div>
                </div>
            </div>
            <div class="row alert alert-success">
                <div class="current_total"><?= i18n('current_holdings');?>: <?= $final_sum;?> <?= i18n('credits');?></div>
            </div>
        </div>
    </div>
</div>