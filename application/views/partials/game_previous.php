<?php if (count($previous) > 0) : ?>
        <div class="row prev_block">
            <div class="game_previous">
                <h3 class="grey"><?= i18n('previous_rounds');?></h3>
                <?php foreach ($previous as $num => $pick) : ?>
                    <div class="game_item col-md-10 col-md-offset-1">
                        <div class="game_info">
                            <h3 class="change"><?
                            $value = $pick['final_sum'] - $pick['initial_sum'];
                            if ($value > 0) : ?> + <? endif; ?>
                            <?= $value; ?></h3>
                             <div class="invest<?= ($pick['role'] == 'investor') ? ' hilite' : '';?>"><?= ($pick['role'] == 'investor') ? i18n('x_invested', i18n('you')) : i18n('x_invested', i18n('they')); ?>:
                                <?= $pick['invested_sum'];?> <?= i18n('credits'); ?>
                            </div>
                            <div class="return"><?= ($pick['role'] == 'investor') ? i18n('x_received', i18n('they')) : i18n('x_received', i18n('you')); ?>:
                                <?= $pick['total_investment'];?> <?= i18n('credits'); ?>
                            </div>
                            <div class="return<?= ($pick['role'] == 'recipient') ? ' hilite' : '';?>"><?= ($pick['role'] == 'investor') ? i18n('x_returned', i18n('they')) : i18n('x_returned', i18n('you')); ?>:
                                <em><?= $pick['returned_sum'];?> <?= i18n('credits'); ?></em>
                            </div>
                        </div>
                        <div class="user_avatar">
                            <img src="<?=$pick['participant']->get_avatar();?>" />
                        </div>
                        <div class="user_info">
                            <h3 class="info_line"><?= $pick['participant']->username;?></h3>
                            <div class="info_line"><strong><?= i18n('from');?> :</strong> <?= ($pick['participant']->city) ? $pick['participant']->city.',' : '';?> <?=($pick['participant']->state) ? $pick['participant']->state.',' : '';?> <?= ($pick['participant']->country) ? $pick['participant']->country : '';?></div>
                            <div class="info_line"><strong><?= i18n('member_of');?> :</strong> <?= count($pick['participant']->get_sites()) ? join(", ", $pick['participant']->get_sites()) : i18n('no_sites');?></div>
                            <div class="role"><strong><?= i18n('role');?> :</strong> <?= i18n(role_toggle($pick['role']));?></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
<?php endif; ?>