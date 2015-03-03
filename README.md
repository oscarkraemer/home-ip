home-ip
Keeps track of computers ip addresses

Installed on a server with a public ip.

index.php
returns your ip

index.php?m=test or index.php?machine=test
returns ip of test

Cronjob to update the ip address 
*/10 * * * * /usr/bin/curl yadayada.local/index.php -d "machine=home&update=true"

Writes in a log (ipaddr.log) all changes.

Require a db.php file that contains variabels for:
$db_ip  // 127.0.0.1 
$db_user // AzureDiamond
$db_passwd // hunter2
$db_db // homeIpDb
