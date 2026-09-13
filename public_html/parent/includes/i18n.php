<?php
declare(strict_types=1);

function lang(): string
{
    $raw = $_SESSION['lang'] ?? ($_GET['lang'] ?? 'eng');
    return $raw === 'arb' ? 'arb' : 'eng';
}

function is_ar(): bool
{
    return lang() === 'arb';
}

function t(string $key): string
{
    static $map = null;
    if ($map === null) {
        $map = [
            'login_title' => ['eng' => 'Login', 'arb' => 'دخول'],
            'login_lead' => ['eng' => 'Use the same phone and password as the Helalia family app.', 'arb' => 'استخدم نفس رقم الهاتف وكلمة المرور الخاصة بتطبيق هلالية.'],
            'phone' => ['eng' => 'Phone or username', 'arb' => 'الهاتف أو اسم المستخدم'],
            'my_student' => ['eng' => 'My student profile', 'arb' => 'ملفي كطالب'],
            'password' => ['eng' => 'Password', 'arb' => 'كلمة المرور'],
            'remember' => ['eng' => 'Remember', 'arb' => 'تذكرني'],
            'sign_in' => ['eng' => 'Login', 'arb' => 'دخول'],
            'school_name' => ['eng' => 'Helalia Language School', 'arb' => 'مدارس هلالية للغات'],
            'back_site' => ['eng' => 'Back to the school website', 'arb' => 'العودة إلى موقع المدرسة'],
            'err_login' => ['eng' => 'That phone number or password is not correct.', 'arb' => 'رقم الهاتف أو كلمة المرور غير صحيحة.'],
            'err_inactive' => ['eng' => 'This account is not active yet.', 'arb' => 'هذا الحساب غير مفعّل بعد.'],
            'err_staff' => ['eng' => 'Staff accounts sign in from the school app, not this family page.', 'arb' => 'حسابات الموظفين تدخل من تطبيق المدرسة وليس من صفحة الأسرة.'],
            'my_children' => ['eng' => 'My children', 'arb' => 'أبنائي'],
            'add_child' => ['eng' => 'Add child', 'arb' => 'إضافة ابن'],
            'no_children' => ['eng' => 'No children are linked yet. Add a child with the school ID and national ID.', 'arb' => 'لا يوجد أبناء مرتبطون بعد. أضف ابناً برقم المدرسة والرقم القومي.'],
            'upload_video' => ['eng' => 'Upload video', 'arb' => 'رفع فيديو'],
            'upload_hero' => ['eng' => 'Share a class video', 'arb' => 'شارك فيديو الفصل'],
            'alerts' => ['eng' => 'Alerts', 'arb' => 'التنبيهات'],
            'ask_school' => ['eng' => 'Ask school', 'arb' => 'اسأل المدرسة'],
            'calendar' => ['eng' => 'Calendar', 'arb' => 'التقويم'],
            'summary' => ['eng' => 'Summary', 'arb' => 'الملخص'],
            'homework' => ['eng' => 'Homework', 'arb' => 'الواجب'],
            'memo' => ['eng' => 'Memo', 'arb' => 'المذكرة'],
            'results' => ['eng' => 'Results', 'arb' => 'النتائج'],
            'revision' => ['eng' => 'Revision', 'arb' => 'المراجعة'],
            'weekly_plan' => ['eng' => 'Weekly plan', 'arb' => 'الخطة الأسبوعية'],
            'gallery' => ['eng' => 'Gallery', 'arb' => 'المعرض'],
            'photos' => ['eng' => 'Photos', 'arb' => 'الصور'],
            'videos' => ['eng' => 'Videos', 'arb' => 'الفيديو'],
            'settings' => ['eng' => 'Settings', 'arb' => 'الإعدادات'],
            'profile' => ['eng' => 'Profile', 'arb' => 'الملف'],
            'change_password' => ['eng' => 'Change password', 'arb' => 'تغيير كلمة المرور'],
            'absence' => ['eng' => 'Absence request', 'arb' => 'طلب غياب'],
            'sign_out' => ['eng' => 'Sign out', 'arb' => 'خروج'],
            'home' => ['eng' => 'Home', 'arb' => 'الرئيسية'],
            'soon' => ['eng' => 'Coming soon — this screen is reserved in the family app.', 'arb' => 'قريباً — هذه الشاشة محجوزة في تطبيق الأسرة.'],
            'empty' => ['eng' => 'Nothing here yet.', 'arb' => 'لا يوجد شيء هنا بعد.'],
            'youtube' => ['eng' => 'YouTube embed or link', 'arb' => 'رابط أو كود يوتيوب'],
            'mp4' => ['eng' => 'MP4 file', 'arb' => 'ملف MP4'],
            'save' => ['eng' => 'Save', 'arb' => 'حفظ'],
            'need_video' => ['eng' => 'Add an MP4 file or a YouTube link.', 'arb' => 'أضف ملف MP4 أو رابط يوتيوب.'],
            'saved' => ['eng' => 'Saved.', 'arb' => 'تم الحفظ.'],
            'upload_fail' => ['eng' => 'The video could not be saved. Use an MP4 under the size limit.', 'arb' => 'تعذر حفظ الفيديو. استخدم ملف MP4 ضمن الحد المسموح.'],
            'parent_videos' => ['eng' => 'Parent videos', 'arb' => 'فيديوهات أولياء الأمور'],
            'school_id' => ['eng' => 'School ID', 'arb' => 'الرقم المدرسي'],
            'national_id' => ['eng' => 'National ID', 'arb' => 'الرقم القومي'],
            'child_linked' => ['eng' => 'This child is already linked.', 'arb' => 'هذا الابن مرتبط بالفعل.'],
            'child_not_found' => ['eng' => 'No matching student was found.', 'arb' => 'لم يتم العثور على الطالب.'],
            'new_password' => ['eng' => 'New password', 'arb' => 'كلمة المرور الجديدة'],
            'name' => ['eng' => 'Name', 'arb' => 'الاسم'],
            'email' => ['eng' => 'Email', 'arb' => 'البريد'],
            'question' => ['eng' => 'Question', 'arb' => 'السؤال'],
            'recipient' => ['eng' => 'Send to', 'arb' => 'إرسال إلى'],
            'send' => ['eng' => 'Send', 'arb' => 'إرسال'],
            'reply' => ['eng' => 'Reply', 'arb' => 'الرد'],
            'from' => ['eng' => 'From', 'arb' => 'من'],
            'to' => ['eng' => 'To', 'arb' => 'إلى'],
            'note' => ['eng' => 'Note', 'arb' => 'ملاحظة'],
            'sick_note' => ['eng' => 'Sick note (image)', 'arb' => 'شهادة مرضية (صورة)'],
            'type_sick' => ['eng' => 'Sick', 'arb' => 'مرض'],
            'type_champ' => ['eng' => 'Championship', 'arb' => 'بطولة'],
            'type_travel' => ['eng' => 'Travel', 'arb' => 'سفر'],
            'type_na' => ['eng' => 'N/A', 'arb' => 'غير محدد'],
            'download' => ['eng' => 'Download', 'arb' => 'تحميل'],
            'everything' => ['eng' => 'Everything for this student', 'arb' => 'كل ما يخص هذا الطالب'],
            'language' => ['eng' => 'العربية', 'arb' => 'English'],
            'admin' => ['eng' => 'Administration', 'arb' => 'الإدارة'],
            'head_office' => ['eng' => 'Head office', 'arb' => 'شئون الطلاب'],
            'vice' => ['eng' => 'Vice', 'arb' => 'الوكيل'],
            'secretary' => ['eng' => 'Secretary', 'arb' => 'السكرتارية'],
            'doctor' => ['eng' => 'Doctor', 'arb' => 'الطبيب'],
            'therapist' => ['eng' => 'Therapist', 'arb' => 'الأخصائي'],
        ];
    }
    $row = $map[$key] ?? null;
    if (!$row) {
        return $key;
    }
    return $row[lang()] ?? $row['eng'];
}

