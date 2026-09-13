<?php
if (!isset($S)) {
    $S = array();
}

$todayStart = strtotime(date('m/d/Y', time()));
$todayEnd = $todayStart + 86400;

if (isset($staffLang) && $staffLang === 'arb') {
    $S = array(
        'preview' => 'بيانات تجريبية — بدون قاعدة بيانات',
        'select_year' => 'اختر السنة',
        'select_class' => 'اختر الفصل',
        'select_group' => 'اختر المجموعة',
        'message' => 'الرسالة',
        'send' => 'إرسال',
        'sent' => 'تم إرسال الرسالة بنجاح',
        'save' => 'حفظ',
        'saved' => 'تم الحفظ',
        'submit' => 'تسجيل',
        'confirm' => 'تأكيد',
        'accept' => 'قبول',
        'delete' => 'حذف',
        'empty' => 'لا توجد بيانات',
        'students' => 'قائمة الطلبة',
        'marked' => 'المسجلون اليوم',
        'pending' => 'قيد الانتظار',
        'replied' => 'تم الرد',
        'status' => 'الحالة',
        'date' => 'التاريخ',
        'parent' => 'ولي الأمر',
        'name' => 'الاسم',
        'student' => 'الطالب',
        'grade' => 'السنة',
        'class' => 'الفصل',
        'subject' => 'المادة',
        'question' => 'السؤال',
        'reply' => 'الرد',
        'teacher' => 'المعلم',
        'director' => 'الموجه',
        'respond' => 'وقت الرد',
        'unreplied' => 'بانتظار الرد',
        'replied_list' => 'الأسئلة المجاب عنها',
        'event_info' => 'بيانات الفعالية',
        'start' => 'البداية',
        'end' => 'النهاية',
        'year' => 'السنة',
        'meetings' => 'الاجتماعات',
        'no_meetings' => 'لا توجد اجتماعات',
        'booked' => 'محجوز',
        'open' => 'متاح',
        'at' => 'الساعة',
        'job' => 'الوظيفة',
        'type' => 'النوع',
        'days' => 'الأيام',
        'hours' => 'الساعات',
        'desc' => 'وصف مختصر',
        'attached' => 'مرفق',
        'vac_start' => 'بداية الإجازة',
        'vac_end' => 'نهاية الإجازة (يوم العودة)',
        'excuse_date' => 'تاريخ الإذن',
        'excuse_start' => 'بداية الإذن',
        'excuse_end' => 'نهاية الإذن',
        'st_pending' => 'قيد الانتظار',
        'st_accept' => 'قبول',
        'st_reject' => 'رفض',
        'st_cancel' => 'إلغاء',
        'collect_title' => 'حصر الغياب',
        'confirm_title' => 'تأكيد الغياب',
        'accept_title' => 'قبول الغياب',
        'notify_title' => 'إشعار الطلاب',
        'groups_title' => 'غياب المجموعات',
        'direct_title' => 'أسئلة أولياء الأمور المباشرة',
        'reply_title' => 'الرد على أسئلة أولياء الأمور',
        'ask_title' => 'سؤال المعلم',
        'events_title' => 'الفعاليات',
        'appt_title' => 'المواعيد',
        'vac_title' => 'إجازات الموظفين',
        'exc_title' => 'أذونات الموظفين',
        'view_vac' => 'عرض الإجازة',
        'view_exc' => 'عرض الإذن',
        'absence_note' => 'يرجى العلم بتغيب الطالب اليوم الموافق ',
        'group_note' => 'يرجى العلم بتغيب الطالب عن المجموعة اليوم الموافق ',
        'years' => array(
            0 => 'حضانة', 1 => 'كي جي 1', 2 => 'كي جي 2',
            3 => 'جونيور 1', 4 => 'جونيور 2', 5 => 'جونيور 3',
            6 => 'جونيور 4', 7 => 'جونيور 5', 8 => 'جونيور 6',
            9 => 'ميدل 1', 10 => 'ميدل 2', 11 => 'ميدل 3',
            12 => 'سينيور 1', 13 => 'سينيور 2', 14 => 'سينيور 3', 15 => 'عام',
        ),
        'stages' => array(
            0 => 'حضانة', 1 => 'كي جي', 2 => 'ابتدائي صغير',
            3 => 'ابتدائي كبير', 4 => 'إعدادي', 5 => 'ثانوي',
        ),
        'vac_types' => array(
            1 => 'اعتيادي', 2 => 'طارئ', 3 => 'مرضي', 4 => 'وضع',
            5 => 'استثنائي', 6 => 'زواج', 7 => 'وفاة', 8 => 'بدون راتب',
        ),
        'subjects' => array(
            10001 => 'الإدارة', 10002 => 'رئيس القسم', 10003 => 'نائب رئيس القسم',
            10004 => 'سكرتارية', 10005 => 'الطبيب', 10006 => 'المعالج', 10007 => 'المشرف',
            1 => 'لغة إنجليزية', 2 => 'رياضيات', 3 => 'علوم',
        ),
    );
} else {
    $S = array(
        'preview' => 'Preview dummy data — no database',
        'select_year' => 'Select year',
        'select_class' => 'Select class',
        'select_group' => 'Select group',
        'message' => 'Message',
        'send' => 'Send',
        'sent' => 'Message sent successfully',
        'save' => 'Save',
        'saved' => 'Saved',
        'submit' => 'Submit',
        'confirm' => 'Confirm',
        'accept' => 'Accept',
        'delete' => 'Delete',
        'empty' => 'Nothing here yet',
        'students' => 'Students list',
        'marked' => 'Marked today',
        'pending' => 'Pending',
        'replied' => 'Replied',
        'status' => 'Status',
        'date' => 'Date',
        'parent' => 'Parent',
        'name' => 'Name',
        'student' => 'Student',
        'grade' => 'Grade',
        'class' => 'Class',
        'subject' => 'Subject',
        'question' => 'Question',
        'reply' => 'Reply',
        'teacher' => 'Teacher',
        'director' => 'Director',
        'respond' => 'Respond time',
        'unreplied' => 'Waiting for reply',
        'replied_list' => 'Replied questions',
        'event_info' => 'Event information',
        'start' => 'Start',
        'end' => 'Ends',
        'year' => 'Year',
        'meetings' => 'Meetings',
        'no_meetings' => 'No meeting available',
        'booked' => 'Booked',
        'open' => 'Open',
        'at' => 'At',
        'job' => 'Job',
        'type' => 'Type',
        'days' => 'Days',
        'hours' => 'Hours',
        'desc' => 'Brief description',
        'attached' => 'Attached',
        'vac_start' => 'Vacation start date',
        'vac_end' => 'Vacation end date (return day)',
        'excuse_date' => 'Excuse date',
        'excuse_start' => 'Excuse start',
        'excuse_end' => 'Excuse ends',
        'st_pending' => 'Pending',
        'st_accept' => 'Accept',
        'st_reject' => 'Reject',
        'st_cancel' => 'Cancel',
        'collect_title' => 'Collect absence',
        'confirm_title' => 'Confirm absence',
        'accept_title' => 'Accept absence',
        'notify_title' => 'Student notification',
        'groups_title' => 'Collect group absence',
        'direct_title' => 'Direct parent questions',
        'reply_title' => 'Reply to parent questions',
        'ask_title' => 'Ask the teacher',
        'events_title' => 'Events',
        'appt_title' => 'Meetings',
        'vac_title' => 'Employee vacations',
        'exc_title' => 'Employee excuses',
        'view_vac' => 'View vacation',
        'view_exc' => 'View excuse',
        'absence_note' => 'Please note the student is absent today ',
        'group_note' => 'Please note the student is absent from the group today ',
        'years' => array(
            0 => 'Preschool', 1 => 'KG1', 2 => 'KG2',
            3 => 'Junior One', 4 => 'Junior Two', 5 => 'Junior Three',
            6 => 'Junior Four', 7 => 'Junior Five', 8 => 'Junior Six',
            9 => 'Middle One', 10 => 'Middle Two', 11 => 'Middle Three',
            12 => 'Senior One', 13 => 'Senior Two', 14 => 'Senior Three', 15 => 'General',
        ),
        'stages' => array(
            0 => 'Preschool', 1 => 'KG', 2 => 'Primary Small',
            3 => 'Primary Big', 4 => 'Preparatory', 5 => 'Secondary',
        ),
        'vac_types' => array(
            1 => 'Regular', 2 => 'Urgent', 3 => 'Sick', 4 => 'Pregnancy',
            5 => 'Exceptional', 6 => 'Marriage', 7 => 'Death', 8 => 'With no salary',
        ),
        'subjects' => array(
            10001 => 'Administration', 10002 => 'Head of department', 10003 => 'Vice head',
            10004 => 'Secretary', 10005 => 'Doctor', 10006 => 'Therapist', 10007 => 'Supervisor',
            1 => 'English', 2 => 'Math', 3 => 'Science',
        ),
    );
}

