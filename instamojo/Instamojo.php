<?php

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://test.instamojo.com/api/1.1/payment-requests/');
curl_setopt($ch, CURLOPT_HEADER, FALSE);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
curl_setopt($ch, CURLOPT_HTTPHEADER,
            array("X-Api-Key:test_a2debc70bdb376abc2058731e1d",
                  "X-Auth-Token:test_b08f3822296d673e9e46246f1fe"));
$payload = Array(
    'purpose' => 'Testing',
    'amount' => '10',
    'phone' => '7573867597',
    'buyer_name' => 'Chetan',
    'redirect_url' => 'http://localhost:8080/instamojo-php-master/instamojo-php-master/redirect.php',
    'send_email' => true,
    'send_sms' => true,
    'email' => 'cheturo2204@example.com',
    'allow_repeated_payments' => false
);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
$response = curl_exec($ch);
curl_close($ch);

$response = json_decode($response);

print_r($response);

?>
