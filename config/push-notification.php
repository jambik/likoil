<?php

return array(

    'likoilIOS'     => array(
        'environment' => 'development',
        'certificate' => storage_path('certificates/apns/production_Olegek.LB.pem'),
        'passPhrase'  => '123456',
        'service'     => 'apns'
    ),
    'likoilAndroid' => array(
        'environment' => 'production',
        'apiKey'      => env('GOOGLE_GCM_KEY'),
        'service'     => 'gcm'
    )

);