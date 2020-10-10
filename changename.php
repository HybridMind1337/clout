<?php
require_once __DIR__ . '/includes/database.php';
require_once __DIR__ . '/includes/phpbb.php';
require_once __DIR__. '/includes/funcs.php';
$pageTitle = 'Смяна на името във форума';
require_once __DIR__ . '/includes/views/HeaderMain.php';

if ($bb_is_anonymous) {
    echo '<br /><div class="alert alert-danger text-center" role="alert"><i class="fas fa-sign-in-alt"></i> Моля, влезте в акаунта си за да имате пълен достъп до системата!</div>';
} else {
?>
<br />
         <div class="card">
            <div class="card-header bg-dark text-white">Смяна на името във форума</div>
            <div class="card-body">
            <div class="alert alert-warning text-center" role="alert">
Услугата ще ви струва <?php echo $smsnick_credits; ?> кредита!<br />
Моля, не въвеждайте специални символи от рода на \',",*,^,% в името си също така не трябва да подобявана на имената на администраторите!
</div>
<form method='post'>
<div class='input-group mb-3'>
<input type='text' name='username' placeholder='Вашето ново име' class='form-control' maxlength="30" required />
<div class='input-group-append'>
<input type='submit' name='submit_nick' class='btn btn-outline-success' value='Промени името ми' />
</div>
</div>
</form>
<?php
if (isset($_POST['submit_nick'])) {
    if (get_credits($bb_user_id) >= $smsnick_credits) {
        $nick_change = mysqli_real_escape_string($conn, trim(htmlspecialchars($_POST['username'])));
        $username_clean = strtolower($nick_change);
        $result = mysqli_query($conn, "SELECT username FROM phpbb_users WHERE username='$nick_change' AND username_clean='$username_clean'");
        if (mysqli_num_rows($result) > 0) {
            echo "<div class='alert alert-danger text-center'>Името <b>$nick_change</b> е вече заето!</div>";
        } else {
            $result = mysqli_query($conn, "UPDATE phpbb_users SET username='$nick_change', username_clean='$username_clean' WHERE username='$bb_username'");
            $result = mysqli_query($conn, "UPDATE phpbb_topics SET topic_first_poster_name='$nick_change' WHERE topic_first_poster_name='$bb_username'");
            $result = mysqli_query($conn, "UPDATE phpbb_topics SET topic_last_poster_name='$nick_change' WHERE topic_last_poster_name='$bb_username'");
            remove_credits($bb_user_id, $smsnick_credits);
            mysqli_query($conn, "INSERT INTO paymentsout (userid, type,time, credits) VALUES ('" . $bb_user_id . "','Смяна на името', '$timehook', '$smsnick_credits')");
            echo '<div class="alert alert-success text-center">Вие успешно промените името си на '.$nick_change.'</div>';
        }
    } else {
        echo '<div class="alert alert-danger text-center">Нямате достатъчно кредити.</div>';
    }
}
?>
            </div>
         </div>

<?php
}
require_once __DIR__ . '/includes/views/FooterMain.php';
