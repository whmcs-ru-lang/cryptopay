<?php

use WHMCS\Database\Capsule;

if (!defined("WHMCS")) {
    die("This file cannot be accessed directly");
}

$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (!isset($data['payload']['invoice_id']) || !isset($data['payload']['status']) || $data['update_type'] != "invoice_paid") {
    http_response_code(400);
    echo 'Invalid payload';
    exit();
}

$invoiceId = $data['payload']['invoice_id'];
$status = $data['payload']['status'];
$amountPaid = isset($data['payload']['paid_amount']) ? $data['payload']['paid_amount'] : null;
$paidAsset = isset($data['payload']['paid_asset']) ? $data['payload']['paid_asset'] : null;

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
