<?php
   require_once __DIR__ . '/includes/database.php';
   require_once __DIR__ . '/includes/phpbb.php';
   require_once __DIR__. '/includes/funcs.php';
   $pageTitle = 'Хронология';
   require_once __DIR__ . '/includes/views/HeaderMain.php';
   
   if ($bb_is_anonymous) {
       echo '<br /><div class="alert alert-danger text-center" role="alert"><i class="fas fa-sign-in-alt"></i> Моля, влезте в акаунта си за да имате пълен достъп до системата!</div>';
   } else {
   ?>
<br />
<div class="card">
   <div class="card-header bg-dark text-white">Хронология на плащанията</div>
   <div class="card-body">
      <?php
         $results_check1 = mysqli_query($conn, "SELECT * FROM `payments` WHERE userid='" . $bb_user_id . "'");
         if (mysqli_num_rows($results_check1) > 0) {
             $results_check = mysqli_result(mysqli_query($conn, "SELECT COUNT(`id`) FROM `payments`"), 0);
             $pagination    = pagination($results_check, array(
                 'per_page' => 10,
                 'get_vars' => array(
                     'p' => $_GET['p']
                 )
             ));
             $result         = mysqli_query($conn, "SELECT * FROM `payments` WHERE userid='" . $bb_user_id . "' ORDER BY id DESC LIMIT  {$pagination['limit']['first']}, {$pagination['limit']['second']}");
             echo '
             <table class="table table-sm table-striped table-bordered table-hover text-center">
           <thead>
             <tr>
             <th scope="col"><i class="fas fa-money-bill-alt"></i> Кредити</th>
             <th scope="col"><i class="fas fa-calendar-week"></i> Дата и час</th>
             </tr>
           </thead>
           <tbody>';
             while ($row = mysqli_fetch_assoc($result)) {
                 $time   = date('d.m.y (H:i:s)', $row['time']);
                 $credits = $row['credits'];
                 echo "
                 <tr><td scope='row'>Заредени $credits кредита</td>
                 <td>$time</td></tr>";
             }
             echo '</tbody></table>';
             echo $pagination['output'];
         } else {
             echo "<div class='alert alert-danger' role='alert'><i class='fas fa-exclamation-triangle'></i> Вие все още нямате извършено плащане</div>";
         }
         ?>
   </div>
</div>
<br />
<div class="card">
   <div class="card-header bg-dark text-white">Хронология на закупените услуги</div>
   <div class="card-body">
      <?php
         $results_check1 = mysqli_query($conn, "SELECT * FROM `paymentsout` WHERE userid='" . $bb_user_id . "'");
         if (mysqli_num_rows($results_check1) > 0) {
             $results_check = mysqli_result(mysqli_query($conn, "SELECT COUNT(`id`) FROM `paymentsout`") , 0);
             $pagination = pagination($results_check, array(
                 'per_page' => 10,
                 'get_vars' => array(
                     'p' => $_GET['p']
                 )
             ));
             $query = mysqli_query($conn, "SELECT * FROM `paymentsout` WHERE userid='" . $bb_user_id . "' ORDER BY id DESC LIMIT  {$pagination['limit']['first']}, {$pagination['limit']['second']}");
             echo '
             <table class="table table-sm table-striped table-bordered table-hover text-center">
           <thead>
             <tr>
             <th scope="col"><i class="fas fa-money-bill-alt"></i> Кредити</th>
             <th scope="col"><i class="fas fa-border-style"></i> Тип</th>
             <th scope="col"><i class="fas fa-calendar-week"></i> Дата и час</th>
             </tr>
           </thead>
           <tbody>';
             while ($row = mysqli_fetch_assoc($query)) {
                 $time = date('d.m.y (H:i:s)', $row['time']);
                 $credits = $row['credits'];
                 $type = $row['type'];
                 echo "
                 <tr><td scope='row'>Взети $credits кредита</td>
                 <td>$type</td>
                 <td>$time</td></tr>";
             }
             echo '</tbody></table>';
             echo $pagination['output'];
         } else {
             echo "<div class='alert alert-danger' role='alert'><i class='fas fa-exclamation-triangle'></i> Вие все още нямате закупени услуги</div>";
         }
         ?>
   </div>
</div>
<?php
}
require_once __DIR__ . '/includes/views/FooterMain.php';