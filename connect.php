<?php
require 'aws-sdk-for-php/sdk.class.php';
 
$Connection = new AmazonS3(array(
        'key' => '78W0YB9F1AK5RMX5B5U9',
        'secret' => '80OUcJzux4OQNwu4lV3uY9KPMXvZMqJkeb1nWsuG',
       // 'canonical_id' => AWS_CANONICAL_ID,
       // 'canonical_name' => AWS_CANONICAL_NAME,
));
$Connection->use_ssl = false;
$Connection->ssl_verification = false;
$Connection->set_hostname('fat.vphotos.cn');
$Connection->allow_hostname_override(false);
 
// Set the S3 class to use objects.dreamhost.com/bucket
// instead of bucket.objects.dreamhost.com
$Connection->enable_path_style();
