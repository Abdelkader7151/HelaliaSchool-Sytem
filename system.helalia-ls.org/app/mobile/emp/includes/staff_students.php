<?php
if (!isset($staffLang)) {
    $staffLang = 'eng';
}

if (!isset($showStudent) || (!$staffPreview && !$showStudent)) {
    header('Location: emp-view.php');
    exit;
}

staff_students_strings();
staff_students_preview_helpers();

function staff_students_strings()
{
    global $staffLang, $S;
    if ($staffLang === 'arb') {
        $S = array(
            'title' => 'الطلبة',
            'search' => 'بحث',
            'name' => 'الاسم',
            'ed_id' => 'الرقم التعليمي',
            'gov_id' => 'الرقم القومي',
            'study_year' => 'السنة الدراسية',
            'year_pick' => 'السنة',
            'years' => 'السنوات',
            'classes' => 'الفصول',
            'students' => 'الطلبة',
            'results' => 'نتائج البحث',
            'empty' => 'لا توجد نتائج',
            'not_found' => 'لم يتم العثور على هذا الطالب',
            'year_invalid' => 'هذه السنة الدراسية غير متاحة لحسابك',
            'back' => 'رجوع',
            'empty_class' => 'لا يوجد فصول لهذه السنة',
            'empty_kids' => 'لا يوجد طلبة في هذا الفصل',
            'empty_abs' => 'لا توجد غيابات',
            'empty_vac' => 'لا توجد إجازات مسوّاة',
            'info' => 'بيانات الطالب',
            'student_details' => 'بيانات الطالب',
            'father' => 'بيانات الأب',
            'mother' => 'بيانات الأم',
            'general' => 'بيانات عامة',
            'siblings' => 'الإخوة / الأخوات',
            'year' => 'السنة',
            'class' => 'الفصل',
            'specialty' => 'التخصص',
            'whatsapp' => 'واتساب',
            'mobile' => 'الموبايل',
            'other_phone' => 'هاتف آخر',
            'job' => 'الوظيفة',
            'id' => 'الرقم القومي',
            'ed_state' => 'الإدارة التعليمية',
            'divorce' => 'في حالة الانفصال يسكن الطالب مع',
            'death' => 'في حالة وفاة الوالدين',
            'chronic' => 'هل يعاني من مرض مزمن؟',
            'allergy' => 'هل لديه حساسية من أي دواء؟',
            'surgery' => 'عمليات سابقة',
            'emergency' => 'رقم الطوارئ',
            'relation' => 'درجة القرابة',
            'yes' => 'نعم',
            'no' => 'لا',
            'absence' => 'الغياب',
            'absence_of' => 'غياب',
            'unsettled' => 'غيابات غير مسوّاة',
            'settled' => 'غياب مسوّى',
            'vacation' => 'الإجازة',
            'view_vacation' => 'عرض الإجازة',
            'vac_start' => 'تاريخ بداية الإجازة',
            'vac_end' => 'تاريخ نهاية الإجازة',
            'vac_return' => 'يوم العودة إلى المدرسة',
            'vac_type' => 'النوع',
            'sick_note' => 'تقرير طبي',
            'sick_attached' => 'مرفق تقرير طبي',
            'description' => 'وصف مختصر',
            'ed' => 'تعليمي',
            'gov' => 'قومي',
            'vac_sick' => 'مرضي',
            'vac_champ' => 'بطولة',
            'vac_travel' => 'سفر',
            'vac_na' => 'غير محدد',
            'type_sci' => 'علمي',
            'type_sciences' => 'علوم',
            'type_maths' => 'رياضيات',
            'type_lit' => 'أدبي',
            'day' => 'يوم',
            'days' => 'أيام',
        );
    } else {
        $S = array(
            'title' => 'Students',
            'search' => 'Search',
            'name' => 'Name',
            'ed_id' => 'Education ID',
            'gov_id' => 'Gov ID',
            'study_year' => 'Study year',
            'year_pick' => 'Year',
            'years' => 'Years',
            'classes' => 'Classes',
            'students' => 'Students',
            'results' => 'Search results',
            'empty' => 'No students found',
            'not_found' => 'This student was not found',
            'year_invalid' => 'This study year is not available for your account',
            'back' => 'Back',
            'empty_class' => 'No classes for this year',
            'empty_kids' => 'No students in this class',
            'empty_abs' => 'No absences',
            'empty_vac' => 'No settled absences',
            'info' => 'Student information',
            'student_details' => 'Student details',
            'father' => 'Father details',
            'mother' => 'Mother details',
            'general' => 'General details',
            'siblings' => 'Brothers / Sisters',
            'year' => 'Year',
            'class' => 'Class',
            'specialty' => 'Specialty',
            'whatsapp' => 'Whatsapp',
            'mobile' => 'Mobile',
            'other_phone' => 'Other phone',
            'job' => 'Job',
            'id' => 'ID',
            'ed_state' => 'Educational state',
            'divorce' => 'In case of separation, student lives with',
            'death' => 'In case of death of parents',
            'chronic' => 'Suffer from any chronic disease?',
            'allergy' => 'Suffer from an allergy to any type of medication?',
            'surgery' => 'Any previous surgeries?',
            'emergency' => 'Emergency number',
            'relation' => 'Degree of relation',
            'yes' => 'Yes',
            'no' => 'No',
            'absence' => 'Absence',
            'absence_of' => 'Absence',
            'unsettled' => 'Absences not settled',
            'settled' => 'Settled absence',
            'vacation' => 'Vacation',
            'view_vacation' => 'View vacation',
            'vac_start' => 'Vacation start date',
            'vac_end' => 'Vacation end date',
            'vac_return' => 'The day of returning to school',
            'vac_type' => 'Type',
            'sick_note' => 'Sick note',
            'sick_attached' => 'Sick note attached',
            'description' => 'Brief description',
            'ed' => 'ED',
            'gov' => 'GOV',
            'vac_sick' => 'Sick',
            'vac_champ' => 'Championship',
            'vac_travel' => 'Travel',
            'vac_na' => 'N/A',
            'type_sci' => 'Scientific',
            'type_sciences' => 'Sciences',
            'type_maths' => 'Maths',
            'type_lit' => 'Literature',
            'day' => 'Day',
            'days' => 'Days',
        );
    }
}

