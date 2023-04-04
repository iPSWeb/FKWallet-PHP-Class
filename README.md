# FKWallet-PHP-Class
PHP class for interacting with API FKWallet<br>
[Official documentation](https://docs.freekassa.ru/#tag/Opisanie-API)
# Usage
```php
require 'FKWallet.php';
$fk = new FKWallet('wallet_id','api_key',1);//1 - return string json, 0 - return php array
```
# Check Balances
```php
$balances = $fk->getBalance();
```
Response example
```json
{"status":"info","desc":"Wallet balance","data":{"RUB":"50.00","USD":"0.00","EUR":"0.00"}}
```
# Withdrawals
```php
$fk->cashout('purse','id_payment_system','amount','description');
```
Response example
```json
{"status":"info","desc":"Payment send","data":{"payment_id":"543273"}}
```
<details>
  <summary>List of Payment Systems</summary>
  2	WebMoney WMZ<br>
  63	QIWI кошелек<br>
  64	Perfect Money USD<br>
  45	Яндекс.Деньги<br>
  69	Perfect Money EUR<br>
  82	Мобильный Платеж Мегафон<br>
  83	Мобильный Платеж Билайн<br>
  84	Мобильный Платеж МТС<br>
  94	VISA/MASTERCARD RUB<br>
  132	Мобильный Платеж Tele2<br>
  115	PAYEER USD<br>
  114	PAYEER RUB<br>
  133	FK WALLET RUB<br>
  136	ADVCASH USD<br>
  150	ADVCASH RUB<br>
  186	VISA/MASTERCARD KZT<br>
  201	СБП<br>
</details>

# Getting the status of a withdrawal operation from a wallet
```php
$fk->getPaymentStatus('paymentId');
```
Response example
```json
{"status":"info","desc":"Order status","data":{"payment_id":"543273","status":"Canceled"}}
```
# Get List Banks for SBP
```php
$fk->getListSBP();
```
# Transfer to another wallet
```php
$fk->transfer('purse','amount');
```
Response example
```json
{"status":"info","desc":"Payment send"}
```
# Payment for online services
```php
$fk->onlinePayment('serviceId','account|purse','amount');
```
Response example
```json
{"status":"info","desc":"Payment send","data":{"payment_id":"543273"}}
```
# Getting a list of services for online payment
```php
$fk->getProviders();
```
Response example
```json
{
    "status": "info",
    "desc": "Providers list",
    "data": [
            {
                "id": "1",
                "name": "МТС",
                "min_amount": "5.00",
                "commission": "0"
            },
            {
                "id": "2",
                "name": "Билайн",
                "min_amount": "5.00",
                "commission": "0"
            },
        ]
    }
```
# Checking the status of an online payment
```php
$fk->checkOnlinePayment('paymentId');
```
Response example
```json
{"status":"info","desc":"Order status","data":{"payment_id":"6532323","status":"Canceled"}}
```
# Creating a BTC/LTC/ETH address
```php
$fk->createCryptoAddress('type');//type - btc,ltc,eth
```
Response example
```json
{"status":"info","desc":"Address created","data": [{"address": "4eftk98j9h76g5454er5ty8uh3dwec"}]}
```
# Getting a BTC/LTC/ETH address
```php
$fk->getCryptoAddress('type');//type - btc,ltc,eth
```
Response example
```json
{"status":"info","desc":"","data":{"address":"46D98a09Fd204C9C72d2A2Dd3563fF5495aD41D0","valid":"2020-05-16 14:54:52"}}
```
# Getting information on Bitcoin/Litecoin/Ethereum transactions
```php
$fk->getCryptoTransaction('type','transactionId');//type - btc,ltc,eth
```
Response example
```json
{
    "status":"info",
    "desc":"",
    "data": [
        {
            "address": "4eftk98j9h76g5454er5ty8uh3dwec",
            "transaction_id": "gb56yu3txdy237dy2xu8d2983tdxy23dux2873d7yx20d",
            "amount": "0.001",
            "fee": "0",
            "confirmations": "4",
            "date": "2017-01-01 23:32:33"
        }
    ]
    }
```
