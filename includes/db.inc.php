<?

##################################
##      Connect to Database     ##
##                              ##
##              By              ##
##          K.C. Jones          ##
##        ©2022 Jonez.co        ##
##      All Rights Reserved     ##
##                              ##
##################################


$dbhost = "localhost";
$dbuser = "kcjonez";
$dbpass = "B1ack#307711";
$dbname = "jonezco";

@mysql_connect($dbhost,$dbuser,$dbpass) or die(mysql_error());

@mysql_select_db($dbname) or die(mysql_error());

//SET time_zone = 'America/Denver';

@mysql_query("SET SESSION time_zone = '-7:00'");


?>