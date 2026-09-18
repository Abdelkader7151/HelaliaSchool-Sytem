<?php require_once('../../Connections/database.php');
      include("../../includes/logout.php");
      include("../../includes/access.php");
      include("../../includes/functions_eng.php");
      
      $kid_id = escape($_GET['id']);
      
      mysqli_select_db($database, $database_database,);
      $query_get_kids_list = "SELECT * FROM `kids_list` where `parent_id` = '{$row_get_user['id']}' and `kid_id` = '{$kid_id}'";
      $get_kids_list = mysqli_query($database, $query_get_kids_list) or die(mysqli_error($database));
      $row_get_kids_list = mysqli_fetch_assoc($get_kids_list);
      $totalRows_get_kids_list = mysqli_num_rows($get_kids_list);

      if($totalRows_get_kids_list==0){
          header("Location: parent-view.php");
          exit();
      }

 
        $query_get_kid_info = "SELECT * FROM `kids` where `id` = '{$kid_id}' ";
        $get_kid_info = mysqli_query($database, $query_get_kid_info) or die(mysqli_error($database));
        $row_get_kid_info = mysqli_fetch_assoc($get_kid_info);
        $totalRows_get_kid_info = mysqli_num_rows($get_kid_info);


      /* ---------------------------------------------------------
         Profile picture upload (PRG pattern: process -> redirect)
      --------------------------------------------------------- */
      $upload_dir     = '../../../../kids/';
      $upload_error    = '';
      $max_upload_size = 5 * 1024 * 1024; // 5MB
      $allowed_mimes   = array('image/jpeg', 'image/png', 'image/webp');

      if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_picture'])) {

          $file = $_FILES['profile_picture'];

          if ($file['error'] !== UPLOAD_ERR_OK || $file['size'] == 0) {
              $upload_error = 'upload_failed';
          } elseif ($file['size'] > $max_upload_size) {
              $upload_error = 'too_large';
          } else {

              $finfo     = finfo_open(FILEINFO_MIME_TYPE);
              $mime_type = finfo_file($finfo, $file['tmp_name']);
              finfo_close($finfo);

              if (!in_array($mime_type, $allowed_mimes)) {
                  $upload_error = 'bad_type';
              } else {

                  switch ($mime_type) {
                      case 'image/jpeg':
                          $src_img = imagecreatefromjpeg($file['tmp_name']);
                          break;
                      case 'image/png':
                          $src_img = imagecreatefrompng($file['tmp_name']);
                          break;
                      case 'image/webp':
                          $src_img = imagecreatefromwebp($file['tmp_name']);
                          break;
                      default:
                          $src_img = false;
                  }

                  if ($src_img === false) {
                      $upload_error = 'bad_type';
                  } else {

                      // Correct orientation for phone photos
                      if (function_exists('exif_read_data') && $mime_type === 'image/jpeg') {
                          $exif = @exif_read_data($file['tmp_name']);
                          if (!empty($exif['Orientation'])) {
                              switch ($exif['Orientation']) {
                                  case 3: $src_img = imagerotate($src_img, 180, 0); break;
                                  case 6: $src_img = imagerotate($src_img, -90, 0); break;
                                  case 8: $src_img = imagerotate($src_img, 90, 0); break;
                              }
                          }
                      }

                      $orig_w = imagesx($src_img);
                      $orig_h = imagesy($src_img);

                      // Square-crop to the centre, then resize down to 500x500 max
                      $crop_size = min($orig_w, $orig_h);
                      $crop_x    = (int)(($orig_w - $crop_size) / 2);
                      $crop_y    = (int)(($orig_h - $crop_size) / 2);

                      $target_size = min(500, $crop_size);
                      $dst_img     = imagecreatetruecolor($target_size, $target_size);
                      imagecopyresampled(
                          $dst_img, $src_img,
                          0, 0, $crop_x, $crop_y,
                          $target_size, $target_size,
                          $crop_size, $crop_size
                      );

                      $new_filename = 'kid_' . $kid_id . '_' . time() . '.jpg';
                      $save_path    = $upload_dir . $new_filename;

                      if (imagejpeg($dst_img, $save_path, 85)) {

                          // Remove the old picture file (if any, and not the placeholder)
                          $old_picture = $row_get_kid_info['picture'];
                          if ($old_picture && $old_picture !== 'no-picture.png') {
                              $old_path = $upload_dir . $old_picture;
                              if (file_exists($old_path)) {
                                  if (is_writable($old_path)) {
                                      $deleted = unlink($old_path);
                                      if (!$deleted) {
                                          error_log('parent-kid.php: failed to unlink old picture at ' . $old_path);
                                      }
                                  } else {
                                      error_log('parent-kid.php: old picture not writable, cannot delete: ' . $old_path);
                                  }
                              } else {
                                  error_log('parent-kid.php: old picture DB value did not match a file on disk: ' . $old_path);
                              }
                          }

                          $new_filename_esc = escape($new_filename);
                          mysqli_select_db($database, $database_database,);
                          $query_update_picture = "UPDATE `kids` SET `picture` = '{$new_filename_esc}' WHERE `id` = '{$kid_id}'";
                          mysqli_query($database, $query_update_picture) or die(mysqli_error($database));

                          imagedestroy($src_img);
                          imagedestroy($dst_img);

                          header("Location: parent-kid.php?id=" . $kid_id . "&pic=1");
                          exit();

                      } else {
                          $upload_error = 'save_failed';
                      }

                      imagedestroy($src_img);
                      imagedestroy($dst_img);
                  }
              }
          }
      }

 ?>     
 <!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<meta name="theme-color" content="#112c5a">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="apple-mobile-web-app-title" content="Helalia">
