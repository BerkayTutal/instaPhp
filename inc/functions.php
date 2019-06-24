<?php
set_time_limit(0);
/**
 * @param \InstagramAPI\Instagram $i
 * @param $lat
 * @param $long
 * @param null $query
 */


function destroySession()
{
    // Oturumu ilklendirelim.
    // session_name("birisim") kullanacaksanız tam sırasıdır!
    session_start();

    // Oturum değişkenlerinin tamamını tanımsız yapalım.
    $_SESSION = array();

    // Oturum öldürülmek istenirse oturum çerezinin de silinmesi gerekir.
    // Dikkat: Bu sadece oturum verisini değil, oturumu da yok edecektir!
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time() - 42000, '/');
    }

    echo "All sessions destroyed!";

    // Son olarak oturumu yok ediyoruz.
    session_destroy();
}


function getRecentActivity(InstagramAPI\Instagram $i)
{
    $i->getRecentActivity();

    try {

        $recentActivity = $i->getRecentActivity();


    } catch (Exception $e) {
        echo 'something went wrong while timelinefeed ' . $e->getMessage() . "\n";
        exit(0);
    }
    return $recentActivity;
}


function getInbox(InstagramAPI\Instagram $i)
{

    try {
        $v2Inbox = $i->getv2Inbox();

    } catch (Exception $e) {
        echo 'something went wrong while v2Inbox ' . $e->getMessage() . "\n";
        exit(0);
    }
    return $v2Inbox;

}


//TODO
function likeFollowCommentFeedItems(InstagramAPI\Instagram $i, $items, $like = null, $follow = null, $comment = null, $maxLimit = null)
{
    set_time_limit(0);
//    ignore_user_abort(true);
//    error_reporting(E_ALL);
//    ini_set("display_errors", 1);
    ob_implicit_flush(true);
//    ob_end_flush();
    if (is_null($maxLimit)) {
        $maxLimit = 800;
    }
    $likedCount = 0;
    $alreadyLikedCount = 0;

    $commentedCount = 0;
    $followedCount = 0;

    $generalCount = 0;

    //comment için array verilmesi lazım
    //like isteniliyorsa like true verilmeli
    //follow isteniliyorsa follow true verilmeli

    if (is_null($like)) {
        $like = false;
    }
    if (is_null($follow)) {
        $follow = false;
    }
    if (is_null($comment)) {
        $comment = false;
    }


    $beklemeSuresi = 50;

    //bekleme süresini toplamda 50'ye sabitledik her işlem için
    if ($like && $comment && $follow) {
        $beklemeSuresi = $beklemeSuresi / 3;
    } elseif (($like && $comment) || ($like && $follow) || ($follow && $comment)) {
        $beklemeSuresi = $beklemeSuresi / 2;
    }


    foreach ($items as $item) {
        set_time_limit(0);
        $isDone = false;
        $tryCount = 5;
        $denemeSayisi = 0;
        while (!$isDone && $denemeSayisi < $tryCount) {
            set_time_limit(0);
            $denemeSayisi++;
//        ob_start();
            $plusOne = false;

            if (strcmp($i->username, $item->user->username) == 0) {
                continue;
            }
            echo "foreach";


            if ($follow) {
                //ob_start();

                try {
                    echo "follow try";
                    //takip  takip etsin diyoruz
                    //kendimizi takip etmiyoruz aynı zamanda
                    if (!$item->user->friendship_status->following) {

                        $i->follow($item->user->pk);
                        echo "Followed! : " . $item->user->username . "\n";
                        $followedCount++;
                        $plusOne = true;
//                    flush();
//                    ob_flush();
//                    //son takip için bekleme devredışı bıraktık
//                    if (($likedCount + $alreadyLikedCount) !== count($items)) {
//                        sleep($beklemeSuresi);

                        sleep($beklemeSuresi);

//                    }

//                        sleep($beklemeSuresi);
                        echo "if dışı follow";


                    } else {
                        echo "Already following : " . $item->user->username . "\n";
//                    flush();
//                    ob_flush();
                    }
                    $isDone = true;

                } catch (Exception $e) {
                    echo 'something went wrong ' . $e->getMessage() . "\n";
                    $isDone = false;
                }


            }

            if ($like) {
                //ob_start();

                try {
                    //beğenilmediyse beğensin diyoruz
                    if (!$item->has_liked) {
                        $i->like($item->id);
                        echo "Liked! : " . $item->user->username . "\n";
                        $likedCount++;
                        $plusOne = true;

//                    flush();
//                    ob_flush();


//                    //son beğeni için bekleme devredışı bıraktık
//                    if (($likedCount + $alreadyLikedCount) !== count($items)) {
//                        sleep($beklemeSuresi);
//                    }
                        sleep($beklemeSuresi);


                    } else {
                        echo "Already liked : " . $item->user->username . "\n";
                        $alreadyLikedCount++;
//                    flush();
//                    ob_flush();
                    }
                    $isDone = true;

                } catch (Exception $e) {
                    echo 'something went wrong ' . $e->getMessage() . "\n";
                    $isDone = false;
                }


            }

            if ($comment) {
                //ob_start();
                $commentText = $comment[array_rand($comment)];

                try {
                    //beğenilmediyse beğensin diyoruz


                    // $i->comment($item->id,$commentText);
                    echo "Commented! : " . $item->user->username . " - " . $commentText . "\n";
                    $commentedCount++;
                    $plusOne = true;
                    $isDone = true;
//                flush();
//                ob_flush();


//                    //son beğeni için bekleme devredışı bıraktık
//                    if (($likedCount + $alreadyLikedCount) !== count($items)) {
//                        sleep($beklemeSuresi);
//                    }
                    sleep($beklemeSuresi);


                } catch (Exception $e) {
                    echo 'something went wrong ' . $e->getMessage() . "\n";
                    $isDone = false;
                }


            }


            //alttaki iki kısım limitleri aşmamak için
            if ($plusOne) {
                $generalCount++;
                echo "count arttir";
                ob_flush();
                flush();
            }

            if ($generalCount >= $maxLimit) {
                echo "Max limit Aşıldı!!!";
                //burada bir sıkıntı olabilir isdone ile ilgili TODO
                $isDone = true;
                break;

            }
            echo "foreach sonu";

//        ob_end_flush();
            ob_flush();
            flush();
            if (!$isDone) {
                echo "Tekrar deneniyor" . $denemeSayisi;
//        $isDone = true;
                sleep(60);
            }
        }


    }

    echo "Result : Liked " . $likedCount . " new items. " . $alreadyLikedCount . " items already liked before!";
    echo "Result : Followed " . $followedCount . " new people. ";
    echo "Result : Commented items :  " . $commentedCount;


}

