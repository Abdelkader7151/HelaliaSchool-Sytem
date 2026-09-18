<?php require_once('../../Connections/database.php');
      include("../../includes/logout.php");
      include("../../includes/access.php");
      include("../../includes/functions_arb.php");
      
      $kid_id = escape($_GET['kid']); 
      
      mysqli_select_db($database, $database_database,);
      $query_get_kids_list = "SELECT * FROM `kids_list` where `parent_id` = '{$row_get_user['id']}' and `kid_id` = '{$kid_id}'";
      $get_kids_list = mysqli_query($database, $query_get_kids_list) or die(mysqli_error($database));
      $row_get_kids_list = mysqli_fetch_assoc($get_kids_list);
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

      
      



 ?><!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<meta name="theme-color" content="#112c5a">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="apple-mobile-web-app-title" content="Helalia">
<meta name="format-detection" content="telephone=no">
<title>التقويم · هلاليا</title>
<link rel="icon" href="../assets/img/logo-icon.png">
<link rel="apple-touch-icon" href="../assets/img/logo-icon.png">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap">
<link rel="stylesheet" href="../assets/css/helalia.css?v=18">
</head>
<body>
<div class="app">


 
  <header class="hero hero--tall">
    <div class="hero__row">
        <a class="back" href="parent-kid.php?id=<?php echo $row_get_kid_data['id'];?>" aria-label="رجوع">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <path d="M15 19 8 12l7-7"/></svg>
        </a>
         <h1 class="hero__title">التقويم</h1>
         <div class="bells">
          <a class="bell bell--alert" href="parent-alerts.php?kid=<?php echo $kid_id;?>" aria-label="تنبيهات">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <path d="M6 16V10a6 6 0 1 1 12 0v6l1.5 2H4.5L6 16z"></path>
              <path d="M10 20a2 2 0 0 0 4 0"></path>
            </svg>
            <?php alert($row_get_user['id'], $kid_id); ?>
          </a>
        </div>
      </div> 
       <p class="hero__lede">فعاليات المدرسة لعام <?php echo date("Y",time());?>.</p>
    </header>
  

 
  
  
  
   <main class="page">
      <div class="calnav">
        <button class="calnav__btn" id="cal-prev" type="button" aria-label="Previous month">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M15 19 8 12l7-7"></path>
          </svg>
        </button>
        <p class="calnav__label" id="cal-label"><?php echo date("M Y",time());?></p>
        <button class="calnav__btn" id="cal-next" type="button" aria-label="Next month">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="m9 5 7 7-7 7"></path>
          </svg>
        </button>
      </div>
      <div class="ymon ymon--single">
        <div class="ymon__grid" id="cal-grid"></div>
      </div>
      <p class="ykey"><span class="ykey__dot"></span>يتم تمييز الأيام التي تشهد حدثاً ما.</p>
    
      <div class="sec">
        <h2 class="sec__title">الفعاليات</h2>
      </div>
      <div class="stack stack--sm" id="cal-list"></div>
  </main>
    



    <nav class="nav" aria-label="الرئيسية"  style="height: 90px">

      <a class="nav__item" href="parent-view.php">
         <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <circle cx="9" cy="8" r="3.2"/>
          <path d="M3 19a6 6 0 0 1 12 0"/>
          <path d="M16.5 5.5a3.2 3.2 0 0 1 0 6"/>
          <path d="M18 13.5a6 6 0 0 1 3 5.5"/>
        </svg>
        <span>الطلاب</span>
        <span class="nav__dot"></span>
      </a>

       <a class="nav__item  " href="parent-calendar.php?kid=<?php echo $row_get_kid_data['id'];?>">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <rect x="3" y="4" width="18" height="18" rx="2"/>
          <line x1="16" y1="2" x2="16" y2="6"/>
          <line x1="8" y1="2" x2="8" y2="6"/>
          <line x1="3" y1="10" x2="21" y2="10"/>
        </svg>
        <span>التقويم</span>
        <span class="nav__dot"></span>
      </a>

      <a class="nav__fab" href="parent-kid.php?id=<?php echo $row_get_kid_data['id'];?>" aria-label="<?php echo $row_get_kid_data['fn_name'];?>">
        <img src="../../../../kids/<?php if($row_get_kid_data['picture']!=NULL && file_exists('../../../../kids/'.$row_get_kid_data['picture'])==1){echo $row_get_kid_data['picture'];}else{ echo "no-picture.png";} ;?>" alt="<?php echo $row_get_kid_data['fn_name'];?>">
      </a>

      <a class="nav__item" href="parent-timeline.php">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <path d="M4 5h13v14H5.5A1.5 1.5 0 0 1 4 17.5V5z"></path>
          <path d="M17 9h2.5A1.5 1.5 0 0 1 21 10.5v7a1.5 1.5 0 0 1-1.5 1.5H17"></path>
          <path d="M7.5 8.5h6M7.5 12h6M7.5 15.5h3.5"></path>
        </svg>
        <span>الأخبار</span>
        <span class="nav__dot"></span>
      </a>

      <a class="nav__item" href="parent-settings.php">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <circle cx="12" cy="12" r="3"/>
          <path d="M19.4 15a1.7 1.7 0 0 0 .3 1.9l.1.1a2 2 0 1 1-2.8 2.8l-.1-.1a1.7 1.7 0 0 0-1.9-.3 1.7 1.7 0 0 0-1 1.5V21a2 2 0 1 1-4 0v-.1a1.7 1.7 0 0 0-1.1-1.5 1.7 1.7 0 0 0-1.9.3l-.1.1a2 2 0 1 1-2.8-2.8l.1-.1a1.7 1.7 0 0 0 .3-1.9 1.7 1.7 0 0 0-1.5-1H3a2 2 0 1 1 0-4h.1a1.7 1.7 0 0 0 1.5-1.1 1.7 1.7 0 0 0-.3-1.9l-.1-.1a2 2 0 1 1 2.8-2.8l.1.1a1.7 1.7 0 0 0 1.9.3H9a1.7 1.7 0 0 0 1-1.5V3a2 2 0 1 1 4 0v.1a1.7 1.7 0 0 0 1 1.5 1.7 1.7 0 0 0 1.9-.3l.1-.1a2 2 0 1 1 2.8 2.8l-.1.1a1.7 1.7 0 0 0-.3 1.9V9a1.7 1.7 0 0 0 1.5 1H21a2 2 0 1 1 0 4h-.1a1.7 1.7 0 0 0-1.5 1z"/>
        </svg>
        <span>الإعدادات</span>
        <span class="nav__dot"></span>
      </a>

  </nav>


  <div class="modal" id="ev-modal" role="dialog" aria-modal="true" aria-labelledby="ev-title">
    <div class="modal__card">
      <p class="modal__date" id="ev-date"></p>
      <p class="modal__title" id="ev-title"></p>
      <div class="modal__meta" id="ev-meta"></div>
      <button class="btn btn--quiet modal__close" id="ev-close" type="button">أغلق</button>
    </div>
  </div>
