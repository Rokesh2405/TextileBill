<?php
error_reporting(1);
ini_set('display_errors','1');
 error_reporting(E_ALL);
require 'vendor/autoload.php';

$sns = Aws\Sns\SnsClient::factory(array(
    'credentials' => [
        'key'    => 'AKIAZDI24VAV7BL7BY3F',
        'secret' => 'jo2eOMyAKV0Lb2u3JMKDrFp1Sr+zEqryjzINK6sQ',
    ],
    'region' => 'us-east-1',
    'version'  => 'latest',
));
$smsmsg="# Your Gotohospital Code is : ".$_REQUEST['otp'];
$result = $sns->publish([
    'Message' => $smsmsg, // REQUIRED
    'MessageAttributes' => [
        'AWS.SNS.SMS.SenderID' => [
            'DataType' => 'String', // REQUIRED
            'StringValue' => 'INwhooami11'
        ],
        'AWS.SNS.SMS.SMSType' => [
            'DataType' => 'String', // REQUIRED
            'StringValue' => 'Transactional' // or 'Promotional'
        ]
    ],
    'PhoneNumber' => '+91'.$_REQUEST['mobileno'],
]);

echo $result['@metadata']['statusCode'];
exit;
?>