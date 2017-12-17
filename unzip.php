<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

$nZip = 'build.zip';
$zip = new ZipArchive;
$res = $zip->open($nZip);

if($res !== TRUE) {
    die('0');
}

$zip->extractTo('./');
$zip->close();
echo '1';

unlink($nZip);
unlink(basename(__FILE__));