function staff_students_use_dummy()
{
    global $staffPreview, $database;
    if (!empty($staffPreview)) {
        return true;
    }
    return !isset($database) || !($database instanceof mysqli);
}

function staff_students_preview_helpers()
{
    global $staffLang;
    if (!staff_students_use_dummy()) {
        return;
    }

    $today = strtotime('today');
    $GLOBALS['staffDummyTeacherYears'] = array(0, 1, 5, 12);
    $GLOBALS['staffDummyClasses'] = array(
        array('id' => '101', 'name' => '5-A', 'study_year' => '5'),
        array('id' => '102', 'name' => '5-B', 'study_year' => '5'),
        array('id' => '201', 'name' => 'S1-A', 'study_year' => '12'),
        array('id' => '301', 'name' => 'KG1-A', 'study_year' => '1'),
        array('id' => '401', 'name' => 'PS-A', 'study_year' => '0'),
    );

    $arb = ($staffLang === 'arb');
    $GLOBALS['staffDummyKids'] = array(
        array(
            'id' => '1',
            'fn_name' => $arb ? 'يوسف أحمد' : 'Youssef Ahmed',
            'name' => $arb ? 'يوسف أحمد' : 'Youssef Ahmed',
            'study_year' => '5',
            'study_type' => '0',
            'class' => '101',
            'gov_id' => '30101010101011',
            'ed_id' => '10021',
            'whatsapp' => '01000000001',
            'picture' => '',
            'gender' => '1',
            'father_name' => $arb ? 'أحمد محمد' : 'Ahmed Mohamed',
            'father_mobile' => '01000000010',
            'other_phone' => '0223456789',
            'father_job' => $arb ? 'مهندس' : 'Engineer',
            'father_gov_id' => '28010101010101',
            'mother_name' => $arb ? 'منى حسن' : 'Mona Hassan',
            'mother_mobile' => '01000000011',
            'mother_job' => $arb ? 'معلمة' : 'Teacher',
            'mother_gov_id' => '28501010101010',
            'ed_welaya' => $arb ? 'القاهرة' : 'Cairo',
            'divorce_living' => $arb ? 'لا يوجد' : 'N/A',
            'death' => $arb ? 'لا يوجد' : 'N/A',
            'chronic_disease' => '0',
            'chronic_disease_name' => '',
            'allergy_to_med' => '1',
            'allergy_to_med_name' => $arb ? 'بنسلين' : 'Penicillin',
            'surgery' => $arb ? 'لا' : 'No',
            'emergency_phone' => '01000000012',
            'emergency_relative' => $arb ? 'عم' : 'Uncle',
        ),
        array(
            'id' => '2',
            'fn_name' => $arb ? 'ليلى أحمد' : 'Layla Ahmed',
            'name' => $arb ? 'ليلى أحمد' : 'Layla Ahmed',
            'study_year' => '5',
            'study_type' => '0',
            'class' => '101',
            'gov_id' => '30101010101022',
            'ed_id' => '10022',
            'whatsapp' => '01000000002',
            'picture' => '',
            'gender' => '2',
            'father_name' => $arb ? 'أحمد محمد' : 'Ahmed Mohamed',
            'father_mobile' => '01000000010',
            'other_phone' => '0223456789',
            'father_job' => $arb ? 'مهندس' : 'Engineer',
            'father_gov_id' => '28010101010101',
            'mother_name' => $arb ? 'منى حسن' : 'Mona Hassan',
            'mother_mobile' => '01000000011',
            'mother_job' => $arb ? 'معلمة' : 'Teacher',
            'mother_gov_id' => '28501010101010',
            'ed_welaya' => $arb ? 'القاهرة' : 'Cairo',
            'divorce_living' => $arb ? 'لا يوجد' : 'N/A',
            'death' => $arb ? 'لا يوجد' : 'N/A',
            'chronic_disease' => '0',
            'chronic_disease_name' => '',
            'allergy_to_med' => '0',
            'allergy_to_med_name' => '',
            'surgery' => $arb ? 'لا' : 'No',
            'emergency_phone' => '01000000012',
            'emergency_relative' => $arb ? 'عم' : 'Uncle',
        ),
        array(
            'id' => '3',
            'fn_name' => $arb ? 'عمر أحمد' : 'Omar Ahmed',
            'name' => $arb ? 'عمر أحمد' : 'Omar Ahmed',
            'study_year' => '5',
            'study_type' => '0',
            'class' => '102',
            'gov_id' => '30101010101033',
            'ed_id' => '10023',
            'whatsapp' => '01000000003',
            'picture' => '',
            'gender' => '1',
            'father_name' => $arb ? 'سعيد عمر' : 'Saeed Omar',
            'father_mobile' => '01000000020',
            'other_phone' => '',
            'father_job' => $arb ? 'طبيب' : 'Doctor',
            'father_gov_id' => '27501010101010',
            'mother_name' => $arb ? 'هدى علي' : 'Huda Ali',
            'mother_mobile' => '01000000021',
            'mother_job' => $arb ? 'صيدلية' : 'Pharmacist',
            'mother_gov_id' => '28001010101020',
            'ed_welaya' => $arb ? 'الجيزة' : 'Giza',
            'divorce_living' => '',
            'death' => '',
            'chronic_disease' => '0',
            'chronic_disease_name' => '',
            'allergy_to_med' => '0',
            'allergy_to_med_name' => '',
            'surgery' => '',
            'emergency_phone' => '01000000022',
            'emergency_relative' => $arb ? 'جدة' : 'Grandmother',
        ),
        array(
            'id' => '4',
            'fn_name' => $arb ? 'ملك أحمد' : 'Malak Ahmed',
            'name' => $arb ? 'ملك أحمد' : 'Malak Ahmed',
            'study_year' => '12',
            'study_type' => '1',
            'class' => '201',
            'gov_id' => '30101010101044',
            'ed_id' => '20011',
            'whatsapp' => '01000000004',
            'picture' => '',
            'gender' => '2',
            'father_name' => $arb ? 'أحمد فوزي' : 'Ahmed Fawzy',
            'father_mobile' => '01000000030',
            'other_phone' => '0222222222',
            'father_job' => $arb ? 'محام' : 'Lawyer',
            'father_gov_id' => '27010101010101',
            'mother_name' => $arb ? 'سارة نبيل' : 'Sara Nabil',
            'mother_mobile' => '01000000031',
            'mother_job' => $arb ? 'محاسبة' : 'Accountant',
            'mother_gov_id' => '27501010101030',
            'ed_welaya' => $arb ? 'القاهرة' : 'Cairo',
            'divorce_living' => '',
            'death' => '',
            'chronic_disease' => '1',
            'chronic_disease_name' => $arb ? 'ربو' : 'Asthma',
            'allergy_to_med' => '0',
            'allergy_to_med_name' => '',
            'surgery' => $arb ? 'لا' : 'No',
            'emergency_phone' => '01000000032',
            'emergency_relative' => $arb ? 'أب' : 'Father',
        ),
        array(
            'id' => '5',
            'fn_name' => $arb ? 'آدم حسن' : 'Adam Hassan',
            'name' => $arb ? 'آدم حسن' : 'Adam Hassan',
            'study_year' => '0',
            'study_type' => '0',
            'class' => '401',
            'gov_id' => '30101010101055',
            'ed_id' => '5001',
            'whatsapp' => '01000000005',
            'picture' => '',
            'gender' => '1',
            'father_name' => $arb ? 'حسن علي' : 'Hassan Ali',
            'father_mobile' => '01000000040',
            'other_phone' => '',
            'father_job' => $arb ? 'موظف' : 'Employee',
            'father_gov_id' => '27001010101010',
            'mother_name' => $arb ? 'نورا سمير' : 'Nora Samir',
            'mother_mobile' => '01000000041',
            'mother_job' => $arb ? 'ربة منزل' : 'Homemaker',
            'mother_gov_id' => '28001010101040',
            'ed_welaya' => $arb ? 'الإسكندرية' : 'Alexandria',
            'divorce_living' => '',
            'death' => '',
            'chronic_disease' => '0',
            'chronic_disease_name' => '',
            'allergy_to_med' => '0',
            'allergy_to_med_name' => '',
            'surgery' => '',
            'emergency_phone' => '01000000042',
            'emergency_relative' => $arb ? 'أم' : 'Mother',
        ),
    );

    $GLOBALS['staffDummyList'] = array(
        array('parent_id' => '10', 'kid_id' => '1'),
        array('parent_id' => '10', 'kid_id' => '2'),
        array('parent_id' => '11', 'kid_id' => '3'),
        array('parent_id' => '12', 'kid_id' => '4'),
        array('parent_id' => '13', 'kid_id' => '5'),
    );

    $GLOBALS['staffDummyVacations'] = array(
        array(
            'id' => '50',
            'kid_id' => '1',
            'study_year' => '5',
            'vacation_date' => (string) ($today - 86400 * 10),
            'vacation_end' => (string) ($today - 86400 * 7),
            'type' => '1',
            'sick_note' => 'sick-note.pdf',
            'text' => $arb ? 'إنفلونزا' : 'Flu',
        ),
        array(
            'id' => '51',
            'kid_id' => '4',
            'study_year' => '12',
            'vacation_date' => (string) ($today - 86400 * 4),
            'vacation_end' => (string) ($today - 86400 * 2),
            'type' => '3',
            'sick_note' => null,
            'text' => $arb ? 'سفر عائلي' : 'Family travel',
        ),
    );

    $GLOBALS['staffDummyAbsence'] = array(
        array('id' => '80', 'kid_id' => '1', 'date' => (string) ($today - 86400 * 3), 'confirm' => '1'),
        array('id' => '81', 'kid_id' => '1', 'date' => (string) ($today - 86400 * 9), 'confirm' => '1'),
        array('id' => '82', 'kid_id' => '3', 'date' => (string) ($today - 86400 * 1), 'confirm' => '1'),
        array('id' => '83', 'kid_id' => '4', 'date' => (string) ($today - 86400 * 3), 'confirm' => '1'),
    );

    if (!function_exists('year_of_study')) {
        function year_of_study($id)
        {
            global $staffLang;
            $id = (int) $id;
            if ($staffLang === 'arb') {
                $map = array(
                    0 => 'بري سكول', 1 => 'رياض أطفال 1', 2 => 'رياض أطفال 2',
                    3 => 'الابتدائي 1', 4 => 'الابتدائي 2', 5 => 'الابتدائي 3',
                    6 => 'الابتدائي 4', 7 => 'الابتدائي 5', 8 => 'الابتدائي 6',
                    9 => 'الاعدادي 1', 10 => 'الاعدادي 2', 11 => 'الاعدادي 3',
                    12 => 'الثانوي 1', 13 => 'الثانوي 2', 14 => 'الثانوي 3',
                    15 => 'عام',
                );
            } else {
                $map = array(
                    0 => 'Preschool', 1 => 'KG1', 2 => 'KG2',
                    3 => 'Junior One', 4 => 'Junior Two', 5 => 'Junior Three',
                    6 => 'Junior Four', 7 => 'Junior Five', 8 => 'Junior Six',
                    9 => 'Middle One', 10 => 'Middle Two', 11 => 'Middle Three',
                    12 => 'Senior One', 13 => 'Senior Two', 14 => 'Senior Three',
                    15 => 'General',
                );
            }
            return isset($map[$id]) ? $map[$id] : '';
        }
    }

    if (!function_exists('class_name')) {
        function class_name($id)
        {
            foreach ($GLOBALS['staffDummyClasses'] as $row) {
                if ((int) $row['id'] === (int) $id) {
                    return $row['name'];
                }
            }
            return '';
        }
    }

    if (!function_exists('kid_name')) {
        function kid_name($id)
        {
            foreach ($GLOBALS['staffDummyKids'] as $row) {
                if ((int) $row['id'] === (int) $id) {
                    return ($row['fn_name'] !== '' && $row['fn_name'] !== null) ? $row['fn_name'] : $row['name'];
                }
            }
            return '';
        }
    }

    if (!function_exists('kid_pic')) {
        function kid_pic($id)
        {
            foreach ($GLOBALS['staffDummyKids'] as $row) {
                if ((int) $row['id'] === (int) $id) {
                    return $row['picture'];
                }
            }
            return null;
        }
    }

    if (!function_exists('parent_id')) {
        function parent_id($id)
        {
            foreach ($GLOBALS['staffDummyList'] as $row) {
                if ((int) $row['kid_id'] === (int) $id) {
                    return $row['parent_id'];
                }
            }
            return '';
        }
    }

    if (!function_exists('vacation_check')) {
        function vacation_check($vacation_date, $kid_id)
        {
            $n = 0;
            foreach ($GLOBALS['staffDummyVacations'] as $row) {
                if ((int) $row['kid_id'] !== (int) $kid_id) {
                    continue;
                }
                if ($row['vacation_date'] <= $vacation_date && $row['vacation_end'] > $vacation_date) {
                    $n++;
                }
            }
            return $n;
        }
    }

    if (!function_exists('vac_days')) {
        function vac_days($start, $end)
        {
            $days = round(($end - $start) / 86400, 0);
            global $S;
            if ($days == 1) {
                return $days . ' ' . $S['day'];
            }
            return $days . ' ' . $S['days'];
        }
    }

    if (!function_exists('kid_vac_type')) {
        function kid_vac_type($id)
        {
            return staff_students_vac_type($id);
        }
    }

    if (!function_exists('study_type')) {
        function study_type($id)
        {
            return staff_students_study_type($id);
        }
    }
}

