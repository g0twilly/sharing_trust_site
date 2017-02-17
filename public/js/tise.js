var TISE = TISE || {};
jQuery(function () {
    TISE.sharing.initialize();
});

TISE.sharing = (function ($) {
    var that = {};
    var timers = [];


    that.initialize = function() {
        avatar_select();
        overview_grid_height();
        survey_setup();
        game_setup();
        $('.btn').button();
        setup_progress();
    };

    function setup_progress() {
        $('#progress .active_step td').delay(1500).addClass('info');
    }

    function survey_setup() {
        $('.show_hide_btn').on('change', function() {
            show_if_yes();
        });
        show_if_yes();
        $('.activate_submit').on('change', function() {
            $('#survey_btn').removeAttr('disabled');
        });
    }

    function show_if_yes() {
        $('.show_if_yes').each(function() {
            var check = $(this).data('qid');
            if ($("input[name=" + check + "]:checked").val() == 'yes') {
                $(this).show();
            }
            else {
                $(this).hide();
            }
        });
    }

    function video_items() {
        if ($('#videoPlayer').length) {
            var player = new MediaElementPlayer('#videoPlayer');
           	$('#showVideoLink').on('click', function() {
                $('#videoModal').modal('show');
                $('video')[0].player.play();
    	    });
            $('#videoModal').on('hidden.bs.modal', function (e) {
                $('video')[0].player.pause();
    	    });
    	    $('#videoModal').on('show.bs.modal', function (e) {
    		  $('video')[0].player.play();
    	    });
        }
    }

    function avatar_select() {
        $('.avatar_option_img').on('click', function(e) {
            e.preventDefault();
            var img = $(this).val();
            $('#avatar_choice').val(img);
            $('.avatar_thumb').attr('src', img);
            $('#submit').removeAttr('disabled');
        });
    }

    function overview_grid_height() {
        var boxes = $('.overview_block');
        var maxHeight = Math.max.apply(
        Math, boxes.map(function() {
            return $(this).height();
        }).get());
        boxes.height(maxHeight);
    }

    function game_setup() {
        if ($('#game').length > 0) {
            game_idleness_check();
            player_load();
        }

        $('.activate_submit').keyup(function() {
            setup_game_submit();
        });
        setup_game_submit();
        calculate_current_holdings();

        $('.playerblock').click(function() {
            $(this).find(".game_input").focus();
        });

        $('.playerblock').hover(function() {
            $('.playerblock').removeClass('hilite');
            $(this).addClass('hilite');
        });
        $('.playerblock input').focus(function(event) {
            $('.playerblock').removeClass('active');
            $(this).closest('.playerblock').addClass('active');
        });
        $('.playerblock input').keyup(function(e) {
            calculate_current_holdings();
            $(this).siblings('.timestamp').val(e.timeStamp);
        });
    }

    function calculate_current_holdings() {
        var current = $('#game').data('initial');

        $('h3.holdings .myholdings').each(function() {
            var myinput = $(this).closest('.row').find('.game_input');
            if ($.isNumeric(myinput.val())) {
                if (myinput.val() > current) {
                    myinput.val(current);
                }
                if (myinput.val() < 0) {
                    myinput.val(0);
                }
            }
        });
        var totalPoints = 0;
        $('form').find('.game_input').each(function(i,n) {
            if ($.isNumeric($(n).val() )) {
                totalPoints += parseInt($(n).val(),10);
            }
        });
        current = current - totalPoints;
        if (current < 0) {
            warning = '<span class="error glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>';
            current = warning + ' ' + current
        }
        $('h3.holdings .myholdings').each(function() {
            $(this).html(current);
        });
    }

    function setup_game_submit() {
        var active = true;
        var count = 0;
        $('.activate_submit').each(function() {
            if ($(this).val() == '') {
                active = false;
                count += 1;
            }
        })
        if (active) {
            var msg = $('#submit_btn').data('continue');
            $('#submit_btn').removeAttr('disabled').val(msg);
        }
        else {
            var msg = count + ' ' + $('#submit_btn').data('todo');
            if (count == 1) {
                msg = msg.replace('s', '');
            }
            $('#submit_btn').attr('disabled', 'disbled').val(msg);
        }
    }


    function player_load() {
        clear_timers();
        set_timers();
        $('.game_form').fadeIn("slow");
    }


    function set_timers() {
            timers.push(setTimeout(function() {
                $('#idle1').fadeIn(400);
            }, 300000));
            timers.push(setTimeout(function() {
                $('#idle1').hide();
                $('#idle2').show();
            }, 600000));
            timers.push(setTimeout(function() {
                $('#idle2').hide();
                $('#idle3').show();
            }, 900000));
            timers.push(setTimeout(function() {
                window.location.replace(window.location.protocol + "//" + window.location.host + '/account/timeout');
            }, 910000));
    }

    function clear_timers() {
        for (var i = 0; i < timers.length; i++) {
            clearTimeout(timers[i]);
        }
    }

    function game_idleness_check() {
        set_timers();
        $('.closeidlebox').on('click', function() {
            $('.overlay').hide();
            clear_timers();
            set_timers();
        });
    }

    return that;
}(jQuery));