function year_label(int $id): string
{
    $eng = [
        0 => 'Preschool', 1 => 'KG1', 2 => 'KG2', 3 => 'Junior One', 4 => 'Junior Two',
        5 => 'Junior Three', 6 => 'Junior Four', 7 => 'Junior Five', 8 => 'Junior Six',
        9 => 'Middle One', 10 => 'Middle Two', 11 => 'Middle Three', 12 => 'Senior One',
        13 => 'Senior Two', 14 => 'Senior Three', 15 => 'General',
    ];
    $arb = [
        0 => 'بريسكول', 1 => 'أولى حضانة', 2 => 'ثانية حضانة', 3 => 'الصف الأول الابتدائي',
        4 => 'الصف الثاني الابتدائي', 5 => 'الصف الثالث الابتدائي', 6 => 'الصف الرابع الابتدائي',
        7 => 'الصف الخامس الابتدائي', 8 => 'الصف السادس الابتدائي', 9 => 'الصف الأول الإعدادي',
        10 => 'الصف الثاني الإعدادي', 11 => 'الصف الثالث الإعدادي', 12 => 'الصف الأول الثانوي',
        13 => 'الصف الثاني الثانوي', 14 => 'الصف الثالث الثانوي', 15 => 'عام',
    ];
    $src = is_ar() ? $arb : $eng;
    return $src[$id] ?? '';
}
