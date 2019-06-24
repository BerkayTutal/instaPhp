<div class="debug">
    <?php
    /**
     * Created by PhpStorm.
     * User: berka
     * Date: 6.03.2017
     * Time: 21:41
     *
     *
     */
    $dataGeldiMi = false;

    //burada post ile search yapıldıysa onu kullanıcı girişi yaparak search sonuçlarını getiriyor
    //bunları bir listeye yazarak oradan alıp alıp databaseye yazacağız
    if (isset($_POST["lat"]) && !is_null($_POST["lat"])) {

        $lat = $_POST["lat"];
        $lng = $_POST["lng"];
        $query = $_POST["query"];

        if (strcmp($query, "") == 0) {
            $query = null;
        }

        var_dump($_POST);
        $i = setUser($username, $password);
        userLogin($i);
        $data = locationSearch($i, $lat, $lng, $query);


        if (isset($data) && !is_null($data)) {
            $dataGeldiMi = true;
        }
        var_dump($data);

    }


    //burası databaseye kaydetmek için efenim

    if (isset($_POST["action"]) && !is_null($_POST["action"])) {
        if (strcmp($_POST["action"], "insert") == 0) {
            var_dump($_POST);
            $json = json_decode($_POST['data']);
            connectDB();
            foreach ($json as $loc) {
                if (!empty($loc[3])) {
                    insertLocation($username, $loc[0], $loc[1], $loc[2], $loc[3]);

                }
            }
            disconnectDB();
        }
    }


    ?>
</div>

<div class="col-md-10 content">
    <h2>Lokasyon Ekle</h2>


    <div class="col-md-5">

        <div class="alert alert-danger" role="alert">
            <strong>ÖNEMLİ! </strong> Kendi çevrenizde bir adres aramak için konum bilginize onay vermeniz
            gerekmektedir!
        </div>
        <div class="row">
            <div id="map" class="col-md-12" style="height: 450px;"></div>
            <script>
                // Note: This example requires that you consent to location sharing when
                // prompted by your browser. If you see the error "The Geolocation service
                // failed.", it means you probably did not give permission for the browser to
                // locate you.
                var marker;
                var map;
                function initMap() {
                    map = new google.maps.Map(document.getElementById('map'), {
                        center: {lat: -34.397, lng: 150.644},
                        zoom: 12
                    });
                    var infoWindow = new google.maps.InfoWindow({map: map});

                    //burası custom geolocation

                    //google geolocation burada
                    // Try HTML5 geolocation.
//                    if (navigator.geolocation) {
//                        navigator.geolocation.getCurrentPosition(function (position) {
//                            konumAyarla(map, position.coords.latitude, position.coords.longitude);
//
//
////                            infoWindow.setPosition(pos);
////                            infoWindow.setContent('Location found.');
//
//                        }, function () {
//                            handleLocationError(true, infoWindow, map.getCenter());
//                        });
//                    } else {
//
//                        // Browser doesn't support Geolocation
//                        handleLocationError(false, infoWindow, map.getCenter());
//
//
//                    }
                    tryGeolocation();
                    map.addListener("click", function (e) {

                        //lat and lng is available in e object
                        var latLng = e.latLng;
                        console.log(latLng);
                        konumAyarla(map, latLng.lat(), latLng.lng());

                    });
                }
                function konumAyarla(map, lat, lng) {
                    console.log(lat + " " + lng)
                    var pos = {
                        lat: lat,
                        lng: lng
                    };
//                    map.setCenter(pos);
                    map.panTo(pos);

                    if (marker) {
                        marker.setPosition(new google.maps.LatLng(lat, lng));
                    } else {
                        marker = new google.maps.Marker({
                            position: pos,
                            map: map
                        });
                    }

                    document.forms["form-lokasyonSearch"]["lat"].value = lat;
                    document.forms["form-lokasyonSearch"]["lng"].value = lng;

                }


                //lokasyon çekme durumları burada

                var apiGeolocationSuccess = function (position) {
//                    alert("API geolocation success!\n\nlat = " + position.coords.latitude + "\nlng = " + position.coords.longitude);
                    konumAyarla(map, position.coords.latitude, position.coords.longitude);
                };

                var tryAPIGeolocation = function () {
                    jQuery.post("https://www.googleapis.com/geolocation/v1/geolocate?key=AIzaSyDCa1LUe1vOczX1hO_iGYgyo8p_jYuGOPU", function (success) {
                        apiGeolocationSuccess({
                            coords: {
                                latitude: success.location.lat,
                                longitude: success.location.lng
                            }
                        });
                    })
                        .fail(function (err) {
                            //alert("API Geolocation error! \n\n" + err);
                        });
                };

                var browserGeolocationSuccess = function (position) {
                    //alert("Browser geolocation success!\n\nlat = " + position.coords.latitude + "\nlng = " + position.coords.longitude);
                    konumAyarla()
                };

                var browserGeolocationFail = function (error) {
                    switch (error.code) {
                        case error.TIMEOUT:
                            //alert("Browser geolocation error !\n\nTimeout.");
                            break;
                        case error.PERMISSION_DENIED:
                            if (error.message.indexOf("Only secure origins are allowed") == 0) {
                                tryAPIGeolocation();
                            }
                            break;
                        case error.POSITION_UNAVAILABLE:
                            //alert("Browser geolocation error !\n\nPosition unavailable.");
                            break;
                    }
                };

                var tryGeolocation = function () {
                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(
                            browserGeolocationSuccess,
                            browserGeolocationFail,
                            {maximumAge: 50000, timeout: 20000, enableHighAccuracy: true});
                    }
                };


                function handleLocationError(browserHasGeolocation, infoWindow, pos) {
                    infoWindow.setPosition(pos);
                    infoWindow.setContent(browserHasGeolocation ?
                        'Error: The Geolocation service failed.' :
                        'Error: Your browser doesn\'t support geolocation.');
                }
            </script>
            <script async defer
                    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC2PfiR74NfKNBJ8ZaQbglihjvKLKR34_0&callback=initMap">
            </script>
        </div>
        <form name="form-lokasyonSearch" method="post" action="admin.php?page=lokasyonEkle">


            <input type="text" name="lat" class="form-control" placeholder="Latitude" required="">
            <input type="text" name="lng" class="form-control" placeholder="Longtitude" required="">
            <input type="text" name="query" class="form-control" placeholder="Arama Kelimesi"
            >
            <button onclick="toggleLoading()" class="btn btn-lg btn-primary btn-block" type="submit">
                Lokasyon Ara
            </button>
        </form>
        </span>
    </div><!-- /input-group -->

    <div class="col-md-5">
        <?php
        if ($dataGeldiMi) {

            ?>
            <table id="lokasyonResult" class="table table-striped">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>İsim</th>
                    <th>Adres</th>
                    <th>Sayı</th>
                    <!--                <th>Last Name</th>-->
                    <!--                <th>Username</th>-->
                </tr>
                </thead>
                <tbody>

                <?php
                foreach ($data["locations"] as $loc) {
                    echo ' <tr>
                <td>' . $loc["id"] . '</td>
                <td>' . $loc["name"] . '</td>
                 <td>' . $loc["address"] . '</td>
                <td><input type="text" ></td>
  
            </tr>';
                }
                ?>

                </tbody>
            </table>
            <div class="row pull-right">
                <button type="button" class="btn btn-success"
                        onclick="sendDataThisPage(getTableRows('lokasyonResult'),'insert');">Seçilileri Ekle
                </button>
            </div>
            <?php

        }
        ?>


    </div>


</div><!-- /.col-lg-6 -->


</div>
