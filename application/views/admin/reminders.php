<?php $this->load->view('partials/adminheader'); ?>
<div id="container" class="container">
    <div class="logo">
        <img src="/img/logo.png" alt="<?= i18n('the_exchange');?>" title="<?= i18n('the_exchange');?>" class="center-block img-responsive" />
        <h3 class="teal"><?= i18n('admin_section');?></h3>
        <form action="/admin/showtoggle" method="POST" id="studytoggleform">
            <input type="hidden" name="return_url" value="/admin/reminders/">
            <div id="verified_filter" class="btn-group">
                <button type="submit" class="btn btn-default admin_showtoggle<?php if ($show_toggle != 'show_current') :?> active<?php endif;?>" type="button" name="show_toggle" value="show_all">Show All</button>
                <button type="submit" class="btn btn-default admin_showtoggle<?php if ($show_toggle == 'show_current') :?> active<?php endif;?>" type="button" name="show_toggle" value="show_current">Show Current Study</button>
            </div>
        </form>
    </div>

    <div class="col-sm-10 col-sm-offset-1">

<table id="payouts" class="tablesorter panel panel-defaults">
  <thead>
    <tr>
        <th>User ID</th>
        <th>Email</th>
        <th>Reminder</th>
        <th>Phase</th>
        <th>Date</th>
    </tr>
  </thead>
  <tbody>
  <? foreach ($reminders as $reminder) : ?>
    <tr>
        <td class="text-left"><?=   $reminder['user_id'];  ?></td>
        <td class="text-left"><?=   $reminder['email']; ?></td>
        <td class="text-center"><?= $reminder['reminder'];    ?></td>
        <td class="text-center"><?= $reminder['phase'];   ?></td>
        <td class="text-center"><?= $reminder['stamp'];   ?></td>
    </tr>
  <? endforeach; ?>
  </tbody>
</table>


    </div>
</div>
<?php $this->load->view('partials/adminfooter'); ?>