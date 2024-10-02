# CryptoPay for WHMCS

**CryptoPay for WHMCS** is a module that integrates the [CryptoBot](https://t.me/send?start=r-8bjc7/) payment system into WHMCS. This module allows your clients to pay invoices with cryptocurrencies directly through the Telegram-based CryptoBot.

## Features

- Accept payments in popular cryptocurrencies: BTC, ETH, USDT, LTC, BNB, TRX, USDC.
- Support for fiat currencies like USD, EUR, RUB, BYN, UAH.
- Automatic payment confirmation via callback.
- Easy setup and configuration through the WHMCS admin panel.
- Secure transaction handling using the CryptoPay API.

## Installation

1. Download the module files from this repository.
2. Upload the files to the `/modules/gateways/` directory of your WHMCS installation.
3. Go to the WHMCS admin panel, navigate to **Setup > Payments > Payment Gateways**, and activate **CryptoPay**.
4. Enter your CryptoPay API token and configure your settings.
5. Save the changes and start accepting cryptocurrency payments!

## Callback URL

Make sure to set the callback URL to:
https://yourdomain.com/modules/gateways/callback/cryptopay.php
