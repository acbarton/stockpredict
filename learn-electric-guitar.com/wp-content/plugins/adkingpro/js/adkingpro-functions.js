jQuery(document).ready(function($) {
    $(".adkingprobanner a").click(function(e) {
        var post_id = $(this).data('id');
        var ga = $(this).data('ga');
        track_click(post_id, ga);
    });
    
    $(".adkingprobannerflash").mousedown(function(e) {
        var post_id = $(this).attr('rel');
        var ga = $(this).data('ga');
        track_click(post_id, ga);
    });
    
    $(".adkingprobannertext").click(function(e) {
        var post_id = $(this).data('id');
        var ga = $(this).data('ga');
        track_click(post_id, ga);
    });

    $(".akpbanner-iframe").each(function() {
        var post_id = $(this).data('id');
        var ga = $(this).data('ga');
        $(this).contents().find('a').each(function() {
            $(this).attr({'onClick': 'parent.track_click('+post_id+', \''+ga+'\')', 'target': '_blank'}).css('cursor', 'pointer');
        });
    });
});

function track_click(post_id, ga_fields) {
    if (typeof(post_id) == 'undefined') return false;
    if (typeof(ga_fields) == 'undefined') ga_fields = false;
    
    if (ga_fields) {
        if (ga_fields.implemented == 'classic')
            _gaq.push(['_trackEvent',ga_fields.campaign, ga_fields.click_action, ga_fields.banner]);
        else if (ga_fields.implemented == 'universal')
            ga('send', 'event', ga_fields.campaign, ga_fields.click_action, ga_fields.banner);
    }
}