function followAll()
{

}

function unFollowAll()
{

}

function likeAll()
{

}

function getHashtagFeedItems(InstagramAPI\Instagram $i, $hashtag, $itemCount = null)
{
    if (is_null($itemCount)) {
        $itemCount = 25;
    }
    $items = array();
    $items["latest"] = array();
    $items["ranked"] = array();

    //burası pagination için
    try {
        $helper = null;
        do {
            if (is_null($helper)) {
                $helper = $i->getHashtagFeed($hashtag);
                //bunu da aşağıda yapacaktık ama ilk seferden sonra ranked items gelmiyor o yüzden en üstte burada ilk çalıştırmada yaptık
                foreach ($helper->ranked_items as $latest_item) {
                    array_push($items["ranked"], $latest_item);
                }

            } else {
                $helper = $i->getHashtagFeed($hashtag, $helper->getNextMaxId());
            }
            foreach ($helper->items as $latest_item) {
                array_push($items["latest"], $latest_item);
            }


        } while (!is_null($helper->getNextMaxId()) && count($items["latest"]) < $itemCount);
        //verilen sayı miktarınca içeriği geri döndürmek için
        $items["latest"] = array_slice($items["latest"], 0, $itemCount);

    } catch (Exception $e) {
        echo $e->getMessage();
    }

    return $items;
}


function locationSearch(InstagramAPI\Instagram $i, $lat, $long, $query = null)
{
    $data = [];
    $data["locations"] = [];
    $data["raw"] = [];

    try {
        $loc = $i->searchLocation($lat, $long, $query);
        foreach ($loc->venues as $item) {
            # code...
            array_push($data["locations"], array(
                "id" => $item->external_id,
                "name" => $item->name,
                "address" => $item->address,
                "lat" => $item->lat,
                "lng" => $item->lng,
            ));

//            echo $item->name . "\n<br>";
        }
//        var_dump($loc);
        $data["raw"] = $loc->venues;
    } catch (Exception $e) {
        echo $e->getMessage();

    }
    return $data;


}

function getLocationFeedItems(InstagramAPI\Instagram $i, $locationID, $itemCount = null)
{
    if (is_null($itemCount)) {
        $itemCount = 25;
    }
    $items = array();
    $items["latest"] = array();
    $items["ranked"] = array();

    //burası pagination için
    try {
        $helper = null;
        do {
            if (is_null($helper)) {
                $helper = $i->getLocationFeed($locationID);
                //bunu da aşağıda yapacaktık ama ilk seferden sonra ranked items gelmiyor o yüzden en üstte burada ilk çalıştırmada yaptık
                foreach ($helper->ranked_items as $latest_item) {
                    array_push($items["ranked"], $latest_item);
                }

            } else {
                $helper = $i->getLocationFeed($locationID, $helper->getNextMaxId());
            }
            foreach ($helper->items as $latest_item) {
                array_push($items["latest"], $latest_item);
            }


        } while (!is_null($helper->getNextMaxId()) && count($items["latest"]) < $itemCount);
        //verilen sayı miktarınca içeriği geri döndürmek için
        $items["latest"] = array_slice($items["latest"], 0, $itemCount);

    } catch (Exception $e) {
        echo "Error while getLocationFeedItems : ".$e->getMessage();
    }

    return $items;
}


function getTimelineItems(InstagramAPI\Instagram $i, $itemCount = null)
{
    if (is_null($itemCount)) {
        $itemCount = 8;
    }
    $items = array();

    //burası pagination için
    try {
        $helper = null;
        do {
            if (is_null($helper)) {
                $helper = $i->timelineFeed();
            } else {
                $helper = $i->timelineFeed($helper->getNextMaxId());
            }
            foreach ($helper->feed_items as $feed_item) {
                if (property_exists($feed_item, "media_or_ad")) {

                    array_push($items, $feed_item->media_or_ad);
                }
            }

        } while (!is_null($helper->getNextMaxId()) && count($items) < $itemCount);
        //verilen sayı miktarınca içeriği geri döndürmek için
        $items = array_slice($items, 0, $itemCount);

    } catch (Exception $e) {
        echo $e->getMessage();
    }

    return $items;
}

function setUser($username, $password, $debug = false)
{

    $i = new \InstagramAPI\Instagram($debug);

    $i->setUser($username, $password);

    return $i;

}


function userLogin(InstagramAPI\Instagram $i, $force = false)
{

    try {
        $i->login($force);
    } catch (Exception $e) {
        echo 'something went wrong while userLogin ' . $e->getMessage() . "\n";
        echo $e->getTraceAsString();
        if (!$force) {
            echo "tekrar login deniyorum";
            userLogin($i, true);
        }

        exit(0);

    }

    sleep(5);


    return $i;
}


?>