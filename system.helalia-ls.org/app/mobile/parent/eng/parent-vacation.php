<?php require_once('../../Connections/database.php');
      include("../../includes/logout.php");
      include("../../includes/access.php");
      include("../../includes/functions_eng.php");
      
      $kid_id = escape($_GET['kid']); 
      
      mysqli_select_db($database, $database_database,);
      $query_get_kids_list = "SELECT * FROM `kids_list` where `parent_id` = '{$row_get_user['id']}' and `kid_id` = '{$kid_id}'";
      $get_kids_list = mysqli_query($database, $query_get_kids_list) or die(mysqli_error($database));
      $row_get_kids_list_list = mysqli_fetch_assoc($get_kids_list);
      $totalRows_get_kids_list = mysqli_num_rows($get_kids_list);

      if($totalRows_get_kids_list==0){
          header("Location: parent-view.php");
          exit();
      }

 
        $query_get_kid_data = "SELECT * FROM `kids` where `id` = '{$kid_id}' ";
        $get_kid_data = mysqli_query($database, $query_get_kid_data) or die(mysqli_error($database));
        $row_get_kid_data = mysqli_fetch_assoc($get_kid_data);
        $totalRows_get_kid_data = mysqli_num_rows($get_kid_data);
 
      if($totalRows_get_kid_data==0){
          header("Location: parent-view.php");
          exit();
      }

 

 
 

if (isset($_POST['submit'])) {

          // Server-side date validation: end must be after start
          if (strtotime($_POST['end']) <= strtotime($_POST['start'])) {
              header("location: parent-vacation.php?kid=".$kid_id."&error=dates");
              exit();
          }
 
        

          $query_get_vacations = sprintf("SELECT * FROM `kids_vacations` where `kid_id`=%s AND `type`=%s AND `vacation_date`=%s AND `vacation_end`=%s AND `study_year`=%s AND `text`=%s  order by `id` desc limit 1",
                                  GetSQLValueString($database,$kid_id, "int"),
                                  GetSQLValueString($database,$_POST['type'], "int"),
                                  GetSQLValueString($database,strtotime($_POST['start']), "int"),
                                  GetSQLValueString($database,strtotime($_POST['end']), "int"),
                                  GetSQLValueString($database,$row_get_kid_data['study_year'], "int"),
                                  GetSQLValueString($database,$_POST['text'], "text"));
          $get_vacations = mysqli_query($database, $query_get_vacations) or die(mysqli_error($database));
          $row_get_vacations = mysqli_fetch_assoc($get_vacations);
          $totalRows_get_vacations = mysqli_num_rows($get_vacations);


              $image_name = null; 
              include("../../includes/sick_note.php");
              

               if (isset($_GET['date'])) { $date =  $_GET['date'];}else{ $date=NULL;}
                $days = floor((strtotime($_POST['end'])-strtotime($_POST['start']))/86400);
              
              $insertSQL = sprintf(
                  "INSERT INTO `kids_vacations` (`kid_id`, `type`, `vacation_date`, `vacation_end`, `study_year`, `text`, `sick_note`, `absence_id`,`date`, `days`) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                                  GetSQLValueString($database,$kid_id, "int"),
                                  GetSQLValueString($database,$_POST['type'], "int"),
                                  GetSQLValueString($database,strtotime($_POST['start']), "int"),
                                  GetSQLValueString($database,strtotime($_POST['end']), "int"),
                                  GetSQLValueString($database,$row_get_kid_data['study_year'], "int"),
                                  GetSQLValueString($database,$_POST['text'], "text"),
                                  GetSQLValueString($database,$image_name, "text"),
                                  GetSQLValueString($database,$date, "int"),
                                  GetSQLValueString($database,time(), "int"),
                                  GetSQLValueString($database,$days, "int")
              );
                if($totalRows_get_vacations<1 || $row_get_vacations['date']<(time()-5)){
                  mysqli_query($database, $insertSQL) or die(mysqli_error($database));
                }
              header("location: parent-summary.php?done&kid=".$kid_id);
              exit();
}