function staff_students_esc($value)
{
    global $database;
    if (staff_students_use_dummy() || !isset($database) || !($database instanceof mysqli)) {
        return addslashes((string) $value);
    }
    return mysqli_real_escape_string($database, (string) $value);
}

function staff_students_query($sql)
{
    global $database, $database_database;
    if (staff_students_use_dummy()) {
        return array();
    }
    if (!isset($database) || !($database instanceof mysqli)) {
        return array();
    }
    mysqli_select_db($database, $database_database);
    $res = @mysqli_query($database, $sql);
    $rows = array();
    if ($res) {
        while ($row = mysqli_fetch_assoc($res)) {
            $rows[] = $row;
        }
    }
    return $rows;
}

function staff_students_tone($i)
{
    $tones = array('t-gold', 't-green', 't-coral', 't-navy', 't-blue');
    return $tones[$i % 5];
}

function staff_students_initials($name)
{
    $parts = preg_split('/\s+/u', trim((string) $name));
    $out = '';
    if (!empty($parts[0])) {
        $out .= function_exists('mb_substr') ? mb_substr($parts[0], 0, 1, 'UTF-8') : substr($parts[0], 0, 1);
    }
    if (!empty($parts[1])) {
        $out .= function_exists('mb_substr') ? mb_substr($parts[1], 0, 1, 'UTF-8') : substr($parts[1], 0, 1);
    }
    if ($out === '') {
        $out = 'S';
    }
    return function_exists('mb_strtoupper') ? mb_strtoupper($out, 'UTF-8') : strtoupper($out);
}

