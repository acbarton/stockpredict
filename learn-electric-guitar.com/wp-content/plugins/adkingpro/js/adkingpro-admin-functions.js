jQuery(document).ready(function($) {
    if ($("#akp_change_media_type").length > 0) {
        $('#postimagediv, #postrolloverdiv, #akphtml5box, #akpflashbox, #akpadsensebox, #postremoveurllink, #akpimagebox, #akptextbox, #akpimageattrbox').hide();
        if ($("#akp_change_media_type").val() === 'image') {
            $('#title-prompt-text').text('Advert URL ie http://kingpro.me/plugins/ad-king-pro');
            $('#postimagediv').fadeIn();
            $('#postrolloverdiv').fadeIn();
            $('#akpimagebox').fadeIn();
            $('#akpimageattrbox').fadeIn();
            $('#postremoveurllink').fadeIn();
        } else if ($("#akp_change_media_type").val() === 'html5') {
            $('#title-prompt-text').text('Advert URL ie http://kingpro.me/plugins/ad-king-pro');
            $('#akphtml5box').fadeIn();
        } else if ($("#akp_change_media_type").val() === 'flash') {
            $('#title-prompt-text').text('Advert description (for internal use)');
            $('#akpflashbox').fadeIn();
        } else if ($("#akp_change_media_type").val() === 'adsense') {
            $('#title-prompt-text').text('Advert description (for internal use)');
            $('#akpadsensebox').fadeIn();
        } else if ($("#akp_change_media_type").val() === 'text') {
            $('#title-prompt-text').text('Advert URL ie http://kingpro.me/plugins/ad-king-pro');
            $('#akptextbox').fadeIn();
        }
    }
    $('#akp_change_media_type').change(function() {
        // Change views
        $('#postimagediv, #postrolloverdiv, #akphtml5box, #akpflashbox, #akpadsensebox, #postremoveurllink, #akpimagebox, #akptextbox, #akpimageattrbox').hide();
        if ($(this).val() === 'image') {
            $('#title-prompt-text').text('Advert URL ie http://kingpro.me/plugins/ad-king-pro');
            $('#postimagediv').fadeIn();
            $('#postrolloverdiv').fadeIn();
            $('#akpimagebox').fadeIn();
            $('#postremoveurllink').fadeIn();
        } else if ($("#akp_change_media_type").val() === 'html5') {
            $('#title-prompt-text').text('Advert URL ie http://kingpro.me/plugins/ad-king-pro');
            $('#akphtml5box').fadeIn();
        } else if ($(this).val() === 'flash') {
            $('#title-prompt-text').text('Advert description (for internal use)');
            $('#akpflashbox').fadeIn();
        } else if ($(this).val() === 'adsense') {
            $('#title-prompt-text').text('Advert description (for internal use)');
            $('#akpadsensebox').fadeIn();
        } else if ($(this).val() === 'text') {
            $('#title-prompt-text').text('Advert URL ie http://kingpro.me/plugins/ad-king-pro');
            $('#akptextbox').fadeIn();
        }
    });
    
    // Shortcode Builder
    // Select type
    $("#akp_shortcode_display").change(function() {
        $(".akp_shortcode_q").not($(this).parent()).fadeOut();
        $(".akp_shortcode_example span").text('');
        $("#akp_shortcode_rotate").removeAttr('checked');
        $("#akp_shortcode_banners").children('option').removeAttr('selected');
        $("#akp_shortcode_effect").children('option').removeAttr('selected');
        var option = $(this).val();
        if (option == 'single') {
            // Single banner
            var current_id = $(this).data('post_id');
            $(".akp_shortcode_example .akp_shortcode_banner").text(' banner="'+current_id+'"');
        } else if (option == 'selected') {
            // Multiple selected banners
            $(".akp_shortcode_q.selected").fadeIn();
        } else if (option == 'group') {
            // Advert type
            $(".akp_shortcode_q.group").fadeIn();
        }
    });
    
    // Select banners
    $("#akp_shortcode_banners").change(function() {
        // Get selected ids
        var options = [];
        var output = '';
        $(this).children('option:selected').each(function() {
            options[options.length] = $(this).val();
            output += $(this).val()+",";
        });
        
        output = output.substr(0, output.length-1);
        
        $(".akp_shortcode_example .akp_shortcode_banner").text(' banner="'+output+'"');
        
        // Check if rotate is selected and process render as required
        if (!$("#akp_shortcode_rotate").is(':checked'))
            $(".akp_shortcode_example .akp_shortcode_render").text(' render="'+options.length+'"');
        else
            $(".akp_shortcode_example .akp_shortcode_render").text('');
    });
    
    // Select Advert Type
    $("#akp_shortcode_adverttype").change(function() {
        var adverttype = $(this).val();
        $(".akp_shortcode_example .akp_shortcode_type").text(' type="'+adverttype+'"');
    });
    
    // Enter render amount
    $("#akp_shortcode_render").keyup(function() {
        var render = $(this).val();
        // validate entry
        
        if (render !== '') {
            $("#akp_shortcode_rotate").parent().fadeOut();
            $(".akp_shortcode_example .akp_shortcode_render").text(' render="'+render+'"');
        } else {
            $("#akp_shortcode_rotate").parent().fadeIn();
            $(".akp_shortcode_example .akp_shortcode_render").text('');
        }
    });
    
    // Select auto rotate
    $("#akp_shortcode_rotate").click(function() {
        if ($(this).is(":checked")) {
            // Display rotate options
            $(".akp_shortcode_q.rotate").fadeIn();
            $("#akp_shortcode_render").parent().fadeOut();
            $(".akp_shortcode_example .akp_shortcode_render").text('');
            $(".akp_shortcode_example .akp_shortcode_rotate").text(' rotate="true"');
            $(".akp_shortcode_example .akp_shortcode_speed").text(' speed="'+$("#akp_shortcode_speed").val()+'"');
            $(".akp_shortcode_example .akp_shortcode_changespeed").text(' changespeed="'+$("#akp_shortcode_changespeed").val()+'"');
            $(".akp_shortcode_example .akp_shortcode_effect").text(' effect="'+$("#akp_shortcode_effect").val()+'"');
        } else {
            // hide rotate options
            if ($("#akp_shortcode_display").val() == 'selected') {
                var options = [];
                var output = '';
                $("#akp_shortcode_banners").children('option:selected').each(function() {
                    options[options.length] = $(this).val();
                    output += $(this).val()+",";
                });

                output = output.substr(0, output.length-1);
                $(".akp_shortcode_example .akp_shortcode_render").text(' render="'+options.length+'"');
            } else {
                $("#akp_shortcode_render").parent().fadeIn();
            }
            $(".akp_shortcode_q.rotate").fadeOut();
            $(".akp_shortcode_example .akp_shortcode_rotate").text('');
            $(".akp_shortcode_example .akp_shortcode_speed").text('');
            $(".akp_shortcode_example .akp_shortcode_changespeed").text('');
            $(".akp_shortcode_example .akp_shortcode_effect").text('');
        }
    });
    
    // Enter speed amount
    $("#akp_shortcode_speed").keyup(function() {
        var speed = $(this).val();
        // validate entry
        
        if (speed !== '') {
            $(".akp_shortcode_example .akp_shortcode_speed").text(' speed="'+speed+'"');
        }
    });
    
    // Enter changespeed amount
    $("#akp_shortcode_changespeed").keyup(function() {
        var changespeed = $(this).val();
        // validate entry
        
        if (changespeed !== '') {
            $(".akp_shortcode_example .akp_shortcode_changespeed").text(' changespeed="'+changespeed+'"');
        }
    });
    
    // Select efect
    $("#akp_shortcode_effect").change(function() {
        var option = $(this).val();
        
        $(".akp_shortcode_example .akp_shortcode_effect").text(' effect="'+option+'"');
    });
    
    var html5_custom_uploader;
    $('#akp_html5_url_button').click(function(e) {
        e.preventDefault();
        
        //If the uploader object has already been created, reopen the dialog
        if (html5_custom_uploader) {
            html5_custom_uploader.open();
            return;
        }
 
        //Extend the wp.media object
        html5_custom_uploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose HTML5 File',
            button: {
                text: 'Choose HTML5 File'
            },
            multiple: false
        });
 
        //When a file is selected, grab the URL and set it as the text field's value
        flash_custom_uploader.on('select', function() {
            attachment = flash_custom_uploader.state().get('selection').first().toJSON();
            var url = '';
            url = attachment['url'];
            $('#akp_html5_url').val(url);
        });
 
        //Open the uploader dialog
        html5_custom_uploader.open();
    });
    
    var flash_custom_uploader;
    $('#akp_flash_url_button').click(function(e) {
        e.preventDefault();
        
        //If the uploader object has already been created, reopen the dialog
        if (flash_custom_uploader) {
            flash_custom_uploader.open();
            return;
        }
 
        //Extend the wp.media object
        flash_custom_uploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Flash File',
            button: {
                text: 'Choose Flash File'
            },
            multiple: false
        });
 
        //When a file is selected, grab the URL and set it as the text field's value
        flash_custom_uploader.on('select', function() {
            attachment = flash_custom_uploader.state().get('selection').first().toJSON();
            var url = '';
            url = attachment['url'];
            $('#akp_flash_url').val(url);
        });
 
        //Open the uploader dialog
        flash_custom_uploader.open();
    });
    
    var image_custom_uploader;
    $('#akp_image_url_button').click(function(e) {
        e.preventDefault();
        
        //If the uploader object has already been created, reopen the dialog
        if (image_custom_uploader) {
            image_custom_uploader.open();
            return;
        }
 
        //Extend the wp.media object
        image_custom_uploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Image',
            button: {
                text: 'Choose Image'
            },
            multiple: false
        });
 
        //When a file is selected, grab the URL and set it as the text field's value
        image_custom_uploader.on('select', function() {
            attachment = image_custom_uploader.state().get('selection').first().toJSON();
            var url = '';
            url = attachment['url'];
            $('#akp_image_url').val(url);
        });
 
        //Open the uploader dialog
        image_custom_uploader.open();
    });
    
    var image_rollover_custom_uploader;
    $('body').on("click", '#akp_rollover_image_button, #set-advert_types-akp_rollover_image-thumbnail', function(e) {
        e.preventDefault();
        
        //If the uploader object has already been created, reopen the dialog
        if (image_rollover_custom_uploader) {
            image_rollover_custom_uploader.open();
            return;
        }
 
        //Extend the wp.media object
        image_rollover_custom_uploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Rollover Image',
            button: {
                text: 'Choose Rollover Image'
            },
            multiple: false
        });
 
        //When a file is selected, grab the URL and set it as the text field's value
        image_rollover_custom_uploader.on('select', function() {
            attachment = image_rollover_custom_uploader.state().get('selection').first().toJSON();
            var url = '';
            url = attachment['url'];
            if ($('#akp_rollover_image').length > 0) {
                // No post thumbnail support
                $('#akp_rollover_image').val(url);
            } else {
                // Post thumbnail support replicating feature image functionality
                var post_id = $("#post_ID").val();
                var thumb_id = attachment['id'];
                var $link = $('a#adverts_posts-akp_rollover_image-thumbnail-' + thumb_id);
                    $link.data('thumbnail_id', thumb_id);
                $link.text( 'Saving...' );
                jQuery.post(akp_ajax_object.ajax_url, {
                        action:'set-adverts_posts-akp_rollover_image-thumbnail', post_id: post_id, thumbnail_id: thumb_id, _ajax_nonce: akp_ajax_object.akp_ajaxnonce, cookie: encodeURIComponent(document.cookie)
                }, function(str){
                        var win = window.dialogArguments || opener || parent || top;
                        $link.text( "Remove Rollover Image" );
                        if ( str == '0' ) {
                                alert( "An error occured" );
                        } else {
                                $link.show();
                                $link.text( "Complete" );
                                $link.fadeOut( 2000, function() {
                                        $('tr.adverts_posts-akp_rollover_image-thumbnail').hide();
                                });
                                var field = jQuery('input[value=_akp_rollover_image]', '#list-table');
                                if ( field.size() > 0 ) {
                                        $('#meta\\[' + field.attr('id').match(/[0-9]+/) + '\\]\\[value\\]').text(thumb_id);
                                }
                                $('.inside', '#postrolloverdiv').html(str);
                        }
                }
                );
            }
        });
 
        //Open the uploader dialog
        image_rollover_custom_uploader.open();
    });
    
    $("body").on("click", "#remove-akp_rollover_image-thumbnail", function(e) {
        e.preventDefault();
        $.post(akp_ajax_object.ajax_url, {
            action:'set-adverts_posts-akp_rollover_image-thumbnail', post_id: $('#post_ID').val(), thumbnail_id: -1, _ajax_nonce: akp_ajax_object.akp_ajaxnonce, cookie: encodeURIComponent(document.cookie)
        }, function(str){
            if ( str == '0' ) {
                    alert("An error occured");
            } else {
                    $('.inside', '#postrolloverdiv').html(str);
            }
        }
        );
    });
    
    $('#expirydiv').siblings('a.edit-expiry').click(function() {
            if ($('#expirydiv').is(":hidden")) {
                    $('#expirydiv').slideDown('fast');
                    $('#exp_m').focus();
                    $(this).hide();
            }
            return false;
    });

    $('.cancel-expiry', '#expirydiv').click(function() {
            $('#expirydiv').slideUp('fast');
//            $('#exp_m').val($('#hidden_exp_m').val());
//            $('#exp_d').val($('#hidden_exp_d').val());
//            $('#exp_y').val($('#hidden_exp_y').val());
//            $('#exp_h').val($('#hidden_exp_h').val());
//            $('#exp_i').val($('#hidden_exp_i').val());
            $('#expirydiv').siblings('a.edit-expiry').show();
//            updateExpiryText();
            return false;
    });

    $('.save-expiry', '#expirydiv').click(function () { // crazyhorse - multiple ok cancels
            if ( updateExpiryText() ) {
                    $('#expirydiv').slideUp('fast');
                    $('#expirydiv').siblings('a.edit-expiry').show();
            }
            return false;
    });
    
    $(".set-never-expiry").click(function() {
        $('#expiry').html(
            'Expire on: <b>Never</b>'
        );

        $("#akp_expiry_date").val(
            'never'
        );
            
        $('#expirydiv').slideUp('fast');
        $('#expirydiv').siblings('a.edit-expiry').show();
    });
    
    function updateExpiryText() {
        
            var stamp = $('#expiry').html();

            if ( ! $('#expirydiv').length )
                    return true;

            var exp_y = $('#exp_y').val(),
                    exp_m = $('#exp_m').val(), exp_d = $('#exp_d').val(), exp_h = $('#exp_h').val(), exp_i = $('#exp_i').val(), exp_s = $('#exp_s').val();

            attemptedDate = new Date( exp_y, exp_m - 1, exp_d, exp_h, exp_i );
            originalDate = new Date( $('#hidden_exp_y').val(), $('#hidden_exp_m').val() -1, $('#hidden_exp_d').val(), $('#hidden_exp_h').val(), $('#hidden_exp_i').val() );

            if ( attemptedDate.getFullYear() != exp_y || (1 + attemptedDate.getMonth()) != exp_m || attemptedDate.getDate() != exp_d || attemptedDate.getMinutes() != exp_i ) {
                    $('.expiry-wrap', '#expirydiv').addClass('form-invalid');
                    return false;
            } else {
                    $('.expiry-wrap', '#expirydiv').removeClass('form-invalid');
            }

            
            if ( originalDate.toUTCString() == attemptedDate.toUTCString() ) { //hack
                    $('#expiry').html(stamp);
            } else {
                    $('#expiry').html(
                        'Expire on: <b>' +
                        $('option[value="' + $('#exp_m').val() + '"]', '#exp_m').text() + ' ' +
                        exp_d + ', ' +
                        exp_y + ' @ ' +
                        exp_h + ':' +
                        exp_i + '</b> '
                    );
                        
                    $("#akp_expiry_date").val(
                        exp_y+'-'+exp_m+'-'+exp_d+' '+exp_h+':'+exp_i+':'+exp_s
                    );
            }

            return true;
    }
    
    $(".banner_detailed_stat h2").click(function() {
        if ($(this).parent().height() > 46) {
            $(this).removeClass('open').parent().animate({'height': '46px'});
        } else {
            var height = $(this).parent().css('height', 'auto').height();
            $(this).parent().css('height', '46px');
            $(this).addClass('open').parent().animate({'height': height+'px'}, function() {
                $(this).css('height', 'auto');
            });
        }
    });
    
    $(".akp_detailed").click(function() {
        if (!$(this).hasClass('active')) {
            $(this).parent().children(".akp_detailed.active").removeClass('active');
            $(this).addClass('active');
            var set = $(this).attr('rel');
            $(this).parent().next(".detailed_details").children('div').hide();
            $(this).parent().next(".detailed_details").children('.akp_detailed_'+set+'_details').fadeIn();
        }
    });
    
    $('.akp_datepicker').datepicker({ dateFormat: "dd/mm/yy" });
    
    $(".from_adkingpro_date, .to_adkingpro_date").live('focus', function() {
        $(this).css('border-color', '#DFDFDF');
    });
    
    // Ajax erroring
    $(".akp_custom_date").live('click', function() {
        var valid = true;
        var from_date = $(this).parent().children(".from_adkingpro_date").val();
        if (from_date == '') {
            $(this).parent().children(".from_adkingpro_date").css('border-color', '#FF0000');
            valid = false;
        }
        var to_date = $(this).parent().children(".to_adkingpro_date").val();
        if (to_date == '') {
            $(this).parent().children(".to_adkingpro_date").css('border-color', '#FF0000');
            valid = false;
        }
        var banner_id = $(this).attr('rel');
        var target_div = $(this).parent().next('.returned_data');
        if (valid) {
            target_div.html("<div class='akploading'></div>");
            $.post(akp_ajax_object.ajax_url, {action: 'akpdaterange', ajaxnonce : akp_ajax_object.akp_ajaxnonce, from_date: from_date, to_date:to_date, banner_id:banner_id}, function(response) {
                target_div.html(response);
            });
        }
    });
    
    // Document generation
    $(".akp_csv").live('click', function() {
        var info = $(this).attr('rel').split('/');
        var from_date = $(this).parent().parent().parent().find(".from_adkingpro_date").val();
        var to_date = $(this).parent().parent().parent().find(".to_adkingpro_date").val();
        $.post(akp_ajax_object.ajax_url, {action: 'akpoutputcsv', ajaxnonce : akp_ajax_object.akp_ajaxnonce, set: info[0], id:info[1], from_date:from_date, to_date:to_date}, function(response) {
            window.location = response;
        });
    });
    
    $(".akp_pdf").live('click', function() {
        var info = $(this).attr('rel').split('/');
        var from_date = $(this).parent().parent().parent().find(".from_adkingpro_date").val();
        var to_date = $(this).parent().parent().parent().find(".to_adkingpro_date").val();
        $.post(akp_ajax_object.ajax_url, {action: 'akpoutputpdf', ajaxnonce : akp_ajax_object.akp_ajaxnonce, set: info[0], id:info[1], from_date:from_date, to_date:to_date}, function(response) {
            window.location = response;
        });
    });
    
    // Settings functionality
    $("#akp_ga_intergrated").click(function() {
        if ($(this).is(":checked")) {
            // GA Intergrated
            $(".akp_ga_disabled").slideUp();
            $(".akp_ga_enabled").slideDown();
        } else {
            // GA not Intergrated
            $(".akp_ga_disabled").slideDown();
            $(".akp_ga_enabled").slideUp();
        }
    });
    
    // Edit screen GA fields
    $(".akp_ga_field").keyup(function() {
        var field = $(this).data('field');
        var val = $(this).val();
        $("#akpgaintergration .akp_ga_"+field+"_text").each(function() {
            $(this).text(val);
        });
    });
    
    if ($(".check-ga").length > 0) {
        var url = $(".check-ga").data('url');
        var analytics = 'www.google-analytics.com/analytics.js';
        var ga = '.google-analytics.com/ga.js';
        $.get(url, function(data) {
            if (data.indexOf(analytics) > -1) {
                var webpropid = /'UA-([^']*)'/;
                var webprop = webpropid.exec(data);
                $(".check-ga").html("<span style='color: #46b450; font-weight: bold;'>Universal (<a href='https://developers.google.com/analytics/devguides/collection/analyticsjs/' target='_blank'>analytics.js</a>) install detected</span> | UA-"+webprop[1]);
                $("input[name=akp_ga_implemented]").val('universal');
            } else if (data.indexOf(ga) > -1) {
                var webpropid = /'UA-([^']*)'/;
                var webprop = webpropid.exec(data);
                $(".check-ga").html("<span style='color: #46b450; font-weight: bold;'>Classic (<a href='https://developers.google.com/analytics/devguides/collection/gajs/' target='_blank'>ga.js</a>) install detected</span> | UA-"+webprop[1]);
                $("input[name=akp_ga_implemented]").val('classic');
            } else {
                $(".check-ga").html("<span style='color: #a00; font-weight: bold;'>No Google Analytics install found!</span> Tracking will not work without Google Analytics installed. <a href='https://developers.google.com/analytics/devguides/collection/analyticsjs/' target='_blank'>Need help?</a>");
            }
        });
    }
});