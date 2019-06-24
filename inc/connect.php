<?php
/**
 * Created by PhpStorm.
 * User: berka
 * Date: 4.03.2017
 * Time: 15:07
 */

$conn;
function connectDB()
{
//    $servername = "localhost";
//    $username = "root";
//    $password = "";
//    $dbname = "insta";
    $servername = "localhost";
    $username = "berkaytu_insta";
    $password = "124578";
    $dbname = "berkaytu_insta";
    global $conn;
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    mysqli_set_charset($conn, 'utf8');
}

function disconnectDB()
{
    global $conn;
    $conn->close();
}

function isUserAdmin($username, $password)
{
    global $conn;

    // select
    $sql = "SELECT * FROM users WHERE username = \"" . $username . "\" AND password = \"" . $password . "\"";
    $result = $conn->query($sql);


    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            if ($row["isAdmin"] == 1) {
                //TODO buraya ekrana ne basılacağını gösteren sayfayı çağıran bir şey de koyabiliriz
                return true;
            } else {
                return false;
            }
        }
    } else {
        return false;
    }

}


function getAllUsers()
{

//    //örnek kullanım

//    return değeri için örnek kullanım
//    $data[0]["username"];
//    $data[0]["password"];
//    $data[0]["expiration"];
//    $data[0]["isAdmin"];

//return değerlerinin tamamı string olarak gelir dikkat et


    global $conn;

    // select
    $sql = "SELECT * FROM users ";
    $result = $conn->query($sql);

    $data = [];

    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            array_push($data, $row);
        }
    } else {
        return false;
    }

//    var_dump($data);
    return $data;


}

function extendUserExpiration($username, $extend)
{
    global $conn;
    $sql = "UPDATE users
SET expiration = expiration + " . $extend . "
WHERE username = \"" . $username . "\"";
    $result = $conn->query($sql);
    if ($result === TRUE) {
        echo "Süre başarıyla uzatıldı";
    } else {
        echo "Sıkıntı oluştu";
    }

}

function changeUserExpiration($username, $expiration)
{
    global $conn;
    $sql = "UPDATE users
SET expiration =  " . $expiration . "
WHERE username = \"" . $username . "\"";
    $result = $conn->query($sql);
    if ($result === TRUE) {
        echo "Süre başarıyla uzatıldı";
    } else {
        echo "Sıkıntı oluştu";
    }
}

function deleteUser($username){
    global $conn;

    // select
    $sql = "DELETE FROM users WHERE  username=\"" . $username . "\"";
    $result = $conn->query($sql);
    if ($result === TRUE) {
        echo "Record deleted successfully : " . $username;
    } else {
        echo "Error deleting record: " . $conn->error;
    }
    deleteUserSettings($username);
}

function addUser($username, $password, $expiration)
{
    echo "test anam";

    global $conn;

    // insert

    $sql = "INSERT INTO users (username,password,expiration)
           VALUES ('" . $username . "'
           ,'" . $password . "'
           ,'" . $expiration . "'
           )";
    // echo "<br><br>\n\n".$sql;
    $result = $conn->query($sql);

    if ($result === TRUE) {
        echo "\n\n<br><br>User added succesfully! : " . $username . " - " . $password . "\n<br>";
    } else {
        echo "\n\n<br><br>Error: " . $sql . "<br>" . $conn->error;
    }
    insertUserSettings($username, 1, 0);
}

function changePassword($username, $oldPassword, $newPassword)
{
    global $conn;
    $sql = "UPDATE users
SET password = \"" . $newPassword . "\"
WHERE username = \"" . $username . "\" AND password = \"" . $oldPassword . "\"";
    $result = $conn->query($sql);

}

