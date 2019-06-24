<?php

// /////////////// INFO //////////////////
// Bu sayfada sadece login yapılıyor.
// $username / $password önceden veriilmesi lazım
// return olarak $timeline $v2Inbox $recentActivity döndürür
// return silinebilir sonradan bunu bir düşün
// ///////////////////////////////////////


// /////// CONFIG ///////
// $username = 'berkaytutal';
// $password = 'rahipmoro';
// $debug = false;
// //////////////////////


$i = new \InstagramAPI\Instagram($debug);

$i->setUser($username, $password);

try {
    $i->login();
    $timeline = $i->timelineFeed();
    $v2Inbox = $i->getv2Inbox();
    $recentActivity = $i->getRecentActivity();

} catch (Exception $e) {
    echo 'something went wrong while login/timelinefeed/getinbox/getRecentActivity ' . $e->getMessage() . "\n";
    exit(0);
}


?>
