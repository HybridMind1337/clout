<?php
   require_once __DIR__ . '/includes/database.php';
   require_once __DIR__ . '/includes/phpbb.php';
   require_once __DIR__ . '/includes/funcs.php';
   $pageTitle = 'Зареждане на кредити';
   require_once __DIR__ . '/includes/views/HeaderMain.php';
   if ($bb_is_anonymous) {
       echo '<br /><div class="alert alert-danger text-center" role="alert"><i class="fas fa-sign-in-alt"></i> Моля, влезте в акаунта си за да имате пълен достъп до системата!</div>';
   } else {
   ?>
<br />
<div class="card">
   <div class="card-header bg-dark text-white">Зареждане, чрез SMS от 2.40лв (<?php echo $credits2; ?> кредита)</div>
   <div class="card-body">
      <div class="alert alert-primary text-center" role="alert"><?php echo $info2; ?></div>
      <form method="post" name="smscode">
         <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="SMS Код" aria-label="SMS Код" name="code1">
            <div class="input-group-append">
               <button class="btn btn-outline-success" type="submit" name="ok1" id="button-addon2">Добави</button>
            </div>
         </div>
      </form>
      <?php
         if (isset($_POST['ok1'])) {
             $code1 = mysqli_real_escape_string($conn, $_POST['code1']);
             if (mobio_checkcode($servID2, $code1) == 1) {
                 mysqli_query($conn, "INSERT INTO payments (userid, time, credits) VALUES ('" . $bb_user_id . "', $timehook, '$credits2')") or die(mysqli_error($conn));
                 set_credits($bb_user_id, $credits2);
                 echo "<div class='alert alert-primary text-center' role='alert'><i class='fas fa-check'></i> Бяха ви добавени $credits2 кредита</div>";
             } else {
                 echo "<div class='alert alert-danger text-center' role='alert'><i class='fas fa-exclamation-triangle'></i> Грешен SMS код за достъп</div>";
             }
         }
         ?>
   </div>
</div>
<br />
<div class="card">
   <div class="card-header bg-dark text-white">Зареждане, чрез SMS от 4.80лв (<?php echo $credits3; ?> кредита)</div>
   <div class="card-body">
      <div class="alert alert-primary text-center" role="alert"><?php echo $info3; ?></div>
      <form method="post" name="smscode">
         <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="SMS Код" aria-label="SMS Код" name="code3">
            <div class="input-group-append">
               <button class="btn btn-outline-success" type="submit" name="ok3" id="button-addon2">Добави</button>
            </div>
         </div>
      </form>
      <?php
         if (isset($_POST['ok3'])) {
             $code3 = mysqli_real_escape_string($conn, $_POST['code3']);
             if (mobio_checkcode($servID2, $code3) == 1) {
                 mysqli_query($conn, "INSERT INTO payments (userid, time, credits) VALUES ('" . $bb_user_id . "', $timehook, '$credits3')") or die(mysqli_error($conn));
                 set_credits($bb_user_id, $credits3);
                 echo "<div class='alert alert-primary text-center' role='alert'><i class='fas fa-check'></i> Бяха ви добавени $credits3 кредита</div>";
             } else {
                 echo "<div class='alert alert-danger text-center' role='alert'><i class='fas fa-exclamation-triangle'></i> Грешен SMS код за достъп</div>";
             }
         }
         ?>
   </div>
</div>
<br />
<div class="card">
   <div class="card-header bg-dark text-white">Зареждане, чрез SMS от 6.00лв (<?php echo $credits4; ?> кредита)</div>
   <div class="card-body">
      <div class="alert alert-primary text-center" role="alert"><?php echo $info4; ?></div>
      <form method="post" name="smscode">
         <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="SMS Код" aria-label="SMS Код" name="code4">
            <div class="input-group-append">
               <button class="btn btn-outline-success" type="submit" name="ok4" id="button-addon2">Добави</button>
            </div>
         </div>
      </form>
      <?php
         if (isset($_POST['ok4'])) {
             $code4 = mysqli_real_escape_string($conn, $_POST['code4']);
             if (mobio_checkcode($servID2, $code4) == 1) {
                 mysqli_query($conn, "INSERT INTO payments (userid, time, credits) VALUES ('" . $bb_user_id . "', $timehook, '$credits4')") or die(mysqli_error($conn));
                 set_credits($bb_user_id, $credits4);
                 echo "<div class='alert alert-primary text-center' role='alert'><i class='fas fa-check'></i> Бяха ви добавени $credits4 кредита</div>";
             } else {
                 echo "<div class='alert alert-danger text-center' role='alert'><i class='fas fa-exclamation-triangle'></i> Грешен SMS код за достъп</div>";
             }
         }
         ?>
   </div>
</div>

<?php
}
require_once __DIR__ . '/includes/views/FooterMain.php';