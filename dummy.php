<?php
echo date("D M d, Y G:i a");
include 'vendor/autoload.php';
require 'vendor/mgp25/instagram-php/src/Instagram.php';

/////// CONFIG ///////
$username = 'berkaytutal';
$password = 'rahipmoro';
$debug = true;

include('inc/functions.php');
include('inc/connect.php');
//connectDB();
////extendUserExpiration("berky","500");
//addUser("145","145","145");
//
//disconnectDB();
//////////////////////

// THIS IS AN EXAMPLE OF HOW TO USE NEXT_MAX_ID TO PAGINATE
// IN THIS EXAMPLE, WE ARE RETRIEVING SELF FOLLOWERS
// BUT THE PROCESS IS SIMILAR IN OTHER REQUESTS

// $feed;
// $helper = $i->timelineFeed();
// // var_dump($helper);
// $feed = $helper->getFeedItems();
// echo "\n<br>".$helper->getNextMaxId();
//  $helper = $i->timelineFeed($helper->getNextMaxId());
//  // var_dump($helper);
//  array_merge($feed,$helper->getFeedItems());
//  echo "\n<br>".$helper->getNextMaxId();
//  $helper = $i->timelineFeed($helper->getNextMaxId());
//  array_merge($feed,$helper->getFeedItems());
//  echo "\n<br>".$helper->getNextMaxId();
//
//  var_dump($feed);

// var_dump($helper[0]);
// $users;
// foreach ($helper as $media) {
//   # code...
//   array_push($users,$media->getUser());
// }
// // $helper = $helper->getUser();
// var_dump($users);







//ignore_user_abort(true);
//echo ignore_user_abort();
//phpinfo();
//
//
//$i = new \InstagramAPI\Instagram($debug);
//
//$i->setUser($username, $password);
//
//try {
//  $i->login();
//  $timeline = $i->timelineFeed();
//  $i->getv2Inbox();
//  $i->getRecentActivity();
//
//} catch (Exception $e) {
//  echo 'something went wrong '.$e->getMessage()."\n";
//  exit(0);
//}
//var_dump($timeline);










//
// // location search query ile
//
// try {
//
//   $loc = $i->searchFBLocation(utf8_encode("osmangazi üniversitesi"));
//   // foreach ($loc->venues as $item ) {
//   //   # code...
//   //   echo $item->name."\n<br>";
//   // }
//   var_dump($loc);
// } catch (Exception $e) {
//   echo $e->getMessage();
//
// }


//
//
// //en iyi location sonucu buradan geliyor
// // location search haritadan
// //searchLocation fonksiyonu içinde !isnull değişecek ! kalkacak
//
// try {
//   $loc = $i->searchLocation(41.0266605,28.8886616,"osmangazi üniversitesi");
//   foreach ($loc->venues as $item ) {
//     # code...
//     echo $item->name."\n<br>";
//   }
//   var_dump($loc);
// } catch (Exception $e) {
//   echo $e->getMessage();
//
// }






//location id ile data getirme
// var_dump($i->getLocationFeed("119861174756830"));








//
// //mesaj yollama
// $response = $i->direct_message($i->getUsernameId("tari.ancalime"),"seni yerim ne tatlı şeysin sen :*");
// var_dump($response);
//




//
//
// //like ve unlike
// //comment atma
//
// $maxCount = 10;
// $c = 0;
// //kullanıcı itemlerini alma
// $userFeed = $i->getUserFeed($i->getUsernameId("tari.ancalime"))->getItems();
// var_dump($userFeed);
// // var_dump($userFeed);
//
//   foreach ($userFeed as $item) {
//
//     if($c < $maxCount){
//       break;
//     }
//     try {
//       //like atma
//
//       if(!$item->has_liked){
//         $i->like($item->id);
//         echo "Liked! : ".$item->id;
//
//       }
//       else{
//         $i->unlike($item->id);
//         echo "UNLiked! : ".$item->id;
//       }
//
//
//
//
//     } catch (Exception $e) {
//       echo 'something went wrong '.$e->getMessage()."\n";
//     }
//
//     //comment atma
//
//     try {
//       $i->comment($item->id,"php");
//
//
//     } catch (Exception $e) {
//       echo 'something went wrong '.$e->getMessage()."\n";
//     }
//
//
//
//
//     //burada time limit koymazsan sıçarsın
//     set_time_limit(60);
//     sleep(50);
//   }









//like atma

