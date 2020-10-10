<?php
require_once __DIR__ . '/includes/database.php';
require_once __DIR__ . '/includes/phpbb.php';
require_once __DIR__ . '/includes/funcs.php';
$pageTitle = 'Закупуване на рекламна позиция';
require_once __DIR__ . '/includes/views/HeaderMain.php';
if ($bb_is_anonymous) {
    echo '<br /><div class="alert alert-danger text-center" role="alert"><i class="fas fa-sign-in-alt"></i> Моля, влезте в акаунта си за да имате пълен достъп до системата!</div>';
} else {
?>
<br />
<div class="card">
<div class="card-header bg-dark text-white">Закупуване на рекламна позиция</div>
<div class="card-body">
   <div class="alert alert-warning" role="alert">
      <p class="text-center">Условия за ползване на услугата</p>
      <hr />
      Когато рекламирате сайта си вие <b>трябва да спазвате</b> следните условия:
      <br/><br/>
      1. Сайтът и/или банера ви не трябва да съдържат в себе си сцени на насилие, расова дискриминация, съдържание за възрастни и друг вид материали, който накърнява по един 
      или друг начин достойнството на даден персонаж.
      <br/>
      2. Линкът към сайта не трябва да води до материали съдръжащи хакове за игри, cracks, keygens и други подобни.
      <br/>
      3. Сайтовете за хазарт също не се тулерират.
      <br/>
      4. Рекламирането на сайтове, нарушаващи условията за авторско прави и/или копиращи дадена част от нашия сайт!
      <br/>
      5. Рекламирането на scam сайтове - сайтове с цел измама.
      <hr />
      При установяване на нарушение, рекламата ще бъде деактивирана незабавно.
      <br/>Екипа на сайта не се задължава да възвърне пари в случай на деактивиране!
      <br/><br />
      При интерес за индивидуален план за реклама, моля свържете се с нас.
   </div>
   <table class="table table-striped table-bordered table-hover text-center">
      <thead class="thead-dark">
         <tr>
            <th scope="col">#</th>
            <th scope="col">Тип</th>
            <th scope="col">Кредити / Време</th>
            <th scope="col">Поръчка</th>
         </tr>
      </thead>
      <tbody>
         <tr>
            <th scope="row">1</th>
            <td>Банер - 468 x 60</td>
            <td><?php echo $sms_468x60; ?> кредита - <strong><?php echo ($expire_ads / 86400); ?></strong> дена</td>
            <td><a href='buyads.php?type=468x60' class="btn btn-primary btn-sm">Поръчай</a></td>
         </tr>
         <tr>
         <tr>
            <th scope="row">2</th>
            <td>Банер - 88 x 31</td>
            <td><?php echo $sms_88x31; ?> кредита - <strong><?php echo ($expire_ads / 86400); ?></strong> дена</td>
            <td><a href='buyads.php?type=88x31' class="btn btn-primary btn-sm">Поръчай</a></td>
         </tr>
         <tr>
      </tbody>
   </table>
   <?php
    if ($_GET['type'] == '468x60') {
        echo "
   <hr />
   <form method='post'>
   <div class='input-group mb-3'>
  <div class='input-group-prepend'>
    <span class='input-group-text'><i class='fas fa-link'></i></span>
  </div>
  <input type='text' name='link' class='form-control' placeholder='URL адрес на сайта' aria-label='URL адрес на сайта' required />
</div>
<div class='input-group mb-3'>
<div class='input-group-prepend'>
  <span class='input-group-text'><i class='fas fa-signature'></i></span>
</div>
<input type='text' name='sitename' class='form-control' placeholder='Името на сайта' aria-label='Името на сайта' required />
</div>
<div class='input-group mb-3'>
<div class='input-group-prepend'>
  <span class='input-group-text'><i class='fas fa-image'></i></span>
</div>
<input type='text' name='banner' class='form-control' placeholder='Линк към банера с размер 468х60' aria-label='Линк към банера с размер 468х60' required />
</div>
      <input type='submit' name='submit_468x60' value='Давай' class='btn btn-outline-success' />
   </form>
   ";
        if (isset($_POST['submit_468x60'])) {
            $banner_468x60 = trim(mysqli_real_escape_string($conn, htmlspecialchars($_POST['banner'])));
            $link_468x60 = trim(mysqli_real_escape_string($conn, htmlspecialchars($_POST['link'])));
            $name_468x60 = trim(mysqli_real_escape_string($conn, htmlspecialchars($_POST['sitename'])));
            if (get_credits($bb_user_id) >= $sms_468x60) {
                $getexpiretime = time() + $expire_ads;
                mysqli_query($conn, "INSERT INTO advertise (type,site_link,banner_img,expire,link_title,dobaven_na) VALUES('468x60','$link_468x60','$banner_468x60','$getexpiretime','$name_468x60','$timehook')");
                mysqli_query($conn, "INSERT INTO paymentsout (userid, type,time, credits) VALUES ('" . $bb_user_id . "','Банер реклама (468x60)', '$timehook', '$sms_468x60')");
                echo "<div class='alert alert-success text-center'>Успешно закупена реклама в сайта!</div>";
                remove_credits($bb_user_id, $sms_468x60);
            } else {
                echo "<div class='alert alert-danger text-center'>Нямаш достатъчно кредити в баланса си, за да поръчаш.</div>";
            }
        }
    } else if($_GET['type'] == '88x31') {
        echo "
   <hr />
   <form method='post'>
   <div class='input-group mb-3'>
  <div class='input-group-prepend'>
    <span class='input-group-text'><i class='fas fa-link'></i></span>
  </div>
  <input type='text' name='link_small' class='form-control' placeholder='URL адрес на сайта' aria-label='URL адрес на сайта' required />
</div>
<div class='input-group mb-3'>
<div class='input-group-prepend'>
  <span class='input-group-text'><i class='fas fa-signature'></i></span>
</div>
<input type='text' name='sitename_small' class='form-control' placeholder='Името на сайта' aria-label='Името на сайта' required />
</div>
<div class='input-group mb-3'>
<div class='input-group-prepend'>
  <span class='input-group-text'><i class='fas fa-image'></i></span>
</div>
<input type='text' name='banner_small' class='form-control' placeholder='Линк към банера с размер 88x31' aria-label='Линк към банера с размер 468х60' required />
</div>
      <input type='submit' name='submit_88x31' value='Давай' class='btn btn-outline-success' />
   </form>
   ";
        if (isset($_POST['submit_88x31'])) {
            $banner_88x31 = trim(mysqli_real_escape_string($conn, htmlspecialchars($_POST['banner_small'])));
            $link_88x31 = trim(mysqli_real_escape_string($conn, htmlspecialchars($_POST['link_small'])));
            $name_88x31 = trim(mysqli_real_escape_string($conn, htmlspecialchars($_POST['sitename_small'])));
            if (get_credits($bb_user_id) >= $sms_88x31) {
                $getexpiretime = time() + $expire_ads;
                mysqli_query($conn, "INSERT INTO advertise (type,site_link,banner_img,expire,link_title,dobaven_na) VALUES('88x31','$link_88x31','$banner_88x31','$getexpiretime','$name_88x31','$timehook')");
                mysqli_query($conn, "INSERT INTO paymentsout (userid, type,time, credits) VALUES ('" . $bb_user_id . "','Банер реклама (88x31)', '$timehook', '$sms_88x31')");
                echo "<div class='alert alert-success text-center'>Успешно закупена реклама в сайта!</div>";
                remove_credits($bb_user_id, $sms_88x31);
            } else {
                echo "<div class='alert alert-danger text-center'>Нямаш достатъчно кредити в баланса си, за да поръчаш.</div>";
            }
        }
    }
    echo '
</div>
';
}
require_once __DIR__ . '/includes/views/FooterMain.php';