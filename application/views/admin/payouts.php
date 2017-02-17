<div class="all_filters">
	<div class="filters">
	  <div id="payoff_filter" class="btn-group">
	     <button id="f_showsent" type="button" class="btn btn-default">Show Invited</button>
	     <button id="f_showunsent" type="button" class="btn btn-default">Show Not Invited</button>
	     <button id="f_showall" type="button" class="btn btn-default">Show All</button>
	  </div>
	</div>
</div>
<div id="payout_container">
<?php $this->load->view('admin/payouts_table'); ?>
</div>
