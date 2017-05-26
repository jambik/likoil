<?php

return array(

    'ios' => array(
        'environment' => 'production',
        'certificate' => storage_path('certificates/apns/production_Olegek.LB.pem'),
        'passPhrase'  => '123456',
        'service'     => 'apns'
    ),
    'android' => array(
        'environment' => 'production',
        'apiKey'      => env('GOOGLE_GCM_KEY'),
        'service'     => 'gcm'
    )

);