function staff_students_year_label($id)
{
    $label = function_exists('year_of_study') ? trim((string) year_of_study($id)) : (string) $id;
    return $label;
}

function staff_students_class_label($id)
{
    $label = function_exists('class_name') ? trim((string) class_name($id)) : '';
    return $label;
}

function staff_students_kid_label($row)
{
    if (!empty($row['fn_name'])) {
        return $row['fn_name'];
    }
    if (!empty($row['name'])) {
        return $row['name'];
    }
    return function_exists('kid_name') ? (string) kid_name($row['id']) : '';
}

function staff_students_pic_url($kidId, $row = null)
{
    $pic = '';
    if (is_array($row) && isset($row['picture'])) {
        $pic = trim((string) $row['picture']);
    } elseif (function_exists('kid_pic')) {
        $pic = trim((string) kid_pic($kidId));
    }
    if ($pic === '' || strcasecmp($pic, 'null') === 0) {
        return 'https://system.helalia-ls.org/kids/no-picture.png';
    }
    $pic = basename(str_replace('\\', '/', $pic));
    return 'https://system.helalia-ls.org/kids/' . rawurlencode($pic);
}

function staff_students_study_type($id)
{
    global $S;
    switch ((int) $id) {
        case 1:
            return $S['type_sci'];
        case 2:
            return $S['type_sciences'];
        case 3:
            return $S['type_maths'];
        case 4:
            return $S['type_lit'];
    }
    return '';
}

