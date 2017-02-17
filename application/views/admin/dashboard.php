<?php $this->load->view('partials/adminheader'); ?>
<div id="container" class="container">
    <div class="logo">
        <img src="/img/logo.png" alt="<?= i18n('the_exchange');?>" title="<?= i18n('the_exchange');?>" class="center-block img-responsive" />
        <h3 class="teal"><?= i18n('admin_section');?></h3>
        <form action="/admin/showtoggle" method="POST" id="studytoggleform">
            <input type="hidden" name="return_url" value="/admin/">
            <div id="verified_filter" class="btn-group">
                <button type="submit" class="btn btn-default admin_showtoggle<?php if ($show_toggle != 'show_current') :?> active<?php endif;?>" type="button" name="show_toggle" value="show_all">Show All</button>
                <button type="submit" class="btn btn-default admin_showtoggle<?php if ($show_toggle == 'show_current') :?> active<?php endif;?>" type="button" name="show_toggle" value="show_current">Show Current Study</button>
            </div>
        </form>
    </div>

    <div class="col-sm-10 col-sm-offset-1">
        <?php $this->load->view('admin/payouts'); ?>
    </div>
</div>
<?php $this->load->view('partials/adminfooter'); ?>
