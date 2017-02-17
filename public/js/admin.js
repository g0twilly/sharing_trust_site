var TISE = TISE || {};
jQuery(function () {
    TISE.admin.initialize();
});

TISE.admin = (function ($) {
    var that = {};
    var timers = [];


    that.initialize = function() {
        admin_setup();
        $('.btn').button();

    };
   function admin_setup() {
        $('#payouts').tablesorter({widthFixed: true, widgets: ['zebra']});
        $('#payouts th').on('click', function() {
            $('#payouts th').removeClass('picked');
            $(this).addClass('picked');
        });

        $('#f_showall').on('click', function() {
            $('#payouts tr').removeClass('hidden');
        });
        $('#f_showunsent').on('click', function() {
            $('#payouts tr.sent').addClass('hidden');
            $('#payouts tr.unsent').removeClass('hidden');
        });
        $('#f_showsent').on('click', function() {
            $('#payouts tr.unsent').addClass('hidden');
            $('#payouts tr.sent').removeClass('hidden');
        });
        $('#f_hideunverified').on('click', function() {
            $('#payouts tr.unvalidated').addClass('verihidden');
        });
        $('#f_showunverified').on('click', function() {
            $('#payouts tr.unvalidated').removeClass('verihidden');
        });

        $('.amazon_link').on('click', function() {
            alert($(this).attr("title"));
        });
        $('.admin_send_action').on('click', function() {
            var col = $(this).parent();
            col.html('<span class="adminspin"></span>');
            var id = $(this).data('sendid');
            col.load('/admin/send/', {sendid: id}, function(response) {
                if (response.indexOf('send_link') >= 0) {
                    col.prev('td').html('<span class="glyphicon glyphicon-ok green"></span>');
                    col.closest('tr').addClass('sent').removeClass('unsent');
                }
            });
        });
        $('.btn-group button').click(function() {
            $(this).parent().children().removeClass('active');
            $(this).addClass('active');
        });
    }


    function reload_payout_table() {
        $('#payout_container').load('/admin/payout_table');
    }

    return that;
}(jQuery));