function svc_int($key, $default = 0)
{
    return isset($_GET[$key]) ? (int) $_GET[$key] : $default;
}

function svc_flash($msg = null)
{
    if ($msg !== null) {
        $_SESSION['staff_flash'] = $msg;
        return '';
    }
    if (!empty($_SESSION['staff_flash'])) {
        $m = $_SESSION['staff_flash'];
        unset($_SESSION['staff_flash']);
        return $m;
    }
    return '';
}

function svc_go($url)
{
    header('Location: ' . $url, true, 303);
    exit;
}

function svc_sql($value, $type = 'int')
{
    global $database;
    if (function_exists('GetSQLValueString') && !empty($database)) {
        return GetSQLValueString($database, $value, $type);
    }
    if ($type === 'text') {
        $v = addslashes((string) $value);
        return ($value === '' || $value === null) ? 'NULL' : "'" . $v . "'";
    }
    if ($value === '' || $value === null) {
        return 'NULL';
    }
    return (string) intval($value);
}

function svc_q($sql)
{
    global $database, $database_database;
    if (empty($database)) {
        return false;
    }
    mysqli_select_db($database, $database_database);
    return mysqli_query($database, $sql);
}

function svc_all($sql)
{
    $res = svc_q($sql);
    $out = array();
    if ($res) {
        while ($row = mysqli_fetch_assoc($res)) {
            $out[] = $row;
        }
    }
    return $out;
}

function svc_one($sql)
{
    $rows = svc_all($sql);
    return $rows ? $rows[0] : null;
}

function svc_can($fn)
{
    global $staffPreview, $empId;
    if ($staffPreview) {
        return true;
    }
    return function_exists($fn) && $fn($empId) == 1;
}

function svc_year($id)
{
    global $S;
    $id = (int) $id;
    return isset($S['years'][$id]) ? $S['years'][$id] : ('#' . $id);
}

function svc_stage($id)
{
    global $S;
    $id = (int) $id;
    return isset($S['stages'][$id]) ? $S['stages'][$id] : ('#' . $id);
}

function svc_stage_where($id)
{
    $id = (int) $id;
    if ($id === 0) {
        return '`study_year` = 0';
    }
    if ($id === 1) {
        return '(`study_year` = 1 OR `study_year` = 2)';
    }
    if ($id === 2) {
        return '(`study_year` = 3 OR `study_year` = 4 OR `study_year` = 5)';
    }
    if ($id === 3) {
        return '(`study_year` = 6 OR `study_year` = 7 OR `study_year` = 8)';
    }
    if ($id === 4) {
        return '(`study_year` = 9 OR `study_year` = 10 OR `study_year` = 11)';
    }
    return '(`study_year` = 12 OR `study_year` = 13 OR `study_year` = 14)';
}

function svc_stage_years($id)
{
    $map = array(
        0 => array(0),
        1 => array(1, 2),
        2 => array(3, 4, 5),
        3 => array(6, 7, 8),
        4 => array(9, 10, 11),
        5 => array(12, 13, 14),
    );
    return isset($map[$id]) ? $map[$id] : array();
}

function svc_subject($id)
{
    global $S, $staffPreview;
    $id = (int) $id;
    if (!$staffPreview && function_exists('question_direct')) {
        $n = trim((string) question_direct($id));
        if ($n !== '') {
            return $n;
        }
    }
    if (!$staffPreview && function_exists('subject_name')) {
        $n = trim((string) subject_name($id));
        if ($n !== '') {
            return $n;
        }
    }
    return isset($S['subjects'][$id]) ? $S['subjects'][$id] : ('#' . $id);
}

function svc_class_name($id)
{
    global $staffPreview, $staffLang;
    $id = (int) $id;
    if (!$staffPreview && function_exists('class_name')) {
        return trim((string) class_name($id));
    }
    foreach (staff_demo()['classes'] as $c) {
        if ((int) $c['id'] === $id) {
            return ($staffLang === 'arb') ? $c['name_ar'] : $c['name_en'];
        }
    }
    return (string) $id;
}

function svc_kid_name($id)
{
    global $staffPreview, $staffLang;
    $id = (int) $id;
    if (!$staffPreview && function_exists('kid_name')) {
        return trim((string) kid_name($id));
    }
    foreach (staff_demo()['kids'] as $k) {
        if ((int) $k['id'] === $id) {
            return ($staffLang === 'arb') ? $k['name_ar'] : $k['name_en'];
        }
    }
    return '#' . $id;
}

