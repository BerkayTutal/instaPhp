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
        foreach ($json as $data) {
            if (strcmp($action, "update") == 0) {
                updateUserSettings($username, $data[0], $data[1], $data[2]);
            }
        }
        disconnectDB();
    }

    connectDB();
    $data = getUSerSettings($username);
    var_dump($data);
    disconnectDB();


    ?>
</div>
<div class="col-md-10 content">

    <h2>Ayarlar</h2>

    <table id="ayarlarTable" class="table table-striped">
        <thead>
        <tr>
            <th>Takip Et</th>
            <th>Beğen</th>
            <th class="debug">Yorum At</th>

            <!--                <th>Last Name</th>-->
            <!--                <th>Username</th>-->
        </tr>
        </thead>
        <tbody>

        <?php

            if ($data["followset"]) {
                $data["followset"] = "checked";
            } else {
                $data["followset"] = "";
            }
            if ($data["likeset"]) {
                $data["likeset"] = "checked";
            } else {
                $data["likeset"] = "";
            }
            if ($data["commentset"]) {
                $data["commentset"] = "checked";
            } else {
                $data["commentset"] = "";
            }
            echo ' <tr>
                <td><input type="checkbox" ' . $data["followset"] . '></td>
                <td><input type="checkbox" ' . $data["likeset"] . '></td>
                <td class="debug"><input type="checkbox" ' . $data["commentset"] . '></td>

  
            </tr>';

        ?>

        </tbody>
    </table>
    <div class="row pull-right">
        <button type="button" class="btn btn-success"
                onclick="sendDataThisPage(getTableRows('ayarlarTable'),'update');">Ayarları Güncelle
        </button>
        <button class="debug" type="button" class="btn btn-danger"
                onclick="sendDataThisPage(getTableRows('kayitliProfilTable'),'deleteSelected');">Seçilileri
            Sil
        </button>
        <button class="debug" type="button" class="btn btn-danger"
                onclick="sendDataThisPage(getTableRows('kayitliProfilTable'),'deleteAll');">Hepsini Sil
        </button>
    </div>

</div>