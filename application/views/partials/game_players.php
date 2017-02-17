<div class="row">
    <div class="game_block col-md-6 col-sm-6 game_investor investor_hand">
        <div class="info_block">
                <div class="info_line"><font size="6">Player </font> </b> </div>
            <div class="user_avatar right-side-pad">
                <img src="<?=$user->get_avatar();?>" />
            </div>
            <div class="user_info">
                <div class="info_line"><strong><?= i18n('age');?> : </strong> <?= $user->age;?> <?= i18n('year_old');?></div>
                <div class="info_line"><strong><?= i18n('status');?> : </strong> <?= i18n($user->marital_status);?></div>
                <div class="info_line"><strong><?= i18n('gender');?> : </strong> <?= i18n($user->gender);?> </div>
                <div class="info_line"><strong><?= i18n('from');?> : </strong> <?= ($user->get_state_from_zip($user->zip));?></div>
                <div class="role"><strong><?= i18n('role');?> : </strong> <?= i18n('investor');?></div>
            </div>
        </div>
    </div>
		<font size="6">Recipient</font> 
    <div class="game_block col-md-6 col-sm-6 game_recipient recipient_hand">
        <div class="info_block">
            <div class="user_avatar left-side-pad">
                <img src="<?=$robot['robot_avatar'];?>" />
            </div>
            <div class="user_info">
                <div class="info_line"><strong><?= i18n('age');?> :</strong> <?= $robot['robot_age']; ?> </div>
                <div class="info_line"><strong><?= i18n('status');?> :</strong> <?= i18n($robot['robot_marital_status']); ?> </div>
                <div class="info_line"><strong><?= i18n('gender');?> :</strong> <?= i18n($robot['robot_gender']); ?> </div>
                <div class="info_line"><strong><?= i18n('from');?> :</strong> <?= $robot['robot_state']; ?> </div>
                <div class="info_line"><strong><?= i18n('airbnb_rating');?> :</strong> <? if ($robot['robot_rating'] == 'not_available') : ?><?= i18n('not_available');?><? else : ?><? foreach(range(1,5) as $i) : ?>
                    <span class="glyphicon glyphicon-star <? if ($i <= intval($robot['robot_rating'])) : ?> gold<?endif;?>" aria-hidden="true" title="<?=$robot['robot_rating']?> / 5 <?= i18n('stars');?>"></span>
                <? endforeach; ?><? endif;?></div>
                <div class="hidden info_line ucword"><strong><?= i18n('airbnb_member_type');?> :</strong> <?=i18n($robot['robot_type']); ?></div>
                <div class="info_line"><strong><?= i18n('airbnb_reviews');?> :</strong> <?= $robot['robot_reviews']; ?></div>
            </div>
        </div>
    </div>
</div>