function svc_emp_name($id)
{
    global $staffPreview, $staffLang, $displayName;
    $id = (int) $id;
    if (!$staffPreview && function_exists('emp_name')) {
        return trim((string) emp_name($id));
    }
    if ($id === 0 || $id === (int) ($GLOBALS['empId'] ?? 0)) {
        return $displayName;
    }
    foreach (staff_demo()['emps'] as $e) {
        if ((int) $e['id'] === $id) {
            return ($staffLang === 'arb') ? $e['name_ar'] : $e['name_en'];
        }
    }
    return '#' . $id;
}

function svc_job_name($empId)
{
    global $staffPreview, $staffLang;
    $empId = (int) $empId;
    if (!$staffPreview && function_exists('job_name') && function_exists('empjob')) {
        return trim((string) job_name(empjob($empId)));
    }
    foreach (staff_demo()['emps'] as $e) {
        if ((int) $e['id'] === $empId) {
            return ($staffLang === 'arb') ? $e['job_ar'] : $e['job_en'];
        }
    }
    return '';
}

function svc_parent_name($id)
{
    global $staffPreview, $staffLang;
    $id = (int) $id;
    if (!$staffPreview && function_exists('app_name')) {
        return trim((string) app_name($id));
    }
    foreach (staff_demo()['parents'] as $p) {
        if ((int) $p['id'] === $id) {
            return ($staffLang === 'arb') ? $p['name_ar'] : $p['name_en'];
        }
    }
    return '#' . $id;
}

function svc_vac_type($id)
{
    global $S, $staffPreview;
    if (!$staffPreview && function_exists('vac_type')) {
        return trim((string) vac_type($id));
    }
    return isset($S['vac_types'][(int) $id]) ? $S['vac_types'][(int) $id] : '';
}

function svc_vac_days($start, $end)
{
    if (function_exists('vac_days')) {
        return vac_days($start, $end);
    }
    $days = (int) round(($end - $start) / 86400, 0);
    return $days . ' ' . ($days === 1 ? 'day' : 'days');
}

function svc_status_label($n)
{
    global $S;
    $n = (int) $n;
    if ($n === 1) {
        return $S['st_accept'];
    }
    if ($n === 2) {
        return $S['st_reject'];
    }
    if ($n === 3) {
        return $S['st_cancel'];
    }
    return $S['st_pending'];
}

function staff_demo()
{
    global $todayStart, $staffLang;
    if (!isset($_SESSION['staff_demo'])) {
        $t = $todayStart;
        $_SESSION['staff_demo'] = array(
            'classes' => array(
                array('id' => 11, 'study_year' => 3, 'name_en' => 'Class A', 'name_ar' => 'فصل أ'),
                array('id' => 12, 'study_year' => 3, 'name_en' => 'Class B', 'name_ar' => 'فصل ب'),
                array('id' => 21, 'study_year' => 4, 'name_en' => 'Class A', 'name_ar' => 'فصل أ'),
                array('id' => 31, 'study_year' => 9, 'name_en' => 'Class C', 'name_ar' => 'فصل ج'),
            ),
            'kids' => array(
                array('id' => 101, 'study_year' => 3, 'class' => 11, 'name_en' => 'Youssef Hassan', 'name_ar' => 'يوسف حسن', 'parent_id' => 501),
                array('id' => 102, 'study_year' => 3, 'class' => 11, 'name_en' => 'Mariam Adel', 'name_ar' => 'مريم عادل', 'parent_id' => 502),
                array('id' => 103, 'study_year' => 3, 'class' => 11, 'name_en' => 'Omar Nabil', 'name_ar' => 'عمر نبيل', 'parent_id' => 503),
                array('id' => 104, 'study_year' => 4, 'class' => 21, 'name_en' => 'Lina Fathy', 'name_ar' => 'لينا فتحي', 'parent_id' => 504),
                array('id' => 105, 'study_year' => 9, 'class' => 31, 'name_en' => 'Karim Samir', 'name_ar' => 'كريم سمير', 'parent_id' => 505),
            ),
            'parents' => array(
                array('id' => 501, 'name_en' => 'Mr Hassan', 'name_ar' => 'أ. حسن'),
                array('id' => 502, 'name_en' => 'Mrs Adel', 'name_ar' => 'أ. عادل'),
                array('id' => 503, 'name_en' => 'Mr Nabil', 'name_ar' => 'أ. نبيل'),
                array('id' => 504, 'name_en' => 'Mrs Fathy', 'name_ar' => 'أ. فتحي'),
                array('id' => 505, 'name_en' => 'Mr Samir', 'name_ar' => 'أ. سمير'),
            ),
            'emps' => array(
                array('id' => 7, 'name_en' => 'Ms Nour Adel', 'name_ar' => 'أ. نور عادل', 'job_en' => 'English teacher', 'job_ar' => 'معلمة إنجليزي'),
                array('id' => 8, 'name_en' => 'Mr Karim Hassan', 'name_ar' => 'أ. كريم حسن', 'job_en' => 'Math teacher', 'job_ar' => 'معلم رياضيات'),
            ),
            'absences' => array(
                array('id' => 1, 'kid_id' => 102, 'study_year' => 3, 'class' => 11, 'date' => $t, 'confirm' => 0, 'accept' => 0, 'emp_id' => 1),
                array('id' => 2, 'kid_id' => 105, 'study_year' => 9, 'class' => 31, 'date' => $t, 'confirm' => 1, 'accept' => 0, 'emp_id' => 1),
            ),
            'abs_next' => 3,
            'questions' => array(
                array(
                    'id' => 31, 'user_id' => 501, 'kid_id' => 101, 'study_year' => 3, 'subject' => 1,
                    'text' => 'Can we have extra reading this week?', 'status' => 0, 'teacher_id' => null,
                    'director_id' => null, 'reply' => null, 'date' => $t - 3600, 'respond' => 0,
                ),
                array(
                    'id' => 32, 'user_id' => 502, 'kid_id' => 102, 'study_year' => 3, 'subject' => 10001,
                    'text' => 'Please confirm the trip date.', 'status' => 0, 'teacher_id' => null,
                    'director_id' => null, 'reply' => null, 'date' => $t - 7200, 'respond' => 0,
                ),
                array(
                    'id' => 33, 'user_id' => 504, 'kid_id' => 104, 'study_year' => 4, 'subject' => 2,
                    'text' => 'Is there homework for Thursday?', 'status' => 0, 'teacher_id' => 0,
                    'director_id' => 1, 'reply' => null, 'date' => $t - 86400, 'respond' => 0,
                ),
                array(
                    'id' => 34, 'user_id' => 505, 'kid_id' => 105, 'study_year' => 9, 'subject' => 1,
                    'text' => 'Thank you for the extra class.', 'status' => 1, 'teacher_id' => 0,
                    'director_id' => 1, 'reply' => 'You are welcome. Next session is Sunday.',
                    'date' => $t - 172800, 'respond' => $t - 86400,
                ),
            ),
            'groups' => array(
                array('id' => 41, 'study_year' => 3, 'subject' => 1, 'name_en' => 'English group A', 'name_ar' => 'مجموعة إنجليزي أ'),
                array('id' => 42, 'study_year' => 3, 'subject' => 2, 'name_en' => 'Math support', 'name_ar' => 'دعم رياضيات'),
                array('id' => 43, 'study_year' => 9, 'subject' => 1, 'name_en' => 'Debate club', 'name_ar' => 'نادي المناظرة'),
            ),
            'group_list' => array(
                array('id' => 1, 'classgroup_id' => 41, 'kid_id' => 101),
                array('id' => 2, 'classgroup_id' => 41, 'kid_id' => 102),
                array('id' => 3, 'classgroup_id' => 41, 'kid_id' => 103),
                array('id' => 4, 'classgroup_id' => 42, 'kid_id' => 101),
                array('id' => 5, 'classgroup_id' => 43, 'kid_id' => 105),
            ),
            'group_abs' => array(),
            'group_abs_next' => 1,
            'events' => array(
                array(
                    'id' => 61, 'study_year' => 15, 'start' => $t + 86400 * 3, 'end' => $t + 86400 * 4,
                    'name_eng' => 'Sports day', 'name_arb' => 'يوم رياضي',
                    'text_eng' => 'All grades meet on the playground at 9:00.',
                    'text_arb' => 'يلتقي كل الصفوف في الملعب الساعة 9:00.',
                    'banner' => '',
                ),
                array(
                    'id' => 62, 'study_year' => 3, 'start' => $t + 86400 * 10, 'end' => $t + 86400 * 10,
                    'name_eng' => 'Junior parents meeting', 'name_arb' => 'اجتماع أولياء أمور الجونيور',
                    'text_eng' => 'Classroom 3A after the first break.',
                    'text_arb' => 'الفصل 3أ بعد الفسحة الأولى.',
                    'banner' => '',
                ),
            ),
            'appointments' => array(
                array('id' => 71, 'emp_id' => 0, 'subject' => 1, 'study_year' => 3, 'day' => $t + 86400, 'meeting_time' => '10:30', 'kid_id' => 101),
                array('id' => 72, 'emp_id' => 0, 'subject' => 2, 'study_year' => 4, 'day' => $t + 86400 * 2, 'meeting_time' => '12:00', 'kid_id' => null),
            ),
            'vacs' => array(
                array(
                    'id' => 81, 'emp_id' => 8, 'status' => 0, 'type' => 1,
                    'vacation_start' => $t + 86400 * 5, 'vacation_end' => $t + 86400 * 7,
                    'text' => 'Family travel', 'sick_note' => null,
                ),
                array(
                    'id' => 82, 'emp_id' => 7, 'status' => 0, 'type' => 3,
                    'vacation_start' => $t + 86400, 'vacation_end' => $t + 86400 * 2,
                    'text' => 'Medical appointment', 'sick_note' => 'note.pdf',
                ),
            ),
            'excuses' => array(
                array(
                    'id' => 91, 'emp_id' => 7, 'status' => 0, 'date' => $t,
                    'start' => $t + 3600 * 11, 'end' => $t + 3600 * 13, 'hours' => 2,
                    'text' => 'Clinic visit',
                ),
            ),
            'teacher_years' => array(3, 4, 9),
        );
        if ($staffLang) {
            $_SESSION['staff_demo']['questions'][2]['teacher_id'] = 0;
            $_SESSION['staff_demo']['questions'][3]['teacher_id'] = 0;
        }
    }
    return $_SESSION['staff_demo'];
}

