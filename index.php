<?php
require_once __DIR__ . '/includes/database.php';
require_once __DIR__ . '/includes/phpbb.php';
require_once __DIR__. '/includes/funcs.php';
$pageTitle = 'Начална страница';
require_once __DIR__ . '/includes/views/HeaderMain.php';

if ($bb_is_anonymous) {
    echo '<br /><div class="alert alert-danger text-center" role="alert"><i class="fas fa-sign-in-alt"></i> Моля, влезте в акаунта си за да имате пълен достъп до системата!</div>';
} else {

    $checkban = mysqli_query($conn, "SELECT * FROM amx_bans WHERE player_ip='$ip_u' AND (ban_length*60+ban_created>UNIX_TIMESTAMP() OR ban_length=0)");
    if (mysqli_num_rows($checkban) > 0) {
        echo "<br /><div class='alert alert-danger text-center'><i class='fas fa-user-slash'></i> Вашето IP — $ip_u е баннато от сървърите ни!</div>
<div class='card text-center'>
<div class='card-header bg-info text-white'>Премахване на бана, чрез SMS</div>
<div class='card-body'>
<div class='alert alert-primary' role='alert'>$info2</div>

<form method='post'>
<div class='input-group mb-3'>
<input type='text' name='sms_code_b' placeholder='SMS Код' class='form-control' />
<div class='input-group-append'>
<input type='submit' name='submit_unban' class='btn btn-outline-success' value='Премахни бан' />
</div>
</div>
</form>";
        if (isset($_POST['submit_unban'])) {
            $code = mysqli_real_escape_string($conn, $_POST['sms_code_b']);
            if (mobio_checkcode($servID2, $code, 0) == 1) { 
                $unban_query = mysqli_query($conn, "DELETE FROM amx_bans WHERE player_ip='$ip_u' LIMIT 100");
                echo '<br /><div class="alert alert-success text-center"><i class="fas fa-check"></i> Вашия бан е успешно премахнат, приятна игра в нашите сървъри!</div>';
                header("Refresh:3");
            } else {
                echo '<br /><div class="alert alert-danger text-center"><i class="fas fa-exclamation-triangle"></i> Грешен SMS код!</div>';
            }
        }
        echo '</div></div><br />';
    } else {
        echo "<br /><div class='alert alert-success text-center'><i class='fas fa-check'></i> Вашето IP — $ip_u. Не е баннато от сървърите ни.</div><hr />";
    }
?>
         <div class="card">
            <div class="card-header bg-dark text-white">Предлагани услуги</div>
            <div class="card-body">
            <div class="alert alert-info text-center" role="alert">
                За да се идентифицирате като админ в нашите сървъри, след като закупите права, в конзолата трябва да напишете:<br />
                setinfo _pw вашата-парола или setinfo _pw-home вашата-парола
            </div>
            <a class="btn btn-primary btn-block" href="buyprivileges.php" role="button">Закупи права във Counter-Strike сървърите</a>
            <a class="btn btn-primary btn-block" href="buyads.php" role="button">Закупи реклама в сайта</a>
            <a class="btn btn-primary btn-block" href="changename.php" role="button">Закупи смяна на името във форума</a>
            <a class="btn btn-primary btn-block" href="changerank.php" role="button">Закупи смяна на ранга във форума</a>
            </div>
         </div>

<?php
}
require_once __DIR__ . '/includes/views/FooterMain.php';