function staff_students_vac_type($id)
{
    global $S;
    switch ((int) $id) {
        case 1:
            return $S['vac_sick'];
        case 2:
            return $S['vac_champ'];
        case 3:
            return $S['vac_travel'];
        case 4:
            return $S['vac_na'];
    }
    return '';
}

function staff_students_vac_days($start, $end)
{
    global $S;
    $days = (int) round(($end - $start) / 86400, 0);
    if ($days == 1) {
        return $days . ' ' . $S['day'];
    }
    return $days . ' ' . $S['days'];
}

function staff_students_year_group($year)
{
    if (function_exists('staff_year_group')) {
        return staff_year_group($year);
    }
    $year = (int) $year;
    if ($year < 1) {
        return 0;
    }
    if ($year < 3) {
        return 1;
    }
    if ($year < 6) {
        return 2;
    }
    if ($year < 9) {
        return 3;
    }
    if ($year < 12) {
        return 4;
    }
    return 5;
}

function staff_students_year_ok($year)
{
    global $empId, $staffPreview;
    if ($staffPreview) {
        return true;
    }
    $eid = (int) $empId;
    if ($eid < 1) {
        return false;
    }
    if (!function_exists('app10access') || app10access($eid) != 1) {
        return false;
    }
    $fn = 'app10_' . staff_students_year_group((int) $year) . 'access';
    return function_exists($fn) && $fn($eid) == 1;
}

function staff_students_years()
{
    global $empId, $staffPreview;
    if (staff_students_use_dummy()) {
        $years = isset($GLOBALS['staffDummyTeacherYears']) ? $GLOBALS['staffDummyTeacherYears'] : array(1, 5, 12);
        $years = array_map('intval', $years);
        sort($years, SORT_NUMERIC);
        return $years;
    }
    $years = array();
    for ($y = 0; $y <= 14; $y++) {
        if (staff_students_year_ok($y)) {
            $years[] = $y;
        }
    }
    return $years;
}

function staff_students_year_allowed($year)
{
    if ($year === '' || $year === null) {
        return true;
    }
    return staff_students_year_ok((int) $year);
}

function staff_students_text($value)
{
    $v = trim((string) $value);
    if ($v === '' || strcasecmp($v, 'null') === 0) {
        return '—';
    }
    return $v;
}

function staff_students_classes($year)
{
    if (staff_students_use_dummy()) {
        $out = array();
        foreach ($GLOBALS['staffDummyClasses'] as $row) {
            if ((int) $row['study_year'] === (int) $year) {
                $out[] = $row;
            }
        }
        return $out;
    }
    $year = staff_students_esc($year);
    return staff_students_query("SELECT * FROM `class` where `study_year` = '{$year}' order by `name` asc");
}

function staff_students_class_row($id)
{
    if (staff_students_use_dummy()) {
        foreach ($GLOBALS['staffDummyClasses'] as $row) {
            if ((int) $row['id'] === (int) $id) {
                return $row;
            }
        }
        return null;
    }
    $id = staff_students_esc($id);
    $rows = staff_students_query("SELECT * FROM `class` where `id` = '{$id}'");
    return $rows ? $rows[0] : null;
}

function staff_students_kids_in_class($classId)
{
    if (staff_students_use_dummy()) {
        $out = array();
        foreach ($GLOBALS['staffDummyKids'] as $row) {
            if ((int) $row['class'] === (int) $classId) {
                $out[] = $row;
            }
        }
        return $out;
    }
    $classId = staff_students_esc($classId);
    return staff_students_query("SELECT * FROM `kids` WHERE `id`>0 AND `class` = '{$classId}'");
}

function staff_students_search()
{
    $name = '';
    $ed_id = '';
    $gov_id = '';
    $study_year = '';
    if (isset($_GET['name']) && $_GET['name'] !== '') {
        $safe = staff_students_esc($_GET['name']);
        $name = "  AND  ( `fn_name` like '%{$safe}%' || `name` like '%{$safe}%' )";
    }
    if (isset($_GET['ed_id']) && $_GET['ed_id'] > 0) {
        $safe = staff_students_esc($_GET['ed_id']);
        $ed_id = "  AND  `ed_id` = '{$safe}' ";
    }
    if (isset($_GET['gov_id']) && $_GET['gov_id'] > 0) {
        $safe = staff_students_esc($_GET['gov_id']);
        $gov_id = "  AND  `gov_id` = '{$safe}' ";
    }
    if (isset($_GET['study_year']) && $_GET['study_year'] !== '') {
        $safe = staff_students_esc($_GET['study_year']);
        $study_year = "  AND  `study_year` = '{$safe}' ";
    }

    if (staff_students_use_dummy()) {
        $out = array();
        $qName = isset($_GET['name']) ? trim((string) $_GET['name']) : '';
        if ($qName !== '' && function_exists('mb_strtolower')) {
            $qName = mb_strtolower($qName, 'UTF-8');
        } else {
            $qName = strtolower($qName);
        }
        $yearPick = (isset($_GET['study_year']) && $_GET['study_year'] !== '');
        foreach ($GLOBALS['staffDummyKids'] as $row) {
            if ($qName !== '') {
                $hay = (string) $row['fn_name'] . ' ' . $row['name'];
                $hay = function_exists('mb_strtolower') ? mb_strtolower($hay, 'UTF-8') : strtolower($hay);
                if (function_exists('mb_stripos')) {
                    if (mb_stripos($hay, $qName, 0, 'UTF-8') === false) {
                        continue;
                    }
                } elseif (stripos($hay, $qName) === false) {
                    continue;
                }
            }
            if (isset($_GET['ed_id']) && $_GET['ed_id'] > 0 && (string) $row['ed_id'] !== (string) $_GET['ed_id']) {
                continue;
            }
            if (isset($_GET['gov_id']) && $_GET['gov_id'] > 0 && (string) $row['gov_id'] !== (string) $_GET['gov_id']) {
                continue;
            }
            if ($yearPick && (int) $row['study_year'] !== (int) $_GET['study_year']) {
                continue;
            }
            $out[] = $row;
        }
        return $out;
    }

    return staff_students_query("SELECT * FROM `kids` WHERE `id`>0  $name $ed_id $gov_id $study_year");
}

