<div class="debug">
    <?php


    /*

    AŞAĞISI ÇOK ÖNELİ HATA VERMEMEİ İÇİN

    */


    // Turn off output buffering
    ini_set('output_buffering', 'off');
    // Turn off PHP output compression
    ini_set('zlib.output_compression', false);

    //Flush (send) the output buffer and turn off output buffering
    //ob_end_flush();
    while (@ob_end_flush()) ;

    // Implicitly flush the buffer(s)
    ini_set('implicit_flush', true);
    ob_implicit_flush(true);

    //prevent apache from buffering it for deflate/gzip
    header("Content-type: text/plain");
    header('Cache-Control: no-cache'); // recommended to prevent caching of event data.
    for ($i = 0; $i < 1000; $i++) {
        echo ' ';
    }
    ob_flush();
    flush();

    /*

    YUKARISI ÇOK ÖNELİ HATA VERMEMEİ İÇİN

    */


    //    ignore_user_abort(true);
    set_time_limit(0);
    /**
     * Created by PhpStorm.
     * User: berka
     * Date: 8.03.2017
     * Time: 21:49
     */
    session_write_close();
    connectDB();
    //    $data = getAllHashtags($username);
    //    var_dump($data);
    $usersettings = getUSerSettings($username);
    $locations = getAllLocations($username);
    disconnectDB();

    echo "<pre>" . var_dump($usersettings) . "</pre>";
    echo "<pre>" . var_dump($locations) . "</pre>";
    $followSetting = $usersettings["followset"];
    $likeSetting = $usersettings["likeset"];
    $commentSetting = $usersettings["commentset"];
    $i = setUser($username, $password, $debug);
    $forceLogin = true;
    $i = userLogin($i, $forceLogin);


    for ($j = 0; $j < 1000; $j++) {
        echo ' ';
    }
    ob_flush();
    flush();


    ?>

</div>

<div class="col-md-10 content">
    <div class="col-md-6">
        <h2>Takip Ediliyor</h2>
        <?php

        //burada lokasyon içindeki dataları birleştiriyoruz
        $allLocs = array();
        $loci = 0;
        if (!empty($locations)) {

            foreach ($locations as $location) {
                echo "locationa girdik " . $location["locName"];
                $deneyelimMi = true;
                $denemeCount = 0;
                while ($deneyelimMi) {

                    $feed = getLocationFeedItems($i, $location["locID"], $location["locCount"]);
                    if (!is_null($feed)) {
                        $deneyelimMi = false;

                    }
                    if ($denemeCount++ > 3) {
                        $deneyelimMi = false;
                    }


                }
                if (is_null($feed)) {
                    echo "burada null geliyor feed";
                    continue;

                }
                if ($pageDebug) {
                    echo "feed geldi";
                    echo "<pre>" . var_dump($feed["latest"]) . "</pre>";
                }
                echo "feed itemleri sayısı : ".count($feed["latest"]);

                $allLocs[$loci++] = $feed;

//                likeFollowCommentFeedItems($i, $feed["latest"], $likeSetting, $followSetting, $commentSetting, $location["locCount"]);
            }


        } else {
            ?>
            <div class="alert alert-info" role="alert">
                <strong>Bilgi: </strong> Henüz hiç lokasyon eklememişsiniz. Lütfen lokasyon ekleyiniz.
            </div>
            <?php
        }

        //burada tüm birleşmiş dataların toplu şekilde işlenmesi takibi vs yapılıyor
        echo "vardumpalllocs";
        if ($pageDebug) {
            echo "<pre>" . var_dump($allLocs) . "</pre>";

            echo count($allLocs);
        }
        echo count($allLocs);
        foreach ($allLocs as $allLoc) {
            set_time_limit(0);


            likeFollowCommentFeedItems($i, $allLoc["latest"], $likeSetting, $followSetting, $commentSetting, $location["locCount"]);


        }
        //        likeFollowCommentFeedItems($i, $feed["latest"], $likeSetting, $followSetting, $commentSetting, $location["locCount"]);
        ?>

    </div>
</div>
