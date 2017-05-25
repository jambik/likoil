<?php

include __DIR__.DIRECTORY_SEPARATOR.'config.php';
include __DIR__.DIRECTORY_SEPARATOR.'Addressbook.php';
include __DIR__.DIRECTORY_SEPARATOR.'Exceptions.php';
include __DIR__.DIRECTORY_SEPARATOR.'Account.php';
include __DIR__.DIRECTORY_SEPARATOR.'Stat.php';

$Gateway     = new APISMS($sms_key_private,$sms_key_public, 'http://atompark.com/api/sms/');
$Addressbook = new Addressbook($Gateway);
$Exceptions  = new Exceptions($Gateway);
$Account     = new Account($Gateway);
$Stat        = new Stat($Gateway);