mysqli_select_db($database, $database_database,);
$query_get_kids_vacations = "SELECT * FROM `kids_vacations` where `id` = '{$kid_id}' and `study_year`='{$row_get_kid_data['study_year']}'  ";
$get_kids_vacations = mysqli_query($database, $query_get_kids_vacations) or die(mysqli_error($database));
$row_get_kids_list_vacations = mysqli_fetch_assoc($get_kids_vacations);
$totalRows_get_kids_vacations = mysqli_num_rows($get_kids_vacations);

mysqli_select_db($database, $database_database,);
$query_get_kids_list2 = "SELECT * FROM `kids-absence` where `kid_id`='{$kid_id}' and `confirm` = 1  ";
$get_kids_list2 = mysqli_query($database, $query_get_kids_list2) or die(mysqli_error($database));
$row_get_kids_list_list2 = mysqli_fetch_assoc($get_kids_list2);
$totalRows_get_kids_list2 = mysqli_num_rows($get_kids_list2);


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
<title>Absence request · Helalia</title>
<link rel="icon" href="../assets/img/logo-icon.png">
<link rel="apple-touch-icon" href="../assets/img/logo-icon.png">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap">
<link rel="stylesheet" href="../assets/css/helalia.css?v=18">
<script src="https://use.fontawesome.com/aac8068caf.js"></script> 
<script src="https://kit.fontawesome.com/94981c2780.js" crossorigin="anonymous"></script>
<style>
  .modal-overlay {
  position: fixed;
  inset: 0;
  background: rgba(0,0,0,0.5);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 9999;
  padding: 20px;
}
.modal-box {
  background: #fff;
  border-radius: 16px;
  padding: 28px 24px;
  max-width: 320px;
  width: 100%;
  text-align: center;
  box-shadow: 0 10px 40px rgba(0,0,0,0.2);
}
.modal-icon {
  color: #e63946;
  margin-bottom: 12px;
}
.modal-icon svg {
  width: 40px;
  height: 40px;
}
.modal-title {
  font-size: 18px;
  font-weight: 700;
  color: #112c5a;
  margin: 0 0 8px;
}
.modal-text {
  font-size: 14px;
  color: #555;
  margin: 0 0 20px;
}
</style> 
</head>
<body>
<div class="app">
  
<!-- File size warning modal -->
<div class="modal-overlay" id="file-size-modal" style="display:none;">
  <div class="modal-box">
    <div class="modal-icon">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <circle cx="12" cy="12" r="10"></circle>
        <line x1="12" y1="8" x2="12" y2="12"></line>
        <line x1="12" y1="16" x2="12.01" y2="16"></line>
      </svg>
    </div>
    <h3 class="modal-title">File too large</h3>
    <p class="modal-text" id="file-size-modal-text">This file is bigger than 10MB. Please choose a smaller file.</p>
    <button class="btn btn--primary" id="file-size-modal-close" type="button">OK</button>
  </div>
</div>

<!-- Date range warning modal -->
<div class="modal-overlay" id="date-range-modal" style="display:none;">
  <div class="modal-box">
    <div class="modal-icon">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <circle cx="12" cy="12" r="10"></circle>
        <line x1="12" y1="8" x2="12" y2="12"></line>
        <line x1="12" y1="16" x2="12.01" y2="16"></line>
      </svg>
    </div>
    <h3 class="modal-title">Invalid dates</h3>
    <p class="modal-text">The "To" date must be after the "From" date.</p>
    <button class="btn btn--primary" id="date-range-modal-close" type="button">OK</button>
  </div>
</div>