function staff_students_kid($id)
{
    if (staff_students_use_dummy()) {
        foreach ($GLOBALS['staffDummyKids'] as $row) {
            if ((int) $row['id'] === (int) $id) {
                return $row;
            }
        }
        return null;
    }
    $id = staff_students_esc($id);
    $rows = staff_students_query("SELECT * FROM `kids` where `id` = '{$id}'");
    return $rows ? $rows[0] : null;
}

function staff_students_family($kidId)
{
    $parent = function_exists('parent_id') ? parent_id($kidId) : '';
    if ($parent === '' || $parent === null) {
        return array();
    }
    if (staff_students_use_dummy()) {
        $siblings = array();
        foreach ($GLOBALS['staffDummyList'] as $row) {
            if ((string) $row['parent_id'] === (string) $parent && (int) $row['kid_id'] !== (int) $kidId) {
                $kid = staff_students_kid($row['kid_id']);
                if ($kid) {
                    $siblings[] = $kid;
                }
            }
        }
        return $siblings;
    }
    $parent = staff_students_esc($parent);
    $kidId = staff_students_esc($kidId);
    $list = staff_students_query("SELECT * FROM `kids_list` WHERE `parent_id` = '{$parent}' AND `kid_id` != '{$kidId}' ");
    $out = array();
    foreach ($list as $row) {
        $sid = staff_students_esc($row['kid_id']);
        $kids = staff_students_query("SELECT * FROM `kids` WHERE `id` = '{$sid}'   ");
        if ($kids) {
            $out[] = $kids[0];
        }
    }
    return $out;
}

function staff_students_vacations($kidId, $studyYear)
{
    if (staff_students_use_dummy()) {
        $out = array();
        foreach ($GLOBALS['staffDummyVacations'] as $row) {
            if ((int) $row['kid_id'] === (int) $kidId && (string) $row['study_year'] === (string) $studyYear) {
                $out[] = $row;
            }
        }
        return $out;
    }
    $kidId = staff_students_esc($kidId);
    $studyYear = staff_students_esc($studyYear);
    return staff_students_query("SELECT * FROM `kids_vacations` where `kid_id` = '{$kidId}' and `study_year`='{$studyYear}'  ");
}

function staff_students_absences($kidId)
{
    if (staff_students_use_dummy()) {
        $out = array();
        foreach ($GLOBALS['staffDummyAbsence'] as $row) {
            if ((int) $row['kid_id'] === (int) $kidId && (int) $row['confirm'] === 1) {
                $out[] = $row;
            }
        }
        return $out;
    }
    $kidId = staff_students_esc($kidId);
    return staff_students_query("SELECT * FROM `kids-absence` where `kid_id`='{$kidId}' and `confirm` = 1  ");
}

function staff_students_vacation($id)
{
    if (staff_students_use_dummy()) {
        foreach ($GLOBALS['staffDummyVacations'] as $row) {
            if ((int) $row['id'] === (int) $id) {
                return $row;
            }
        }
        return null;
    }
    $id = staff_students_esc($id);
    $rows = staff_students_query("SELECT * FROM `kids_vacations` where  `id` = '{$id}' ");
    return $rows ? $rows[0] : null;
}

function staff_students_empty($text)
{
    echo '<div class="empty"><p>' . staff_h($text) . '</p></div>';
}

function staff_students_back_btn($href)
{
    global $S;
    echo '<a class="btn btn--primary stu-back" href="' . staff_h($href) . '">' . staff_h($S['back']) . '</a>';
}

function staff_students_message_page($title, $text, $backHref)
{
    staff_inner($title, $backHref);
    staff_students_empty($text);
    staff_students_back_btn($backHref);
    staff_inner_end();
}

function staff_students_fact_block($title, $rows)
{
    if (!$rows) {
        return;
    }
    echo '<section class="facts">';
    echo '<p class="facts__h">' . staff_h($title) . '</p>';
    foreach ($rows as $row) {
        if ($row === null) {
            continue;
        }
        echo '<div class="facts__row">';
        echo '<span class="facts__k">' . staff_h($row[0]) . '</span>';
        if (isset($row[2])) {
            echo '<span class="facts__v">' . $row[2] . '</span>';
        } else {
            echo '<span class="facts__v">' . staff_h(staff_students_text($row[1])) . '</span>';
        }
        echo '</div>';
    }
    echo '</section>';
}

function staff_students_kid_rows($kids, $extraQs = '')
{
    global $S;
    if (!$kids) {
        staff_students_empty($S['empty']);
        return;
    }
    echo '<div class="rows">';
    $i = 0;
    foreach ($kids as $kid) {
        $name = staff_students_kid_label($kid);
        $year = staff_students_year_label($kid['study_year']);
        $class = staff_students_class_label($kid['class']);
        $href = 'student-view.php?id=' . urlencode($kid['id']) . $extraQs;
        echo '<a class="row ' . staff_students_tone($i) . '" href="' . staff_h($href) . '">';
        echo '<span class="av av--sm ' . staff_students_tone($i) . '">' . staff_h(staff_students_initials($name)) . '</span>';
        echo '<div class="row__body">';
        echo '<p class="row__title">' . staff_h($name) . '</p>';
        echo '<p class="row__meta">' . staff_h(trim($year . ($class !== '' ? ' / ' . $class : ''))) . '<br>';
        echo staff_h($S['ed'] . ': ' . staff_students_text($kid['ed_id']) . ' · ' . $S['gov'] . ': ' . staff_students_text($kid['gov_id']));
        echo '</p></div>';
        echo '<span class="row__go">›</span>';
        echo '</a>';
        $i++;
    }
    echo '</div>';
}

