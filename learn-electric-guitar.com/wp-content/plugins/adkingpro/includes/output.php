<?php

// [adkingpro type="sidebar" banner="random" rotate="false" speed="5000" changespeed="600" effect='fade' render="1"]
function adkingpro_func( $atts ) {
	extract( shortcode_atts( array(
		'type' => 'sidebar',
		'banner' => 'random',
                'rotate' => false,
                'speed' => '5000',
                'changespeed' => '600',
                'effect'=> 'fade',
                'render' => '0'
	), $atts ) );
        
        $output = '';
        
        $akpAdmin = new AKP_Admin('init');
        
        $effects = array('fade', 'slideLeft', 'none');
        if (!in_array($effect, $effects)) $effect = 'fade';
        
        $banner = explode(',', $banner);
        if (count($banner) == 1) {
            $banner = trim(preg_replace('/ +/', ' ', preg_replace('/[^A-Za-z0-9 ]/', ' ', urldecode(html_entity_decode(strip_tags($banner[0]))))));
        } else {
            for ($b=0;$b<count($banner);$b++) {
                $banner[$b] = trim(preg_replace('/ +/', ' ', preg_replace('/[^A-Za-z0-9 ]/', ' ', urldecode(html_entity_decode(strip_tags($banner[$b]))))));
                if (!is_numeric($banner[$b])) unset($banner[$b]);
            }
        }
        
        $ga_enabled = false;
        if (get_option('akp_ga_intergrated', 1))
            $ga_enabled = true;
        
        if ($banner == 'random') {
            // ADVERT TYPE OUTPUT
            if ($render == 0 && $rotate) $render = -1;
            if ($render == 0) $render = 1;
            $adverts = new WP_Query(array(
                'post_type'=>'adverts_posts',
                'orderby'=>'rand',
                'showposts'=>$render,
                //'advert_types'=>$type, - removed to stop url forming
                'taxonomy'=>'advert_types', 
                'term'=>$type,
                'meta_query' => array(
                    'relation' => 'OR',
                    array(
                        'key' => 'akp_expiry_date',
                        'value' => 'never',
                        'compare' => '='
                    ),
                    array(
                        'key' => 'akp_expiry_date',
                        'value' => '',
                        'compare' => 'NOT EXISTS'
                    ),
                    array(
                        'key' => 'akp_expiry_date',
                        'value' => current_time('timestamp'),
                        'type' => 'numeric',
                        'compare' => '>='
                    )
                )
                ));
            
            if ($render > 1 || $render === -1) {
                $slideshow = "";
                if ($rotate) $slideshow = "akp_slideshow".rand(10000, 99999);
                $output .= "<div class='adkingprocontainer' id='".$slideshow."'>";
            }
            while ($adverts->have_posts()) : $adverts->the_post();
                $term = get_term_by("slug", $type, 'advert_types');
                $term_meta = get_option( "akp_advert_type_".$term->term_id);
                $post_id = get_the_ID();
                $cfields = $akpAdmin->return_fields($post_id);
                $ga = '';
                if ($ga_enabled) {
                    $ga_data = $akpAdmin->ga_data($post_id);
                    $ga_data = json_encode($ga_data);
                    $ga = " data-ga='".$ga_data."'";
                }
                
                if ($cfields['akp_expiry_date'][0] == '') $cfields['akp_expiry_date'][0] = 'never';
                if ($cfields['akp_expiry_date'][0] !== 'never')
                if ($cfields['akp_media_type'][0] == '') $cfields['akp_media_type'][0] = 'image';
                switch ($cfields['akp_media_type'][0]) {
                    case 'image':
                        $image = $cfields['akp_image_url'][0];
                        $rollover = $cfields['akp_rollover_image'][0];
                        $rollover_class = '';
                        if (is_numeric($rollover) && $rollover > 0) {
                            $rollover = wp_get_attachment_image_src($rollover, 'full');
                            $rollover_class = ' rollover';
                        }
                        $alt = $cfields['akp_image_alt'][0];
                        $nofollow = '';
                        if ($cfields['akp_nofollow'][0] == '1') $nofollow = ' rel="nofollow"';
                        $target = '';
                        if ($cfields['akp_target'][0] !== 'none') $target = ' target="_'.$cfields['akp_target'][0].'"';
                        if ($image == '')
                            $image = $akpAdmin->get_featured_image($post_id, "akp_".$term->term_id);
                        $display_link = true;
                        if (!isset($cfields['akp_remove_url']) || (isset($cfields['akp_remove_url']) && $cfields['akp_remove_url'][0] == 1)) $display_link = false;
                        $output .= "<div class='adkingprobanner ".$type.$rollover_class." akpbanner banner".$post_id."' style='width: ".$term_meta['advert_width']."px; height: ".$term_meta['advert_height']."px;'>";
                        if ($display_link)
                            $output .= "<a href='".get_the_title()."'".$target.$nofollow." data-id='".$post_id."'".$ga.">";
                        if (is_array($rollover)) {
                            $output .= "<img src='".$image."' style='max-width: ".$term_meta['advert_width']."px; max-height: ".$term_meta['advert_height']."px;' alt='".$alt."' class='akp_rollover_image' />";
                            $output .= "<img src='".$rollover[0]."' style='max-width: ".$term_meta['advert_width']."px; max-height: ".$term_meta['advert_height']."px;' alt='".$alt."' class='akp_rollover_image over' />";
                        } else
                            $output .= "<img src='".$image."' style='max-width: ".$term_meta['advert_width']."px; max-height: ".$term_meta['advert_height']."px;' alt='".$alt."' />";
                        if ($display_link)
                            $output .= "</a>";
                        $output .= "</div>";
                        break;
                        
                    case 'html5':
                        $output .= "<div class='adkingprobannerhtml5 ".$type." akpbanner banner".$post_id."'>";
                        $output .= '<iframe width="'.$cfields['akp_html5_width'][0].'" height="'.$cfields['akp_html5_height'][0].'" src="'.$cfields['akp_html5_url'][0].'" id="akpbanner'.$post_id.'-iframe" name="akpbanner'.$post_id.'-iframe" class="akpbanner-iframe" data-id="'.$post_id.'"'.$ga.' style="border: none;"></iframe>';
                        $output .= "</div>";
                        break;
                    
                    case 'flash':
                        $output .= "<div class='adkingprobannerflash ".$type." akpbanner banner".$post_id."'>";
                        $output .= '<object width="'.$cfields['akp_flash_width'][0].'" height="'.$cfields['akp_flash_height'][0].'">';
                        $output .= '<param value="'.$cfields['akp_flash_url'][0].'" name="wmode" value="transparent">';
                        $output .= '<embed src="'.$cfields['akp_flash_url'][0].'" width="'.$cfields['akp_flash_width'][0].'" height="'.$cfields['akp_flash_height'][0].'" wmode="transparent" allowfullscreen="false" allowscriptaccess="always">';
                        $output .= '</embed>';
                        $output .= '</object>';
                        $output .= "</div>";
                        break;
                    
                    case 'adsense':
                        $output .= "<div class='adkingprobanneradsense ".$type." akpbanner banner".$post_id."'>";
                        $output .= $cfields['akp_adsense_code'][0];
                        $output .= "</div>";
                        break;
                    
                    case 'text':
                        $nofollow = '';
                        if ($cfields['akp_nofollow'][0] == '1') $nofollow = ' rel="nofollow"';
                        $target = '';
                        if ($cfields['akp_target'][0] !== 'none') $target = ' target="_'.$cfields['akp_target'][0].'"';
                        if ($rotate) $output .= "<div class='adkingprobannertextcontainer ".$type." akpbanner banner".$post_id."'>";
                        $output .= "<a href='".get_the_title()."'".$target.$nofollow." data-id='".$post_id."'".$ga." class='adkingprobannertext ".$type." banner".$post_id."'>";
                        $output .= $cfields['akp_text'][0];
                        $output .= "</a>";
                        if ($rotate) $output .= "</div>";
                        break;
                }
                if (isset($post_id) && get_option('akp_track_impressions') == '1')
                    $output .= $akpAdmin->log_impression($post_id);
            endwhile;
            if ($render > 1 || $render === -1) {
                $output .= "</div>";
                if ($rotate) {
                    $output .= "<script type='text/javascript'>jQuery('#".$slideshow."').jshowoff({ speed:".$speed.", changeSpeed:".$changespeed.", effect: '".$effect."', links: false, controls: false });</script>";
                }
            }
            wp_reset_postdata();
        } elseif (is_array($banner)) {
            // MULTIPLE BANNER IDS
            if ($render == 0 && $rotate) count($banner);
            if ($render == 0) $render = 1;
            $adverts = new WP_Query(array(
                'post_type'=>'adverts_posts',
                'orderby'=>'rand',
                'showposts'=>$render,
                'post__in'=>$banner,
                'meta_query' => array(
                    'relation' => 'OR',
                    array(
                        'key' => 'akp_expiry_date',
                        'value' => 'never',
                        'compare' => '='
                    ),
                    array(
                        'key' => 'akp_expiry_date',
                        'value' => '',
                        'compare' => 'NOT EXISTS'
                    ),
                    array(
                        'key' => 'akp_expiry_date',
                        'value' => current_time('timestamp'),
                        'type' => 'numeric',
                        'compare' => '>='
                    )
                )
                ));
            
            if ($render > 1) {
                $slideshow = "";
                if ($rotate) $slideshow = "akp_slideshow".rand(10000, 99999);
                $output .= "<div class='adkingprocontainer' id='".$slideshow."'>";
            }
            while ($adverts->have_posts()) : $adverts->the_post();
                $post_id = get_the_ID();
                $cfields = $akpAdmin->return_fields();
                $ga = '';
                if ($ga_enabled) {
                    $ga_data = $akpAdmin->ga_data($post_id);
                    $ga_data = json_encode($ga_data);
                    $ga = " data-ga='".$ga_data."'";
                }
                
                if ($cfields['akp_expiry_date'][0] == '') $cfields['akp_expiry_date'][0] = 'never';
                if ($cfields['akp_expiry_date'][0] !== 'never')
                if ($cfields['akp_media_type'][0] == '') $cfields['akp_media_type'][0] = 'image';
                switch ($cfields['akp_media_type'][0]) {
                    case 'image':
                        $image = $cfields['akp_image_url'][0];
                        $rollover = $cfields['akp_rollover_image'][0];
                        $rollover_class = '';
                        if (is_numeric($rollover) && $rollover > 0) {
                            $rollover = wp_get_attachment_image_src($rollover, 'full');
                            $rollover_class = ' rollover';
                        }
                        $alt = $cfields['akp_image_alt'][0];
                        if ($image == '')
                            $image = $akpAdmin->get_featured_image($post_id);
                        $display_link = true;
                        $nofollow = '';
                        if ($cfields['akp_nofollow'][0] == '1') $nofollow = ' rel="nofollow"';
                        $target = '';
                        if ($cfields['akp_target'][0] !== 'none') $target = ' target="_'.$cfields['akp_target'][0].'"';
                        if (!isset($cfields['akp_remove_url']) || (isset($cfields['akp_remove_url']) && $cfields['akp_remove_url'][0] == 1)) $display_link = false;
                        $output .= "<div class='adkingprobanner ".$type.$rollover_class." akpbanner banner".$post_id."'>";
                        if ($display_link)
                            $output .= "<a href='".get_the_title()."'".$target.$nofollow." data-id='".$post_id."'".$ga.">";
                        if (is_array($rollover)) {
                            $output .= "<img src='".$image."' alt='".$alt."' class='akp_rollover_image' />";
                            $output .= "<img src='".$rollover[0]."' alt='".$alt."' class='akp_rollover_image over' />";
                        } else
                            $output .= "<img src='".$image."' alt='".$alt."' />";
                        if ($display_link)
                            $output .= "</a>";
                        $output .= "</div>";
                        break;
                        
                    case 'html5':
                        $output .= "<div class='adkingprobannerhtml5 ".$type." akpbanner banner".$post_id."'>";
                        $output .= '<iframe width="'.$cfields['akp_html5_width'][0].'" height="'.$cfields['akp_html5_height'][0].'" src="'.$cfields['akp_html5_url'][0].'" id="akpbanner'.$post_id.'-iframe" name="akpbanner'.$post_id.'-iframe" class="akpbanner-iframe" data-id="'.$post_id.'"'.$ga.' style="border: none;"></iframe>';
                        $output .= "</div>";
                        break;
                    
                    case 'flash':
                        $output .= "<div class='adkingprobannerflash ".$type." akpbanner banner".$post_id."'>";
                        $output .= '<object width="'.$cfields['akp_flash_width'][0].'" height="'.$cfields['akp_flash_height'][0].'">';
                        $output .= '<param value="'.$cfields['akp_flash_url'][0].'" name="wmode" value="transparent">';
                        $output .= '<embed src="'.$cfields['akp_flash_url'][0].'" width="'.$cfields['akp_flash_width'][0].'" height="'.$cfields['akp_flash_height'][0].'" wmode="transparent" allowfullscreen="false" allowscriptaccess="always">';
                        $output .= '</embed>';
                        $output .= '</object>';
                        $output .= "</div>";
                        break;
                    
                    case 'adsense':
                        $output .= "<div class='adkingprobanneradsense ".$type." akpbanner banner".$post_id."'>";
                        $output .= $cfields['akp_adsense_code'][0];
                        $output .= "</div>";
                        break;
                    
                    case 'text':
                        $nofollow = '';
                        if ($cfields['akp_nofollow'][0] == '1') $nofollow = ' rel="nofollow"';
                        $target = '';
                        if ($cfields['akp_target'][0] !== 'none') $target = ' target="_'.$cfields['akp_target'][0].'"';
                        if ($rotate) $output .= "<div class='adkingprobannertextcontainer ".$type." akpbanner banner".$post_id."'>";
                        $output .= "<a href='".get_the_title()."'".$target.$nofollow." data-id='".$post_id."'".$ga." class='adkingprobannertext ".$type." banner".$post_id."'>";
                        $output .= $cfields['akp_text'][0];
                        $output .= "</a>";
                        if ($rotate) $output .= "</div>";
                        break;
                }
                if (isset($post_id) && get_option('akp_track_impressions') == '1')
                    $output .= $akpAdmin->log_impression($post_id);
            endwhile;
            if ($render > 1) {
                $output .= "</div>";
                if ($rotate) {
                    $output .= "<script type='text/javascript'>jQuery('#".$slideshow."').jshowoff({ speed:".$speed.", changeSpeed:".$changespeed.", effect: '".$effect."', links: false, controls: false });</script>";
                }
            }
            wp_reset_postdata();
        } elseif (is_numeric($banner)) {
            // SINGLE BANNER ID
            $adverts = new WP_Query(array(
                'post_type'=>'adverts_posts',
                'p'=>$banner,
                'meta_query' => array(
                    'relation' => 'OR',
                    array(
                        'key' => 'akp_expiry_date',
                        'value' => 'never',
                        'compare' => '='
                    ),
                    array(
                        'key' => 'akp_expiry_date',
                        'value' => '',
                        'compare' => 'NOT EXISTS'
                    ),
                    array(
                        'key' => 'akp_expiry_date',
                        'value' => current_time('timestamp'),
                        'type' => 'numeric',
                        'compare' => '>='
                    )
                )
                ));
            while ($adverts->have_posts()) : $adverts->the_post();
                $post_id = get_the_ID();
                $cfields = $akpAdmin->return_fields();
                $ga = '';
                if ($ga_enabled) {
                    $ga_data = $akpAdmin->ga_data($post_id);
                    $ga_data = json_encode($ga_data);
                    $ga = " data-ga='".$ga_data."'";
                }
                
                if ($cfields['akp_media_type'][0] == '') $cfields['akp_media_type'][0] = 'image';
                switch ($cfields['akp_media_type'][0]) {
                    case 'image':
                        $image = $cfields['akp_image_url'][0];
                        $rollover = $cfields['akp_rollover_image'][0];
                        $rollover_class = '';
                        if (is_numeric($rollover) && $rollover > 0) {
                            $rollover = wp_get_attachment_image_src($rollover, 'full');
                            $rollover_class = ' rollover';
                        }
                        $alt = $cfields['akp_image_alt'][0];
                        if ($image == '')
                            $image = $akpAdmin->get_featured_image($post_id);
                        $display_link = true;
                        $nofollow = '';
                        if ($cfields['akp_nofollow'][0] == '1') $nofollow = ' rel="nofollow"';
                        $target = '';
                        if ($cfields['akp_target'][0] !== 'none') $target = ' target="_'.$cfields['akp_target'][0].'"';
                        if (!isset($cfields['akp_remove_url']) || (isset($cfields['akp_remove_url']) && $cfields['akp_remove_url'][0] == 1)) $display_link = false;
                        $output .= "<div class='adkingprobanner ".$type.$rollover_class." banner".$post_id."'>";
                        if ($display_link)
                            $output .= "<a href='".get_the_title()."'".$target.$nofollow." data-id='".$post_id."'".$ga.">";
                        if (is_array($rollover)) {
                            $output .= "<img src='".$image."' alt='".$alt."' class='akp_rollover_image' />";
                            $output .= "<img src='".$rollover[0]."' alt='".$alt."' class='akp_rollover_image over' />";
                        } else
                            $output .= "<img src='".$image."' alt='".$alt."' />";
                        if ($display_link)
                            $output .= "</a>";
                        $output .= "</div>";
                        break;
                        
                    case 'html5':
                        $output .= "<div class='adkingprobannerhtml5 ".$type." akpbanner banner".$post_id."'>";
                        $output .= '<iframe width="'.$cfields['akp_html5_width'][0].'" height="'.$cfields['akp_html5_height'][0].'" src="'.$cfields['akp_html5_url'][0].'" id="akpbanner'.$post_id.'-iframe" name="akpbanner'.$post_id.'-iframe" class="akpbanner-iframe" data-id="'.$post_id.'"'.$ga.' style="border: none;"></iframe>';
                        $output .= "</div>";
                        break;
                    
                    case 'flash':
                        $output .= "<div class='adkingprobannerflash ".$type." banner".$post_id."' rel='".$post_id."'>";
                        $output .= '<object width="'.$cfields['akp_flash_width'][0].'" height="'.$cfields['akp_flash_height'][0].'">';
                        $output .= '<param value="'.$cfields['akp_flash_url'][0].'" name="wmode" value="transparent">';
                        $output .= '<embed src="'.$cfields['akp_flash_url'][0].'" width="'.$cfields['akp_flash_width'][0].'" height="'.$cfields['akp_flash_height'][0].'" wmode="transparent" allowfullscreen="false" allowscriptaccess="always">';
                        $output .= '</embed>';
                        $output .= '</object>';
                        $output .= "</div>";
                        break;
                    
                    case 'adsense':
                        $output .= "<div class='adkingprobanneradsense ".$type." banner".$post_id."' rel='".$post_id."'>";
                        $output .= $cfields['akp_adsense_code'][0];
                        $output .= "</div>";
                        break;
                    
                    case 'text':
                        $nofollow = '';
                        if ($cfields['akp_nofollow'][0] == '1') $nofollow = ' rel="nofollow"';
                        $target = '';
                        if ($cfields['akp_target'][0] !== 'none') $target = ' target="_'.$cfields['akp_target'][0].'"';
                        $output .= "<a href='".get_the_title()."'".$target.$nofollow." data-id='".$post_id."'".$ga." class='adkingprobannertext ".$type." banner".$post_id."'>";
                        $output .= $cfields['akp_text'][0];
                        $output .= "</a>";
                        break;
                }
                if (isset($post_id) && get_option('akp_track_impressions') == '1')
                    $output .= $akpAdmin->log_impression($post_id);
            endwhile;
            wp_reset_postdata();
        }
	return $output;
}
add_shortcode( 'adkingpro', 'adkingpro_func' );
?>
