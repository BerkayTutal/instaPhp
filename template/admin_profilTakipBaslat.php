<div class="debug">
    <?php
    /**
     * Created by PhpStorm.
     * User: berka
     * Date: 8.03.2017
     * Time: 21:49
     */

    connectDB();
    $data = getAllFollowFollowers($username);
    var_dump($data);
    disconnectDB();

    ?>

</div>

<div class="col-md-10 content">
    <div class="col-md-6">
        <h2>Takip Ediliyor</h2>
        <?php
        if (!empty($data)) {

        } else {
            ?>
            <div class="alert alert-info" role="alert">
                <strong>Bilgi: </strong> Henüz hiç profil eklememişsiniz. Lütfen profil ekleyiniz.
            </div>
            <?php
        }
        ?>

    </div>
</div>
