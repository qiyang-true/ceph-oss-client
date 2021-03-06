<?php
require 'aws-sdk-for-php/sdk.class.php';
$settings = parse_ini_file('settings.ini', true);

$Connection = new AmazonS3(array(
        'key' => $settings['base']['key'],
        'secret' => $settings['base']['secret'],
       // 'canonical_id' => AWS_CANONICAL_ID,
       // 'canonical_name' => AWS_CANONICAL_NAME,
));
$Connection->use_ssl = false;
$Connection->ssl_verification = false;
$Connection->set_hostname($settings['base']['hostname'].':'.$settings['base']['port']);
$Connection->allow_hostname_override(false);
 
// Set the S3 class to use objects.dreamhost.com/bucket
// instead of bucket.objects.dreamhost.com
$Connection->enable_path_style();