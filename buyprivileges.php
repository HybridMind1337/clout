<?php
   require_once __DIR__ . '/includes/database.php';
   require_once __DIR__ . '/includes/phpbb.php';
   require_once __DIR__. '/includes/funcs.php';
   $pageTitle = 'Закупуване на права във CS сървърите';
   require_once __DIR__ . '/includes/views/HeaderMain.php';
   
   if ($bb_is_anonymous) {
       echo '<br /><div class="alert alert-danger text-center" role="alert"><i class="fas fa-sign-in-alt"></i> Моля, влезте в акаунта си за да имате пълен достъп до системата!</div>';
   } else {
   ?>
<br />
<div class="card">
   <div class="card-header bg-dark text-white">Закупуване на права във Counter-Strike сървърите</div>
   <div class="card-body">
   <form method="post" action="buyprivileges.php">
   <div class="input-group mb-3">
  <div class="input-group-prepend">
    <label class="input-group-text">Избери сървър</label>
  </div>
  <select class="custom-select" name="serverid">
    <option selected>Избери...</option>
    <?php
$servers = mysqli_query($conn,"SELECT * FROM amx_serverinfo");
while ($row = mysqli_fetch_assoc($servers)) {
echo '<option value="'.$row['id'].'">'.$row['hostname'].'</option>';
} 
?>
  </select>
</div>

    <input type="radio" name="choices" value="nick"> Регистрация на име <?php echo "$sms_nickname_price"; ?> кредита - Флаг <?php echo "$accessnick"; ?> за 30 дни<br />
    <input type="radio" name="choices" value="vip"> VIP права <?php echo "$sms_vip_price"; ?> кредита - Флаг <?php echo "$accessvip "; ?> за 30 дни<br />
    <input type="radio" name="choices" value="admin"> Администраторски права + V.I.P <?php echo "$sms_admin_price"; ?> кредита - Флаг <?php echo "$accessadmin"; ?> за 30 дни
 <br />
 <hr />
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
Информация за достъпа
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Информация за достъпа</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      a - Имунитет (неможе да бъде кикнат / баннат и т.н.)<br/>b - Резервирано място (може да използва резервирани места)<br/>c - Командата amx_kick<br/>d - Командите amx_ban и amx_unban <br/>e -  Командите amx_slay и amx_slap <br/>f - Командата amx_map <br/>g - Командата amx_cvar (не всички cvar команди са достъпни)<br/>h - Командата amx_cfg <br/>i - Командата amx_chat и други команди за чатене<br/>j - Командата amx_vote и други Vote команди<br/>k - Достъп до sv_password cvar-a (през amx_cvar командата)<br/>l - Достъп до командата amx_rcon и rcon_password cvar-а (през командата amx_cvar)<br/>m - Допълнителен флаг  A (за други плъгини)<br/>n -Допълнителен флаг B<br/>o - Допълнителен флаг C<br/>p - Допълнителен флаг D<br/>q - Допълнителен флаг E<br/>r - Допълнителен флаг F<br/>s - Допълнителен флаг G<br/>t - Допълнителен флаг H<br/>u - Достъп до админ менютата<br/>z - Потребител (не е администратор)
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Затвори</button>
      </div>
    </div>
  </div>
</div>
<hr />

  <div class="form-group">
    <label>Вашето име в играта</label>
    <input type="text" class="form-control" name="adminName" placeholder="Име, с което искате да сте админ в сървъра">
    <small class="form-text text-muted">Моля, прочетете правилата на сървърите!</small>
  </div>
  <div class="form-group">
    <label>Парола</label>
    <input type="password" class="form-control" name="pass" placeholder="Парола">
  </div>
  <button type="submit" name="buy" class="btn btn-primary">Напред</button>
</form>
<?php
if (isset($_POST['buy'])) {
    echo '<hr />';  
  $server = mysqli_real_escape_string($conn, $_POST["serverid"]);
    $pass = md5($_POST["pass"]);
    $adminName = mysqli_real_escape_string($conn, $_POST["adminName"]);
    if ($adminName == NULL || $pass == NULL) {
        echo "<div class='alert alert-danger text-center'>Моля, попълнете вашето име и парола!</div>";
        return;
    }
    if (isset($_POST['choices']) && !empty($_POST['choices'])) {
        if (mysqli_real_escape_string($conn, $_POST['choices']) == 'vip') {
            if (get_credits($bb_user_id) >= $sms_vip_price) {
                //проверка
                $check = mysqli_query($conn, "SELECT steamid FROM amx_amxadmins WHERE steamid = '$adminName'");
                if (mysqli_num_rows($check) > 0) {
                    echo "<div class='alert alert-danger text-center'>Името <b>$adminName</b> е вече заето</div>";
                }
                //end проверка
                mysqli_query($conn, "INSERT INTO paymentsout (userid, type,time, credits) VALUES ('" . $bb_user_id . "','Закупен V.I.P пакет', '$timehook', '$sms_vip_price')") or die(mysqli_error($conn));
                remove_credits($bb_user_id, $sms_vip_price);
                $vipinsert = mysqli_query($conn, "INSERT INTO `amx_amxadmins` (`id`, `password`, `access` , `flags` ,`steamid` , `ashow` , `created` , `expired` , `days`, `user_id`) VALUES ('', '$pass', '$accessvip', '$nameflags' , '" . $adminName . "' , '$ashowin' , '$timehook' , '$expiredvip' , '$daysvip' , '" . $bb_user_id . "')") or die(mysqli_error($conn));
                $idvip = mysqli_insert_id($conn);
                mysqli_query($conn, "INSERT INTO `amx_admins_servers` (`admin_id`, `server_id`, `custom_flags`, `use_static_bantime`) VALUES ('$idvip', '$server', '', 'no')") or die(mysqli_error($conn));
                echo "<div class='alert alert-success text-center'>След смяната на картата права ще бъдат активирани</div>";
            } else {
                echo "<div class='alert alert-danger text-center'>Нямате достатъчно кредити</div>";
            }
        } elseif (mysqli_real_escape_string($conn, $_POST['choices']) == 'admin') {
            if (get_credits($bb_user_id) >= $sms_admin_price) {
                //проверка
                $check = mysqli_query($conn, "SELECT steamid FROM amx_amxadmins WHERE steamid = '$adminName'");
                if (mysqli_num_rows($check) > 0) {
                    echo "<div class='alert alert-danger text-center'>Името <b>$adminName</b> е вече заето</div>";
                }
                //end проверка
                mysqli_query($conn, "INSERT INTO paymentsout (userid, type,time, credits) VALUES ('" . $bb_user_id . "','Закупен Admin пакет', '$timehook', '$sms_admin_price')") or die(mysqli_error($conn));
                remove_credits($bb_user_id, $sms_admin_price);
                $admininsert = mysqli_query($conn, "INSERT INTO `amx_amxadmins` (`id`, `password`, `access` , `flags` ,`steamid` , `ashow` , `created` , `expired` , `days`, `user_id`) VALUES ('', '$pass', '$accessadmin', '$nameflags' , '" . $adminName . "' , '$ashowin' , '$timehook' , '$expiredadmin' , '$daysadmin' , '" . $bb_user_id . "')") or die(mysqli_error($conn));
                $idadmin = mysqli_insert_id($conn);
                mysqli_query($conn, "INSERT INTO `amx_admins_servers` (`admin_id`, `server_id`, `custom_flags`, `use_static_bantime`) VALUES ('$idadmin', '$server', '', 'no')") or die(mysqli_error($conn));
                echo "<div class='alert alert-success text-center'>След смяната на картата права ще бъдат активирани</div>";
            } else {
                echo "<div class='alert alert-danger text-center'>Нямате достатъчно кредити</div>";
            }
        } elseif (mysqli_real_escape_string($conn, $_POST['choices']) == 'nick') {
            if (get_credits($bb_user_id) >= $sms_nickname_price) {
                //проверка
                $check = mysqli_query($conn, "SELECT steamid FROM amx_amxadmins WHERE steamid = '$adminName'");
                if (mysqli_num_rows($check) > 0) {
                  echo "<div class='alert alert-danger text-center'>Името <b>$adminName</b> е вече заето</div>";
                }
                //end проверка
                mysqli_query($conn, "INSERT INTO paymentsout (userid, type,time, credits) VALUES ('" . $bb_user_id . "','Защита на името', '$timehook', '$sms_nickname_price')") or die(mysqli_error($conn));
                remove_credits($bb_user_id, $sms_nickname_price);
                $admininsert = mysqli_query($conn, "INSERT INTO `amx_amxadmins` (`id`, `password`, `access` , `flags` ,`steamid` , `ashow` , `created` , `expired` , `days`, `user_id`) VALUES ('', '$pass', '$accessnick', '$nameflags' , '" . $adminName . "' , '$ashowin' , '$timehook' , '$expirednick' , '$daysnick' , '" . $bb_user_id . "')") or die(mysqli_error($conn));
                $idadmin = mysqli_insert_id($conn);
                mysqli_query($conn, "INSERT INTO `amx_admins_servers` (`admin_id`, `server_id`, `custom_flags`, `use_static_bantime`) VALUES ('$idadmin', '$server', '', 'no')") or die(mysqli_error($conn));
                echo "<div class='alert alert-success text-center'>След смяната на картата права ще бъдат активирани</div>";
            } else {
                echo "<div class='alert alert-danger text-center'>Нямате достатъчно кредити</div>";
            }
        } //end choose packets
        
    } else {
        echo "<div class='alert alert-danger text-center'>Моля, изберете услуга</div>";
    }
} 

?>
   </div>
</div>

<?php
}
require_once __DIR__ . '/includes/views/FooterMain.php';