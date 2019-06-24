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
        foreach ($json as $loc) {
            if (strcmp($action, "update") == 0) {
                updateLocation($username, $loc[0], $loc[1], $loc[2], $loc[3]);
            } elseif (strcmp($action, "deleteSelected") == 0) {
                if ($loc[4]) {
                    deleteLocation($username, $loc[0]);
                }
            } elseif (strcmp($action, "deleteAll") == 0) {
                deleteLocation($username, $loc[0]);
            }
        }
        disconnectDB();
    }

    connectDB();
    $data = getAllLocations($username);
    disconnectDB();
    ?>
</div>
<div class="col-md-10 content">
    <h2>Kayıtlı Lokasyonlarım</h2>

    <!---->
    <!--    <div class="col-md-5">-->
    <!---->
    <!--    </div> -->

    <div class="col-md-12">
        <?php
        if (!empty($data)) {
            ?>
            <table id="kayitliLokasyonTable" class="table table-striped">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>İsim</th>
                    <th >Adres</th>
                    <th>Sayı</th>
                    <th>Sil</th>
                    <!--                <th>Last Name</th>-->
                    <!--                <th>Username</th>-->
                </tr>
                </thead>
                <tbody>

                <?php
                foreach ($data as $loc) {
                    echo ' <tr>
                <td>' . $loc["locID"] . '</td>
                <td>' . $loc["locName"] . '</td>
                <td >' . $loc["locAddress"] . '</td>
                <td><input type="text" value="' . $loc["locCount"] . '"></td>
                <td><input type="checkbox"></td>
  
            </tr>';
                }
                ?>

                </tbody>
            </table>
            <div class="row pull-right">
                <button type="button" class="btn btn-success"
                        onclick="sendDataThisPage(getTableRows('kayitliLokasyonTable'),'update');">Hepsini Güncelle
                </button>
                <button type="button" class="btn btn-danger"
                        onclick="sendDataThisPage(getTableRows('kayitliLokasyonTable'),'deleteSelected');">Seçilileri
                    Sil
                </button>
                <button type="button" class="btn btn-danger"
                        onclick="sendDataThisPage(getTableRows('kayitliLokasyonTable'),'deleteAll');">Hepsini Sil
                </button>
            </div>
            <?php

        }
        else{
            ?>
            <div class="alert alert-info" role="alert">
                <strong>Bilgi: </strong> Henüz hiç lokasyon eklememişsiniz. Lütfen <strong>Lokasyon Ekle</strong> sayfasından lokasyon ekleyiniz.
            </div>
        <?php
        }
        ?>


    </div>


</div><!-- /.col-lg-6 -->


</div>
