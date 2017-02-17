<?php $this->load->view('partials/header'); ?>
<div id="container" class="container">
    <div class="logo">
        <img src="/img/logo.png" alt="<?= i18n('the_exchange');?>" title="<?= i18n('the_exchange');?>" class="center-block img-responsive" />
    </div>

    <div id="progress">
        <div class="col-sm-8 col-sm-offset-2">
            <div class="row panel progress-panel">
                <div class="panel-head">
                    <h1><?= i18n('your_progress');?></h1>
                </div>
                <div class="panel-body">
                    <table class="table table-striped">
                    <tbody>
                        <? foreach ($user->get_my_steps() as $step) : ?>
                            <tr <?= ($current == $step) ? 'class="active_step"' : '';?>>
                                <td class="text-left"><?= i18n($step."_progress");?></td>
                                <td class="text-right"><?= ($user->step_is_complete($step)) ? '<span class="glyphicon glyphicon-check green">' : (($step == $current) ? '<span class="glyphicon glyphicon-expand blue"></span>' : '<span class="glyphicon glyphicon-unchecked black">');?></td>
                            </tr>
                        <? endforeach ;?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row text-center">
                <a href="/account/next" class="btn btn-teal btn-lg"><?= i18n('continue');?></a>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('partials/footer'); ?>