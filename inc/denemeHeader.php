<?php
include '../vendor/autoload.php';
require '../vendor/mgp25/instagram-php/src/Instagram.php';
include('functions.php');
set_time_limit(0);

!// TODO: buraya username alma databaseden veya sessiondan ayarlamamız lazım

$username = 'berkaytutal';
$password = 'rahipmoro';
$debug = false;
//////////////////////


/////////// CONFIG ///////////
// include("denemeinstaLogin.php");

$i = setUser($username, $password, $debug);
userLogin($i);

//$timelineItems = getTimelineItems($i, 28);
//$inbox = getInbox($i);
//$recentActivity = getRecentActivity($i);


$loc = locationSearch($i, 41.0252983, 28.8711549, "kale center");
//
var_dump($loc);

$test = $loc["locations"][0]["id"];

//$test = 11532365;

$feed = $i->getLocationFeed($test);
var_dump($feed);


//burası likeeeeee asıl kemik fonksiyon


var_dump( $test);

$feed = getLocationFeedItems($i,$test,50);

var_dump($feed);
//var_dump($feed["latest"]);
//foreach ($feed["ranked"] as $item){
//    var_dump($item->user);
//}
likeFollowCommentFeedItems($i,$feed["latest"],true,true,false,20);






//likeFollowCommentFeedItems($i,null,null,null,5);

//$result = getHashtagFeedItems($i,"eskişehir");
//
//$result;
//try {
//    $result = $i->getHashtagFeed("fitness");
//
//
//} catch (Exception $e) {
//    echo $e->getMessage();
//

//var_dump($timelineItems);







//aslında her türlü toplu like işi için oluyor burası sorun olmaz
//burası timeline like için
//$likedCount = 0;
//$alreadyLikedCount = 0;
//foreach ($timelineItems as $timelineItem) {
//
//
//    try {
//
//        if (!$timelineItem->has_liked) {
//            $i->like($timelineItem->id);
//            echo "Liked! : ".$timelineItem->user->username."\n";
//            $likedCount++;
//            flush();
//            ob_end_flush();
//            if(($likedCount+$alreadyLikedCount)!==count($timelineItems)){
//                sleep(50);
//            }
//
//
//        }
//        else{
//            echo "Already liked : ".$timelineItem->user->username."\n";
//            $alreadyLikedCount++;
//            flush();
//            ob_end_flush();
//        }
//
//    } catch (Exception $e) {
//        echo 'something went wrong ' . $e->getMessage() . "\n";
//    }
//
//}
//echo "Result : Liked ".$likedCount." new items. ".$alreadyLikedCount." items already liked before!";
//

?>
