<?php require_once('../../Connections/database.php');
      include("../../includes/logout.php");
      include("../../includes/access.php");
      include("../../includes/functions_eng.php");
      
      $kid_id = (int) (escape($_GET['id']) ?? 0);
      if ($kid_id <= 0) {
          header("location: parent-view.php");
          exit;
      }


      if(isset($_POST['submit'])){   

         /* the educational-state copy is a real upload, so it is moved first and
            its filename is what goes into the text column below */
         if (isset($_FILES['ed_welaya_copy']) && $_FILES['ed_welaya_copy']['error'] === UPLOAD_ERR_OK) {
           $up_dir  = '../../uploads/doc/';
           if (!is_dir($up_dir)) { @mkdir($up_dir, 0775, true); }
           $up_ext  = strtolower(pathinfo($_FILES['ed_welaya_copy']['name'], PATHINFO_EXTENSION));
           $up_name = 'welaya-' . (int)$_GET['id'] . '-' . time() . '.' . $up_ext;
           if (move_uploaded_file($_FILES['ed_welaya_copy']['tmp_name'], $up_dir . $up_name)) {
             $_POST['ed_welaya_copy'] = $up_name;
           }
         }
         if (!isset($_POST['ed_welaya_copy'])) { $_POST['ed_welaya_copy'] = ''; }


         $updateSQL = sprintf("UPDATE `kids` SET `data_update`=%s, 
          `father_name`=%s, `father_mobile`=%s, `father_gov_id`=%s, `father_job`=%s,
          `mother_name`=%s, `mother_mobile`=%s, `mother_gov_id`=%s, `mother_job`=%s, 
          `whatsapp`=%s, `ed_welaya`=%s, `ed_welaya_copy`=%s, `divorce_living`=%s, `divorce_living_why`=%s, `death`=%s, `chronic_disease`=%s, `chronic_disease_name`=%s, `allergy_to_med`=%s, `allergy_to_med_name`=%s, `surgery`=%s, `emergency_phone`=%s, `emergency_relative`=%s
                  WHERE `id`=%s ", 
                                  GetSQLValueString($database, 1, "int"), 
                                  GetSQLValueString($database,$_POST['father_name'], "text"), 
                                  GetSQLValueString($database,$_POST['father_mobile'], "text"), 
                                  GetSQLValueString($database,$_POST['father_gov_id'], "text"), 
                                  GetSQLValueString($database,$_POST['father_job'], "text"), 
                                  GetSQLValueString($database,$_POST['mother_name'], "text"), 
                                  GetSQLValueString($database,$_POST['mother_mobile'], "text"), 
                                  GetSQLValueString($database,$_POST['mother_gov_id'], "text"), 
                                  GetSQLValueString($database,$_POST['mother_job'], "text"), 
                                  GetSQLValueString($database,$_POST['whatsapp'], "text"), 
                                  GetSQLValueString($database,$_POST['ed_welaya'], "text"), 
                                  GetSQLValueString($database,$_POST['ed_welaya_copy'], "text"),
                                  GetSQLValueString($database,$_POST['divorce_living'], "text"), 
                                  GetSQLValueString($database,$_POST['divorce_living_why'], "text"), 
                                  GetSQLValueString($database,$_POST['death'], "text"), 
                                  GetSQLValueString($database,$_POST['chronic_disease'], "text"), 
                                  GetSQLValueString($database,$_POST['chronic_disease_name'], "text"), 
                                  GetSQLValueString($database,$_POST['allergy_to_med'], "text"),
                                  GetSQLValueString($database,$_POST['allergy_to_med_name'], "text"), 
                                  GetSQLValueString($database,$_POST['surgery'], "text"), 
                                  GetSQLValueString($database,$_POST['emergency_phone'], "text"), 
                                  GetSQLValueString($database,$_POST['emergency_relative'], "text"), 
                                  GetSQLValueString($database,$_GET['id'], "int")); 

          mysqli_query($database , $updateSQL) or die(mysqli_error($database)); 
 
         header("location: parent-kid-data-thanks.php?id=".$_GET['id']); 
         exit();   
      }
       


        $query_get_kid_info = "SELECT * FROM `kids` where `id` = '{$kid_id}' ";
        $get_kid_info = mysqli_query($database, $query_get_kid_info) or die(mysqli_error($database));
        $row_get_kid_info = mysqli_fetch_assoc($get_kid_info);
        $totalRows_get_kid_info = mysqli_num_rows($get_kid_info);
 
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
<title>Update Data · Helalia</title>
<link rel="icon" href="../assets/img/logo-icon.png">
<link rel="apple-touch-icon" href="../assets/img/logo-icon.png">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap">
<link rel="stylesheet" href="../assets/css/helalia.css?v=19">
</head>
<body>
<div class="app">

  <header class="hero hero--tall">
    <div class="hero__row">
      <a class="back" href="parent-view.php" aria-label="Back">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <path d="M15 19 8 12l7-7"/></svg></a><h1 class="hero__title">Update Data</h1>
        
        
          <div class="bells">
          <a class="bell bell--alert" href="parent-alerts.php" aria-label="Alerts">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <path d="M6 16V10a6 6 0 1 1 12 0v6l1.5 2H4.5L6 16z"></path>
              <path d="M10 20a2 2 0 0 0 4 0"></path>
            </svg>
            <?php alert($row_get_user['id'], 0); ?>
          </a>
        </div>

  </div>
    
  </header>
  <main class="page page--fab">
  <form class="stack" id="kid-update-form" action="parent-kid-update-data.php?id=<?php echo $kid_id; ?>" method="post" enctype="multipart/form-data"  >

    <div class="card stack">
      <div class="sec"><h2 class="sec__title">Father Details</h2></div>
      <label class="field"><span class="field__label">Name <span class="req">*</span></span><input class="input" id="father_name" name="father_name" type="text" required></label>
      <label class="field"><span class="field__label">Mobile No. <span class="req">*</span></span><input class="input" id="father_mobile" name="father_mobile" type="tel" inputmode="numeric" required></label>
      <label class="field"><span class="field__label">ID or Passport <span class="req">*</span></span><input class="input" id="father_gov_id" name="father_gov_id" type="text" maxlength="14" required></label>
      <label class="field"><span class="field__label">Job &amp; educational qualifications <span class="req">*</span></span><input class="input" id="father_job" name="father_job" type="text" required></label>
    </div>

    <div class="card stack">
      <div class="sec"><h2 class="sec__title">Mother Details</h2></div>
      <label class="field"><span class="field__label">Name <span class="req">*</span></span><input class="input" id="mother_name" name="mother_name" type="text" required></label>
      <label class="field"><span class="field__label">Mobile No. <span class="req">*</span></span><input class="input" id="mother_mobile" name="mother_mobile" type="tel" inputmode="numeric" required></label>
      <label class="field"><span class="field__label">ID or Passport <span class="req">*</span></span><input class="input" id="mother_gov_id" name="mother_gov_id" type="text" maxlength="14" required></label>
      <label class="field"><span class="field__label">Job &amp; educational qualifications <span class="req">*</span></span><input class="input" id="mother_job" name="mother_job" type="text" required></label>
    </div>

    <div class="card stack">
      <div class="sec"><h2 class="sec__title">General Details</h2></div>
      <label class="field"><span class="field__label">Whatsapp</span><input class="input" id="whatsapp" name="whatsapp" type="tel" inputmode="numeric"></label>

      <fieldset class="field">
        <legend class="field__label">Educational state</legend>
        <div class="opts">
          <label class="opt"><input type="radio" name="ed_welaya" value="There is no divorce"><span class="opt__box"></span><span>There is no divorce</span></label>
          <label class="opt"><input type="radio" name="ed_welaya" value="Father" data-reveal-target="ed_welaya_copy_row"><span class="opt__box"></span><span>Father</span></label>
          <label class="opt"><input type="radio" name="ed_welaya" value="Mother" data-reveal-target="ed_welaya_copy_row"><span class="opt__box"></span><span>Mother</span></label>
          <label class="opt"><input type="radio" name="ed_welaya" value="Other" data-reveal-target="ed_welaya_copy_row"><span class="opt__box"></span><span>Other</span></label>
        </div>
      </fieldset>
      <div class="field" id="ed_welaya_copy_row" data-reveal>
        <span class="field__label">Educational state Copy</span>
        <label class="upload">
          <input type="file" id="ed_welaya_copy" name="ed_welaya_copy" accept="image/*,.pdf">
          <span class="upload__ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 16V5"></path><path d="m8 9 4-4 4 4"></path><path d="M5 16v2a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2"></path></svg></span>
          <span class="upload__body">
            <span class="upload__title">Upload copy</span>
            <span class="upload__meta" id="ed_welaya_copy_name">Photo or PDF</span>
          </span>
        </label>
      </div>

      <fieldset class="field">
        <legend class="field__label">In case of separation, student live with</legend>
        <div class="opts">
          <label class="opt"><input type="radio" name="divorce_living" value="There is no separation"><span class="opt__box"></span><span>There is no separation</span></label>
          <label class="opt"><input type="radio" name="divorce_living" value="Father"><span class="opt__box"></span><span>Father</span></label>
          <label class="opt"><input type="radio" name="divorce_living" value="Mother"><span class="opt__box"></span><span>Mother</span></label>
          <label class="opt"><input type="radio" name="divorce_living" value="Other" data-reveal-target="divorce_living_why_row"><span class="opt__box"></span><span>Other &amp; mention</span></label>
        </div>
      </fieldset>
      <label class="field" id="divorce_living_why_row" data-reveal>
        <span class="field__label">Please mention</span>
        <input class="input" id="divorce_living_why" name="divorce_living_why" type="text">
      </label>

      <fieldset class="field">
        <legend class="field__label">In case of death of parents</legend>
        <div class="opts">
          <label class="opt"><input type="radio" name="death" value="No death"><span class="opt__box"></span><span>No death</span></label>
          <label class="opt"><input type="radio" name="death" value="Father"><span class="opt__box"></span><span>Father</span></label>
          <label class="opt"><input type="radio" name="death" value="Mother"><span class="opt__box"></span><span>Mother</span></label>
          <label class="opt"><input type="radio" name="death" value="Both"><span class="opt__box"></span><span>Both</span></label>
        </div>
      </fieldset>

      <fieldset class="field">
        <legend class="field__label">Does the student suffer from any chronic disease? <span class="req">*</span></legend>
        <div class="opts">
          <label class="opt"><input type="radio" name="chronic_disease" value="0"><span class="opt__box"></span><span>No</span></label>
          <label class="opt"><input type="radio" name="chronic_disease" value="1" data-reveal-target="chronic_disease_div"><span class="opt__box"></span><span>Yes</span></label>
        </div>
      </fieldset>
      <label class="field" id="chronic_disease_div" data-reveal>
        <span class="field__label">Name of the disease <span class="req">*</span></span>
        <input class="input" id="chronic_disease_name" name="chronic_disease_name" type="text">
      </label>

      <fieldset class="field">
        <legend class="field__label">Does the student suffer from an allergy to any type of medication? <span class="req">*</span></legend>
        <div class="opts">
          <label class="opt"><input type="radio" name="allergy_to_med" value="0"><span class="opt__box"></span><span>No</span></label>
          <label class="opt"><input type="radio" name="allergy_to_med" value="1" data-reveal-target="allergy_to_med_div"><span class="opt__box"></span><span>Yes</span></label>
        </div>
      </fieldset>
      <label class="field" id="allergy_to_med_div" data-reveal>
        <span class="field__label">Name of the medicine <span class="req">*</span></span>
        <input class="input" id="allergy_to_med_name" name="allergy_to_med_name" type="text">
      </label>

      <label class="field"><span class="field__label">Any previous surgeries? <span class="req">*</span></span><input class="input" id="surgery" name="surgery" type="text" required></label>
      <label class="field"><span class="field__label">Emergency Number <span class="req">*</span></span><input class="input" id="emergency_phone" name="emergency_phone" type="tel" inputmode="numeric" required></label>
      <label class="field"><span class="field__label">Degree of Relation <span class="req">*</span></span><input class="input" id="emergency_relative" name="emergency_relative" type="text" placeholder="Grand Father" required></label>
    </div>

    <button class="btn btn--primary" type="submit" id="submit" name="submit">Save</button>
  </form>
  </main>
  
  
  <nav class="nav" aria-label="Home"  style="height: 90px">
    <a class="nav__item" href="parent-view.php">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <circle cx="9" cy="8" r="3.2"/>
        <path d="M3 19a6 6 0 0 1 12 0"/>
        <path d="M16.5 5.5a3.2 3.2 0 0 1 0 6"/>
        <path d="M18 13.5a6 6 0 0 1 3 5.5"/>
      </svg>
      <span>Students</span>
      <span class="nav__dot"></span>
    </a>

  <a class="nav__item  " href="parent-subjects.php?id=<?php echo $row_get_kid_info['id'];?>">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <rect x="3" y="4" width="18" height="18" rx="2"/>
        <line x1="16" y1="2" x2="16" y2="6"/>
        <line x1="8" y1="2" x2="8" y2="6"/>
        <line x1="3" y1="10" x2="21" y2="10"/>
      </svg>
      <span>Calendar</span>
      <span class="nav__dot"></span>
    </a>

    <a class="nav__fab" href="parent-kid.php?id=<?php echo $row_get_kid_info['id'];?>" aria-label="<?php echo $row_get_kid_info['fn_name'];?>">
      <img src="../../../../kids/<?php if($row_get_kid_info['picture']!=NULL && file_exists('../../../../kids/'.$row_get_kid_info['picture'])==1){echo $row_get_kid_info['picture'];}else{ echo "no-picture.png";} ;?>" alt="<?php echo $row_get_kid_info['fn_name'];?>">
    </a>
    
   <a class="nav__item" href="parent-timeline.php">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <path d="M4 5h13v14H5.5A1.5 1.5 0 0 1 4 17.5V5z"/>
        <path d="M17 9h2.5A1.5 1.5 0 0 1 21 10.5v7a1.5 1.5 0 0 1-1.5 1.5H17"/>
        <path d="M7.5 8.5h6M7.5 12h6M7.5 15.5h3.5"/>
      </svg>
      <span>Timeline</span>
      <span class="nav__dot"></span>
    </a>

    <a class="nav__item" href="parent-settings.php">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <circle cx="12" cy="12" r="3"/>
        <path d="M19.4 15a1.7 1.7 0 0 0 .3 1.9l.1.1a2 2 0 1 1-2.8 2.8l-.1-.1a1.7 1.7 0 0 0-1.9-.3 1.7 1.7 0 0 0-1 1.5V21a2 2 0 1 1-4 0v-.1a1.7 1.7 0 0 0-1.1-1.5 1.7 1.7 0 0 0-1.9.3l-.1.1a2 2 0 1 1-2.8-2.8l.1-.1a1.7 1.7 0 0 0 .3-1.9 1.7 1.7 0 0 0-1.5-1H3a2 2 0 1 1 0-4h.1a1.7 1.7 0 0 0 1.5-1.1 1.7 1.7 0 0 0-.3-1.9l-.1-.1a2 2 0 1 1 2.8-2.8l.1.1a1.7 1.7 0 0 0 1.9.3H9a1.7 1.7 0 0 0 1-1.5V3a2 2 0 1 1 4 0v.1a1.7 1.7 0 0 0 1 1.5 1.7 1.7 0 0 0 1.9-.3l.1-.1a2 2 0 1 1 2.8 2.8l-.1.1a1.7 1.7 0 0 0-.3 1.9V9a1.7 1.7 0 0 0 1.5 1H21a2 2 0 1 1 0 4h-.1a1.7 1.7 0 0 0-1.5 1z"/>
      </svg>
      <span>Settings</span>
      <span class="nav__dot"></span>
    </a>
  </nav>


</div>
<script>
/* follow-up fields appear only for the answers that need them */
(function () {
  var form = document.getElementById('kid-update-form');
  var groups = {};
  form.querySelectorAll('input[type="radio"][data-reveal-target]').forEach(function (r) {
    groups[r.name] = r.dataset.revealTarget;
  });
  function sync() {
    Object.keys(groups).forEach(function (name) {
      var box = document.getElementById(groups[name]);
      if (!box) return;
      var on = !!form.querySelector('input[name="' + name + '"][data-reveal-target]:checked');
      box.classList.toggle('is-on', on);
      if (!on) box.querySelectorAll('input').forEach(function (i) { i.value = ''; });
    });
  }
  form.addEventListener('change', function (e) { if (e.target.type === 'radio') sync(); });
  document.getElementById('ed_welaya_copy').addEventListener('change', function () {
    document.getElementById('ed_welaya_copy_name').textContent =
      this.files.length ? this.files[0].name : "Photo or PDF";
  });
  sync();
})();
</script>
<script src="../assets/js/app.js" defer></script>
</body>
</html>