function isUserValid($username, $password)
{
    global $conn;

    // select
    $sql = "SELECT * FROM users WHERE username = \"" . $username . "\" AND password = \"" . $password . "\"";
    $result = $conn->query($sql);


    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            if ($row["expiration"] > time()) {
                //TODO buraya ekrana ne basılacağını gösteren sayfayı çağıran bir şey de koyabiliriz
                return true;
            } else {
                return false;
            }
        }
    } else {
        return false;
    }

//    var_dump($data);
}


function getUserNamePassword($username)
{

//    //örnek kullanım
//    getAllLocations($username)

//    return değeri için örnek kullanım
//    $data["username"];
//    $data["password"];

//return değerlerinin tamamı string olarak gelir dikkat et


    global $conn;

    // select
    $sql = "SELECT * FROM users WHERE username = \"" . $username . "\"";
    $result = $conn->query($sql);

    $data = [];

    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            array_push($data, $row);
        }
    } else {
        return false;
    }

//    var_dump($data);
    return $data[0];


}


function getUSerSettings($username)
{

//    //örnek kullanım
//    getAllLocations($username)

//    return değeri için örnek kullanım
//    $data[0]["username"];
//    $data[0]["followset"];
//    $data[0]["likeset"];
//    $data[0]["commentset"];

//return değerlerinin tamamı string olarak gelir dikkat et


    global $conn;

    // select
    $sql = "SELECT * FROM usersettings WHERE username = \"" . $username . "\"";
    $result = $conn->query($sql);

    $data = [];

    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            array_push($data, $row);
        }
    } else {
        return false;
    }

//    var_dump($data);
    return $data[0];


}


function updateUserSettings($username, $follow, $like, $comment = null)
{
    deleteUserSettings($username);
    insertUserSettings($username, $follow, $like, $comment);

}


function deleteUserSettings($username)
{
    global $conn;

    // select
    $sql = "DELETE FROM usersettings WHERE  username=\"" . $username . "\"";
    $result = $conn->query($sql);
    if ($result === TRUE) {
        echo "Record deleted successfully : " . $username;
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}


function insertUserSettings($username, $follow, $like, $comment = null)
{

    if (is_null($comment)) {
        $comment = false;
    }
    if (!$follow && !$like) {
        $follow = true;
    }
    if ($follow == false) {
        $follow = 0;
    }
    if ($like == false) {
        $like = 0;
    }
    if ($comment == false) {
        $comment = 0;
    }


    global $conn;

    // insert

    $sql = "INSERT INTO usersettings (username,followset,likeset, commentset)
           VALUES ('" . $username . "'
           ,'" . $follow . "'
           ,'" . $like . "'
           ,'" . $comment . "'
           )";
    // echo "<br><br>\n\n".$sql;


    if ($conn->query($sql) === TRUE) {
        echo "\n\n<br><br>User settings added succesfully! : " . $username . " - " . $follow . " - " . $like . " - " . $comment . "\n<br>";
    } else {
        echo "\n\n<br><br>Error: " . $sql . "<br>" . $conn->error;
    }

}


function getAllFollowFollowers($username)
{

//    //örnek kullanım
//    getAllLocations($username)

//    return değeri için örnek kullanım
//    $data[0]["username"];
//    $data[0]["name"];
//    $data[0]["count"];
//    $data[0]["following"];
//    $data[0]["followers"];

//return değerlerinin tamamı string olarak gelir dikkat et


    global $conn;

    // select
    $sql = "SELECT * FROM followfollowers WHERE username = \"" . $username . "\"";
    $result = $conn->query($sql);

    $data = [];

    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            array_push($data, $row);
        }
    } else {
        return false;
    }

//    var_dump($data);
    return $data;


}


function updateFollowFollowers($username, $name, $count, $following, $followers)
{
    deleteFollowFollowers($username, $name);
    insertFollowFollowers($username, $name, $count, $following, $followers);

}