function staff_demo_save($data)
{
    $_SESSION['staff_demo'] = $data;
}

function svc_notify($parentId, $kidId, $text, $type = 6, $absence = null)
{
    global $staffPreview, $database, $row_get_user;
    if ($staffPreview) {
        return;
    }
    $userCol = $absence !== null ? '`absence`' : '`type`';
    $userVal = $absence !== null ? svc_sql($absence, 'int') : svc_sql($type, 'int');
    $emp = isset($row_get_user['id']) ? (int) $row_get_user['id'] : 0;
    if ($absence !== null) {
        $sql = sprintf(
            'INSERT INTO `notifications` (`user_id`, `kid_id`, `text`, `date`, `absence`) VALUES (%s, %s, %s, %s, %s)',
            svc_sql($parentId, 'int'),
            svc_sql($kidId, 'int'),
            svc_sql($text, 'text'),
            svc_sql(time(), 'int'),
            $userVal
        );
    } else {
        $sql = sprintf(
            'INSERT INTO `notifications` (`user_id`, `kid_id`, `text`, `date`, `type`, `emp_id`) VALUES (%s, %s, %s, %s, %s, %s)',
            svc_sql($parentId, 'int'),
            svc_sql($kidId, 'int'),
            svc_sql($text, 'text'),
            svc_sql(time(), 'int'),
            svc_sql($type, 'int'),
            svc_sql($emp, 'int')
        );
    }
    svc_q($sql);
    if (function_exists('sendMessage') && function_exists('app_msg_id')) {
        $pid = app_msg_id($kidId);
        if ($pid) {
            sendMessage($pid, 'HLS', $text);
        }
    }
}

function svc_parent_of($kidId)
{
    global $staffPreview;
    if (!$staffPreview && function_exists('parent_id')) {
        return (int) parent_id($kidId);
    }
    foreach (staff_demo()['kids'] as $k) {
        if ((int) $k['id'] === (int) $kidId) {
            return (int) $k['parent_id'];
        }
    }
    return 0;
}

function svc_years_notify()
{
    global $staffPreview, $empId;
    if ($staffPreview) {
        $out = array();
        foreach (staff_demo()['teacher_years'] as $y) {
            $out[] = array('study_year' => $y);
        }
        return $out;
    }
    return svc_all("SELECT DISTINCT `study_year` FROM `teachers` WHERE `emp_id` = '" . (int) $empId . "' ORDER BY `study_year` ASC");
}

