# kwc-shop
Shop Component for Koala Framework

#### Wirecard credentials
Several types of payment methods can be configured. Each payment method has its own individual test credentials, which need to be set correctly for each payment method to work properly in a test environment. Some payment methods are shown below but other configurations can be found at: https://doc.wirecard.com/PPv2.html#PPv2_PaymentMethods
```
[test]
;creditcard
wirecard.url = https://wpp-test.wirecard.com/api/payment/register
wirecard.merchant.id = 7a6dd74f-06ab-4f3f-a864-adc52687270a
wirecard.secret = a8c3fce6-8df7-4fd6-a1fd-62fa229c5e55
wirecard.auth.username = "70000-APIDEMO-CARD"
wirecard.auth.password = "ohysS0-dvfMx"

;creditcard with 3d-secure enabled
wirecard.url = https://wpp-test.wirecard.com/api/payment/register
wirecard.merchant.id = cad16b4a-abf2-450d-bcb8-1725a4cef443
wirecard.secret = b3b131ad-ea7e-48bc-9e71-78d0c6ea579d
wirecard.auth.username = "70000-APILUHN-CARD"
wirecard.auth.password = "8mhwavKVb91T"

;sofortbanking
wirecard.url = https://wpp-test.wirecard.com/api/payment/register
wirecard.merchant.id = f19d17a2-01ae-11e2-9085-005056a96a54
wirecard.secret = ad39d9d9-2712-4abd-9016-cdeb60dc3c8f
wirecard.auth.username = "70000-APITEST-AP"
wirecard.auth.password = "qD2wzQ_hrc!8"
```
For a production environment, production credentials have to be supplied. They can be found in wirecard's merchant center. 
```
[production]
wirecard.url = https://wpp.wirecard.com/api/payment/register
wirecard.merchant.id = ""
wirecard.secret = ""
wirecard.auth.username = ""
wirecard.auth.password = ""
```

