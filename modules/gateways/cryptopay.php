<?php

if (!defined("WHMCS")) {
    die("This file cannot be accessed directly");
}

function cryptopay_MetaData()
{
    return [
        'DisplayName' => 'CryptoPay Payment Gateway',
        'APIVersion' => '1.1',
    ];
}

function cryptopay_config()
{
    return [
        'FriendlyName' => ['Type' => 'System', 'Value' => 'CryptoPay'],
        'apiToken' => ['FriendlyName' => 'API Token', 'Type' => 'text', 'Size' => '50', 'Description' => 'Enter your CryptoPay API token here'],
        'currencyType' => ['FriendlyName' => 'Currency Type', 'Type' => 'dropdown', 'Options' => 'crypto,fiat', 'Description' => 'Select the type of currency (crypto or fiat)'],
        'asset' => ['FriendlyName' => 'Asset', 'Type' => 'dropdown', 'Options' => 'BTC,ETH,USDT,LTC,BNB,TRX,USDC', 'Description' => 'Select cryptocurrency asset'],
        'fiat' => ['FriendlyName' => 'Fiat Currency', 'Type' => 'dropdown', 'Options' => 'USD,EUR,RUB,BYN,UAH', 'Description' => 'Select fiat currency'],
    ];
}

function cryptopay_link($params)
{
    if (empty($params['apiToken'])) {
        return 'Error: API token is missing.';
    }

    $invoiceId = $params['invoiceid'];
    $amount = $params['amount'];
    $description = "Invoice #" . $invoiceId;
    
    $apiToken = $params['apiToken'];
    $currencyType = $params['currencyType'];
    $asset = $params['asset'];
    $fiat = $params['fiat'];
    $callbackUrl = $params['systemurl'] . '/modules/gateways/callback/cryptopay.php';
    
    $postData = [
        'amount' => $amount,
        'asset' => $asset,
        'description' => $description,
        'callback_url' => $callbackUrl,
        'currency_type' => $currencyType
    ];

    if ($currencyType === 'fiat' && !empty($fiat)) {
        $postData['fiat'] = $fiat;
    }

    $postFields = http_build_query($postData);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://pay.crypt.bot/api/createInvoice");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Crypto-Pay-API-Token: " . $apiToken,
        "Content-Type: application/x-www-form-urlencoded"
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
    if (curl_errno($ch)) {
        $curlError = curl_error($ch);
        curl_close($ch);
        return 'CURL Error: ' . $curlError;
    }

    curl_close($ch);

    $result = json_decode($response, true);

    if ($httpCode === 200 && isset($result['ok']) && $result['ok'] === true) {
        if (isset($result['result']['bot_invoice_url'])) {
            return '<a href="' . $result['result']['bot_invoice_url'] . '" class="btn btn-success">Pay Now</a>';
        } else {
            return 'Error: bot_invoice_url not found in the response';
        }
    } else {
        $error = isset($result['error']) ? $result['error'] : 'Unknown error';
        return 'Error creating payment: ' . $error;
    }
}

?>
