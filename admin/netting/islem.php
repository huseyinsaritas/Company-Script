<?php
ob_start();
session_start();
include 'baglan.php';



if(isset($_POST['loggin'])) {


    $kullanici_ad=$_POST['kullanici_ad'];
    $kullanici_password=md5($_POST['kullanici_password']);

    if ($kullanici_ad && $kullanici_password) {
        $kullanicisor = $db->prepare("SELECT * FROM kullanici WHERE kullanici_ad=:ad AND kullanici_password=:password");
        $kullanicisor->execute(array(
            'ad' => $kullanici_ad,
            'password' => $kullanici_password
        ));
        $say = $kullanicisor->rowCount();
        if ($say > 0) {
            $_SESSION['kullanici_ad'] = $kullanici_ad;
            $_SESSION['kullanici_password'] = $kullanici_password;
            $_SESSION['oturum'] = true;

            if (isset($_POST['benihatirla'])) {
                //cookie atama
                setcookie("kullanici_ad", $kullanici_ad, strtotime("+1 day"));
                setcookie("kullanici_password", $kullanici_password, strtotime("+1 day"));
            } else {
                //cookie sil
                setcookie("kullanici_ad", $kullanici_ad, strtotime("-1 day"));
                setcookie("kullanici_password", $kullanici_password, strtotime("-1 day"));
            }

            header('Location:../production/index.php');
        } else {
            //giriş bilgileri doğru değilse
            header('Location:../production/login.php?durum=no');
        }
    }
}