<header class="hero hero--tall">
    <div class="hero__row">
      <a class="back" href="parent-summary.php?kid=<?php echo $kid_id;?>" aria-label="Back">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <path d="M15 19 8 12l7-7"></path>
        </svg>
      </a>
        <h1 class="hero__title">Attendance </h1>
        <div class="bells">
      <a class="bell bell--alert" href="parent-alerts.php?kid=<?php echo $kid_id;?>" aria-label="Alerts">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <path d="M6 16V10a6 6 0 1 1 12 0v6l1.5 2H4.5L6 16z"></path>
          <path d="M10 20a2 2 0 0 0 4 0"></path>
        </svg>
         <?php alert($row_get_user['id'], $kid_id); ?>
      </a>
    </div>
  </div>  

  </header>
  
  
  
  
  <main class="page">


  <form action="parent-vacation.php?kid=<?php echo $kid_id;?>" method="POST" enctype="multipart/form-data" id="form" > 
     <div class="card stack">
            <label class="field">
              <span class="field__label">Request type</span>
                <select class="input" id="vac-type" name="type">
                    <option value="1">Sick</option>
                    <option value="2">Championship</option>
                    <option value="3">Travel</option> 
                    <option value="4">Other</option>
                </select>
            </label>

        <label class="field"><span class="field__label">From</span><input class="input datepicker" type="date" id="vac-from" name="start" required></label>
        <label class="field"><span class="field__label">To</span><input class="input datepicker" type="date" id="vac-to" name="end" required></label>
         <label class="field" style="text-align: center; padding-top:20px"> <span id="number_days" style="color: orangered; font-size:24px;">0 <span style="font-size: 20px;  color:#112c5a">Days</span></span> </label>
        <label class="field"><span class="field__label">Reason</span><textarea class="input" name="text" id="vac-reason" placeholder="Tell the school why…"></textarea></label>
       

         

        <div class="field">
          <span class="field__label">Attachment</span>
          <label class="upload">
            <input type="file" id="vac-file" accept="image/*,.pdf" name="sick_note"> 
            <span class="upload__ico">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <path d="M12 16V5"></path>
              <path d="m8 9 4-4 4 4"></path>
              <path d="M5 16v2a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2"></path>
            </svg>
          </span>
            <span class="upload__body">
              <span class="upload__title">Upload  attachment</span>
              <span class="upload__meta" id="vac-file-name">Photo or PDF · Max 10MB</span>
            </span>
          </label>
        </div>

 
         <button class="btn btn--primary " name="submit" type="submit"><i class="fa fa-paper-plane-o" aria-hidden="true"></i> Send request <i class="fa fa-spinner fa-spin fa-fw" style="display: none;" id="loading"></i></button>
      </div>
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

  <a class="nav__item  " href="parent-calendar.php?kid=<?php echo (int) $kid_id; ?>">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <rect x="3" y="4" width="18" height="18" rx="2"/>
        <line x1="16" y1="2" x2="16" y2="6"/>
        <line x1="8" y1="2" x2="8" y2="6"/>
        <line x1="3" y1="10" x2="21" y2="10"/>
      </svg>
      <span>Calendar</span>
      <span class="nav__dot"></span>
    </a>

    <a class="nav__fab" href="parent-kid.php?id=<?php echo $row_get_kid_data['id'];?>" aria-label="<?php echo $row_get_kid_data['fn_name'];?>">
      <img src="../../../../kids/<?php if($row_get_kid_data['picture']!=NULL && file_exists('../../../../kids/'.$row_get_kid_data['picture'])==1){echo $row_get_kid_data['picture'];}else{ echo "no-picture.png";} ;?>" alt="<?php echo $row_get_kid_data['fn_name'];?>">
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
        <path d="M19.4 15a1.7 1.7 0 0 0 .3 1.9l.1.1a2 2 0 1 1-2.8 2.8l-.1-.1a1.7 1.7 0 0 0-1.9-.3 1.7 1.7 0 0 0-1 1.5V21a2 2 0 1 1-4 0v-.1a1.7 1.7 0 0 0-1.1-1.5 1.7 1.7 0 0 0-1.9.3l-.1.1a2 2 0 1 1-2.8-2.8l.1-.1a1.7 1.7 0 0 0 .3-1.9 1.7 1.7 0 0 0-1.5-1H3a2 2 0 1 1 0-4h.1a1.7 1.7 0 0 0 1.5-1.1 1.7 1.7 0 0 0-.3-1.9l-.1-.1a2 2 0 1 1 2.8-2.8l.1.1a1.7 1.7 0 0 0 1.9.3H9a1.7 1.7 0 0 0 1-1.5V3a2 2 0 1 1 4 0v.1a1.7 1.7 0 0 0 1 1.5 1.7 1.7 0 0 0 1.9-.3l.1-.1a2 2 0 1 1 2.8 2.8l-.1.1a1.7 1.7 0 0 0-.3 1.9V9a1.7 1.7 0 0 0 1.5 1H21a2 2 0 1 1 0 4h-.1a1.7 1.7 0 0 0-1.5 1z"/>
      </svg>
      <span>Settings</span>
      <span class="nav__dot"></span>
    </a>
  </nav>