function svc_classes_notify($year)
{
    global $staffPreview, $empId;
    $year = (int) $year;
    if ($staffPreview) {
        $out = array();
        foreach (staff_demo()['classes'] as $c) {
            if ((int) $c['study_year'] === $year) {
                $out[] = array('class' => $c['id']);
            }
        }
        return $out;
    }
    return svc_all("SELECT DISTINCT `class` FROM `teachers` WHERE `emp_id` = '" . (int) $empId . "' AND `study_year` = '" . $year . "' ORDER BY `class` ASC");
}

function svc_send_notify($year, $class, $msg)
{
    global $staffPreview, $empId, $row_get_user, $S;
    $class = (int) $class;
    $msg = trim((string) $msg);
    if ($msg === '') {
        return;
    }
    if ($staffPreview) {
        svc_flash($S['sent']);
        return;
    }
    $info = svc_one("SELECT `study_year` FROM `class` WHERE `id`='" . $class . "'");
    if (!$info) {
        svc_go('class-notify.php');
    }
    $kids = svc_all("SELECT `kids`.id AS `kid_id`, `kids`.fn_name AS `kid_name`, `kids_list`.parent_id AS `parent_id`, `app_login`.phone_id AS `phone_id` FROM `kids` RIGHT JOIN `kids_list` ON `kids`.id = `kids_list`.kid_id RIGHT JOIN `app_login` ON `app_login`.id = `kids_list`.parent_id WHERE `kids`.class ='" . $class . "' AND `kids`.linked = 1 AND `kids_list`.parent_id > 0");
    svc_q(sprintf(
        'INSERT INTO `class_announce` (`class_id`, `msg`, `date`, `emp_id`) VALUES (%s, %s, %s, %s)',
        svc_sql($class, 'int'),
        svc_sql($msg, 'text'),
        svc_sql(time(), 'int'),
        svc_sql($empId, 'int')
    ));
    foreach ($kids as $row) {
        $text = $row['kid_name'] . ' ' . $msg;
        svc_q(sprintf(
            'INSERT INTO `notifications` (`user_id`, `kid_id`, `text`, `date`, `type`, `emp_id`) VALUES (%s, %s, %s, %s, %s, %s)',
            svc_sql($row['parent_id'], 'int'),
            svc_sql($row['kid_id'], 'int'),
            svc_sql($text, 'text'),
            svc_sql(time(), 'int'),
            svc_sql(6, 'int'),
            svc_sql($row_get_user['id'] ?? 0, 'int')
        ));
        if (!empty($row['phone_id']) && function_exists('sendMessage')) {
            sendMessage($row['phone_id'], 'HLS', $text);
        }
    }
    svc_flash($S['sent']);
}

function svc_collect_years()
{
    $checks = array(
        0 => 'app1_0access', 1 => 'app1_1access', 2 => 'app1_1access',
        3 => 'app1_2access', 4 => 'app1_2access', 5 => 'app1_2access',
        6 => 'app1_3access', 7 => 'app1_3access', 8 => 'app1_3access',
        9 => 'app1_4access', 10 => 'app1_4access', 11 => 'app1_4access',
        12 => 'app1_5access', 13 => 'app1_5access', 14 => 'app1_5access',
    );
    $out = array();
    foreach ($checks as $year => $fn) {
        if (svc_can($fn)) {
            $out[] = $year;
        }
    }
    return $out;
}

function svc_classes_year($year)
{
    global $staffPreview;
    $year = (int) $year;
    if ($staffPreview) {
        $out = array();
        foreach (staff_demo()['classes'] as $c) {
            if ((int) $c['study_year'] === $year) {
                $out[] = $c;
            }
        }
        return $out;
    }
    return svc_all("SELECT * FROM `class` WHERE `study_year` = '" . $year . "' ORDER BY `name` ASC");
}

function svc_kids_class($year, $class)
{
    global $staffPreview;
    $year = (int) $year;
    $class = (int) $class;
    if ($staffPreview) {
        $out = array();
        foreach (staff_demo()['kids'] as $k) {
            if ((int) $k['study_year'] === $year && (int) $k['class'] === $class) {
                $out[] = $k;
            }
        }
        return $out;
    }
    return svc_all("SELECT * FROM `kids` WHERE `study_year` = '" . $year . "' AND `class` = '" . $class . "' ORDER BY `name` ASC");
}

function svc_today_absences($year, $class)
{
    global $staffPreview, $todayStart, $todayEnd;
    $year = (int) $year;
    $class = (int) $class;
    if ($staffPreview) {
        $out = array();
        foreach (staff_demo()['absences'] as $a) {
            if ((int) $a['study_year'] === $year && (int) $a['class'] === $class && (int) $a['date'] >= $todayStart && (int) $a['date'] < $todayEnd) {
                $out[] = $a;
            }
        }
        return $out;
    }
    return svc_all("SELECT * FROM `kids-absence` WHERE `study_year` = '" . $year . "' AND `class` = '" . $class . "' AND `date` >= '" . $todayStart . "' AND `date` < '" . $todayEnd . "'");
}

function svc_kid_absent_today($kidId)
{
    global $staffPreview, $todayStart, $todayEnd;
    $kidId = (int) $kidId;
    if ($staffPreview) {
        foreach (staff_demo()['absences'] as $a) {
            if ((int) $a['kid_id'] === $kidId && (int) $a['date'] >= $todayStart && (int) $a['date'] < $todayEnd) {
                return true;
            }
        }
        return false;
    }
    if (function_exists('check_absence')) {
        return check_absence($kidId) > 0;
    }
    $row = svc_one("SELECT `id` FROM `kids-absence` WHERE `kid_id`='" . $kidId . "' AND `date` >= '" . $todayStart . "' AND `date` < '" . $todayEnd . "'");
    return (bool) $row;
}

function svc_collect_submit($year, $class, $posted)
{
    global $staffPreview, $todayStart, $row_get_user, $S;
    $year = (int) $year;
    $class = (int) $class;
    $kids = svc_kids_class($year, $class);
    if ($staffPreview) {
        $d = staff_demo();
        foreach ($kids as $k) {
            $key = 'kid_' . $k['id'];
            if (!empty($posted[$key]) && !svc_kid_absent_today($k['id'])) {
                $d['absences'][] = array(
                    'id' => $d['abs_next']++,
                    'kid_id' => (int) $k['id'],
                    'study_year' => $year,
                    'class' => $class,
                    'date' => $todayStart,
                    'confirm' => 0,
                    'accept' => 0,
                    'emp_id' => 1,
                );
            }
        }
        staff_demo_save($d);
        svc_flash($S['saved']);
        return;
    }
    foreach ($kids as $k) {
        $key = 'kid_' . $k['id'];
        $exists = svc_one("SELECT `kid_id` FROM `kids-absence` WHERE `kid_id` = '" . (int) $k['id'] . "' AND `study_year` = '" . $year . "' AND `class`= '" . $class . "' AND `date` = '" . $todayStart . "'");
        if (!empty($posted[$key]) && !$exists) {
            svc_q(sprintf(
                'INSERT INTO `kids-absence` (`kid_id`, `study_year`, `class`, `date`, `emp_id`) VALUES (%s, %s, %s, %s, %s)',
                svc_sql($k['id'], 'int'),
                svc_sql($year, 'int'),
                svc_sql($class, 'int'),
                svc_sql($todayStart, 'int'),
                svc_sql($row_get_user['id'] ?? 0, 'int')
            ));
        }
    }
    svc_flash($S['saved']);
}

