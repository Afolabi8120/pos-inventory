<?php
    require('../core/init.php');
    require_once('../assets/dompdf/vendor/autoload.php');

    $date_from = date('Y-m-d', strtotime($_GET['from']));
    $date_to = date('Y-m-d', strtotime($_GET['to']));

    /* Filter Excel Data */
    function filterData(&$str)
    {
        $str = preg_replace("/\t/", "\\t", $str);
        $str = preg_replace("/\r?\n/", "\\n", $str);
        if (strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
    }

    /* Excel File Name */
    $fileName = 'Profit & Loss Report From ' . $date_from . ' - To ' . $date_to . '.xls';

    /* Excel Column Name */
    $fields = array('S/N', 'Product Name', 'Quantity', 'Price', 'Sub Total', 'Profit & Loss', 'Payment Type', 'Payment Status', 'Sold By', 'Date Sold');

    /* Implode Excel Data */
    $excelData = implode("\t", array_values($fields)) . "\n";

    /* Fetch All Records From The Database */
    $i = 1;
    foreach ($order->getProfitSummary($date_from,$date_to) as $fetchProfitSummary){
        $lineData = array($i++, ucwords($fetchProfitSummary->product_name), $fetchProfitSummary->quantity, number_format($fetchProfitSummary->price, 00), number_format($fetchProfitSummary->quantity * $fetchProfitSummary->price, 00), number_format($fetchProfitSummary->profit, 00), ucwords($fetchProfitSummary->paytype), $order->printPaymentStatus($fetchProfitSummary->invoiceno), $order->printSellerUsername($fetchProfitSummary->invoiceno), $fetchProfitSummary->date_paid);
        array_walk($lineData, 'filterData');
        $lineData2 = array("", "", "", "", "Total Profit", $order->getProfitSummaryTotal($date_from,$date_to), "", "", "", "");
        array_walk($lineData, 'filterData');
        $excelData .= implode("\t", array_values($lineData)) . "\n";
    }
    $excelData .= implode("\t", array_values($lineData2)) . "\n";

    /* Generate Header File Encodings For Download */
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=\"$fileName\"");

    /* Render  Excel Data For Download */
    echo $excelData;

    exit;
