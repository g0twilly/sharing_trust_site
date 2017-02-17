<table id="payouts" class="tablesorter panel panel-defaults">
  <thead>
  	<tr>
  		<th>Name</th>
  		<th>Email</th>
      <th>Study</th>
  		<th>Score</th>
  		<th>Phase</th>
      <th>Group</th>
  		<th>Date</th>
      <th>Will Return?</th>
  		<th>Sent</th>
  	</tr>
  </thead>
  <tbody>
  <? foreach ($userlist as $payout) : ?>
  	<tr class="<?= ($payout['contacted']) ? 'sent ' : 'unsent ';?><?= ($show_toggle == 'show_current' and $payout['study'] != $this->config->item('study') ) ? 'hidden' : '';?>">
    	<td class="text-left"><?= $payout['first_name'].' '.$payout['last_name'];?></td>
    	<td class="text-left"><?= $payout['email'];	?></td>
      <td class="text-left"><?= $payout['study'];?></td>
    	<td class="text-right"><?= $payout['score'];	?></td>
    	<td class="text-center"><?= $payout['phase'];	?></td>
      <td class="text-center"><?= $payout['grouping'];?></td>
    	<td class="text-center"><?= $payout['stamp'];	?></td>
      <td class="text-center"><?= ($payout['will_return']) ? '<span title="YES" class="green glyphicon glyphicon-ok"></span>' : '<span title="NO" class="red glyphicon glyphicon-remove-sign"></span>';?></td>
    	<td class="text-center"><?
      if ($payout['phase'] == 2 and $payout['rewarded']) :
        ?><span title="Paid" class="blue glyphicon glyphicon-thumbs-up"></span><?
      elseif ($payout['contacted']) :
        // Aleady Invited
        ?><span title="Already Invited" class="green glyphicon glyphicon-ok"></span><?
      elseif ( $payout['study'] == $this->config->item('study') and $payout['phase'] == $this->config->item('phase') and $payout['phase'] == 1 ) :
        // Not invited, Current Phase, and the First Phase
        ?><span title="Send Invitation to Phase 2" data-sendid="<?=$payout['game_id'];?>" class="admin_send_action btn btn-xs btn-success">Send</span><?
      elseif ($payout['phase'] == 2) :
        ?><span title="Unpaid" class="green glyphicon glyphicon-usd"></span><?
      else :
        ?><span title="Disqualified" class="red glyphicon glyphicon-remove-sign"></span><?
       endif;?>
       </td>
  	</tr>
  <? endforeach; ?>
  </tbody>
</table>