// $i = new \InstagramAPI\Instagram($debug);
//
// $i->setUser($username, $password);
//
// try {
//     $i->login();
// } catch (Exception $e) {
//     echo 'something went wrong '.$e->getMessage()."\n";
//     exit(0);
// }
//
// $timeline;
// try {
//      $timeline = $i->timelineFeed();
//      $i->getv2Inbox();
//      $i->getRecentActivity();
//
// } catch (Exception $e) {
//   echo $e->getMessage();
// }
//
// $items = $timeline->getFeedItems();
// $items = $items[0];
// $i->like($items->media_or_ad->id);
// var_dump($items->media_or_ad->id);










//anasayfa çekme ve pagination
//
// $maxItems = 100;
//
// try {
//     $helper = null;
//     $items = [];
//
//     do {
//         if (is_null($helper)) {
//             $helper = $i->timelineFeed();
//         } else {
//             $helper = $i->timelineFeed($helper->getNextMaxId());
//         }
//
//         $items = array_merge($items, $helper->getFeedItems());
//         // echo $sayac."\n";
//         // var_dump($followers);
//     } while (!is_null($helper->getNextMaxId())&&count($items)<$maxItems);
//
//     echo "Timeline Items: \n";
//     var_dump($items);
//     // foreach ($followers as $follower) {
//     //     echo '- '.$follower."\n";
//     //     // echo '- '.$follower->getUsername()."\n";
//     // }
// } catch (Exception $e) {
//     echo $e->getMessage();
// }

//<html>
//<script type="application/javascript">
//
//    var apiGeolocationSuccess = function(position) {
//        alert("API geolocation success!\n\nlat = " + position.coords.latitude + "\nlng = " + position.coords.longitude);
//    };
//
//    var tryAPIGeolocation = function() {
//        jQuery.post( "https://www.googleapis.com/geolocation/v1/geolocate?key=AIzaSyDCa1LUe1vOczX1hO_iGYgyo8p_jYuGOPU", function(success) {
//            apiGeolocationSuccess({coords: {latitude: success.location.lat, longitude: success.location.lng}});
//        })
//            .fail(function(err) {
//                alert("API Geolocation error! \n\n"+err);
//            });
//    };
//
//    var browserGeolocationSuccess = function(position) {
//        alert("Browser geolocation success!\n\nlat = " + position.coords.latitude + "\nlng = " + position.coords.longitude);
//    };
//
//    var browserGeolocationFail = function(error) {
//        switch (error.code) {
//            case error.TIMEOUT:
//                alert("Browser geolocation error !\n\nTimeout.");
//                break;
//            case error.PERMISSION_DENIED:
//                if(error.message.indexOf("Only secure origins are allowed") == 0) {
//                    tryAPIGeolocation();
//                }
//                break;
//            case error.POSITION_UNAVAILABLE:
//                alert("Browser geolocation error !\n\nPosition unavailable.");
//                break;
//        }
//    };
//
//    var tryGeolocation = function() {
//        if (navigator.geolocation) {
//            navigator.geolocation.getCurrentPosition(
//                browserGeolocationSuccess,
//                browserGeolocationFail,
//                {maximumAge: 50000, timeout: 20000, enableHighAccuracy: true});
//        }
//    };
//
//    tryGeolocation();
//</script>
//</html>




$i = new \InstagramAPI\Instagram($debug);

$i->setUser($username, $password);

try {
  $i->login();
//  $following = $i->getSelfUsersFollowing();


} catch (Exception $e) {
  echo 'something went wrong '.$e->getMessage()."\n";
  exit(0);
}

//echo "<pre>";
//var_dump($following);
//echo "</pre>";









//
////takip ettiklerimi çekme ve pagination
////
// $maxItems = 10000;
//
// try {
//     $helper = null;
//     $users = [];
//
//     do {
//         if (is_null($helper)) {
//             $helper = $i->getSelfUsersFollowing();
//         } else {
//             $helper = $i->getSelfUsersFollowing($helper->getNextMaxId());
//         }
//
//         $users = array_merge($users, $helper->users);
//         // echo $sayac."\n";
//         // var_dump($followers);
//     } while (!is_null($helper->getNextMaxId())&&count($items)<$maxItems);
//
//     echo "users list: \n";
//     echo "<pre>";
//     var_dump($users);
//     echo "</pre>";
//     // foreach ($followers as $follower) {
//     //     echo '- '.$follower."\n";
//     //     // echo '- '.$follower->getUsername()."\n";
//     // }
// } catch (Exception $e) {
//     echo $e->getMessage();
// }
//

echo "<pre>";
$uid = $i->getUsernameId("ilaydatutal");
//print_r($i->getUsernameInfo($uid));
print_r($i->userFriendship($uid));
echo "</pre>";
?>