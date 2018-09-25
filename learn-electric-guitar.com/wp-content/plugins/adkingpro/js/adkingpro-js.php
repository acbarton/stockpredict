<?php

// Log click on front end
function akp_log_click_ajax() {
    if (wp_verify_nonce( $_POST['ajaxnonce'], 'akpN0nc3' ) && get_option('akp_track_clicks') == '1') {
        $post_id = $_POST['post_id'];
        $timestamp = current_time('timestamp');
        $expire = strtotime(get_option('expiry_time'), $timestamp);
        $url = $_POST['url'];
        $ip_address = $_SERVER['REMOTE_ADDR'];
        global $wpdb;
        $ip = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."akp_click_expire WHERE ip_address = '$ip_address' AND post_id = '$post_id'");
        if ($ip != null) {
            if ($ip->expire < $timestamp) {
                $wpdb->query( $wpdb->prepare( 
                        "DELETE FROM ".$wpdb->prefix."akp_click_expire
                         WHERE post_id = %d
                         AND ip_address = %s
                        ",
                        $post_id, $ip_address
                        )
                );
                $wpdb->query( $wpdb->prepare( 
                        "INSERT INTO ".$wpdb->prefix."akp_click_log
                        ( post_id, ip_address, timestamp )
                        VALUES ( %d, %s, %d )", 
                        array(
                            $post_id, 
                            $ip_address, 
                            $timestamp
                        ) 
                ) );
                $wpdb->query( $wpdb->prepare( 
                        "INSERT INTO ".$wpdb->prefix."akp_click_expire
                        ( post_id, ip_address, expire )
                        VALUES ( %d, %s, %d )", 
                        array(
                            $post_id, 
                            $ip_address, 
                            $expire
                        ) 
                ) );
            }
        } else {
            $wpdb->query( $wpdb->prepare( 
                    "INSERT INTO ".$wpdb->prefix."akp_click_log
                    ( post_id, ip_address, timestamp )
                    VALUES ( %d, %s, %d )", 
                    array(
                        $post_id, 
                        $ip_address, 
                        $timestamp
                    ) 
            ) );
            $wpdb->query( $wpdb->prepare( 
                    "INSERT INTO ".$wpdb->prefix."akp_click_expire
                    ( post_id, ip_address, expire )
                    VALUES ( %d, %s, %d )", 
                    array(
                        $post_id, 
                        $ip_address, 
                        $expire
                    ) 
            ) );
        }
    }
    die();
}

add_action( 'wp_ajax_nopriv_akplogclick', 'akp_log_click_ajax' );
add_action( 'wp_ajax_akplogclick', 'akp_log_click_ajax' );

