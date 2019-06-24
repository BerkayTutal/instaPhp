<div class="debug">
<?php
/**
 * Created by PhpStorm.
 * User: berka
 * Date: 8.03.2017
 * Time: 20:58
 */



if (isset($_POST) && !empty($_POST)) {
    var_dump($_POST);
    $json = json_decode($_POST['data']);
    $action = $_POST['action'];

    var_dump($json);
    connectDB();
    foreach ($json as $profil) {
        if (strcmp($action, "update") == 0) {
            updateFollowFollowers($username, $profil[0], $profil[1],$profil[2],$profil[3]);
        } elseif (strcmp($action, "deleteSelected") == 0) {
            if ($profil[4]) {
                deleteFollowFollowers($username, $profil[0]);
            }
        } elseif (strcmp($action, "deleteAll") == 0) {
            deleteFollowFollowers($username, $profil[0]);
        } elseif (strcmp($action, "insert") == 0) {
            if (!empty($profil[0])) {
                insertFollowFollowers($username, $profil[0], $profil[1],$profil[2],$profil[3]);

            }
        }
    }
    disconnectDB();
}

connectDB();
$data = getAllFollowFollowers($username);
var_dump($data);
disconnectDB();


?>
</div>
<div class="col-md-10 content">
    <div class="col-md-6">
        <h2>Kayıtlı Profillerim</h2>
        <?php
        if (!empty($data)) {
            ?>
            <table id="kayitliProfilTable" class="table table-striped">
                <thead>
                <tr>
                    <th>Profil</th>
                    <th>Sayı</th>
                    <th>Takipçileri</th>
                    <th>Takip Ettikleri</th>
                    <th>Sil</th>
                    <!--                <th>Last Name</th>-->
                    <!--                <th>Username</th>-->
                </tr>
                </thead>
                <tbody>

                <?php
                foreach ($data as $profil) {
                    if($profil["following"]){
                        $profil["following"] = "checked";
                    }
                    else{
                        $profil["following"] = "";
                    }
                    if($profil["followers"]){
                        $profil["followers"] = "checked";
                    }
                    else{
                        $profil["followers"] = "";
                    }
                    echo ' <tr>
                <td>' . $profil["name"] . '</td>
                <td><input type="text" value="' . $profil["count"] . '"></td>
                <td><input type="checkbox" '. $profil["following"].'></td>
                <td><input type="checkbox" '. $profil["followers"].'></td>
                <td><input type="checkbox"></td>
  
            </tr>';
                }
                ?>

                </tbody>
            </table>
            <div class="row pull-right">
                <button type="button" class="btn btn-success"
                        onclick="sendDataThisPage(getTableRows('kayitliProfilTable'),'update');">Hepsini Güncelle
                </button>
                <button type="button" class="btn btn-danger"
                        onclick="sendDataThisPage(getTableRows('kayitliProfilTable'),'deleteSelected');">Seçilileri
                    Sil
                </button>
                <button type="button" class="btn btn-danger"
                        onclick="sendDataThisPage(getTableRows('kayitliProfilTable'),'deleteAll');">Hepsini Sil
                </button>
            </div>
            <?php

        } else {
            ?>
            <div class="alert alert-info" role="alert">
                <strong>Bilgi: </strong> Henüz hiç profil eklememişsiniz. Lütfen profil ekleyiniz.
            </div>
            <?php
        }
        ?>


    </div>
    <div class="col-md-6">
        <h2>Profil Ekle</h2>
        <!--        <div class="alert alert-info" role="alert">-->
        <!--            <strong>Bilgi: </strong> Lütfen hashtag yazarken "#" senbolünü kullanmamaya özen gösteriniz.-->
        <!--        </div>-->

        <table id="profilEkleTable" class="table table-striped">
            <thead>
            <tr>
                <th>Profil</th>
                <th>Sayı</th>
                <th>Takipçileri</th>
                <th>Takip Ettikleri</th>
                <!--                <th>Sil</th>-->
                <!--                <th>Last Name</th>-->
                <!--                <th>Username</th>-->
            </tr>
            </thead>
            <tbody>
            <?php


            for ($i = 0; $i < 5; $i++) {
                echo '<tr>
                <td><input type="text" placeholder="Kullanıcı Adı.."></td>
                <td><input type="text" ></td>
                <td><input type="checkbox" checked ></td>
                <td><input type="checkbox" ></td>
            </tr>
            ';
            }
            ?>

            </tbody>
        </table>
        <div class="row pull-right">
            <button type="button" class="btn btn-info"
                    onclick="sendDataThisPage(getTableRows('profilEkleTable'),'insert');">Tümünü Ekle
            </button>
        </div>


    </div>
</div>
