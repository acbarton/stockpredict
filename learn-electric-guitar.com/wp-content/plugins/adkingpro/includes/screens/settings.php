<div class="wrap">
    <?php screen_icon(); ?>
    <h2>Ad King Pro Settings</h2>
    
    <div class="kpp_block filled">
        <h2><?= __("Connect", 'akptext') ?></h2>
        <div id="kpp_social">
            <div class="kpp_social facebook"><a href="https://www.facebook.com/KingProPlugins" target="_blank"><i class="icon-facebook"></i> <span class="kpp_width"><span class="kpp_opacity"><?= __("Facebook", 'akptext') ?></span></span></a></div>
            <div class="kpp_social twitter"><a href="https://twitter.com/KingProPlugins" target="_blank"><i class="icon-twitter"></i> <span class="kpp_width"><span class="kpp_opacity"><?= __("Twitter", 'akptext') ?></span></span></a></div>
            <div class="kpp_social google"><a href="https://plus.google.com/b/101488033905569308183/101488033905569308183/about" target="_blank"><i class="icon-google-plus"></i> <span class="kpp_width"><span class="kpp_opacity"><?= __("Google+", 'akptext') ?></span></span></a></div>
        </div>
        <h4><?= __("Found an issue? Post your issue on the", 'akptext') ?> <a href="http://wordpress.org/support/plugin/adkingpro" target="_blank"><?= __("support forums", 'akptext') ?></a>. <?= __("If you would prefer, please email your concern to", 'akptext') ?> <a href="mailto:plugins@kingpro.me">plugins@kingpro.me</a></h4>   
    </div>
    
    <div class="akp_tabs">
        <a class="akp_advert_settings active"><?= __("Advert Settings", 'akptext') ?></a>
        <a class="akp_howto"><?= __("How-To", 'akptext') ?></a>
        <a class="akp_faq"><?= __("FAQ", 'akptext') ?></a>
    </div>
    
    <?php if (isset($_GET['settings-updated']) && $_GET['settings-updated'] === 'true') : ?>
    <div class="updated akp_notice">
        <p><?= __( "Settings have been saved", 'akptext' ); ?></p>
    </div>
    <?php elseif (isset($_GET['settings-updated']) && $_GET['settings-updated'] === 'false') : ?>
    <div class="error akp_notice">
        <p><?= __( "Settings have <strong>NOT</strong> been saved. Please try again.", 'akptext' ); ?></p>
    </div>
    <?php endif; ?>
    
    <div class="akp_sections">
        <form method="post" action="options.php">
        <?php settings_fields('akp-options'); ?>
        <?php do_settings_sections('akp-options'); ?>
            
        <?php /******* ADVERT SETTINGS *******/ ?>
        <div id="akp_advert_settings" class="akp_section active">
            <?php submit_button(__('Save Settings', 'akptext'), 'primary', 'submit', false, array('id'=>'akp_advert_settings_top_submit')); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row" colspan="3"><h2><?= __("Permissions", 'akptext' ); ?></h2></th>
                </tr>
                
                <tr valign="top">
                <th scope="row"><?= __("Minimum Authorised Role", 'akptext' ); ?></th>
                <td>
                    <?php $role = get_option('akp_auth_role'); ?>
                    <select name="akp_auth_role">
                        <option value="subscriber"<?= ($role == "subscriber") ? ' selected' : '' ?>><?= __("Subscriber", 'akptext' ); ?></option>
                        <option value="administrator"<?= ($role == "administrator") ? ' selected' : '' ?>><?= __("Administrator", 'akptext' ); ?></option>
                        <option value="editor"<?= ($role == "editor") ? ' selected' : '' ?>><?= __("Editor", 'akptext' ); ?></option>
                        <option value="author"<?= ($role == "author") ? ' selected' : '' ?>><?= __("Author", 'akptext' ); ?></option>
                        <option value="contributor"<?= ($role == "contributor") ? ' selected' : '' ?>><?= __("Contributor", 'akptext' ); ?></option>
                    </select>
                </td>
                <td></td>
                </tr>
                
                <tr valign="top">
                    <th scope="row" colspan="3"><hr /></th>
                </tr>
                
                <tr valign="top">
                    <th scope="row" colspan="3"><h2><?= __("Tracking Settings", 'akptext' ); ?></h2></th>
                </tr>
                
                <tr valign="top">
                <th scope="row"><?= __("Google Analytics Installed?", 'akptext' ); ?></th>
                <td colspan="2">
                    <span class="check-ga" data-url="<?php echo site_url() ?>">Checking the markup...</span>
                    <input type="hidden" name="akp_ga_intergrated" value="1" />
                    <input type="hidden" name="akp_ga_implemented" value="<?php echo get_option('akp_ga_implemented') ?>" />
                </td>
                </tr>
                
                <tr valign="top">
                <th scope="row"><?= __("Track Impressions", 'akptext' ); ?></th>
                <td>
                    <?php $track_impressions = get_option('akp_track_impressions'); ?>
                    <input type="hidden" name="akp_track_impressions" value="0" />
                    <input type="checkbox" name="akp_track_impressions" id="akp_track_impressions" value="1"<?php if ($track_impressions == 1) echo " checked" ?> />
                </td>
                <td>If unchecked, no impression tracking is logged</td>
                </tr>
                
                <tr valign="top">
                <th scope="row"><?= __("Track Clicks", 'akptext' ); ?></th>
                <td>
                    <?php $track_clicks = get_option('akp_track_clicks'); ?>
                    <input type="hidden" name="akp_track_clicks" value="0" />
                    <input type="checkbox" name="akp_track_clicks" id="akp_track_clicks" value="1"<?php if ($track_clicks == 1) echo " checked" ?> />
                </td>
                <td>If unchecked, no impression tracking is logged</td>
                </tr>
                
                <tr valign="top" class="akp_ga_enabled">
                <th scope="row"><?= __("Impression action name (GA Action)", 'akptext' ); ?></th>
                <td colspan="2">
                    <?php $ga_imp_action = get_option('akp_ga_imp_action'); ?>
                    <input type="text" name="akp_ga_imp_action" value="<?php echo $ga_imp_action ?>" style="width: 100%;" />
                </td>
                </tr>
                
                <tr valign="top" class="akp_ga_enabled">
                <th scope="row"><?= __("Click action name (GA Action)", 'akptext' ); ?></th>
                <td colspan="2">
                    <?php $ga_click_action = get_option('akp_ga_click_action'); ?>
                    <input type="text" name="akp_ga_click_action" value="<?php echo $ga_click_action ?>" style="width: 100%;" />
                </td>
                </tr>
                
                <tr valign="top">
                    <th scope="row" colspan="3"><hr /></th>
                </tr>
                
                <tr valign="top">
                    <th scope="row" colspan="3"><h2><?= __("Defaults", 'akptext' ); ?></h2></th>
                </tr>
                
                <tr valign="top">
                <th scope="row"><?= __("Media Type", 'akptext' ); ?></th>
                <td colspan="2">
                    <?php
                    $media_type = get_option('akp_default_media_type', 'image');
                    ?>
                    <select name='akp_default_media_type'>
                        <option value='image'><?php _e('Image', 'akptext') ?></option>
                        <option value='html5'<?php echo ($media_type == 'html5') ? ' selected' : '' ?>><?php _e('HTML5', 'akptext') ?></option>
                        <option value='flash'<?php echo ($media_type == 'flash') ? ' selected' : '' ?>><?php _e('Flash', 'akptext') ?></option>
                        <option value='adsense'<?php echo ($media_type == 'adsense') ? ' selected' : '' ?>><?php _e('AdSense', 'akptext') ?></option>
                        <option value='text'<?php echo ($media_type == 'text') ? ' selected' : '' ?>><?php _e('Text', 'akptext') ?></option>
                    </select>
                </td>
                </tr>
                
                <tr valign="top">
                <th scope="row"><?= __("Window Target", 'akptext' ); ?></th>
                <td colspan="2">
                    <?php
                    $target = get_option('akp_default_window_target', 'blank');
                    ?>
                    <select name='akp_default_window_target'>
                        <option value='blank'>_blank</option>
                        <option value='self'<?php echo ($target == 'self') ? ' selected' : '' ?>>_self</option>
                        <option value='parent'<?php echo ($target == 'parent') ? ' selected' : '' ?>>_parent</option>
                        <option value='top'<?php echo ($target == 'top') ? ' selected' : '' ?>>_top</option>
                        <option value='none'<?php echo ($target == 'none') ? ' selected' : '' ?>><?php _e('none', 'akptext') ?></option>
                    </select>
                </td>
                </tr>
                
                <tr valign="top">
                <th scope="row"><?= __("No Follow", 'akptext' ); ?></th>
                <td colspan="2">
                    <?php $nofollow = get_option('akp_default_nofollow', '0'); ?>
                    <input type="hidden" name="akp_default_nofollow" value="0" />
                    <input type="checkbox" value="1" name="akp_default_nofollow"<?php echo $nofollow ? ' checked="checked"' : '' ?> />
                </td>
                </tr>
                
                <tr valign="top">
                <th scope="row"><?= __("Remove Link", 'akptext' ); ?></th>
                <td colspan="2">
                    <?php $removelink = get_option('akp_default_remove_link', '0'); ?>
                    <input type="hidden" name="akp_default_remove_link" value="0" />
                    <input type="checkbox" value="1" name="akp_default_remove_link"<?php echo $removelink ? ' checked="checked"' : '' ?> />
                </td>
                </tr>
                
                <tr valign="top">
                <th scope="row"><?= __("Revenue per Impression", 'akptext' ); ?></th>
                <td colspan="2">
                    <?php $rev_imp = get_option('akp_default_rev_imp', '0.00'); ?>
                    <input type="text" value="<?php echo $rev_imp; ?>" name="akp_default_rev_imp" />
                </td>
                </tr>
                
                <tr valign="top">
                <th scope="row"><?= __("Revenue per Click", 'akptext' ); ?></th>
                <td colspan="2">
                    <?php $rev_click = get_option('akp_default_rev_click', '0.00'); ?>
                    <input type="text" value="<?php echo $rev_click; ?>" name="akp_default_rev_click" />
                </td>
                </tr>
                
                <tr valign="top">
                    <th scope="row" colspan="3"><hr /></th>
                </tr>
                
                <tr valign="top">
                    <th scope="row" colspan="3"><h2><?= __("Customisation", 'akptext' ); ?></h2></th>
                </tr>
                
                <tr valign="top">
                <th scope="row"><?= __("Custom CSS", 'akptext' ); ?></th>
                <td colspan="2">
                    <?php $css = get_option('akp_custom_css'); ?>
                    <textarea name="akp_custom_css" style="width: 100%; height: 200px;"><?= $css ?></textarea>
                </td>
                </tr>
                
                <tr valign="top">
                    <th scope="row" colspan="3"><h2><?= __("House-keeping", 'akptext' ); ?></h2></th>
                </tr>
                
                <tr valign="top">
                <th scope="row"><?= __("Remove all data on deletion of plugin", 'akptext' ); ?></th>
                <td>
                    <?php $clear_data = get_option('akp_clear_on_delete'); ?>
                    <input type="hidden" name="akp_clear_on_delete" value="0" />
                    <input type="checkbox" name="akp_clear_on_delete" id="akp_clear_on_delete" value="1"<?php if ($clear_data == 1) echo " checked" ?> />
                </td>
                <td>If checked, ALL data related to Ad King Pro will be removed from your environment.</td>
                </tr>
            </table>
            <?php submit_button(__('Save Settings', 'akptext'), 'primary', 'submit', false, array('id'=>'akp_advert_settings_bottom_submit')); ?>
        </div>

        <?php /****** HOW-TO ******/ ?>
        <div id="akp_howto" class="akp_section">
            <h2><?= __("How To", 'akptext' ); ?></h2>
            <h3><?= __("Use Shortcodes", 'akptext' ); ?></h3>
            <p><?= __("Shortcodes can be used in any page or post on your site. By default", 'akptext' ); ?>:</p>
            <pre>[adkingpro]</pre>
            <p><?= __("is defaulting to the advert type 'Sidebar' and randomly chosing from that. You can define your own advert type and display the adverts attached to that type by", 'akptext' ); ?>:</p>
            <pre>[adkingpro type='your-advert-type-slug']</pre>
            <p><?= __("Alternatively, you can display a single advert by entering its \"Banner ID\" which can be found in the table under the Adverts section", 'akptext' ); ?>:</p>
            <pre>[adkingpro banner='{banner_id}']</pre>
            <p><?= __("Have a select few adverts that you'd like to show? No problem, just specify the ids separated by commas", 'akptext' ); ?>:</p>
            <pre>[adkingpro banner='{banner_id1}, {banner_id2}']</pre>
            <p><?= __("Want to output a few adverts at once? Use the 'render' option in the shortcode", 'akptext' ); ?>:</p>
            <pre>[adkingpro banner='{banner_id1}, {banner_id2}' render='2']</pre>
            <pre>[adkingpro type='your-advert-type-slug' render='2']</pre>
            <p><?= __("Only have a small space and what a few adverts to display? Turn on the auto rotating slideshow!", 'akptext' ); ?>:</p>
            <pre>[adkingpro type="your-advert-type-slug" rotate='true']</pre>
            <p><?= __("There are also some settings you can play with to get it just right", 'akptext' ); ?>:</p>
            <ul>
                <li><?= __("Effect: \"fade | slideLeft | none\" Default - fade", 'akptext' ); ?></li>
                <li><?= __("Pause Speed: \"Time in ms\" Default - 5000 (5s)", 'akptext' ); ?></li>
                <li><?= __("Change Speed: \"Time in ms\" Default - 600 (0.6s)", 'akptext' ); ?></li>
            </ul>
            <p><?= __("Use one or all of these settings", 'akptext' ); ?>:</p>
            <pre>[adkingpro rotate='true' effect='fade' speed='5000' changespeed='600']</pre>
            <p><?= __("To add this into a template, just use the \"do_shortcode\" function", 'akptext' ); ?>:</p>
            <pre>&lt;?php 
        if (function_exists('adkingpro_func'))
            echo do_shortcode("[adkingpro type='sidebar']");
    ?&gt;</pre>
        </div>
            
        <?php /****** FAQ ******/ ?>
        <div id="akp_faq" class="akp_section">
            <h2><?= __("FAQ", 'akptext' ); ?></h2>
            <h4><?= __("Q. After activating this plugin, my site has broken! Why?", 'akptext' ); ?></h4>
            <p><?= __("Nine times out of ten it will be due to your own scripts being added above the standard area where all the plugins are included. ", 'akptext' ); ?>
                <?= __("If you move your javascript files below the function, \"wp_head()\" in the \"header.php\" file of your theme, it should fix your problem.", 'akptext' ); ?></p>
            <h4><?= __("Q. I want to track clicks on a banner that scrolls to or opens a flyout div on my site. Is it possible?", 'akptext' ); ?></h4>
            <p><?= __("Yes. Enter a '#' in as the URL for the banner when setting it up. At output, the banner is given a number of classes to allow for styling, one being \"banner{banner_id}\",", 'akptext' ); ?>
                <?= __("where you would replace the \"{banner_id}\" for the number in the required adverts class.", 'akptext' ); ?>
                <?= __("Use this in a jquery click event and prevent the default action of the click to make it do the action you require", 'akptext' ); ?>:</p>
            <pre>$(".adkingprobanner.banner{banner_id}").click(
            function(e) {
            &nbsp;&nbsp;&nbsp;&nbsp;e.preventDefault();
            &nbsp;&nbsp;&nbsp;&nbsp;// Your action here
            });</pre>
            <h4><?= __("Q. I'm getting a _gaq or ga is not defined error. Why?", 'akptext' ); ?></h4>
            <p><?= __("This is most probably due to either you don't have your standard Google Analytics tracking code implemented or the GA code is initialised after WP initialises the AKP scripts.", 'akptext' ); ?>
                <?= __("Bring the tracking code up into the header to allow the code it initialise for the event functions to work on the page.", 'akptext' ); ?></p>
            <br />
            <h4><?= __("Found an issue? Post your issue on the", 'akptext' ); ?> <a href="http://wordpress.org/support/plugin/adkingpro" target="_blank"><?= __("support forums", 'akptext' ); ?></a>. <?= __("If you would prefer, please email your concern to", 'akptext' ); ?> <a href="mailto:plugins@kingpro.me">plugins@kingpro.me</a></h4>
        </div>
        </form>
    </div>  
</div>

<script type="text/javascript">
    jQuery('.akp_tabs a').click(function() {
        jQuery(this).parent().children('a.active').removeClass('active');
        jQuery('.akp_sections').find('div.akp_section.active').removeClass('active');
        
        var active = jQuery(this).attr('class');
        jQuery(this).addClass('active');
        jQuery("#"+active).addClass('active');
    });
</script>