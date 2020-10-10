<?php
   require_once __DIR__ . '/includes/database.php';
   require_once __DIR__ . '/includes/phpbb.php';
   require_once __DIR__. '/includes/funcs.php';
   $pageTitle = 'Смяна на ранга във форума';
   require_once __DIR__ . '/includes/views/HeaderMain.php';
   
   if ($bb_is_anonymous) {
       echo '<br /><div class="alert alert-danger text-center" role="alert"><i class="fas fa-sign-in-alt"></i> Моля, влезте в акаунта си за да имате пълен достъп до системата!</div>';
   } else {
   ?>
<br />
<div class="card">
   <div class="card-header bg-dark text-white">Смяна на ранга във форума</div>
   <div class="card-body">
      <div class="alert alert-primary text-center" role="alert">Услугата ще ви струва <?php echo $smsrank_credits;?> кредита!<br/>
         (макс размери: 150 x 150 px) | (макс големина: 95.8kb) | (разрешени формати: jpg, png, gif)
      </div>
      <form method="post" enctype="multipart/form-data">
         <div class="input-group mb-3">
            <div class="input-group-prepend">
               <span class="input-group-text"><i class="fas fa-star"></i></span>
            </div>
            <input type="text"  name="new_rank_text" class="form-control" placeholder="Името на ранга" aria-label="rankname" required />
         </div>
         <div class="input-group mb-3">
            <div class="input-group-prepend">
               <span class="input-group-text" id="inputGroupFileAddon01"><i class="fas fa-image"></i></span>
            </div>
            <div class="custom-file">
               <input type="file" class="custom-file-input" name="image_file" required />
               <label class="custom-file-label" for="inputGroupFile01">Качи изображението</label>
            </div>
         </div>
         <input type="submit" value="Промени ранга ми" class="btn btn-outline-success" name="submit_rank" />
      </form>
      <?php
if (isset($_POST['submit_rank'])) {
    if (get_credits($bb_user_id) >= $smsrank_credits) {

        unset($imagename);
        if (!isset($_FILES) && isset($HTTP_POST_FILES)) $_FILES = $HTTP_POST_FILES;
        if (!isset($_FILES['image_file'])) $error["image_file"] = "Няма ранг.<br />";
        $imagename = basename($_FILES['image_file']['name']);
        $test123 = ($_FILES['image_file']['tmp_name']);
        
        $random_digit = rand(0000000, 9999999);
        $imagename = $random_digit . $imagename;
        
        $check = getimagesize($test123);
        list($width, $height, $type, $attr) = $check;
        if ($width > 150 || $height > 150) {
            $error = "<div class='alert alert-danger text-center'>Проблем с размерите на изображението!</div>";
        }
        if ($check === false) {
            $error = "<div class='alert alert-danger text-center'>Проблем с изображението!</div>";
        }
        if ($_FILES['image_file']['size'] > 95880) {
            $error = "<div class='alert alert-danger text-center'>Надвишен е лимита от 95.8KB</div>";
        }
        if (!empty($error)) { echo $error; } else {
            $newimage = $forum_path."/images/ranks/" . $imagename;
            $result = move_uploaded_file($_FILES['image_file']['tmp_name'], $newimage);

            $new_rank_text = mysqli_real_escape_string($conn,trim(htmlspecialchars($_POST['new_rank_text'])));
            $rank_image = $imagename;
            mysqli_query($conn, "INSERT INTO phpbb_ranks(rank_title, rank_min, rank_special, rank_image) VALUES('$new_rank_text', '0', '1', '$rank_image')");
            $result = mysqli_query($conn, "SELECT rank_id FROM phpbb_ranks ORDER BY rank_id DESC LIMIT 1");
            $row = mysqli_fetch_assoc($result);
            $new_rank_id = $row['rank_id'];
            $result = mysqli_query($conn, "UPDATE phpbb_users SET user_rank='$new_rank_id' WHERE user_id='" . $bb_user_id . "'");
            $cache->destroy('_ranks');
            remove_credits($bb_user_id, $smsrank_credits);

            mysqli_query($conn, "INSERT INTO paymentsout (userid, type,time, credits) VALUES ('".$bb_user_id."','Смяна на ранг', '$timehook', '$smsrank_credits')");
            echo "<div class='alert alert-success text-centers'>Успешно сменихте ранга си!</div>";
        }
    } else {
        echo '<div class="alert alert-danger text-center">Нямаш достатъчно кредити!</div>';
    }
}
echo '</div></div>';
}
require_once __DIR__ . '/includes/views/FooterMain.php';