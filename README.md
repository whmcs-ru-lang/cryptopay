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


## Requirements

- WHMCS 7.0 or higher
- PHP 7.2 or higher
- Valid CryptoPay API token

## Support

For support or any questions, create an issue in this repository.

---

# CryptoPay для WHMCS


**CryptoPay для WHMCS** — это модуль для интеграции платежной системы [CryptoBot](https://t.me/send?start=r-8bjc7/) в WHMCS. Этот модуль позволяет вашим клиентам оплачивать счета криптовалютами напрямую через Telegram-бот CryptoBot.

## Основные функции

- Прием платежей в популярных криптовалютах: BTC, ETH, USDT, LTC, BNB, TRX, USDC.
- Поддержка фиатных валют: USD, EUR, RUB, BYN, UAH.
- Автоматическое подтверждение платежа через callback.
- Легкая установка и настройка через панель администратора WHMCS.
- Безопасная обработка транзакций с использованием API CryptoPay.

## Установка

1. Скачайте файлы модуля из этого репозитория.
2. Загрузите файлы в директорию `/modules/gateways/` в установке WHMCS.
3. В админ-панели WHMCS перейдите в **Настройки > Платежи > Платежные шлюзы**, активируйте **CryptoPay**.
4. Введите ваш API-токен CryptoPay и настройте параметры.
5. Сохраните изменения и начните принимать криптовалютные платежи!

## URL для обратного вызова (Callback)

Убедитесь, что вы установили URL для обратного вызова в вашем аккаунте CryptoPay:

https://yourdomain.com/modules/gateways/callback/cryptopay.php

## Требования

- WHMCS версии 7.0 или выше
- PHP 7.2 или выше
- Действующий API-токен CryptoPay

## Поддержка

Для поддержки или вопросов свяжитесь с нами или создайте обращение в этом репозитории.