// Retreive clicks from daterange
function akp_date_range_ajax() {
    if (wp_verify_nonce( $_POST['ajaxnonce'], 'akpN0nc3' )) {
        $from_date = $_POST['from_date'];
        $to_date = $_POST['to_date'];
        $banner_id = $_POST['banner_id'];
        global $wpdb;
        $date_start = mktime(0, 0, 0, date('m', strtotime(str_replace('/', '-', $from_date))), date('d', strtotime(str_replace('/', '-', $from_date))), date('Y', strtotime(str_replace('/', '-', $from_date))));
        $date_end = mktime(23, 59, 59, date('m', strtotime(str_replace('/', '-', $to_date))), date('d', strtotime(str_replace('/', '-', $to_date))), date('Y', strtotime(str_replace('/', '-', $to_date))));
        $date_clicks = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."akp_click_log WHERE timestamp BETWEEN '$date_start' AND '$date_end' AND post_id = '$banner_id' ORDER BY timestamp DESC");
        $date_impressions = $wpdb->get_results("SELECT COUNT(*) as impressions FROM ".$wpdb->prefix."akp_impressions_log WHERE timestamp BETWEEN '$date_start' AND '$date_end' AND post_id = '$banner_id'");
        
        $clicks = count($date_clicks);
        $dets = akp_return_fields($banner_id);
        
        $currency_sign = get_option('revenue_currency');
        $impression_cost = $dets['akp_revenue_per_impression'][0];
        $click_cost = $dets['akp_revenue_per_click'][0];
        
        $per_impression = $currency_sign.number_format($impression_cost, 2);
        $impression_total = $impression_cost * $date_impressions[0]->impressions;
        $impression_total_output = $currency_sign.number_format($impression_total, 2);
        
        $per_click = $currency_sign.number_format($click_cost, 2);
        $click_total = $click_cost * $clicks;
        $click_total_output = $currency_sign.number_format($click_total, 2);
        
        $total_made = $impression_total + $click_total;
        $total_made_output = $currency_sign.number_format($total_made, 2);
        ?>
        <br />
        <table>
            <tr>
                <td></td>
                <th class="center"><?= __('Count', 'akptext') ?></th>
                <th class="center"><?= __('Cost Per', 'akptext') ?></th>
                <th class="center"><?= __('Total', 'akptext') ?></th>
            </tr>
            <tr>
                <td><?= __('Impressions', 'akptext') ?></td>
                <td class="center"><?= $date_impressions[0]->impressions ?></td>
                <td class="right"><?= $per_impression ?></td>
                <td class="right"><?= $impression_total_output ?></td>
            </tr>
            <tr>
                <td><?= __('Clicks', 'akptext') ?></td>
                <td class="center"><?= $clicks ?></td>
                <td class="right"><?= $per_click ?></td>
                <td class="right"><?= $click_total_output ?></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td class="right bold"><?= __('TOTAL', 'akptext') ?></td>
                <td class="right bold"><?= $total_made_output ?></td>
            </tr>
        </table>
        <br />
        <div class="akp_reporting">
            <strong><?= __('Download report', 'akptext') ?>: </strong> <a class="akp_csv" rel="daterange/<?= $banner_id ?>"><?= __('CSV', 'akptext') ?></a> <a class="akp_pdf" rel="daterange/<?= $banner_id ?>"><?= __('PDF', 'akptext') ?></a>
        </div>
        <br />
        <table>
            <thead>
                <tr>
                    <th><?= __('Date/Time', 'akptext') ?></th>
                    <th><?= __('IP Address', 'akptext') ?></th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($date_clicks as $dc) : ?>
            <tr>
                <td><?= date('d/m/Y h:i:sa', $dc->timestamp) ?></td>
                <td><?= $dc->ip_address ?></td>
            </tr>
            <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th><?= __('Date/Time', 'akptext') ?></th>
                    <th><?= __('IP Address', 'akptext') ?></th>
                </tr>
            </tfoot>
        </table>
        <?php 
    }
    die();
}

add_action( 'wp_ajax_akpdaterange', 'akp_date_range_ajax' );


// Output CSV file
function akp_output_csv() {
    if (wp_verify_nonce( $_POST['ajaxnonce'], 'akpN0nc3' )) {
        $set = $_POST['set'];
        $post_id = $_POST['id'];
        global $wpdb;
        
        switch ($set) {
            case 'all':
                $clicks_detailed = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."akp_click_log WHERE post_id = '$post_id' ORDER BY timestamp DESC");
                break;
                
            case 'month':
                $month_start = mktime(0, 0, 0, date('n', current_time('timestamp')), 1, date('Y', current_time('timestamp')));
                $month_end = mktime(23, 59, 59, date('n', current_time('timestamp')), date('t', current_time('timestamp')), date('Y', current_time('timestamp')));
                $clicks_detailed = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."akp_click_log WHERE timestamp BETWEEN '$month_start' AND '$month_end' AND post_id = '$post_id' ORDER BY timestamp DESC");
                break;
            
            case 'week':
                $start_week = get_option('week_starts');
                if (strtolower(date('l', current_time('timestamp'))) == $start_week) {
                    $day = date('j', current_time('timestamp'));
                    $month = date('n', current_time('timestamp'));
                    $year = date('Y', current_time('timestamp'));
                } else {
                    $day = date('j', strtotime('last '.$start_week));
                    $month = date('n', strtotime('last '.$start_week));
                    $year = date('Y', strtotime('last '.$start_week));
                }
                $week_start = mktime(0, 0, 0, $month, $day, $year);
                $week_end = mktime(23, 59, 59, date('n', strtotime("+7 days", $week_start)), date('j', strtotime("+7 days", $week_start)), date('Y', strtotime("+7 days", $week_start)));
                $clicks_detailed = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."akp_click_log WHERE timestamp BETWEEN '$week_start' AND '$week_end' AND post_id = '$post_id' ORDER BY timestamp DESC");
                break;
            
            case 'today':
                $today_start = mktime(0, 0, 0, date('n', current_time('timestamp')), date('j', current_time('timestamp')), date('Y', current_time('timestamp')));
                $today_end = mktime(23, 59, 59, date('n', current_time('timestamp')), date('j', current_time('timestamp')), date('Y', current_time('timestamp')));
                $clicks_detailed = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."akp_click_log WHERE timestamp BETWEEN '$today_start' AND '$today_end' AND post_id = '$post_id' ORDER BY timestamp DESC");
                break;
            
            case 'daterange':
                $from_date = $_POST['from_date'];
                $to_date = $_POST['to_date'];
                $date_start = mktime(0, 0, 0, date('m', strtotime(str_replace('/', '-', $from_date))), date('d', strtotime(str_replace('/', '-', $from_date))), date('Y', strtotime(str_replace('/', '-', $from_date))));
                $date_end = mktime(23, 59, 59, date('m', strtotime(str_replace('/', '-', $to_date))), date('d', strtotime(str_replace('/', '-', $to_date))), date('Y', strtotime(str_replace('/', '-', $to_date))));
                $clicks_detailed = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."akp_click_log WHERE timestamp BETWEEN '$date_start' AND '$date_end' AND post_id = '$post_id' ORDER BY timestamp DESC");
                break;
        }
        
        $array = array();
        $array[] = array('Date/Time', 'IP Address');
        foreach ($clicks_detailed as $click) {
            $array[] = array(date('d/m/Y h:i:sa', $click->timestamp), $click->ip_address);
        }
        outputCSV($array);
        echo str_replace("js/","",plugin_dir_url(__FILE__))."outputs/output.csv";
        ?>
        
        <?php 
    }
    die();
}

