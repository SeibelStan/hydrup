<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

$cfg = json_decode(file_get_contents('cfg.json'));

$nFile = basename($cfg->source);
$lFile = 'tmp/' . $nFile;
$lUnzp = 'unzip.php';
$nUnzp = basename($lUnzp);

$sContent = file_get_contents($cfg->source);
file_put_contents($lFile, $sContent);

foreach($cfg->hosts as $host) {
    $rFile = "$host->remotePath/$nFile";
    $rUnzp = "$host->remotePath/$nUnzp";

    $conn = ftp_connect($host->host);
    ftp_login($conn, $host->username, $host->password);

    foreach(ftp_nlist($conn, $host->remotePath) as $path) {
        if(!in_array($path, ['.', '..'])) {
            ftp_delete($conn, "$host->remotePath/$path");
        }
    }

    ftp_put($conn, $rFile, $lFile, FTP_BINARY);
    ftp_put($conn, $rUnzp, $lUnzp, FTP_BINARY);

    ftp_close($conn);
    unlink($lFile);
    echo "<iframe src='$host->site/$nUnzp'></iframe>";
    //file_get_contents("$host->site/$nUnzp");
}