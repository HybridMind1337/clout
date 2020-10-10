<!doctype html>
<html lang="bg">
   <head>
      <meta charset="utf-8">
      <title><?php echo $siteName.' &bull; '.$pageTitle; ?></title>
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css">
      <link rel="stylesheet" href="assets/stylesheets.css">
   </head>
   <body>
      <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
         <div class="container">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbars" aria-controls="navbars" aria-expanded="false" aria-label="Отвори менюто"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbars">
               <a class="navbar-brand" href="#"><i class="fab fa-vimeo-v"></i> <i class="fas fa-info"></i> <i class="fab fa-pinterest-p"></i> Услуги</a>
               <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
                  <?php
                  if($bb_is_anonymous) {
                  echo '<li class="nav-item"><a class="nav-link" href="'.$forum_path.'ucp.php?mode=login"><i class="fas fa-sign-in-alt"></i> Вход</a></li>
                  <li class="nav-item"><a class="nav-link" href="'.$forum_path.'ucp.php?mode=register"><i class="fas fa-user-plus"></i> Регистрация</a></li>';
                  } else {
                  echo '<li class="nav-item"><a class="nav-link" href="index.php">Начало</a></li>
                  <li class="nav-item"><a class="nav-link" href="buycredits.php">Купи точки</a></li>
                  <li class="nav-item"><a class="nav-link" href="hronology.php">История</a></li>
                  <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        '.$bb_username.'
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="#"><i class="fas fa-pencil-alt"></i> Мнения: '.$bb_user_posts.'</a>
          <a class="dropdown-item" href="'.$forum_path.'/ucp.php"><i class="fas fa-user-cog"></i> Настройки</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Кредити '.get_credits($bb_user_id).'</a>
        </div>
      </li>';
                  }
                  ?>
               </ul>
            </div>
         </div>
      </nav>
      <div class="container">