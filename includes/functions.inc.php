<?

################################
##        PHP Functions       ##
##        for  Jonez.co       ##
##         -----------        ##
##        ©2022 JonezCo       ##
##     All Rights Reserved    ##
##         kc@jonez.co        ##
################################	



// Show a list of all MySQL Databases on server //
function showDB() {
	require "db.inc.php"; //Connect to DB for the function
	$UIP = $_SERVER['REMOTE_ADDR']; //Get user's IP Address

	$result = $dbo->query("SHOW DATABASES");
	while ($row = $result->fetch(PDO::FETCH_NUM)) {
		echo $row[0]."<br>";
	}
} // EOF




// Check if user is logged and alert if not
function chklogged() {
	if ( !isset ( $_SESSION['user_logged'] ) ) {
		echo "You are not allowed to view this page!<br />".
			"Please <a href=\"#\" onClick=\"history.back(-1);\">Click Here</a> to go back or<br />".
			"click <a onClick=\"window.open('../login.php', 'login', 'toolbar=no, scrollbars=no, resizable=no, top=200, left=100, width=400, height=600');\" class=\"social-button fa-user\" target=\"_blank\"><i class=\"fa fa-user\"></i></a> and log in.";
		exit();
	}
} // EOF




// Get user's IP address for logging attempts
function userIP() {
    $_SESSION['user_ip'] = $_SERVER['REMOTE_ADDR'];
} //EOF




// Inactive timeout after 15 minutes //
function lgnTime() {

//Check the session start time is set or not

if(!isset($_SESSION['start']))

{

    //Set the session start time

    $_SESSION['start'] = time();

}


//Check the session is expired or not

if (isset($_SESSION['start']) && (time() - $_SESSION['start'] >900)) {

    //Unset the session variables

    session_unset(); 

    //Destroy the session

    session_destroy(); 

    header("Location: ../mem/login.php");
    die();

}

else

    echo "Current session exists.<br/>";
    header("Location: ../index.php");
    die();
    
} //EOF




// Redirect to inputted URL //
function redirect($url, $statusCode = 303)
{
   header('Location: ' . $url, true, $statusCode);
   die();
} // EOF




// Just set the damn admin status ffs!
function isAdmin() {
    if ( isset ( $_SESSION['isadmin'] ) && $SESSION['isadmin'] == "1" ) {
        $_SESSION['adm'] = "1";
        $_SESSION['isOk'] = "true";
    } else {
        $_SESSION['badMessage'] = "<center>You are not allowed to view that page!<br><br>If you are in fact and admin, and have received this message in error, contact K.C. at <a href=\"mailto:kcjonez6@outlook.com?Subject=re: Error Message on kcjonez.com.\"><em>kcjonez6@outlook.com</em></a>.<br><br>Otherwise, just like, go fuck off somewhere else!<br><br>
        <script>
            history.back(-1);
        </script>
        <a href=\"#\" onClick=\"history.back(-1);\">Click Here</a> to go back to what you were doing before being so rudely interrupted or <a href=\"#\" onClick=\"window.close();\">here</a> to close the damn window!<br><br>And have a special day!
        </center>
        ";
    }
} // EOF




// Hit Counter
function hits() {
    if ( $_SESSION['chkhit'] != "1" ) {
        $addhit = "true";
        $_SESSION['chkhit'] = "1";
    } else {
        $addhit = "false";
    }

	$gethit = @mysql_query("SELECT * FROM `hits` WHERE `id` = '1' ") or die(mysql_error());
	
	$hitrow = mysql_fetch_array($gethit);
    
    
    if ( $addhit == "true" ) {
        
        $newhit = $hitrow['hits'] + 1;
        
        @mysql_query("UPDATE `hits` SET `hits` = '" . $newhit . "' WHERE `id` = '1' LIMIT 1") or die(mysql_error());
        
    } else {
        $newhit = $hitrow['hits'];
        $_SESSION['newhit'] = $hitrow['hits'];
    }
} // EOF




// Make sure an Admin is logged in before showing 'Add Item'
/*function addItem() {
        $_SESSION['isOk'] = "";
    if ( isset ( $_SESSION['isadmin'] ) && $_SESSION['isadmin'] == "1" ) {
        $_SESSION['isOk'] = "true";
    } else {
        $_SESSION['isOK'] = "";
    }
} */ // EOF



    
// Get user info if logged in
function usrLogged() {
if ( isset ( $_SESSION['user_logged'] ) && $_SESSION['user_logged'] != "" ) {
	// Grab user info for last login display
	$query = @mysql_query("SELECT * FROM `members` WHERE `id` = '" . $_SESSION['userid'] . "'") or die(mysql_error());
	$row = mysql_fetch_array($query);
    $_SESSION['shwAdd'] = "true";
}
} // EOF





// Resize image
function imageResize($imageSrc,$imageWidth,$imageHeight) {

    $newImageWidth =200;
    $newImageHeight =200;

    $newImageLayer=imagecreatetruecolor($newImageWidth,$newImageHeight);
    imagecopyresampled($newImageLayer,$imageSrc,0,0,0,0,$newImageWidth,$newImageHeight,$imageWidth,$imageHeight);

    return $newImageLayer;
} // EOF





// Rotate Image
function correctImageOrientation($filename) {
  if (function_exists('exif_read_data')) {
    $exif = exif_read_data($filename);
    if($exif && isset($exif['Orientation'])) {
      $orientation = $exif['Orientation'];
      if($orientation != 1){
        $img = imagecreatefromjpeg($filename);
        $deg = 0;
        switch ($orientation) {
          case 3:
            $deg = 180;
            break;
          case 6:
            $deg = 270;
            break;
          case 8:
            $deg = 90;
            break;
        }
        if ($deg) {
          $img = imagerotate($img, $deg, 0);        
        }
        // then rewrite the rotated image back to the disk as $filename 
        imagejpeg($img, $filename, 95);
      } // if there is some rotation necessary
    } // if have the exif orientation info
  } // if function exists      
} // EOF





?>