function deleteFollowFollowers($username, $name)
{

    global $conn;

    // select
    $sql = "DELETE FROM followfollowers WHERE name = \"" . $name . "\" AND username=\"" . $username . "\"";
    $result = $conn->query($sql);
    if ($result === TRUE) {
        echo "Record deleted successfully : " . $name;
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

function insertFollowFollowers($username, $name, $count, $following, $followers)
{

    if (!$following && !$followers) {
        $following = true;
    }
    if ($following == false) {
        $following = 0;
    }
    if ($followers == false) {
        $followers = 0;
    }

    if (empty($count)) {
        $count = 100;
    }
    global $conn;

    // insert

    $sql = "INSERT INTO followfollowers (username,name,count,following,followers)
           VALUES ('" . $username . "'
           ,'" . $name . "'
           ,'" . $count . "'
           ,'" . $following . "'
           ,'" . $followers . "'
           )";


    if ($conn->query($sql) === TRUE) {
        echo "\n\n<br><br>Profil added succesfully! : " . $username . " - " . $count . " - " . $following . " - " . $followers . "\n<br>";
    } else {
        echo "\n\n<br><br>Error: " . $sql . "<br>" . $conn->error;
    }
}


/**
 * @param $username
 * @return array|["hashtag"]|["hashtagCount"]
 */
function getAllHashtags($username)
{

//    //örnek kullanım
//    getAllLocations($username)

//    return değeri için örnek kullanım
//    $data[0]["username"];
//    $data[0]["hashtag"];
//    $data[0]["hashtagCount"];

//return değerlerinin tamamı string olarak gelir dikkat et


    global $conn;

    // select
    $sql = "SELECT * FROM hashtags WHERE username = \"" . $username . "\"";
    $result = $conn->query($sql);

    $data = [];

    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            array_push($data, $row);
        }
    } else {
        return false;
    }

//    var_dump($data);
    return $data;


}

/**
 * @param $username
 * @param $hashtags array|["hashtag"]|["hashtagCount"]
 */
function updateAllHashtags($username, $hashtags)
{


    // //buralar hep hashtag yazılı sen anla
//    //örnek kullanım
//    $location=[];
//    $location["hashtag"]="berkay";
//    $location["hashtagCount"]=15489;
//    array_push($locations,$location);
//
//    insertAllLocations($username,$locations);


    foreach ($hashtags as $hashtag) {
        deleteHashtag($username, $hashtag["hashtag"]);
    }
    insertAllHashtags($username, $hashtags);
}

/**
 * @param $username
 * @param $hashtag string
 * @param $count int
 */

function updateHashtag($username, $hashtag, $count)
{

    deleteHashtag($username, $hashtag);
    insertHashtag($username, $hashtag, $count);
}


function deleteHashtag($username, $hashtag)
{

    global $conn;

    // select
    $sql = "DELETE FROM hashtags WHERE hashtag = \"" . $hashtag . "\" AND username=\"" . $username . "\"";
    $result = $conn->query($sql);
    if ($result === TRUE) {
        echo "Record deleted successfully : " . $hashtag;
    } else {
        echo "Error deleting record: " . $conn->error;
    }


}


function insertAllHashtags($username, $hashtags)
{

// //buralar hep hashtag yazılı sen anla
//    //örnek kullanım
//    $location=[];
//    $location["hashtag"]="berkay";
//    $location["hashtagCount"]=15489;
//    array_push($locations,$location);
//
//    insertAllLocations($username,$locations);

    foreach ($hashtags as $hashtag) {
        insertHashtag($username, $hashtag["hashtag"], $hashtag["hashtagCount"]);
    }

}


function insertHashtag($username, $hashtag, $count)
{

    //# işaretini siliyoruz
    $hashtag = str_replace("#", "", $hashtag);
    global $conn;

    // insert

    $sql = "INSERT INTO hashtags (username,hashtag,hashtagCount)
           VALUES ('" . $username . "'
           ,'" . $hashtag . "'
           ,'" . $count . "'
           )";
    // echo "<br><br>\n\n".$sql;


    if ($conn->query($sql) === TRUE) {
        echo "\n\n<br><br>Hashtag added succesfully! : " . $hashtag . " - " . $count . "\n<br>";
    } else {
        echo "\n\n<br><br>Error: " . $sql . "<br>" . $conn->error;
    }

}