</div>
 
<script src="../assets/js/app.js?v=65" defer></script>
<script src="https://code.jquery.com/jquery-4.0.0.min.js" integrity="sha256-OaVG6prZf4v69dPg6PhVattBXkcOWQB62pdZ3ORyrao=" crossorigin="anonymous"></script>

<script>
const MAX_FILE_SIZE = 10 * 1024 * 1024; // 10MB in bytes

function showSizeModal(fileName) {
  document.getElementById('file-size-modal-text').textContent =
    fileName ? `"${fileName}" is bigger than 10MB. Please choose a smaller file.` : 'This file is bigger than 10MB. Please choose a smaller file.';
  document.getElementById('file-size-modal').style.display = 'flex';
}

document.getElementById('file-size-modal-close').addEventListener('click', function () {
  document.getElementById('file-size-modal').style.display = 'none';
});

function showDateModal() {
  document.getElementById('date-range-modal').style.display = 'flex';
}

document.getElementById('date-range-modal-close').addEventListener('click', function () {
  document.getElementById('date-range-modal').style.display = 'none';
});

document.getElementById('vac-file').addEventListener('change', function () {
  var n = this.files.length;
  var oversized = null;

  for (var i = 0; i < this.files.length; i++) {
    if (this.files[i].size > MAX_FILE_SIZE) {
      oversized = this.files[i];
      break;
    }
  }

  if (oversized) {
    showSizeModal(oversized.name);
    this.value = ''; // clear the input so it can't be submitted
    document.getElementById('vac-file-name').textContent = 'Photo or PDF · Max 10MB';
    return;
  }

  document.getElementById('vac-file-name').textContent =
    n === 0 ? 'Photo or PDF · Max 10MB' : (n === 1 ? this.files[0].name : n + ' files selected');
});
 



$(document).ready(function() {

   $("#form").submit(function(e) {
        var fileInput = document.getElementById('vac-file');
        var MAX_FILE_SIZE = 10 * 1024 * 1024;

        for (var i = 0; i < fileInput.files.length; i++) {
            if (fileInput.files[i].size > MAX_FILE_SIZE) {
                e.preventDefault();
                showSizeModal(fileInput.files[i].name);
                return false;
            }
        }

        var start = $("#vac-from").val();
        var end = $("#vac-to").val();
        if (start && end && new Date(end) <= new Date(start)) {
            e.preventDefault();
            showDateModal();
            return false;
        }

        $("#loading").fadeIn();
    });

    function updateDays() {
        var start = $("#vac-from").val();
        var end = $("#vac-to").val();

        if (!start || !end) {
            $("#number_days").html('0 <span style="font-size: 20px; color:#112c5a">Days</span>');
            return;
        }

        $.post("get_days.php", {
                start: start,
                end: end
            },
            function(Date, status) {
                $("#number_days").html(Date);
            });
    }

    $("#vac-from").change(function() {
        var start = $(this).val();

        // Clear "To" every time "From" is reselected, forcing a fresh pick
        $("#vac-to").val('');
        $("#number_days").html('0 <span style="font-size: 20px; color:#112c5a">Days</span>');

        // Prevent picking an "end" date before or equal to the new "start"
        $("#vac-to").attr('min', start);
    });

    $("#vac-to").change(function() {
        var start = $("#vac-from").val();
        var end = $(this).val();

        if (start && end && new Date(end) <= new Date(start)) {
            $(this).val(''); // clear invalid selection, forces reselect
            $("#number_days").html('0 <span style="font-size: 20px; color:#112c5a">Days</span>');
            showDateModal();
            return;
        }

        updateDays();
    });

});
</script>
        
</body>
</html>