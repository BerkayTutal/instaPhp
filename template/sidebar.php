<?php
/**
 * Created by PhpStorm.
 * User: berka
 * Date: 6.03.2017
 * Time: 20:27
 */
?>

<div class="col-md-2 sidebar">
    <div class="row">
        <!-- uncomment code for absolute positioning tweek see top comment in css -->
        <div class="absolute-wrapper"></div>
        <!-- Menu -->
        <div class="side-menu">
            <nav class="navbar navbar-default" role="navigation">
                <!-- Main Menu -->
                <div class="side-menu-container">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="?"><span class="glyphicon glyphicon-dashboard"></span> Anasayfa</a>
                        </li>

                        <?php
                        connectDB();
                        if (isUserAdmin($username, $password)) {
                            ?>
                            <li><a href="?page=addUser"><span class="glyphicon glyphicon-cog"></span> Kullanıcı
                                    Ekle/Sil/Ayarla</a></li>
                            <?php
                        }


                        ?>

                        <li><a href="?page=topluTakipBegeniAyar"><span class="glyphicon glyphicon-heart"></span> Toplu
                                Takip/Beğeni Ayarı</a></li>

                        <li class="panel panel-default" id="dropdown">
                            <a data-toggle="collapse" href="#dropdown-lvl2">
                                <span class="glyphicon glyphicon-user"></span> Profil Takip Ayarları <span
                                        class="caret"></span>
                            </a>

                            <!-- Dropdown level 1 -->
                            <div id="dropdown-lvl2" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <ul class="nav navbar-nav">
                                        <li><a href="?page=profilTakipAyar"><span
                                                        class="glyphicon glyphicon-cog"></span> Profil
                                                Ekle/Sil/Ayarla</a></li>
                                        <li><a href="?page=profilTakipBaslat"><span
                                                        class="glyphicon glyphicon-play"></span> Profil Takibi
                                                Başlat</a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <li class="panel panel-default" id="dropdown">
                            <a data-toggle="collapse" href="#dropdown-lvl1">
                                <span class="glyphicon glyphicon-map-marker"></span> Lokasyon Ayarları <span
                                        class="caret"></span>
                            </a>

                            <!-- Dropdown level 1 -->
                            <div id="dropdown-lvl1" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <ul class="nav navbar-nav">
                                        <li><a href="?page=lokasyonKayitli"><span
                                                        class="glyphicon glyphicon-floppy-disk"></span> Kayıtlı
                                                Lokasyonlar</a></li>
                                        <li><a href="?page=lokasyonEkle"><span class="glyphicon glyphicon-plus"></span>
                                                Lokasyon Ekle</a></li>
                                        <li><a href="?page=lokasyonBaslat"><span
                                                        class="glyphicon glyphicon-play"></span> Lokasyon
                                                Takibi/Beğenisi Başlat</a></li>

                                    </ul>
                                </div>
                            </div>
                        </li>
                        <!--                        <li><a href="?page=lokasyonEkle"><span class="glyphicon glyphicon-map-marker"></span> Lokasyon-->
                        <!--                                Ayarları</a></li>-->
                        <li class="panel panel-default" id="dropdown">
                            <a data-toggle="collapse" href="#dropdown-lvl3">
                                <span class="glyphicon glyphicon-tag"></span> Hashtag Ayarları <span
                                        class="caret"></span>
                            </a>

                            <!-- Dropdown level 1 -->
                            <div id="dropdown-lvl3" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <ul class="nav navbar-nav">
                                        <li><a href="?page=hashtagAyar"><span class="glyphicon glyphicon-cog"></span>
                                                Hashtag Ekle/Sil/Ayarla</a></li>
                                        <li><a href="?page=hashtagBaslat"><span class="glyphicon glyphicon-play"></span>
                                                Hashtag Takibi/Beğenisi Başlat</a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>


                        <!-- Dropdown-->
                        <li class="panel panel-default" id="dropdown">
                            <a data-toggle="collapse" href="#dropdown-lvl1">
                                <span class="glyphicon glyphicon-user"></span> Sub Level <span class="caret"></span>
                            </a>

                            <!-- Dropdown level 1 -->
                            <div id="dropdown-lvl1" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <ul class="nav navbar-nav">
                                        <li><a href="#">Link</a></li>
                                        <li><a href="#">Link</a></li>
                                        <li><a href="#">Link</a></li>

                                        <!-- Dropdown level 2 -->
                                        <li class="panel panel-default" id="dropdown">
                                            <a data-toggle="collapse" href="#dropdown-lvl2">
                                                <span class="glyphicon glyphicon-off"></span> Sub Level <span
                                                        class="caret"></span>
                                            </a>
                                            <div id="dropdown-lvl2" class="panel-collapse collapse">
                                                <div class="panel-body">
                                                    <ul class="nav navbar-nav">
                                                        <li><a href="#">Link</a></li>
                                                        <li><a href="#">Link</a></li>
                                                        <li><a href="#">Link</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </li>


                    </ul>
                </div><!-- /.navbar-collapse -->
            </nav>

        </div>
    </div>
</div>

