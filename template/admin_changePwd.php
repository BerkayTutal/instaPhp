<?php
/**
 * Created by PhpStorm.
 * User: berka
 * Date: 6.03.2017
 * Time: 20:55
 */

$degistirildi;
if (isset($_POST["newPassword"])) {
    connectDB();
    changePassword($username, $_POST["oldPassword"], $_POST["newPassword"]);
    disconnectDB();
    $degistirildi = true;
    $password = $_POST["newPassword"];
    $_SESSION['password'] = $password;


}
?>

<div class="col-md-10 content">
    <h1>Şifre değiştir</h1>
    <div class="panel panel-info">
        <div class="panel-heading">
            Şifre Değiştir
        </div>
        <div class="panel-body">
            Eğer Instagram şifrenizi değiştirdiyseniz buradan da güncellemeniz gerekmektedir. Aksi takdirde sistem
            çalışmayacaktır.
        </div>
    </div>
    <!--<div class="alert alert-danger" role="alert"><strong>DİKKAT! </strong> Şifrenizi değiştirdikten sonra çıkış yapıp
        yeni şifrenizle tekrar giriş yapmanız gerekmektedir!
    </div>-->
    <?php
    if (isset($degistirildi) && !is_null($degistirildi)) {
        if ($degistirildi) {
            echo '<div class="alert alert-success" role="alert"><strong>Bilgi! </strong> Şifreniz başarıyla değiştirildi!
                    </div>';
        }
    }
    ?>


    <div class="row">
        <div class="col-md-2 col-md-offset-5">
            <form name="form-pwdchg" method="post" action="admin.php?page=changePwd"
                  onsubmit="return validatePwdChgForm()">


                <input type="password" name="oldPassword" class="form-control" placeholder="Eski Şifreniz" required=""
                       value="<?php echo $password; ?>">
                <input type="password" name="newPassword" class="form-control" placeholder="Yeni Şifre" required="">
                <input type="password" name="newPasswordAgain" class="form-control" placeholder="Yeni Şifre Tekrar"
                       required="">
                <button class="btn btn-lg btn-primary btn-block" type="submit">
                    Değiştir
                </button>
            </form>
        </div>

    </div>

</div>