function svc_delete_absence($id)
{
    global $staffPreview;
    $id = (int) $id;
    if ($staffPreview) {
        $d = staff_demo();
        $keep = array();
        foreach ($d['absences'] as $a) {
            if ((int) $a['id'] !== $id || (int) $a['confirm'] !== 0) {
                $keep[] = $a;
            }
        }
        $d['absences'] = $keep;
        staff_demo_save($d);
        return;
    }
    svc_q('DELETE FROM `kids-absence` WHERE `id`=' . svc_sql($id, 'int') . ' AND `confirm` = 0');
}

function svc_stage_access($kind)
{
    $map = array(
        'confirm' => array('app6_0access', 'app6_1access', 'app6_2access', 'app6_3access', 'app6_4access', 'app6_5access'),
        'accept' => array('app9_0access', 'app9_1access', 'app9_2access', 'app9_3access', 'app9_4access', 'app9_5access'),
    );
    $fns = $map[$kind];
    $out = array();
    foreach ($fns as $i => $fn) {
        if (svc_can($fn)) {
            $out[] = $i;
        }
    }
    return $out;
}

function svc_confirm_list($stage)
{
    global $staffPreview, $todayStart, $todayEnd;
    $years = svc_stage_years($stage);
    if ($staffPreview) {
        $out = array();
        foreach (staff_demo()['absences'] as $a) {
            if (in_array((int) $a['study_year'], $years, true) && (int) $a['date'] >= $todayStart && (int) $a['date'] < $todayEnd) {
                $out[] = $a;
            }
        }
        return $out;
    }
    return svc_all("SELECT * FROM `kids-absence` WHERE " . svc_stage_where($stage) . " AND `date` >= '" . $todayStart . "' AND `date` < '" . $todayEnd . "'");
}

function svc_confirm_pending($stage)
{
    $rows = array();
    foreach (svc_confirm_list($stage) as $a) {
        if ((int) $a['confirm'] === 0) {
            $rows[] = $a;
        }
    }
    return $rows;
}

function svc_confirm_all($stage)
{
    global $staffPreview, $todayStart, $todayEnd, $row_get_user, $S;
    $years = svc_stage_years($stage);
    if ($staffPreview) {
        $d = staff_demo();
        foreach ($d['absences'] as &$a) {
            if (in_array((int) $a['study_year'], $years, true) && (int) $a['confirm'] === 0 && (int) $a['date'] >= $todayStart && (int) $a['date'] < $todayEnd) {
                $a['confirm'] = 1;
            }
        }
        unset($a);
        staff_demo_save($d);
        svc_flash($S['saved']);
        return;
    }
    $rows = svc_all("SELECT * FROM `kids-absence` WHERE `date`>='" . $todayStart . "' AND `date`<'" . $todayEnd . "' AND `confirm`=0 AND " . svc_stage_where($stage));
    foreach ($rows as $row) {
        svc_q(sprintf(
            'UPDATE `kids-absence` SET `confirm`=%s, `confirm_appuser`=%s WHERE `id`=%s AND `confirm`=%s',
            svc_sql(1, 'int'),
            svc_sql($row_get_user['id'] ?? 0, 'int'),
            svc_sql($row['id'], 'int'),
            svc_sql(0, 'int')
        ));
        $skip = function_exists('vacation_check') && vacation_check($row['date'], $row['kid_id']) == 1;
        if ($skip) {
            continue;
        }
        $links = svc_all("SELECT * FROM `kids_list` WHERE `kid_id`='" . (int) $row['kid_id'] . "'");
        $note = $S['absence_note'] . date('d/m/Y');
        foreach ($links as $link) {
            svc_notify($link['parent_id'], $link['kid_id'], $note, 0, $row['id']);
        }
    }
    svc_flash($S['saved']);
}

function svc_accept_list($stage)
{
    global $staffPreview;
    $years = svc_stage_years($stage);
    if ($staffPreview) {
        $out = array();
        foreach (staff_demo()['absences'] as $a) {
            if (in_array((int) $a['study_year'], $years, true) && (int) $a['confirm'] === 1 && (int) $a['accept'] === 0) {
                $out[] = $a;
            }
        }
        return $out;
    }
    return svc_all("SELECT * FROM `kids-absence` WHERE " . svc_stage_where($stage) . " AND `confirm`= 1 AND `accept` = 0 ORDER BY `id` DESC");
}

function svc_accept_one($id)
{
    global $staffPreview, $empId, $S;
    $id = (int) $id;
    if ($staffPreview) {
        $d = staff_demo();
        foreach ($d['absences'] as &$a) {
            if ((int) $a['id'] === $id) {
                $a['accept'] = 1;
            }
        }
        unset($a);
        staff_demo_save($d);
        svc_flash($S['saved']);
        return;
    }
    svc_q(sprintf(
        'UPDATE `kids-absence` SET `accept`=%s, `app_user`=%s WHERE `id`=%s',
        svc_sql(1, 'int'),
        svc_sql($empId, 'int'),
        svc_sql($id, 'int')
    ));
    svc_flash($S['saved']);
}

function svc_direct_ok_year($year)
{
    $year = (int) $year;
    if (svc_can('app2_1access') && $year <= 2) {
        return true;
    }
    if (svc_can('app2_2access') && $year > 2 && $year <= 5) {
        return true;
    }
    if (svc_can('app2_3access') && $year > 5 && $year <= 8) {
        return true;
    }
    if (svc_can('app2_4access') && $year > 8 && $year <= 11) {
        return true;
    }
    if (svc_can('app2_5access') && $year > 11 && $year <= 15) {
        return true;
    }
    return false;
}

function svc_questions_direct()
{
    global $staffPreview;
    if ($staffPreview) {
        $out = array();
        foreach (staff_demo()['questions'] as $q) {
            if ((int) $q['status'] === 0 && empty($q['director_id']) && svc_direct_ok_year($q['study_year'])) {
                $out[] = $q;
            }
        }
        return $out;
    }
    $rows = svc_all("SELECT * FROM `ask_teacher` WHERE `status`= 0 AND `director_id` IS NULL ORDER BY `id` DESC");
    $out = array();
    foreach ($rows as $q) {
        if (svc_direct_ok_year($q['study_year'])) {
            $out[] = $q;
        }
    }
    return $out;
}