add_action( 'wp_ajax_akpoutputcsv', 'akp_output_csv' );

function outputCSV($data) {
    $outstream = fopen(plugin_dir_path(__FILE__)."../outputs/output.csv", "w");
    function __outputCSV(&$vals, $key, $filehandler) {
        fputcsv($filehandler, $vals); // add parameters if you want
    }
    array_walk($data, "__outputCSV", $outstream);
    fclose($outstream);
}


// Output PDF file
function akp_output_pdf() {
    if (wp_verify_nonce( $_POST['ajaxnonce'], 'akpN0nc3' )) {
        include plugin_dir_path(__FILE__)."../packages/fpdf/fpdf.php";
        $set = $_POST['set'];
        $post_id = $_POST['id'];
        global $wpdb;
        
        switch ($set) {
            case 'all':
                $clicks_detailed = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."akp_click_log WHERE post_id = '$post_id' ORDER BY timestamp DESC");
                $impressions_detailed = $wpdb->get_results("SELECT COUNT(*) as impressions FROM ".$wpdb->prefix."akp_impressions_log WHERE post_id = '$post_id'");
                $title = "Clicks made All-time";
                break;
                
            case 'month':
                $month_start = mktime(0, 0, 0, date('n', current_time('timestamp')), 1, date('Y', current_time('timestamp')));
                $month_end = mktime(23, 59, 59, date('n', current_time('timestamp')), date('t', current_time('timestamp')), date('Y', current_time('timestamp')));
                $clicks_detailed = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."akp_click_log WHERE timestamp BETWEEN '$month_start' AND '$month_end' AND post_id = '$post_id' ORDER BY timestamp DESC");
                $impressions_detailed = $wpdb->get_results("SELECT COUNT(*) as impressions FROM ".$wpdb->prefix."akp_impressions_log WHERE timestamp BETWEEN '$month_start' AND '$month_end' AND post_id = '$post_id'");
                $title = "Clicks made in the month of ".date('F', current_time('timestamp'))." in ".date('Y', current_time('timestamp'));
                break;
            
            case 'week':
                $start_week = get_option('week_starts');
                if (strtolower(date('l', current_time('timestamp'))) == $start_week) {
                    $day = date('j', current_time('timestamp'));
                    $month = date('n', current_time('timestamp'));
                    $year = date('Y', current_time('timestamp'));
                } else {
                    $day = date('j', strtotime('last '.$start_week));
                    $month = date('n', strtotime('last '.$start_week));
                    $year = date('Y', strtotime('last '.$start_week));
                }
                $week_start = mktime(0, 0, 0, $month, $day, $year);
                $week_end = mktime(23, 59, 59, date('n', strtotime("+7 days", $week_start)), date('j', strtotime("+7 days", $week_start)), date('Y', strtotime("+7 days", $week_start)));
                $clicks_detailed = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."akp_click_log WHERE timestamp BETWEEN '$week_start' AND '$week_end' AND post_id = '$post_id' ORDER BY timestamp DESC");
                $impressions_detailed = $wpdb->get_results("SELECT COUNT(*) FROM ".$wpdb->prefix."akp_impressions_log WHERE timestamp BETWEEN '$week_start' AND '$week_end' AND post_id = '$post_id'");
                $title = "Clicks made in the week between ".date('jS F Y', $week_start)." to ".date('jS F Y', $week_end);
                break;
            
            case 'today':
                $today_start = mktime(0, 0, 0, date('n', current_time('timestamp')), date('j', current_time('timestamp')), date('Y', current_time('timestamp')));
                $today_end = mktime(23, 59, 59, date('n', current_time('timestamp')), date('j', current_time('timestamp')), date('Y', current_time('timestamp')));
                $clicks_detailed = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."akp_click_log WHERE timestamp BETWEEN '$today_start' AND '$today_end' AND post_id = '$post_id' ORDER BY timestamp DESC");
                $impressions_detailed = $wpdb->get_results("SELECT COUNT(*) as impressions FROM ".$wpdb->prefix."akp_impressions_log WHERE timestamp BETWEEN '$today_start' AND '$today_end' AND post_id = '$post_id'");
                $title = "Clicks made on the ".date('jS F Y', $today_start);
                break;
            
            case 'daterange':
                $from_date = $_POST['from_date'];
                $to_date = $_POST['to_date'];
                $date_start = mktime(0, 0, 0, date('m', strtotime(str_replace('/', '-', $from_date))), date('d', strtotime(str_replace('/', '-', $from_date))), date('Y', strtotime(str_replace('/', '-', $from_date))));
                $date_end = mktime(23, 59, 59, date('m', strtotime(str_replace('/', '-', $to_date))), date('d', strtotime(str_replace('/', '-', $to_date))), date('Y', strtotime(str_replace('/', '-', $to_date))));
                $clicks_detailed = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."akp_click_log WHERE timestamp BETWEEN '$date_start' AND '$date_end' AND post_id = '$post_id' ORDER BY timestamp DESC");
                $impressions_detailed = $wpdb->get_results("SELECT COUNT(*) as impressions FROM ".$wpdb->prefix."akp_impressions_log WHERE timestamp BETWEEN '$date_start' AND '$date_end' AND post_id = '$post_id'");
                $title = "Clicks made between ".date('jS F Y', $date_start)." to ".date('jS F Y', $date_end);
                break;
        }
        $impressions = $impressions_detailed[0]->impressions;
        $clicks = count($clicks_detailed);
        
        query_posts(array(
            'post_type'=>'adverts_posts',
            'p'=>$post_id
            ));
        while (have_posts()) : the_post();
            $post_id = get_the_ID();
            $image = akp_get_featured_image($post_id);
            $dets = akp_return_fields($post_id);
        endwhile;
        wp_reset_query();
    
        $currency_sign = get_option('revenue_currency');
        $impression_cost = $dets['akp_revenue_per_impression'][0];
        $click_cost = $dets['akp_revenue_per_click'][0];
        
        $per_impression = $currency_sign.$impression_cost;
        $impression_total = $impression_cost * $impressions;
        $impression_total_output = $currency_sign.$impression_total;
        
        $per_click = $currency_sign.$click_cost;
        $click_total = $click_cost * $clicks;
        $click_total_output = $currency_sign.$click_total;
        
        $total_made = $impression_total + $click_total;
        $total_made_output = $currency_sign.$total_made;
        
        $pdf_theme = get_option('pdf_theme');
        if (file_exists(str_replace("js/","",plugin_dir_path(__FILE__)).'themes/'.$pdf_theme.'/pdf.php'))
            include str_replace("js/","",plugin_dir_path(__FILE__)).'themes/'.$pdf_theme.'/pdf.php';
        else {
            // Fallback for missing themes folder.
            $pdf = new FPDF('P','mm','A4');
            $pdf->AliasNbPages();
            $pdf->AddPage();

            $imagesize = getimagesize(str_replace('http://'.$_SERVER['HTTP_HOST'], $_SERVER['DOCUMENT_ROOT'], $image));
            $imagesize[0] = ($imagesize[0] * 25.4) / 72;
            $imagesize[1] = ($imagesize[1] * 25.4) / 72;
            $imw = 190;
            $imh = 20;
            if ($imagesize[0] > $imagesize[1]) {
                if ($imagesize[0] > 190) {
                    $wpc = 190 / $imagesize[0];
                    $imh = $imagesize[1] * $wpc;
                } else {
                    $imh = $imagesize[1];
                    $imw = $imagesize[0];
                }
            } else {
                if ($imagesize[1] > 20) {
                    $wph = 20 / $imagesize[1];
                    $imw = $imagesize[0] * $wph;
                } else {
                    $imh = $imagesize[1];
                    $imw = $imagesize[0];
                }
            }

            $pdf->Image(str_replace('http://'.$_SERVER['HTTP_HOST'], $_SERVER['DOCUMENT_ROOT'], $image), 10, 6, $imw, $imh);

            $pdf->SetX(15); $pdf->SetY($pdf->GetY()+ $imh + 5);
            $pdf->SetFont('Arial','BU',10);
            $pdf->Cell(95,8,$title,0,0,'L');
            $pdf->Cell(95,8,"Banner ID: #".$post_id,0,0,'R');
            $pdf->Ln(15);

            // Overview
            $pdf->SetFillColor(255,255,255);
            $pdf->SetTextColor(0,0,0);
            $pdf->SetX(10);
            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(55,5,'',0,0,'C',1);
            $pdf->SetFillColor(227,227,227);
            $pdf->Cell(45,5,'Count',1,0,'C',1);
            $pdf->Cell(45,5,'Cost Per',1,0,'R',1);
            $pdf->Cell(45,5,'Total',1,0,'R',1);
            $pdf->Ln(5);
            $pdf->SetFillColor(255,255,255);
            $pdf->SetX(10);
            $pdf->SetFont('Arial','',9);

            $pdf->Cell(55,5,'Impressions',1,0,'C',1);
            $pdf->Cell(45,5,$impressions,1,0,'C',1);
            $pdf->Cell(45,5,$per_impression,1,0,'R',1);
            $pdf->Cell(45,5,$impression_total_output,1,0,'R',1);
            $pdf->Ln(5);

            $pdf->Cell(55,5,'Clicks',1,0,'C',1);
            $pdf->Cell(45,5,$clicks,1,0,'C',1);
            $pdf->Cell(45,5,$per_click,1,0,'R',1);
            $pdf->Cell(45,5,$click_total_output,1,0,'R',1);
            $pdf->Ln(5);

            $pdf->Cell(55,5,'',0,0,'C',1);
            $pdf->Cell(45,5,'',0,0,'C',1);
            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(45,5,'TOTAL',0,0,'R',1);
            $pdf->SetFillColor(227,227,227);
            $pdf->Cell(45,5,$total_made_output,1,0,'R',1);
            $pdf->Ln(15);

            // IPs
            $pdf->SetFillColor(227,227,227);
            $pdf->SetTextColor(0,0,0);
            $pdf->SetX(10);
            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(95,5,'Date/Time',1,0,'C',1);
            $pdf->Cell(95,5,'IP Address',1,0,'C',1);
            $pdf->Ln(5);
            $pdf->SetFillColor(255,255,255);
            $pdf->SetX(10);
            $pdf->SetFont('Arial','',9);
            foreach ($clicks_detailed as $click) {
                $pdf->Cell(95,5,date('d/m/Y h:i:sa', $click->timestamp),1,0,'C',1);
                $pdf->Cell(95,5,$click->ip_address,1,0,'C',1);
                $pdf->Ln(5);
            }

            $pdf_path = plugin_dir_path(__FILE__)."../../outputs/output.pdf";
            $pdf->Output($pdf_path, "F");
        }
        echo str_replace("js/","",plugin_dir_url(__FILE__))."outputs/output.pdf";
    }
    die();
}

add_action( 'wp_ajax_akpoutputpdf', 'akp_output_pdf' );

?>
