<?

/* --> _______________ <-- */
/* --> Scripts n Stuff <-- */ 
/* --> _______________ <-- */


// >-< Timed Login Attempts >-< //

$last_login_string = {{ get unsuccesful_login_timestamps value for this user from database }}
$last_login_string = update_last_login($last_login_string);
$fourth_last_login = get_4th_last_login($last_login_string);
$time_difference = time() - $fourth_last_login;

{{Update unsuccesful_login_timestamps in db with $last_login_string}}

if($time_difference <900){
    //show captcha
}else{
    //no_need_for_captcha
}
//Method to update last 4 unsuccessful logins by removing
// the last one from the starting and append the latest time in the end
function update_last_login($last_login_string){ 
    $time_array = array();
    if(strlen($last_login_string) > 0){
        $time_array = explode(",",$last_login_string);
        $size = count($time_array);
        if($size ==0){ //first attempt
            $last_login_string = time();
        }else if($size == 4){ //>=4th attempt
            $time_array[4]=time();
            array_shift($time_array);
            $last_login_string = implode(",",$time_array);
        }else{ // >0, but <4 attempts
            $time_array[$size]=time();
            $last_login_string = implode(",",$time_array);
        }
        return $last_login_string;
    }else{
        return time();
    }
}

function get_4th_last_login($last_login_string){
    $time_array = array();
    $time_array = explode(",",$last_login_string);
    if($size !=4){
        $last_login_time time();
    }else{
        $last_login_time = $time_array[0];
    }
    return $last_login_time;
}



// MySql version //
/* SQL */
$add = mysql_query("ALTER TABLE `members` ADD `login_atmpt` INT(1) NOT NULL DEFAULT '1' AFTER `forum_mailto`;")
$set_atmpt = mysql_query("UPDATE members SET login_attmp = login_atmpt++") or die(mysql_error());
$time = $_SERVER['REQUEST_TIME'] - 900; // Current time minus 900 seconds (15 minutes)
$query1 = "SELECT login_attempts from users WHERE email = '$email' AND last_login < $time";


// funtion //

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


