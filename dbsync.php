#!/usr/bin/php
<?php

/**
 * If you have your .ssh/config file setup you can use this syntax
 *  $sshServer = 'server';
 * If you are not using your .ssh/config file you should use this syntax
 *  $sshServer = 'user@server.com

// SSH server connection string
$sshServer = '';

// Remote database configuration
$rDbUser = '';
$rDbPass = '';
$rDbName = '';

// Local database configuration
$lDbUser = '';
$lDbPass = '';
$lDbName = '';
*/

/** End of configuration settings. Do not edit below this line **/

$mode = $argv[1];

if(isset($argv[2])) {
  $config = $argv[2];
  if(file_exists($config)) {
    $ini = parse_ini_file($config, true);
    $sshServer = $ini['remote']['ssh'];
    $rDbUser = $ini['remote']['username'];
    $rDbPass = $ini['remote']['password'];
    $rDbName = $ini['remote']['database'];
    $lDbUser = $ini['local']['username'];
    $lDbPass = $ini['local']['password'];
    $lDbName = $ini['local']['database'];
  }
}

if($mode == 'get') {
  $source = "ssh $sshServer" . ' "' . "mysqldump -u $rDbUser --password=$rDbPass $rDbName" . '" ';
  $target = "mysql -u $lDbUser --password=$lDbPass --host=localhost -C $lDbName";
  $cmd = " $source | $target";
  echo "Replacing $lDbName on localhost with $rDbName from $sshServer\n\n";
  echo `$cmd`;
}
elseif($mode == 'put') {
  $source = "mysqldump -u $lDbUser --password=$lDbPass --host=localhost -C $lDbName";
  $target = "ssh $sshServer" . ' "' . "mysql -u $rDbUser --password=$rDbPass $rDbName" . '"';
  $cmd = $source . ' | ' . $target;
  echo "Replacing $rDbName on $sshServer with $lDbName on localhost\n\n";
  echo `$cmd`;
}
echo "\n\nTransfer complete.\n\n";