if (isset($_POST['kresimduzenle'])){



    $uploads_dir = '../../dimg/kullanici';
    @$tmp_name = $_FILES['kullanici_resim']["tmp_name"];
    @$name = $_FILES['kullanici_resim']["name"];

    $refimgyol=substr($uploads_dir,6)."/".$name;
    @move_uploaded_file($tmp_name,"$uploads_dir/$name");


    $duzenle=$db->prepare("UPDATE kullanici SET
        kullanici_resim=:resim
        WHERE kullanici_id={$_POST['kullanici_id']}");

    $update=$duzenle->execute(array(

        'resim' => $refimgyol
    ));

    if($update){

        Header("Location:../production/kullanici-profil.php?durum=ok");
    }else{

        Header("Location:../production/kullanici-profil.php?durum=no");
    }

}





if (isset($_POST['genelayarkaydet'])){
    $ayarkaydet=$db->prepare("UPDATE ayar SET
    ayar_siteurl=:siteurl,
    ayar_title=:title,
    ayar_description=:description,
    ayar_keywords=:keywords,
    ayar_author=:author
    WHERE ayar_id=0");
    $update=$ayarkaydet->execute(array(
        'siteurl' => $_POST['ayar_siteurl'],
        'title' => $_POST['ayar_title'],
        'description' => $_POST['ayar_description'],
        'keywords' => $_POST['ayar_keywords'],
        'author' => $_POST['ayar_author']
    ));

    if($update){

        Header("Location:../production/genel-ayar.php?durum=ok");
    }else{

        Header("Location:../production/genel-ayar.php?durum=no");
    }
}



if (isset($_POST['iletisimayarkaydet'])){

    $ayarkaydet=$db->prepare("UPDATE ayar SET
    ayar_tel=:tel,
    ayar_gsm=:gsm,
    ayar_faks=:faks,
    ayar_mail=:mail,
    ayar_adres=:adres,
    ayar_ilce=:ilce,
    ayar_il=:il,
    ayar_mesai=:mesai
    WHERE ayar_id=0");

    $update=$ayarkaydet->execute(array(
        'tel' => $_POST['ayar_tel'],
        'gsm' => $_POST['ayar_gsm'],
        'faks' => $_POST['ayar_faks'],
        'mail' => $_POST['ayar_mail'],
        'adres' => $_POST['ayar_adres'],
        'ilce' => $_POST['ayar_ilce'],
        'il' => $_POST['ayar_il'],
        'mesai' => $_POST['ayar_mesai']
    ));

    if($update){

        Header("Location:../production/iletisim-ayar.php?durum=ok");
    }else{

        Header("Location:../production/iletisim-ayar.php?durum=no");
    }
}


if (isset($_POST['apiayarkaydet'])){

    $ayarkaydet=$db->prepare("UPDATE ayar SET
    ayar_recapctha=:recapctha,
    ayar_googlemap=:googlemap,
    ayar_analystic=:analystic
    WHERE ayar_id=0");

    $update=$ayarkaydet->execute(array(
        'recapctha' => $_POST['ayar_recapctha'],
        'googlemap' => $_POST['ayar_googlemap'],
        'analystic' => $_POST['ayar_analystic']
    ));

    if($update){

        Header("Location:../production/api-ayar.php?durum=ok");
    }else{

        Header("Location:../production/api-ayar.php?durum=no");
    }
}

if (isset($_POST['sosyalayarkaydet'])){

    $ayarkaydet=$db->prepare("UPDATE ayar SET
    ayar_facebook=:facebook,
    ayar_twitter=:twitter,
    ayar_linkedln=:linkedln,
    ayar_google=:google
    
    WHERE ayar_id=0");

    $update=$ayarkaydet->execute(array(
        'facebook' => $_POST['ayar_facebook'],
        'twitter' => $_POST['ayar_twitter'],
        'linkedln' => $_POST['ayar_linkedln'],
        'google' => $_POST['ayar_google']
    ));

    if($update){

        Header("Location:../production/sosyal-ayar.php?durum=ok");
    }else{

        Header("Location:../production/sosyal-ayar.php?durum=no");
    }
}

if (isset($_POST['mailayarkaydet'])){

    $ayarkaydet=$db->prepare("UPDATE ayar SET
    ayar_smtphost=:smtphost,
    ayar_smtpuser=:smtpuser,
    ayar_smtppassword=:smtppassword,
    ayar_smtpport=:smtpport
    
    WHERE ayar_id=0");

    $update=$ayarkaydet->execute(array(
        'smtphost' => $_POST['ayar_smtphost'],
        'smtpuser' => $_POST['ayar_smtpuser'],
        'smtppassword' => $_POST['ayar_smtppassword'],
        'smtpport' => $_POST['ayar_smtpport']
    ));

    if($update){

        Header("Location:../production/mail-ayar.php?durum=ok");
    }else{

        Header("Location:../production/mail-ayar.php?durum=no");
    }
}


if (isset($_POST['hakkimizdakaydet'])){

    $hakkimizdakaydet=$db->prepare("UPDATE hakkimizda SET
    hakkimizda_baslik=:baslik,
    hakkimizda_icerik=:icerik,
    hakkimizda_video=:video,
    hakkimizda_vizyon=:vizyon,
    hakkimizda_misyon=:misyon 
    WHERE hakkimizda_id=0");

    $update=$hakkimizdakaydet->execute(array(
        'baslik' => $_POST['hakkimizda_baslik'],
        'icerik' => $_POST['hakkimizda_icerik'],
        'video' => $_POST['hakkimizda_video'],
        'vizyon' => $_POST['hakkimizda_vizyon'],
        'misyon' => $_POST['hakkimizda_misyon']
    ));

    if($update){

        Header("Location:../production/hakkimizda.php?durum=ok");
    }else{

        Header("Location:../production/hakkimizda.php?durum=no");
    }
}

if (isset($_POST['sliderkaydet'])){

    $uploads_dir = '../../dimg/slider';
    @$tmp_name = $_FILES['slider_resimyol']["tmp_name"];
    @$name = $_FILES['slider_resimyol']["name"];
    $benzersizsayi1=rand(20000,32000);
    $benzersizsayi2=rand(20000,32000);
    $benzersizsayi3=rand(20000,32000);
    $benzersizsayi4=rand(20000,32000);
    $benzersizad=$benzersizsayi1.$benzersizsayi2.$benzersizsayi3.$benzersizsayi4;
    $refimgyol=substr($uploads_dir,6)."/".$benzersizad.$name;
    @move_uploaded_file($tmp_name,"$uploads_dir/$benzersizad$name");


    $sliderkaydet=$db->prepare("INSERT INTO slider SET
    slider_ad=:ad,
    slider_link=:link,
    slider_sira=:sira,
    slider_durum=:durum,
    slider_resimyol=:resimyol"
    );

    $insert=$sliderkaydet->execute(array(
        'ad'   => $_POST['slider_ad'],
        'link' => $_POST['slider_link'],
        'sira' => $_POST['slider_sira'],
        'durum'=> $_POST['slider_durum'],
        'resimyol'=> $refimgyol
    ));

    if($insert){

        Header("Location:../production/slider.php?durum=ok");
    }else{

        Header("Location:../production/slider.php?durum=no");
    }
}

if ($_GET['slidersil']=="ok"){
    $sil=$db->prepare("DELETE from slider WHERE slider_id=:slider_id");
    $kontrol=$sil->execute(array(
        'slider_id'=>$_GET['slider_id']
    ));
    if($kontrol){
        Header("Location:../production/slider.php?durum=ok");
    }else{
        Header("Location:../production/slider.php?durum=no");
    }
}

if (isset($_POST['sliderduzenle'])){

    if($_FILES['slider_resimyol']["size"] > 0){

        $uploads_dir = '../../dimg/slider';
        @$tmp_name = $_FILES['slider_resimyol']["tmp_name"];
        @$name = $_FILES['slider_resimyol']["name"];
        $benzersizsayi1=rand(20000,32000);
        $benzersizsayi2=rand(20000,32000);
        $benzersizsayi3=rand(20000,32000);
        $benzersizsayi4=rand(20000,32000);
        $benzersizad=$benzersizsayi1.$benzersizsayi2.$benzersizsayi3.$benzersizsayi4;
        $refimgyol=substr($uploads_dir,6)."/".$benzersizad.$name;
        @move_uploaded_file($tmp_name,"$uploads_dir/$benzersizad$name");


        $duzenle=$db->prepare("UPDATE slider SET
     slider_ad=:ad,
     slider_link=:link,
     slider_sira=:sira,
     slider_durum=:durum,
     slider_resimyol=:resimyol
    WHERE slider_id={$_POST['slider_id']}");

        $update=$duzenle->execute(array(
            'ad' => $_POST['slider_ad'],
            'link' => $_POST['slider_link'],
            'sira' => $_POST['slider_sira'],
            'durum' => $_POST['slider_durum'],
            'resimyol' => $refimgyol
        ));
        $slider_id=$_POST['slider_id'];

        if($update){

        //    $resimsilunlink=$_POST['slider_resimyol'];
        //   unlink("../../$resimsilunlink");

            Header("Location:../production/slider.php?slider_id=$slider_id&durum=ok");
        }else{

            Header("Location:../production/slider.php?durum=no");
        }


    }else{
        $duzenle=$db->prepare("UPDATE slider SET
     slider_ad=:ad,
     slider_link=:link,
     slider_sira=:sira,
     slider_durum=:durum
    WHERE slider_id={$_POST['slider_id']}");

        $update=$duzenle->execute(array(
            'ad' => $_POST['slider_ad'],
            'link' => $_POST['slider_link'],
            'sira' => $_POST['slider_sira'],
            'durum' => $_POST['slider_durum']
        ));
        $slider_id=$_POST['slider_id'];

        if($update){

            Header("Location:../production/slider.php?slider_id=$slider_id&durum=ok");
        }else{

            Header("Location:../production/slider.php?durum=no");
        }
    }

}

if (isset($_POST['icerikkaydet'])){

    $uploads_dir = '../../dimg/icerik';
    @$tmp_name = $_FILES['icerik_resimyol']["tmp_name"];
    @$name = $_FILES['icerik_resimyol']["name"];
    $benzersizsayi1=rand(20000,32000);
    $benzersizsayi2=rand(20000,32000);
    $benzersizsayi3=rand(20000,32000);
    $benzersizsayi4=rand(20000,32000);
    $benzersizad=$benzersizsayi1.$benzersizsayi2.$benzersizsayi3.$benzersizsayi4;
    $refimgyol=substr($uploads_dir,6)."/".$benzersizad.$name;
    @move_uploaded_file($tmp_name,"$uploads_dir/$benzersizad$name");

    $tarih=$_POST['icerik_tarih'];
    $saat=$_POST['icerik_saat'];
    $zaman=$tarih." ".$saat;

    $icerikkaydet=$db->prepare("INSERT INTO icerik SET
    icerik_ad=:ad,
    icerik_detay=:detay,
    icerik_keyword=:keyword,
    icerik_durum=:durum,
    icerik_resimyol=:resimyol,
    icerik_zaman=:zaman
    ");

    $insert=$icerikkaydet->execute(array(
        'ad'   => $_POST['icerik_ad'],
        'detay' => $_POST['icerik_detay'],
        'keyword' => $_POST['icerik_keyword'],
        'durum'=> $_POST['icerik_durum'],
        'resimyol'=> $refimgyol,
        'zaman'=> $zaman
    ));

    if($insert){

        Header("Location:../production/icerik.php?durum=ok");
    }else{

        Header("Location:../production/icerik.php?durum=no");
    }
}


if ($_GET['iceriksil']=="ok"){
    $sil=$db->prepare("DELETE from icerik WHERE icerik_id=:icerik_id");
    $kontrol=$sil->execute(array(
        'icerik_id'=>$_GET['icerik_id']
    ));
    if($kontrol){
        Header("Location:../production/icerik.php?durum=ok");
    }else{
        Header("Location:../production/icerik.php?durum=no");
    }
}

if (isset($_POST['icerikduzenle'])){

    if($_FILES['icerik_resimyol']["size"] > 0){

        $uploads_dir = '../../dimg/icerik';
        @$tmp_name = $_FILES['icerik_resimyol']["tmp_name"];
        @$name = $_FILES['icerik_resimyol']["name"];
        $benzersizsayi1=rand(20000,32000);
        $benzersizsayi2=rand(20000,32000);
        $benzersizsayi3=rand(20000,32000);
        $benzersizsayi4=rand(20000,32000);
        $benzersizad=$benzersizsayi1.$benzersizsayi2.$benzersizsayi3.$benzersizsayi4;
        $refimgyol=substr($uploads_dir,6)."/".$benzersizad.$name;
        @move_uploaded_file($tmp_name,"$uploads_dir/$benzersizad$name");



        $tarih=$_POST['icerik_tarih'];
        $saat=$_POST['icerik_saat'];
        $zaman=$tarih." ".$saat;

        $duzenle=$db->prepare("UPDATE icerik SET
     icerik_ad=:ad,
     icerik_detay=:detay,
     icerik_keyword=:keyword,
     icerik_durum=:durum,
     icerik_resimyol=:resimyol,
     icerik_zaman=:zaman
    WHERE icerik_id={$_POST['icerik_id']}");

        $update=$duzenle->execute(array(
            'ad' => $_POST['icerik_ad'],
            'detay' => $_POST['icerik_detay'],
            'keyword' => $_POST['icerik_keyword'],
            'durum' => $_POST['icerik_durum'],
            'resimyol' => $refimgyol,
            'zaman'=> $zaman
        ));
        $icerik_id=$_POST['icerik_id'];

        if($update){

        //    $resimsilunlink=$_POST['icerik_resimyol'];
        //   unlink("../../$resimsilunlink");

            Header("Location:../production/icerik.php?icerik_id=$slider_id&durum=ok");
        }else{

            Header("Location:../production/icerik.php?durum=no");
        }


    }else{
        $duzenle=$db->prepare("UPDATE icerik SET
     icerik_ad=:ad,
     icerik_detay=:detay,
     icerik_keyword=:keyword,
     icerik_durum=:durum,
     icerik_zaman=:zaman
    WHERE icerik_id={$_POST['icerik_id']}");

        $update=$duzenle->execute(array(
            'ad' => $_POST['icerik_ad'],
            'detay' => $_POST['icerik_detay'],
            'keyword' => $_POST['icerik_keyword'],
            'durum' => $_POST['icerik_durum'],
            'zaman'=> $zaman
        ));
        $icerik_id=$_POST['icerik_id'];

        if($update){

            Header("Location:../production/icerik.php?icerik_id=$slider_id&durum=ok");
        }else{

            Header("Location:../production/icerik.php?durum=no");
        }
    }

}

if (isset($_POST['menukaydet'])){


    $kaydet=$db->prepare("INSERT INTO menu SET
    menu_ust=:ust,
    menu_ad=:ad,
    menu_url=:url,
    menu_detay=:detay,
    menu_sira=:sira,
    menu_durum=:durum
    ");

    $insert=$kaydet->execute(array(
        'ust'   => $_POST['menu_ust'],
        'ad' => $_POST['menu_ad'],
        'url' => $_POST['menu_url'],
        'detay'=> $_POST['menu_detay'],
        'sira'=> $_POST['menu_sira'],
        'durum'=> $_POST['menu_durum']

    ));


    if($insert){

        Header("Location:../production/menu.php?durum=ok");
    }else{

        Header("Location:../production/menu.php?durum=no");

    }
}

if ($_GET['menusil']=="ok"){
    $sil=$db->prepare("DELETE from menu WHERE menu_id=:menu_id");
    $kontrol=$sil->execute(array(
        'menu_id'=>$_GET['menu_id']
    ));
    if($kontrol){
        Header("Location:../production/menu.php?durum=ok");
    }else{
        Header("Location:../production/menu.php?durum=no");
    }
}


if (isset($_POST['menuduzenle'])){

    $duzenle=$db->prepare("UPDATE menu SET
     menu_ad=:ad,
     menu_url=:url,
     menu_detay=:detay,
     menu_sira=:sira,
     menu_durum=:durum
     WHERE menu_id={$_POST['menu_id']}");

        $update=$duzenle->execute(array(
            'ad' => $_POST['menu_ad'],
            'url' => $_POST['menu_url'],
            'detay' => $_POST['menu_detay'],
            'sira' => $_POST['menu_sira'],
            'durum' => $_POST['menu_durum']
        ));
        $menu_id=$_POST['menu_id'];
        
        if($update){

            Header("Location:../production/menu.php?menu_id=$menu_id&durum=ok");
        }else{

            Header("Location:../production/menu.php?durum=no");
        }
    }




if (isset($_POST['altlogoduzenle'])){



        $uploads_dir = '../../dimg';
        @$tmp_name = $_FILES['ayar_altlogo']["tmp_name"];
        @$name = $_FILES['ayar_altlogo']["name"];

        $refimgyol=substr($uploads_dir,6)."/".$name;
        @move_uploaded_file($tmp_name,"$uploads_dir/$name");


        $duzenle=$db->prepare("UPDATE ayar SET
        ayar_altlogo=:logo
        WHERE ayar_id=0");

        $update=$duzenle->execute(array(

            'logo' => $refimgyol
        ));

        if($update){

            Header("Location:../production/genel-ayar.php?durum=ok");
        }else{

            Header("Location:../production/genel-ayar.php?durum=no");
        }

    }

    if (isset($_POST['ustlogoduzenle'])){



        $uploads_dir = '../../dimg';
        @$tmp_name = $_FILES['ayar_ustlogo']["tmp_name"];
        @$name = $_FILES['ayar_ustlogo']["name"];

        $refimgyol=substr($uploads_dir,6)."/".$name;
        @move_uploaded_file($tmp_name,"$uploads_dir/$name");


        $duzenle=$db->prepare("UPDATE ayar SET
        ayar_ustlogo=:logo
        WHERE ayar_id=0");

        $update=$duzenle->execute(array(

            'logo' => $refimgyol
        ));

        if($update){

            Header("Location:../production/genel-ayar.php?durum=ok");
        }else{

            Header("Location:../production/genel-ayar.php?durum=no");
        }

    }



if (isset($_POST['kullaniciprofilkaydet'])){

    $kullanici_password=md5($_POST['kullanici_password']);

    $ayarkaydet=$db->prepare("UPDATE kullanici SET
    kullanici_adsoyad=:adsoyad,
    kullanici_password=:password 
    WHERE kullanici_id=:id");
    $update=$ayarkaydet->execute(array(
        'adsoyad' => $_POST['kullanici_adsoyad'],
        'password' => $kullanici_password,
        'id' => $_POST['kullanici_id']
    ));

    if($update){

        Header("Location:../production/kullanici-profil.php?durum=ok");
    }else{

        Header("Location:../production/kullanici-profil.php?durum=no");
    }
}


?>