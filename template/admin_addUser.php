<div class="debug">
    <?php
    /**
     * Created by PhpStorm.
     * User: berka
     * Date: 6.03.2017
     * Time: 21:41
     */


    if (isset($_POST) && !empty($_POST)) {
        var_dump($_POST);
        $json = json_decode($_POST['data']);
        $action = $_POST['action'];

        var_dump($json);
        connectDB();
        foreach ($json as $user) {
            if (strcmp($action, "update") == 0) {
                changeUserExpiration($user[0], $user[1]);
            } elseif (strcmp($action, "deleteSelected") == 0) {
                if ($user[2]) {
                    deleteUser($user[0]);
                }
            } elseif (strcmp($action, "deleteAll") == 0) {
                deleteHashtag($username, $user[0]);
            } elseif (strcmp($action, "insert") == 0) {
                if (!empty($user[1])) {
                    addUser($user[0], $user[1],$user[2]);

                }
            }
        }
        disconnectDB();
    }

    connectDB();
    if(!isUserAdmin($username,$password)){
        echo "Bu sayfayı görmeye yetkiniz yoktur!";
        exit(0);
    }
    $data = getAllUsers();
    var_dump($data);
    disconnectDB();
    ?>
</div>
<div class="col-md-10 content">


    <!---->
    <!--    <div class="col-md-5">-->
    <!---->
    <!--    </div> -->

    <div class="col-md-6">
        <h2>Kayıtlı Kullanıcılar</h2>
        <?php

        if (!empty($data)) {
            ?>
            <table id="kayitliKullaniciTable" class="table table-striped">
                <thead>
                <tr>
                    <th>Username</th>
<!--                    <th>Password</th>-->
                    <th>Expiration</th>
                    <!--                <th>Last Name</th>-->
                    <!--                <th>Username</th>-->
                    <th>Delete</th>

                </tr>
                </thead>
                <tbody>

                <?php
                foreach ($data as $user) {
                    echo ' <tr>
                <td>' . $user["username"] . '</td>
                <td><input type="text" value="' . $user["expiration"] . '"></td>
                <td><input type="checkbox"></td>
  
            </tr>';
                }
                ?>

                </tbody>
            </table>
            <div class="row pull-right">
                <button type="button" class="btn btn-success"
                        onclick="sendDataThisPage(getTableRows('kayitliKullaniciTable'),'update');">Hepsini Güncelle
                </button>
                <button type="button" class="btn btn-danger"
                        onclick="sendDataThisPage(getTableRows('kayitliKullaniciTable'),'deleteSelected');">Seçilileri
                    Sil
                </button>
<!--                <button type="button" class="btn btn-danger"-->
                <!--                        onclick="sendDataThisPage(getTableRows('kayitliKullaniciTable'),'deleteAll');">Hepsini Sil-->
                <!--                </button>-->
            </div>
            <?php

        } else {
            ?>
            <div class="alert alert-info" role="alert">
                <strong>Bilgi: </strong> Henüz hiç kullanıcı eklememişsiniz. Lütfen kullanıcı ekleyiniz.
            </div>
            <?php
        }
        ?>


    </div>
    <div class="col-md-6">
        <h2>Kullanıcı Ekle</h2>
<!--        <div class="alert alert-info" role="alert">-->
<!--            <strong>Bilgi: </strong> Lütfen hashtag yazarken "#" senbolünü kullanmamaya özen gösteriniz.-->
<!--        </div>-->

        <table id="kullaniciEkleTable" class="table table-striped">
            <thead>
            <tr>
                <th>Username</th>
                <th>Password</th>
                <th>Expiration</th>
                <!--                <th>Sil</th>-->
                <!--                <th>Last Name</th>-->
                <!--                <th>Username</th>-->
            </tr>
            </thead>
            <tbody>
            <?php


            for ($i = 0; $i < 5; $i++) {
                echo '<tr>
                <td><input type="text" placeholder="Username.."></td>
                <td><input type="text" ></td>
                <td><input type="text" ></td>
            </tr>
            ';
            }
            ?>

            </tbody>
        </table>
        <div class="row pull-right">
            <button type="button" class="btn btn-info"
                    onclick="sendDataThisPage(getTableRows('kullaniciEkleTable'),'insert');">Tümünü Ekle
            </button>
        </div>


    </div>


</div><!-- /.col-lg-6 -->


</div>