function svc_questions_unreplied()
{
    global $staffPreview, $empId;
    if ($staffPreview) {
        $out = array();
        foreach (staff_demo()['questions'] as $q) {
            if (($q['reply'] === null || $q['reply'] === '') && $q['teacher_id'] !== null) {
                $out[] = $q;
            }
        }
        return $out;
    }
    return svc_all("SELECT * FROM `ask_teacher` WHERE `teacher_id`= '" . (int) $empId . "' AND `reply` IS NULL ORDER BY `id` DESC");
}

function svc_questions_replied()
{
    global $staffPreview, $empId;
    $all = svc_can('app7_6access');
    if ($staffPreview) {
        $out = array();
        foreach (staff_demo()['questions'] as $q) {
            if ($q['reply'] !== null && $q['reply'] !== '') {
                $out[] = $q;
            }
        }
        return $out;
    }
    if ($all) {
        return svc_all("SELECT * FROM `ask_teacher` WHERE `reply` IS NOT NULL ORDER BY `id` DESC");
    }
    return svc_all("SELECT * FROM `ask_teacher` WHERE `teacher_id` = '" . (int) $empId . "' AND `reply` IS NOT NULL ORDER BY `id` DESC");
}

function svc_question($id)
{
    global $staffPreview;
    $id = (int) $id;
    if ($staffPreview) {
        foreach (staff_demo()['questions'] as $q) {
            if ((int) $q['id'] === $id) {
                return $q;
            }
        }
        return null;
    }
    return svc_one("SELECT * FROM `ask_teacher` WHERE `id` = '" . $id . "'");
}

function svc_kid_row($id)
{
    global $staffPreview;
    $id = (int) $id;
    if ($staffPreview) {
        foreach (staff_demo()['kids'] as $k) {
            if ((int) $k['id'] === $id) {
                return $k;
            }
        }
        return null;
    }
    return svc_one("SELECT * FROM `kids` WHERE `id` = '" . $id . "'");
}

function svc_save_reply($id, $text)
{
    global $staffPreview, $empId, $S;
    $id = (int) $id;
    $text = trim((string) $text);
    if ($text === '') {
        return;
    }
    if ($staffPreview) {
        $d = staff_demo();
        foreach ($d['questions'] as &$q) {
            if ((int) $q['id'] === $id) {
                $q['reply'] = $text;
                $q['status'] = 1;
                $q['teacher_id'] = $empId;
                $q['respond'] = time();
            }
        }
        unset($q);
        staff_demo_save($d);
        svc_flash($S['saved']);
        return;
    }
    $q = svc_question($id);
    svc_q(sprintf(
        'UPDATE `ask_teacher` SET `teacher_id`=%s, `reply`=%s, `status` = 1, `respond` =%s WHERE `id`=%s',
        svc_sql($empId, 'int'),
        svc_sql($text, 'text'),
        svc_sql(time(), 'int'),
        svc_sql($id, 'int')
    ));
    if ($q && function_exists('sendMessage') && function_exists('app_msg_id') && function_exists('kid_name')) {
        sendMessage(app_msg_id($q['kid_id']), 'HLS', date('d/m/Y') . ' رد سؤال من ولي امر  ' . kid_name($q['kid_id']));
    }
    svc_flash($S['saved']);
}

function svc_groups_year($year)
{
    global $staffPreview, $staffLang;
    $year = (int) $year;
    if ($staffPreview) {
        $out = array();
        foreach (staff_demo()['groups'] as $g) {
            if ((int) $g['study_year'] === $year) {
                $g['name'] = ($staffLang === 'arb') ? $g['name_ar'] : $g['name_en'];
                $out[] = $g;
            }
        }
        return $out;
    }
    return svc_all("SELECT * FROM `classgroup` WHERE `study_year` = '" . $year . "' ORDER BY `name` ASC");
}

function svc_group($id)
{
    global $staffPreview, $staffLang;
    $id = (int) $id;
    if ($staffPreview) {
        foreach (staff_demo()['groups'] as $g) {
            if ((int) $g['id'] === $id) {
                $g['name'] = ($staffLang === 'arb') ? $g['name_ar'] : $g['name_en'];
                return $g;
            }
        }
        return null;
    }
    return svc_one("SELECT * FROM `classgroup` WHERE `id` = '" . $id . "'");
}

function svc_group_members($id)
{
    global $staffPreview;
    $id = (int) $id;
    if ($staffPreview) {
        $out = array();
        foreach (staff_demo()['group_list'] as $m) {
            if ((int) $m['classgroup_id'] === $id) {
                $out[] = $m;
            }
        }
        return $out;
    }
    return svc_all("SELECT * FROM `classgroup_list` WHERE `classgroup_id` = '" . $id . "'");
}

function svc_group_today($id)
{
    global $staffPreview, $todayStart;
    $id = (int) $id;
    if ($staffPreview) {
        $out = array();
        foreach (staff_demo()['group_abs'] as $a) {
            if ((int) $a['group_id'] === $id && (int) $a['day'] === $todayStart) {
                $out[] = $a;
            }
        }
        return $out;
    }
    return svc_all("SELECT * FROM `group_absence` WHERE `group_id` = '" . $id . "' AND `day`= '" . $todayStart . "'");
}

function svc_group_mark($gid, $kid)
{
    global $staffPreview, $todayStart, $row_get_user, $S;
    $gid = (int) $gid;
    $kid = (int) $kid;
    if ($staffPreview) {
        $d = staff_demo();
        foreach ($d['group_abs'] as $a) {
            if ((int) $a['group_id'] === $gid && (int) $a['kid_id'] === $kid && (int) $a['day'] === $todayStart) {
                return;
            }
        }
        $d['group_abs'][] = array('id' => $d['group_abs_next']++, 'kid_id' => $kid, 'group_id' => $gid, 'day' => $todayStart, 'emp_id' => 1);
        staff_demo_save($d);
        return;
    }
    svc_q(sprintf(
        'INSERT INTO `group_absence` (`kid_id`, `group_id`, `day`, `emp_id`) VALUES (%s, %s, %s, %s)',
        svc_sql($kid, 'int'),
        svc_sql($gid, 'int'),
        svc_sql($todayStart, 'int'),
        svc_sql($row_get_user['id'] ?? 0, 'int')
    ));
    $gname = function_exists('group_subject') ? group_subject($gid) : '';
    $note = $S['group_note'] . date('d/m/Y');
    if ($gname !== '') {
        $note = 'يرجى العلم بتغيب الطالب عن المجموعة (  ' . $gname . ')اليوم الموافق ' . date('d/m/Y');
    }
    $pid = svc_parent_of($kid);
    if ($pid > 0) {
        svc_notify($pid, $kid, $note, 3);
    }
}