function staff_students_render_index()
{
    global $S;
    $searching = isset($_GET['submit']);
    $nameVal = isset($_GET['name']) ? (string) $_GET['name'] : '';
    $edVal = isset($_GET['ed_id']) ? (string) $_GET['ed_id'] : '';
    $govVal = isset($_GET['gov_id']) ? (string) $_GET['gov_id'] : '';
    $yearVal = isset($_GET['study_year']) ? (string) $_GET['study_year'] : '';
    $years = staff_students_years();

    if ($searching && $yearVal !== '' && !staff_students_year_allowed($yearVal)) {
        staff_students_message_page($S['title'], $S['year_invalid'], 'students.php');
        return;
    }

    $kids = $searching ? staff_students_search() : array();
    if ($searching && !$kids) {
        staff_students_message_page($S['results'], $S['empty'], 'students.php');
        return;
    }

    staff_inner($S['title'], 'emp-view.php');
    echo '<form class="form-stack" method="get">';
    echo '<label class="field"><span class="field__label">' . staff_h($S['name']) . '</span>';
    echo '<input class="input" type="text" name="name" value="' . staff_h($nameVal) . '" autocomplete="name"></label>';
    echo '<label class="field"><span class="field__label">' . staff_h($S['ed_id']) . '</span>';
    echo '<input class="input" type="text" name="ed_id" value="' . staff_h($edVal) . '" inputmode="numeric"></label>';
    echo '<label class="field"><span class="field__label">' . staff_h($S['gov_id']) . '</span>';
    echo '<input class="input" type="text" name="gov_id" value="' . staff_h($govVal) . '" inputmode="numeric"></label>';
    echo '<label class="field"><span class="field__label">' . staff_h($S['study_year']) . '</span>';
    echo '<select class="input" name="study_year">';
    echo '<option value="">' . staff_h($S['year_pick']) . '</option>';
    foreach ($years as $y) {
        $sel = ($yearVal !== '' && (string) $yearVal === (string) $y) ? ' selected' : '';
        echo '<option value="' . $y . '"' . $sel . '>' . staff_h(staff_students_year_label($y)) . '</option>';
    }
    echo '</select></label>';
    echo '<button class="btn btn--primary" type="submit" name="submit" value="1">' . staff_h($S['search']) . '</button>';
    echo '</form>';

    if ($searching && $kids) {
        echo '<div class="sec"><h2 class="sec__title">' . staff_h($S['results']) . '</h2></div>';
        staff_students_kid_rows($kids, '');
    }
    staff_inner_end();
}

function staff_students_missing_back()
{
    if (function_exists('dual_is_parent_mode') && dual_is_parent_mode()) {
        return 'parent-home.php';
    }
    return 'students.php';
}

function staff_students_back_from_view($kid)
{
    if (function_exists('dual_is_parent_mode') && dual_is_parent_mode()) {
        return 'parent-kid.php?id=' . urlencode((string) $kid['id']);
    }
    return 'students.php';
}

function staff_students_parent_guard($id)
{
    if (!function_exists('dual_is_parent_mode') || !dual_is_parent_mode()) {
        return;
    }
    if (!dual_owns_kid($id)) {
        header('Location: parent-home.php');
        exit;
    }
}

function staff_students_render_view()
{
    global $S;
    $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
    staff_students_parent_guard($id);
    $kid = $id > 0 ? staff_students_kid($id) : null;
    if (!$kid) {
        staff_students_message_page($S['info'], $S['not_found'], staff_students_missing_back());
        return;
    }

    $name = staff_students_kid_label($kid);
    $year = staff_students_year_label($kid['study_year']);
    $class = staff_students_class_label($kid['class']);

    staff_inner($S['info'], staff_students_back_from_view($kid));
    echo '<div class="stu-photo">';
    echo '<img src="' . staff_h(staff_students_pic_url($id, $kid)) . '" alt="">';
    echo '<p class="stu-photo__name">' . staff_h($name) . '</p>';
    echo '<p class="stu-photo__meta">' . staff_h(trim($year . ($class !== '' ? ' · ' . $class : ''))) . '</p>';
    echo '</div>';

    $studentRows = array(
        array($S['name'], $name),
        array($S['year'], $year),
    );
    if ((int) $kid['study_year'] === 13 || (int) $kid['study_year'] === 14) {
        $studentRows[] = array($S['specialty'], staff_students_study_type($kid['study_type']));
    }
    $studentRows[] = array($S['class'], $class);
    $studentRows[] = array($S['gov_id'], $kid['gov_id']);
    $studentRows[] = array($S['ed_id'], $kid['ed_id']);
    $studentRows[] = array($S['whatsapp'], $kid['whatsapp']);
    staff_students_fact_block($S['student_details'], $studentRows);

    staff_students_fact_block($S['father'], array(
        array($S['name'], $kid['father_name']),
        array($S['mobile'], $kid['father_mobile']),
        array($S['other_phone'], $kid['other_phone']),
        array($S['job'], $kid['father_job']),
        array($S['id'], $kid['father_gov_id']),
    ));

    staff_students_fact_block($S['mother'], array(
        array($S['name'], $kid['mother_name']),
        array($S['mobile'], $kid['mother_mobile']),
        array($S['job'], $kid['mother_job']),
        array($S['id'], $kid['mother_gov_id']),
    ));

    $chronic = ((int) $kid['chronic_disease'] === 1)
        ? ($S['yes'] . ' - ' . staff_students_text($kid['chronic_disease_name']))
        : $S['no'];
    $allergy = ((int) $kid['allergy_to_med'] === 1)
        ? ($S['yes'] . ' - ' . staff_students_text($kid['allergy_to_med_name']))
        : $S['no'];
    staff_students_fact_block($S['general'], array(
        array($S['ed_state'], $kid['ed_welaya']),
        array($S['divorce'], $kid['divorce_living']),
        array($S['death'], $kid['death']),
        array($S['chronic'], $chronic),
        array($S['allergy'], $allergy),
        array($S['surgery'], $kid['surgery']),
        array($S['emergency'], $kid['emergency_phone']),
        array($S['relation'], $kid['emergency_relative']),
    ));

    $family = staff_students_family($id);
    $sibRows = array();
    if ($family) {
        foreach ($family as $sib) {
            $sibName = staff_students_kid_label($sib);
            $href = 'student-view.php?id=' . urlencode($sib['id']);
            $sibRows[] = array(
                $S['name'],
                $sibName,
                '<a href="' . staff_h($href) . '">' . staff_h($sibName) . '</a>',
            );
            $sibRows[] = array($S['year'], staff_students_year_label($sib['study_year']));
            $sibRows[] = array($S['class'], staff_students_class_label($sib['class']));
        }
    } else {
        $sibRows[] = array($S['name'], '');
        $sibRows[] = array($S['year'], '');
        $sibRows[] = array($S['class'], '');
    }
    staff_students_fact_block($S['siblings'], $sibRows);

    echo '<div class="rows">';
    echo '<a class="row t-gold" href="student-absence.php?id=' . urlencode((string) $id) . '">';
    echo '<span class="row__ico">' . staff_ico('calendar') . '</span>';
    echo '<div class="row__body"><p class="row__title">' . staff_h($S['absence']) . '</p></div>';
    echo '<span class="row__go">›</span></a>';
    echo '</div>';
    staff_inner_end();
}