<meta name="format-detection" content="telephone=no">
<title> Helalia</title>
<link rel="icon" href="../assets/img/logo-icon.png">
<link rel="apple-touch-icon" href="../assets/img/logo-icon.png">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap">
<link rel="stylesheet" href="../assets/css/helalia.css?v=18">
<style>
/* Profile picture upload modal */
.av--clickable { cursor: pointer; position: relative; }
.av--clickable .av__edit {
  position: absolute; right: -2px; bottom: -2px;
  width: 26px; height: 26px; border-radius: 50%;
  background: #112c5a; color: #fff;
  display: flex; align-items: center; justify-content: center;
  border: 2px solid #fff;
}
.av--clickable .av__edit svg { width: 14px; height: 14px; }
.featured--profile { position: relative; }

.pic-modal { position: fixed; inset: 0; z-index: 999; display: none; }
.pic-modal.is-open { display: block; }
.pic-modal__overlay { position: absolute; inset: 0; background: rgba(17,44,90,.45); }
.pic-modal__box {
  position: relative; margin: auto; margin-top: 12vh;
  width: 90%; max-width: 420px; background: #fff; border-radius: 16px;
  padding: 24px 20px; box-shadow: 0 20px 50px rgba(0,0,0,.25);
  max-height: 74vh; overflow-y: auto; text-align: center;
}
.pic-modal__close {
  position: absolute; top: 12px; right: 12px; background: none; border: none;
  color: #112c5a; padding: 4px; line-height: 0; cursor: pointer;
}
.pic-modal__close svg { width: 22px; height: 22px; }
.pic-modal__title { margin: 0 0 16px; font-size: 17px; color: #111; }
.pic-modal__preview {
  width: 140px; height: 140px; border-radius: 50%; object-fit: cover;
  margin: 0 auto 16px; display: block; border: 3px solid #f0f2f7;
}
.pic-modal__filelabel {
  display: inline-block; padding: 10px 18px; border-radius: 30px;
  background: #f7f8fb; color: #112c5a; font-weight: 600; font-size: 14px;
  cursor: pointer; margin-bottom: 16px;
}
.pic-modal__filelabel input[type="file"] { display: none; }
.pic-modal__error {
  color: #c0392b; font-size: 13px; margin: 0 0 12px; display: none;
}
.pic-modal__error.show { display: block; }
.pic-modal__actions { display: flex; gap: 10px; }
.pic-modal__actions .btn { flex: 1; }
</style>
</head>
<body>
<div class="app">
  <header class="hero hero--tall">

    <div class="hero__row">
           <div class="grow"></div>
     
            <div class="bells">
              <a class="bell bell--alert" href="parent-alerts.php?kid=<?php echo $kid_id;?>" aria-label="Alerts">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                  <path d="M6 16V10a6 6 0 1 1 12 0v6l1.5 2H4.5L6 16z"/>
                  <path d="M10 20a2 2 0 0 0 4 0"/>
                </svg>
                <?php alert($row_get_user['id'], $kid_id); ?>
              </a>
            </div> 
    </div>
    
    <section class="featured featured--profile">
      <button type="button" class="av av--lg av--clickable" id="pic-modal-trigger" aria-label="Change photo" style="padding:0;border:none;background:none;">
        <img class="av av--lg" id="profile-picture-img" src="../../../../kids/<?php if($row_get_kid_info['picture']!=NULL && file_exists('../../../../kids/'.$row_get_kid_info['picture'])==1){echo $row_get_kid_info['picture'];}else{ echo "no-picture.png";} ;?>" alt="<?php echo htmlspecialchars($row_get_kid_info['fn_name'], ENT_QUOTES); ?>">
        <span class="av__edit" aria-hidden="true">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 20h9"/>
            <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5z"/>
          </svg>
        </span>
      </button>
      <div class="featured__body">
        <p class="featured__name"><?php echo $row_get_kid_info['fn_name']; ?></p>
        <p class="featured__meta"><?php echo year_of_study($row_get_kid_info['study_year']); ?> · ⁦<?php echo class_name($row_get_kid_info['class']);?>⁩</p>
        <div class="featured__tags"><span class="tag">ID#: <?php echo $row_get_kid_info['ed_id']; ?></span></div>
      </div>
      </section>
  </header>


  <main class="page">

  <!--Top quick links-->
     <div class="quickrow quickrow--3">
      <?php 
          $query_get_question = "SELECT `id` FROM `ask_teacher` where `kid_id` = '{$kid_id}' AND `view` = 0 AND `respond` > 0 AND `del` = 0  ";
          $get_question =mysqli_query($database ,$query_get_question) or die(mysqli_error($database));
          $row_get_question = mysqli_fetch_assoc($get_question);
          $totalRows_get_question = mysqli_num_rows($get_question);
            ?>

     <a class="quick t-navy" href="parent-ask.php?kid=<?php echo $row_get_kid_info['id'];?>">
      <?php if($totalRows_get_question>0){ ?><span class="tile__new pulse"><?php echo $totalRows_get_question; ?></span><?php } ?>
            <span class="quick__ico quick__ico--art"><img src="../assets/img/quick/ask.webp" alt="" aria-hidden="true"></span>Ask school </a>

        <a class="quick t-blue" href="parent-calendar.php?kid=<?php echo $row_get_kid_info['id'];?>">
            <span class="quick__ico quick__ico--art"><img src="../assets/img/quick/calendar.avif" alt="" aria-hidden="true"></span>Calendar </a>

        <a class="quick t-green" href="parent-summary.php?kid=<?php echo $row_get_kid_info['id'];?>">
           <span class="quick__ico quick__ico--art"><img src="../assets/img/quick/attendance.webp" alt="" aria-hidden="true"></span>Attendance </a>
     </div>



    <!-- App options --> 
    <div class="tiles">

        <?php
        $query_get_homework_count = "SELECT COUNT(*) as `homework` FROM `homework` WHERE `study_year` = '{$row_get_kid_data['study_year']}' AND (`class` = '{$row_get_kid_data['class']}' ||  `class` = 0 ) AND `confirm` = 1 AND `subject` = '{$row_get_subjects['id']}' AND `date` ='{$today}' order BY `id` desc  ";
        $get_homework_count = mysqli_query($database ,$query_get_homework_count) or die(mysqli_error($database));
        $row_get_homework_count = mysqli_fetch_assoc($get_homework_count);
        $totalRows_get_homework_count = mysqli_num_rows($get_homework_count); ?> 
    
    <a class="tile t-coral" href="parent-homework.php?id=<?php echo $row_get_kid_info['id'];?>">
      <?php if($row_get_homework_count['homework']>0){ ?><span class="tile__new pulse"><?php echo $row_get_homework_count['homework']; ?></span><?php } ?>
      <span class="tile__ico tile__ico--art"><img src="../assets/img/quick/homework.webp" alt="" aria-hidden="true"></span>
      <span class="tile__label">Homework</span>
    </a>

      <?php
      $memoYear = (int) $row_get_kid_data['study_year'];
      $memoClass = (int) $row_get_kid_data['class'];
      $query_get_memo_count = "SELECT COUNT(*) as `memo` FROM `memos` WHERE (`study_year` = '{$memoYear}' OR `study_year` = 300) AND (`class` = '{$memoClass}' OR `class` = 0 OR `class` IS NULL OR `class` = '') AND `date` >= '{$today}' AND `date` < ('{$today}' + 86400) ";
      $get_memo_count = mysqli_query($database ,$query_get_memo_count) or die(mysqli_error($database));
      $row_get_memo_count = mysqli_fetch_assoc($get_memo_count);
      $totalRows_get_memo_count = mysqli_num_rows($get_memo_count);
      ?>
    <a class="tile t-blue" href="parent-memo.php?id=<?php echo $row_get_kid_info['id'];?>">
      <?php if($row_get_memo_count['memo']>0){ ?><span class="tile__new pulse"><?php echo $row_get_memo_count['memo']; ?></span><?php } ?>
      <span class="tile__ico tile__ico--art"><img src="../assets/img/quick/memo.webp" alt="" aria-hidden="true"></span>
      <span class="tile__label">Memo</span>
    </a>

    <?php
    $query_get_revision_count = "SELECT COUNT(*) as `revision` FROM `revision` WHERE `study_year` = '{$row_get_kid_data['study_year']}' AND (`class` = '{$row_get_kid_data['class']}' ||  `class` = 0 ) AND `confirm` = 1 AND `subject` = '{$row_get_subjects['id']}' AND `date` ='{$today}' order BY `id` desc  ";
    $get_revision_count = mysqli_query($database ,$query_get_revision_count) or die(mysqli_error($database));
    $row_get_revision_count = mysqli_fetch_assoc($get_revision_count);
    $totalRows_get_revision_count = mysqli_num_rows($get_revision_count);
    ?>
    <a class="tile t-gold" href="parent-revision.php?id=<?php echo $row_get_kid_info['id'];?>">
      <?php if($row_get_revision_count['revision']>0){ ?><span class="tile__new pulse"><?php echo $row_get_revision_count['revision']; ?></span><?php } ?>
      <span class="tile__ico tile__ico--art"><img src="../assets/img/quick/revision.webp" alt="" aria-hidden="true"></span>
      <span class="tile__label">Revision</span>
    </a>

    <a class="tile t-navy" href="parent-plan.php?kid=<?php echo $row_get_kid_info['id'];?>">
      <span class="tile__ico tile__ico--art"><img src="../assets/img/quick/plan.webp" alt="" aria-hidden="true"></span>
      <span class="tile__label">Weekly plan</span>
    </a>


    <a class="tile t-coral" href="#">
      <span class="tile__ico tile__ico--art"><img src="../assets/img/quick/gallery.webp" alt="" aria-hidden="true"></span>
      <span class="tile__label">Gallery</span>
    </a>


    <a class="tile t-green" href="#">
      <span class="tile__ico tile__ico--art"><img src="../assets/img/quick/certificate.webp" alt="" aria-hidden="true"></span>
      <span class="tile__label">Certificate</span>
    </a>  

   
  </div>

</main>


<!-- Bottom navigation -->
  <nav class="nav nav--trio" aria-label="Home"  style="height: 90px">

    <a class="nav__item is-active" href="parent-view.php">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <circle cx="9" cy="8" r="3.2"/>
        <path d="M3 19a6 6 0 0 1 12 0"/>
        <path d="M16.5 5.5a3.2 3.2 0 0 1 0 6"/>
        <path d="M18 13.5a6 6 0 0 1 3 5.5"/>
      </svg>
      <span>Students</span>
      <span class="nav__dot"></span>
    </a>
    
    <a class="nav__item" href="parent-timeline.php">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <path d="M4 5h13v14H5.5A1.5 1.5 0 0 1 4 17.5V5z"/>
        <path d="M17 9h2.5A1.5 1.5 0 0 1 21 10.5v7a1.5 1.5 0 0 1-1.5 1.5H17"/>
        <path d="M7.5 8.5h6M7.5 12h6M7.5 15.5h3.5"/>
      </svg>
      <span>Latest News</span>
      <span class="nav__dot"></span>
    </a>

    <a class="nav__item" href="parent-settings.php">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <circle cx="12" cy="12" r="3"/>
        <path d="M19.4 15a1.7 1.7 0 0 0 .3 1.9l.1.1a2 2 0 1 1-2.8 2.8l-.1-.1a1.7 1.7 0 0 0-1.9-.3 1.7 1.7 0 0 0-1 1.5V21a2 2 0 1 1-4 0v-.1a1.7 1.7 0 0 0-1.1-1.5 1.7 1.7 0 0 0-1.9.3l-.1.1a2 2 0 1 1-2.8-2.8l.1-.1a1.7 1.7 0 0 0 .3-1.9 1.7 1.7 0 0 0-1.5-1H3a2 2 0 1 1 0-4h.1a1.7 1.7 0 0 0 1.5-1.1 1.7 1.7 0 0 0-.3-1.9l-.1-.1a2 2 0 1 1 2.8-2.8l.1.1a1.7 1.7 0 0 0 1.9.3H9a1.7 1.7 0 0 0 1-1.5V3a2 2 0 1 1 4 0v.1a1.7 1.7 0 0 0 1 1.5 1.7 1.7 0 0 0 1.9-.3l.1-.1a2 2 0 1 1 2.8 2.8l-.1.1a1.7 1.7 0 0 0-.3 1.9V9a1.7 1.7 0 0 0 1.5 1H21a2 2 0 1 1 0 4h-.1a1.7 1.7 0 0 0-1.5 1z"/></svg>
        <span>Settings</span>
        <span class="nav__dot"></span>
    </a>
  </nav>

  <!-- Profile picture upload modal -->
  <div class="pic-modal" id="pic-modal">
    <div class="pic-modal__overlay" id="pic-modal-overlay"></div>
    <div class="pic-modal__box" role="dialog" aria-modal="true" aria-labelledby="pic-modal-title">
      <button class="pic-modal__close" id="pic-modal-close" aria-label="Close">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M18 6 6 18"/><path d="M6 6l12 12"/>
        </svg>
      </button>
      <h3 class="pic-modal__title" id="pic-modal-title">Change Photo</h3>

      <p class="pic-modal__error<?php echo $upload_error ? ' show' : ''; ?>" id="pic-modal-error">
        <?php
        switch ($upload_error) {
            case 'too_large':    echo 'That image is too large. Max size is 5MB.'; break;
            case 'bad_type':     echo 'Please choose a JPG, PNG or WEBP image.'; break;
            case 'upload_failed':
            case 'save_failed':  echo 'The upload failed. Please try again.'; break;
        }
        ?>
      </p>

      <form action="parent-kid.php?id=<?php echo $kid_id;?>" method="post" enctype="multipart/form-data" id="pic-upload-form">
        <img class="pic-modal__preview" id="pic-preview-img" src="../../../../kids/<?php if($row_get_kid_info['picture']!=NULL && file_exists('../../../../kids/'.$row_get_kid_info['picture'])==1){echo $row_get_kid_info['picture'];}else{ echo "no-picture.png";} ;?>" alt="Preview">

        <label class="pic-modal__filelabel" for="pic-file-input">
          Choose photo
          <input type="file" name="profile_picture" id="pic-file-input" accept="image/jpeg,image/png,image/webp" required>
        </label>

        <div class="pic-modal__actions">
          <button type="button" class="btn btn--quiet" id="pic-modal-cancel">Cancel</button>
          <button type="submit" class="btn btn--primary" id="pic-modal-save">Save</button>
        </div>
      </form>
    </div>
  </div>

</div>


<script>
var picModal      = document.getElementById('pic-modal');
var picTrigger     = document.getElementById('pic-modal-trigger');
var picClose       = document.getElementById('pic-modal-close');
var picOverlay      = document.getElementById('pic-modal-overlay');
var picCancel      = document.getElementById('pic-modal-cancel');
var picFileInput   = document.getElementById('pic-file-input');
var picPreviewImg  = document.getElementById('pic-preview-img');
var picForm        = document.getElementById('pic-upload-form');
var picSaveBtn     = document.getElementById('pic-modal-save');

function openPicModal() {
  picModal.classList.add('is-open');
}
function closePicModal() {
  picModal.classList.remove('is-open');
}

picTrigger.addEventListener('click', openPicModal);
picClose.addEventListener('click', closePicModal);
picOverlay.addEventListener('click', closePicModal);
picCancel.addEventListener('click', closePicModal);

document.addEventListener('keydown', function (e) {
  if (e.key === 'Escape' && picModal.classList.contains('is-open')) closePicModal();
});

picFileInput.addEventListener('change', function () {
  if (this.files && this.files[0]) {
    var reader = new FileReader();
    reader.onload = function (e) { picPreviewImg.src = e.target.result; };
    reader.readAsDataURL(this.files[0]);
  }
});

picForm.addEventListener('submit', function () {
  picSaveBtn.disabled = true;
  picSaveBtn.textContent = 'Saving...';
});

<?php if ($upload_error): ?>
openPicModal();
<?php endif; ?>

<?php if (isset($_GET['pic']) && $_GET['pic'] === '1'): ?>
// picture saved successfully — nothing else to do, fresh image already rendered
<?php endif; ?>
</script>
<script src="../assets/js/app.js?v=65" defer></script>
</body>
</html>
