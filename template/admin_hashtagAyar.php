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
        foreach ($json as $hashtag) {
            if (strcmp($action, "update") == 0) {
                updateHashtag($username, $hashtag[0], $hashtag[1]);
            } elseif (strcmp($action, "deleteSelected") == 0) {
                if ($hashtag[2]) {
                    deleteHashtag($username, $hashtag[0]);
                }
            } elseif (strcmp($action, "deleteAll") == 0) {
                deleteHashtag($username, $hashtag[0]);
            } elseif (strcmp($action, "insert") == 0) {
                if (!empty($hashtag[1])) {
                    insertHashtag($username, $hashtag[0], $hashtag[1]);

                }
            }
        }
        disconnectDB();
    }

    connectDB();
    $data = getAllHashtags($username);
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
        <h2>Kayıtlı Hashtaglerim</h2>
        <?php
        if (!empty($data)) {
            ?>
            <table id="kayitliHashtagTable" class="table table-striped">
                <thead>
                <tr>
                    <th>Hashtag</th>
                    <th>Sayı</th>
                    <th>Sil</th>
                    <!--                <th>Last Name</th>-->
                    <!--                <th>Username</th>-->
                </tr>
                </thead>
                <tbody>

                <?php
                foreach ($data as $hashtag) {
                    echo ' <tr>
                <td>' . $hashtag["hashtag"] . '</td>
                <td><input type="text" value="' . $hashtag["hashtagCount"] . '"></td>
                <td><input type="checkbox"></td>
  
            </tr>';
                }
                ?>

                </tbody>
            </table>
            <div class="row pull-right">
                <button type="button" class="btn btn-success"
                        onclick="sendDataThisPage(getTableRows('kayitliHashtagTable'),'update');">Hepsini Güncelle
                </button>
                <button type="button" class="btn btn-danger"
                        onclick="sendDataThisPage(getTableRows('kayitliHashtagTable'),'deleteSelected');">Seçilileri
                    Sil
                </button>
                <button type="button" class="btn btn-danger"
                        onclick="sendDataThisPage(getTableRows('kayitliHashtagTable'),'deleteAll');">Hepsini Sil
                </button>
            </div>
            <?php

        } else {
            ?>
            <div class="alert alert-info" role="alert">
                <strong>Bilgi: </strong> Henüz hiç hashtag eklememişsiniz. Lütfen hashtag ekleyiniz.
            </div>
            <?php
        }
        ?>


    </div>
    <div class="col-md-6">
        <h2>Hashtag Ekle</h2>
<!--        <div class="alert alert-info" role="alert">-->
<!--            <strong>Bilgi: </strong> Lütfen hashtag yazarken "#" senbolünü kullanmamaya özen gösteriniz.-->
<!--        </div>-->

        <table id="hashtagEkleTable" class="table table-striped">
            <thead>
            <tr>
                <th>Hashtag</th>
                <th>Sayı</th>
                <!--                <th>Sil</th>-->
                <!--                <th>Last Name</th>-->
                <!--                <th>Username</th>-->
            </tr>
            </thead>
            <tbody>
            <?php


            for ($i = 0; $i < 5; $i++) {
                echo '<tr>
                <td><input type="text" placeholder="Hashtag.."></td>
                <td><input type="text" ></td>
            </tr>
            ';
            }
            ?>

            </tbody>
        </table>
        <div class="row pull-right">
            <button type="button" class="btn btn-info"
                    onclick="sendDataThisPage(getTableRows('hashtagEkleTable'),'insert');">Tümünü Ekle
            </button>
        </div>


    </div>


</div><!-- /.col-lg-6 -->


</div>