</div>

<script>
(function () {
  var MONTHS = ['يناير', 'فبراير', 'مارس', 'أبريل', 'مايو', 'يونيو', 'يوليو', 'أغسطس', 'سبتمبر', 'أكتوبر', 'نوفمبر', 'ديسمبر'];
  var DOW = ['S','M','T','W','T','F','S'];
  var view = new Date();
  var studyYear = <?php echo json_encode($row_get_kid_data['study_year']); ?>;
  var grid = document.getElementById('cal-grid');
  var label = document.getElementById('cal-label');
  var list = document.getElementById('cal-list');
  var modal = document.getElementById('ev-modal');

  // Cache events per "year-month" so switching back and forth
  // between months already visited doesn't refetch.
  var cache = {};
  // requestId guards against a slow response landing after the
  // user has already clicked to a different month.
  var requestId = 0;

  function key(y, m, d) {
    return y + '-' + String(m + 1).padStart(2, '0') + '-' + String(d).padStart(2, '0');
  }

  function cacheKey(y, m) {
    return y + '-' + (m + 1) + '-' + studyYear;
  }

  function fetchEvents(y, m, callback) {
    var ck = cacheKey(y, m);
    if (cache[ck]) {
      callback(cache[ck]);
      return;
    }
    var thisRequest = ++requestId;
    fetch('ajax-get-calendar-events.php?year=' + y + '&month=' + (m + 1) + '&study_year=' + encodeURIComponent(studyYear), {
      credentials: 'same-origin'
    })
      .then(function (res) { return res.json(); })
      .then(function (data) {
        if (thisRequest !== requestId) return; // a newer request superseded this one
        cache[ck] = data || { events: {}, days: {} };
        callback(cache[ck]);
      })
      .catch(function () {
        if (thisRequest !== requestId) return;
        cache[ck] = { events: {}, days: {} };
        callback(cache[ck]);
      });
  }

  function renderGrid(y, m, DAYS) {
    var html = DOW.map(function (d) { return '<span class="ymon__dow">' + d + '</span>'; }).join('');
    var first = new Date(y, m, 1).getDay();
    var days = new Date(y, m + 1, 0).getDate();
    for (var i = 0; i < first; i++) html += '<span class="yday yday--pad"></span>';
    for (var d = 1; d <= days; d++) {
      var k = key(y, m, d);
      var anchor = DAYS[k];
      html += anchor
        ? '<button class="yday yday--event" type="button" data-date="' + anchor + '">' + d + '</button>'
        : '<span class="yday">' + d + '</span>';
    }
    grid.innerHTML = html;
  }

  function renderList(EVENTS) {
    var eventKeys = Object.keys(EVENTS).sort();
    var rows = '';
    eventKeys.forEach(function (k) {
      var ev = EVENTS[k];
      var parts = k.split('-'); // [yyyy, mm, dd]
      var mIdx = Number(parts[1]) - 1;
      var dd = Number(parts[2]);
      rows += '<div class="cal cal--fold ' + ev[2] + '" style="align-items:flex-start">' +
        '<div class="cal__date"><span class="cal__day">' + dd + '</span><span class="cal__mon">' + MONTHS[mIdx].slice(0, 3) + '</span></div>' +
        '<div class="grow"><p class="row__title">' + ev[0] + '</p>' +
        '<div class="cal__more" style="margin-right:-50px">' + ev[1] + '</div></div>' +
        '<span class="cal__chev">\u203a</span>' +
        '</div>';
    });
    list.innerHTML = rows || '<p class="tiny">No events this month.</p>';

    list.querySelectorAll('.cal--fold').forEach(function (card) {
      card.addEventListener('click', function () { card.classList.toggle('is-open'); });
    });
  }

  function bindDayClicks(EVENTS) {
    grid.querySelectorAll('.yday--event').forEach(function (btn) {
      btn.addEventListener('click', function () {
        var k = btn.getAttribute('data-date'); // anchor key of the event this day belongs to
        var ev = EVENTS[k];
        if (!ev) return;
        var parts = k.split('-');
        document.getElementById('ev-date').textContent = Number(parts[2]) + ' ' + MONTHS[Number(parts[1]) - 1] + ' ' + parts[0];
        document.getElementById('ev-title').textContent = ev[3];
        document.getElementById('ev-meta').innerHTML = ev[1]; // details include a banner <img> + date range
        modal.classList.add('is-open');
      });
    });
  }

  function render() {
    var y = view.getFullYear(), m = view.getMonth();
    label.textContent = MONTHS[m] + ' ' + y;

    // Show empty grid + loading state immediately, then fill in once data arrives.
    grid.innerHTML = DOW.map(function (d) { return '<span class="ymon__dow">' + d + '</span>'; }).join('');
    list.innerHTML = '<p class="tiny">Loading…</p>';

    fetchEvents(y, m, function (data) {
      // If the user has already navigated to another month, drop this result.
      if (view.getFullYear() !== y || view.getMonth() !== m) return;

      var EVENTS = data.events || {};
      var DAYS = data.days || {};

      renderGrid(y, m, DAYS);
      renderList(EVENTS);
      bindDayClicks(EVENTS);
    });
  }

  function closeModal() { modal.classList.remove('is-open'); }
  document.getElementById('ev-close').addEventListener('click', closeModal);
  modal.addEventListener('click', function (e) { if (e.target === modal) closeModal(); });
  document.addEventListener('keydown', function (e) { if (e.key === 'Escape') closeModal(); });

  document.getElementById('cal-prev').addEventListener('click', function () {
    view = new Date(view.getFullYear(), view.getMonth() - 1, 1);
    render();
  });
  document.getElementById('cal-next').addEventListener('click', function () {
    view = new Date(view.getFullYear(), view.getMonth() + 1, 1);
    render();
  });
  render();
})();
</script>
<script src="../assets/js/app.js?v=65" defer></script>
</body>
</html>
