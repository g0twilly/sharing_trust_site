<div id="control_loading" class="alert alert-white loadbox" data-game_key=<?=$game_key;?>>
    <h3><?= i18n('waiting_for_x', $participant->username);?></h3>
    <h5><?= i18n('please_wait');?></h5>
    <div class="progress progress-striped active">
      <div class="progress-bar progress-bar-teal" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
        <span class="sr-only">waiting...</span>
      </div>
    </div>
</div>