/**
 * @param $username
 * @return array|location
 */
function getAllLocations($username)
{
//return değerlerinin tamamı string olarak gelir dikkat et
//    //örnek kullanım
//    getAllLocations($username)

//    return değeri için örnek kullanım
//    $data[0]["username"];
//    $data[0]["locID"];
//    $data[0]["locName"];
//    $data[0]["locAddress"];
//    $data[0]["locCount"];

//    örnek return değeri:
//    array (size=5)
//      'username' => string 'berkaytutal' (length=11)
//      'locID' => string '123546' (length=6)
//      'locName' => string 'berkay' (length=6)
//      'locAddress' => string 'domaniç' (length=8)
//      'locCount' => string '25' (length=2)


    global $conn;

    // select
    $sql = "SELECT * FROM locations WHERE username = \"" . $username . "\"";
    $result = $conn->query($sql);

    $data = [];

    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            array_push($data, $row);
        }
    } else {
        return false;
    }

//    var_dump($data);
    return $data;


}

/**
 * @param $username
 * @param $locations array
 */
function updateAllLocations($username, $locations)
{
    foreach ($locations as $location) {
        deleteLocation($username, $location["locID"]);
    }
    insertAllLocations($username, $locations);
}

/**
 * @param $username
 * @param $locID int
 * @param $locName
 * @param $locAddress
 * @param $locCount int
 */
function updateLocation($username, $locID, $locName, $locAddress, $locCount)
{
    deleteLocation($username, $locID);
    insertLocation($username, $locID, $locName, $locAddress, $locCount);
}

/**
 * @param $username
 * @param $locID int
 */
function deleteLocation($username, $locID)
{

    global $conn;

    // select
    $sql = "DELETE FROM locations WHERE locID = \"" . $locID . "\" AND username=\"" . $username . "\"";
    $result = $conn->query($sql);
    if ($result === TRUE) {
        echo "Record deleted successfully : " . $locID;
    } else {
        echo "Error deleting record: " . $conn->error;
    }


}


/**
 * @param $username
 * @param $locations array
 */
function insertAllLocations($username, $locations)
{


//    //örnek kullanım
//    $location=[];
//    $location["locID"]=15654;
//    $location["locName"]="hakkı";
//    $location["locAddress"]="bulut";
//    $location["locCount"]=5;
//    $locations = [];
//    array_push($locations,$location);
//    array_push($locations,$location);
//    array_push($locations,$location);
//
//    insertAllLocations($username,$locations);


    foreach ($locations as $location) {
        insertLocation($username, $location['locID'], $location['locName'], $location['locAddress'], $location['locCount']);
    }
}


/**
 * @param $username string
 * @param $locID int
 * @param $locName string
 * @param $locAddress string
 * @param $locCount int
 */
function insertLocation($username, $locID, $locName, $locAddress, $locCount)
{

//    //örnek kullanım
//    insertLocation($username,65498,"berkay","domaniç",25);

    global $conn;

    // insert

    $sql = "INSERT INTO locations (username,locID, locName, locAddress, locCount)
           VALUES ('" . $username . "'
           ," . $locID . "
          ,'" . $locName . "'
          ,'" . $locAddress . "'
          ," . $locCount . ")";
    // echo "<br><br>\n\n".$sql;


    if ($conn->query($sql) === TRUE) {
        echo "\n\n<br><br>Location added succesfully! : " . $locID . " - " . $locName . " - " . $locAddress . " - " . $locCount . "\n<br>";
    } else {
        echo "\n\n<br><br>Error: " . $sql . "<br>" . $conn->error;
    }

}


?>