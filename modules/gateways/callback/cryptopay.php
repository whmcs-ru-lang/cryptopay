<?php

use WHMCS\Database\Capsule;

if (!defined("WHMCS")) {
    die("This file cannot be accessed directly");
}

$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (!isset($data['invoice_id']) || !isset($data['status'])) {
    http_response_code(400);
    echo 'Invalid payload';
    exit();
}

$invoiceId = $data['payload'];
$status = $data['status'];
$amountPaid = isset($data['paid_amount']) ? $data['paid_amount'] : null;
$paidAsset = isset($data['paid_asset']) ? $data['paid_asset'] : null;

logModuleCall('cryptopay', 'callback', $data, '', '', ['invoiceId' => $invoiceId, 'status' => $status]);

if ($status === 'paid') {
    try {
        $invoice = Capsule::table('tblinvoices')->where('id', $invoiceId)->first();

        if ($invoice) {
            addInvoicePayment(
                $invoiceId,
                $data['invoice_id'],
                $amountPaid,
                0,
                'cryptopay'
            );

            http_response_code(200);
            echo 'Payment successful';
        } else {
            http_response_code(404);
            echo 'Invoice not found';
        }
    } catch (Exception $e) {
        logModuleCall('cryptopay', 'callback_error', $data, $e->getMessage());
        http_response_code(500);
        echo 'Error: ' . $e->getMessage();
    }
} elseif ($status === 'expired') {
    try {
        Capsule::table('tblinvoices')->where('id', $invoiceId)->update(['status' => 'Cancelled']);
        http_response_code(200);
        echo 'Invoice expired';
    } catch (Exception $e) {
        logModuleCall('cryptopay', 'callback_error', $data, $e->getMessage());
        http_response_code(500);
        echo 'Error: ' . $e->getMessage();
    }
} else {
    http_response_code(400);
    echo 'Unknown status';
}

?>