function staff_students_render_absence()
{
    global $S;
    $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
    staff_students_parent_guard($id);
    $kid = $id > 0 ? staff_students_kid($id) : null;
    if (!$kid) {
        staff_students_message_page($S['absence'], $S['not_found'], staff_students_missing_back());
        return;
    }
    $name = staff_students_kid_label($kid);
    $backAbs = (function_exists('dual_is_parent_mode') && dual_is_parent_mode())
        ? ('parent-kid.php?id=' . urlencode((string) $id))
        : ('student-view.php?id=' . urlencode((string) $id));
    staff_inner($name . ' ' . $S['absence_of'], $backAbs);

    $absences = staff_students_absences($id);
    $unsettled = array();
    foreach ($absences as $row) {
        $check = function_exists('vacation_check') ? vacation_check($row['date'], $id) : 0;
        if ($check < 1) {
            $unsettled[] = $row;
        }
    }
    if ($unsettled) {
        echo '<div class="sec"><h2 class="sec__title">' . staff_h($S['unsettled']) . '</h2></div>';
        echo '<div class="rows">';
        $i = 0;
        foreach ($unsettled as $row) {
            echo '<div class="row ' . staff_students_tone($i) . '">';
            echo '<span class="row__ico">' . staff_ico('calendar') . '</span>';
            echo '<div class="row__body"><p class="row__title">' . staff_h(date('d/m/Y', (int) $row['date'])) . '</p></div>';
            echo '</div>';
            $i++;
        }
        echo '</div>';
    }

    echo '<div class="sec"><h2 class="sec__title">' . staff_h($S['settled']) . '</h2></div>';
    $vacs = staff_students_vacations($id, $kid['study_year']);
    if (!$vacs) {
        staff_students_empty($unsettled ? $S['empty_vac'] : $S['empty_abs']);
    } else {
        echo '<div class="rows">';
        $i = 0;
        foreach ($vacs as $vac) {
            $label = date('d/m/Y', (int) $vac['vacation_date']) . ' - ' . date('d/m/Y', (int) $vac['vacation_end']);
            echo '<a class="row ' . staff_students_tone($i) . '" href="student-view-vacation.php?id=' . urlencode($vac['id']) . '">';
            echo '<span class="row__ico">' . staff_ico('calendar') . '</span>';
            echo '<div class="row__body"><p class="row__title">' . staff_h($label) . '</p>';
            echo '<p class="row__meta">' . staff_h(staff_students_vac_type($vac['type'])) . '</p></div>';
            echo '<span class="row__go">›</span></a>';
            $i++;
        }
        echo '</div>';
    }
    staff_inner_end();
}

function staff_students_render_vacation()
{
    global $S;
    $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
    $vac = $id > 0 ? staff_students_vacation($id) : null;
    if (!$vac) {
        staff_students_message_page($S['vacation'], $S['not_found'], staff_students_missing_back());
        return;
    }
    staff_students_parent_guard((int) $vac['kid_id']);
    $back = 'student-absence.php?id=' . urlencode((string) $vac['kid_id']);
    staff_inner($S['vacation'], $back);

    echo '<p class="lede">' . staff_h($S['view_vacation']) . '</p>';
    $rows = array(
        array($S['vac_start'], date('d/m/Y', (int) $vac['vacation_date'])),
        array($S['vac_end'], date('d/m/Y', (int) $vac['vacation_end'])),
        array($S['vac_return'], staff_students_vac_days($vac['vacation_date'], $vac['vacation_end'])),
        array($S['vac_type'], staff_students_vac_type($vac['type'])),
    );
    if (!empty($vac['sick_note']) && $vac['sick_note'] !== null) {
        $rows[] = array($S['sick_note'], $S['sick_attached']);
    }
    $rows[] = array($S['description'], $vac['text']);
    staff_students_fact_block($S['vacation'], $rows);
    staff_inner_end();
}