function svc_group_unmark($gid, $absId)
{
    global $staffPreview;
    $absId = (int) $absId;
    if ($staffPreview) {
        $d = staff_demo();
        $keep = array();
        foreach ($d['group_abs'] as $a) {
            if ((int) $a['id'] !== $absId) {
                $keep[] = $a;
            }
        }
        $d['group_abs'] = $keep;
        staff_demo_save($d);
        return;
    }
    svc_q('DELETE FROM `group_absence` WHERE `id`=' . svc_sql($absId, 'int'));
}

function svc_events($year = null)
{
    global $staffPreview;
    if ($staffPreview) {
        $rows = staff_demo()['events'];
        if ($year !== null && $year !== '') {
            $year = (int) $year;
            $out = array();
            foreach ($rows as $e) {
                if ((int) $e['study_year'] === $year || (int) $e['study_year'] === 15) {
                    $out[] = $e;
                }
            }
            return $out;
        }
        return $rows;
    }
    if ($year !== null && $year !== '') {
        $year = (int) $year;
        return svc_all("SELECT * FROM `events` WHERE (`study_year` = '" . $year . "' OR `study_year`=15) ORDER BY `id` DESC");
    }
    return svc_all("SELECT * FROM `events` ORDER BY `id` DESC");
}

function svc_event($id)
{
    global $staffPreview;
    $id = (int) $id;
    if ($staffPreview) {
        foreach (staff_demo()['events'] as $e) {
            if ((int) $e['id'] === $id) {
                return $e;
            }
        }
        return null;
    }
    return svc_one("SELECT * FROM `events` WHERE `id` = '" . $id . "'");
}

function svc_appointments()
{
    global $staffPreview, $empId, $todayStart;
    if ($staffPreview) {
        $out = array();
        foreach (staff_demo()['appointments'] as $a) {
            if ((int) $a['day'] >= $todayStart) {
                $out[] = $a;
            }
        }
        return $out;
    }
    return svc_all("SELECT * FROM `appointment` WHERE `emp_id` = '" . (int) $empId . "' AND `day`>='" . $todayStart . "'");
}

function svc_vacs()
{
    global $staffPreview, $staffSnapshot;
    if ($staffPreview || !empty($staffSnapshot)) {
        $out = array();
        foreach (staff_demo()['vacs'] as $v) {
            if ((int) $v['status'] === 0) {
                $out[] = $v;
            }
        }
        return $out;
    }
    return svc_all("SELECT * FROM `emps_vacations` WHERE `status` = 0");
}

function svc_vac($id)
{
    global $staffPreview, $staffSnapshot;
    $id = (int) $id;
    if ($staffPreview || !empty($staffSnapshot)) {
        foreach (staff_demo()['vacs'] as $v) {
            if ((int) $v['id'] === $id) {
                return $v;
            }
        }
        return null;
    }
    return svc_one("SELECT * FROM `emps_vacations` WHERE `id` = '" . $id . "'");
}

function svc_save_vac($id, $status)
{
    global $staffPreview, $staffSnapshot, $S;
    $id = (int) $id;
    $status = (int) $status;
    if ($staffPreview || !empty($staffSnapshot)) {
        $d = staff_demo();
        foreach ($d['vacs'] as &$v) {
            if ((int) $v['id'] === $id) {
                $v['status'] = $status;
            }
        }
        unset($v);
        staff_demo_save($d);
        svc_flash($S['saved']);
        return;
    }
    svc_q(sprintf(
        'UPDATE `emps_vacations` SET `status`=%s WHERE `id`=%s',
        svc_sql($status, 'int'),
        svc_sql($id, 'int')
    ));
    svc_flash($S['saved']);
}

function svc_excuses()
{
    global $staffPreview;
    if ($staffPreview) {
        $out = array();
        foreach (staff_demo()['excuses'] as $v) {
            if ((int) $v['status'] === 0) {
                $out[] = $v;
            }
        }
        return $out;
    }
    return svc_all("SELECT * FROM `emps_excuse` WHERE `status` = 0");
}

function svc_excuse($id)
{
    global $staffPreview;
    $id = (int) $id;
    if ($staffPreview) {
        foreach (staff_demo()['excuses'] as $v) {
            if ((int) $v['id'] === $id) {
                return $v;
            }
        }
        return null;
    }
    return svc_one("SELECT * FROM `emps_excuse` WHERE `id` = '" . $id . "'");
}

function svc_save_excuse($id, $status)
{
    global $staffPreview, $S;
    $id = (int) $id;
    $status = (int) $status;
    if ($staffPreview) {
        $d = staff_demo();
        foreach ($d['excuses'] as &$v) {
            if ((int) $v['id'] === $id) {
                $v['status'] = $status;
            }
        }
        unset($v);
        staff_demo_save($d);
        svc_flash($S['saved']);
        return;
    }
    svc_q(sprintf(
        'UPDATE `emps_excuse` SET `status`=%s WHERE `id`=%s',
        svc_sql($status, 'int'),
        svc_sql($id, 'int')
    ));
    svc_flash($S['saved']);
}

function svc_note()
{
    global $staffPreview, $S;
    if ($staffPreview) {
        echo '<p class="svc-note">' . staff_h($S['preview']) . '</p>';
    }
    $flash = svc_flash();
    if ($flash !== '') {
        echo '<p class="svc-alert svc-alert--ok">' . staff_h($flash) . '</p>';
    }
}

function svc_empty()
{
    global $S;
    echo '<p class="svc-empty">' . staff_h($S['empty']) . '</p>';
}

function svc_row($href, $title, $meta = '', $count = null, $tone = 't-navy', $ico = 'list')
{
    echo '<a class="row ' . $tone . '" href="' . staff_h($href) . '">';
    echo '<span class="row__ico">' . staff_ico($ico) . '</span>';
    echo '<span class="row__body"><span class="row__title">' . staff_h($title) . '</span>';
    if ($meta !== '') {
        echo '<span class="row__meta">' . staff_h($meta) . '</span>';
    }
    echo '</span>';
    if ($count !== null && $count !== '') {
        echo '<span class="row__count">' . staff_h($count) . '</span>';
    }
    echo '<span class="row__go">›</span></a>';
}

function svc_boot($title, $back = 'emp-view.php')
{
    staff_inner($title, $back, 'home');
    svc_note();
}
