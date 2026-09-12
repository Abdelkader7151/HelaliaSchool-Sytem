<?php
/**
 * Real dual-role staff already identified from the school database.
 * Used only on this computer when live MySQL is not open to this IP.
 */

function staff_emp_perm($empId, $col)
{
    $empId = (int) $empId;
    if (isset($_SESSION['helalia_snapshot_emp'])) {
        $person = $_SESSION['helalia_snapshot_emp'];
        if ((int) ($person['emp_id'] ?? 0) === $empId && array_key_exists($col, $person)) {
            return $person[$col];
        }
    }
    return 0;
}

function local_real_snapshot_control_flags()
{
    return array(
        'app19' => 1,
        'app19_1' => 1,
    );
}

function local_real_snapshot_absence_flags()
{
    $flags = array(
        'app1' => 1,
        'app6' => 1,
        'app9' => 1,
    );
    for ($i = 0; $i <= 5; $i++) {
        $flags['app1_' . $i] = 1;
        $flags['app6_' . $i] = 1;
        $flags['app9_' . $i] = 1;
    }
    return $flags;
}

function local_real_snapshot_plan_flags()
{
    return array(
        'app12' => 1,
        'app12_0' => 0,
        'app12_1' => 0,
        'app12_2' => 1,
        'app12_3' => 0,
        'app12_4' => 0,
        'app12_5' => 0,
    );
}

function local_real_snapshot_question_flags($person = array())
{
    $flags = array(
        'app20_1' => 1,
        'app20_2' => 0,
        'app20_3_1' => 0,
        'app20_3_2' => 0,
        'app20_3_3' => 1,
        'app20_3_4' => 0,
        'app20_3_5' => 0,
        'app20_3_6' => 0,
        'app20_4_1' => 0,
        'app20_4_2' => 0,
        'app20_4_3' => 1,
        'app20_4_4' => 0,
        'app20_4_5' => 0,
        'app20_4_6' => 0,
        'app20_5_1' => 0,
        'app20_5_2' => 0,
        'app20_5_3' => 1,
        'app20_5_4' => 0,
        'app20_5_5' => 0,
        'app20_5_6' => 0,
        'app20_6_1' => 0,
        'app20_6_2' => 0,
        'app20_6_3' => 1,
        'app20_6_4' => 0,
        'app20_6_5' => 0,
        'app20_6_6' => 0,
        'app20_7_1' => 0,
        'app20_7_2' => 0,
        'app20_7_3' => 1,
        'app20_7_4' => 0,
        'app20_7_5' => 0,
        'app20_7_6' => 0,
        'app20_8' => 0,
    );
    if (!empty($person['job']) && stripos((string) $person['job'], 'coordinator') !== false) {
        $flags['app20_8'] = 1;
    }
    return $flags;
}

function local_real_snapshot_people()
{
    return array(
        array(
            'id' => 91001,
            'emp_id' => 91001,
            'phone' => '01201372952',
            'name' => 'Mervat Abdul Razeq',
            'job' => 'Teacher',
            'kids' => array(
                array('id' => 17401, 'fn_name' => 'Mohamed Ashraf Saeid El Naggar', 'study_year' => 5, 'class' => 0, 'picture' => '', 'role' => 'mother'),
                array('id' => 17402, 'fn_name' => 'Moaz Ashraf Saied Abdellatif Elnagar', 'study_year' => 5, 'class' => 0, 'picture' => '', 'role' => 'mother'),
            ),
        ),
        array(
            'id' => 91002,
            'emp_id' => 91002,
            'phone' => '01006470320',
            'name' => 'Engy Hasan',
            'job' => 'Teacher',
            'kids' => array(
                array('id' => 17403, 'fn_name' => 'Omar Mostafa Hossein Mohamed Ali', 'study_year' => 5, 'class' => 0, 'picture' => '', 'role' => 'mother'),
            ),
        ),
        array(
            'id' => 91003,
            'emp_id' => 91003,
            'phone' => '01222316896',
            'name' => 'Heba Aftouh',
            'job' => 'Teacher',
            'kids' => array(
                array('id' => 17404, 'fn_name' => 'Khadija Mohamed Adel Ahmed', 'study_year' => 5, 'class' => 0, 'picture' => '', 'role' => 'mother'),
            ),
        ),
        array(
            'id' => 91004,
            'emp_id' => 91004,
            'phone' => '01000591167',
            'name' => 'Gamal Ahmed',
            'job' => 'Teacher',
            'kids' => array(
                array('id' => 17405, 'fn_name' => 'Yahya Gamal Ahmed Ali Mohamed', 'study_year' => 5, 'class' => 0, 'picture' => '', 'role' => 'father'),
            ),
        ),
        array(
            'id' => 91005,
            'emp_id' => 91005,
            'phone' => '01002206451',
            'name' => 'Hend Ali',
            'job' => 'Coordinator',
            'kids' => array(
                array('id' => 17405, 'fn_name' => 'Yahya Gamal Ahmed Ali Mohamed', 'study_year' => 5, 'class' => 0, 'picture' => '', 'role' => 'mother'),
            ),
        ),
        array(
            'id' => 91006,
            'emp_id' => 91006,
            'phone' => '01282623069',
            'name' => 'Bassant Hamdy',
            'job' => 'Teacher',
            'kids' => array(
                array('id' => 17406, 'fn_name' => 'Younis Amr MohyEl Din Mohamed', 'study_year' => 5, 'class' => 0, 'picture' => '', 'role' => 'mother'),
            ),
        ),
    );
}

function local_real_snapshot_person($id)
{
    $id = (int) $id;
    foreach (local_real_snapshot_people() as $person) {
        if ((int) $person['id'] === $id) {
            return $person + local_real_snapshot_plan_flags() + local_real_snapshot_question_flags($person) + local_real_snapshot_control_flags() + local_real_snapshot_absence_flags();
        }
    }
    return null;
}

function local_real_pack_kids($person)
{
    $out = array();
    foreach ($person['kids'] as $kid) {
        $out[] = array(
            'id' => (int) $kid['id'],
            'fn_name' => $kid['fn_name'],
            'study_year' => isset($kid['study_year']) ? (int) $kid['study_year'] : 0,
            'class' => isset($kid['class']) ? $kid['class'] : '',
            'picture' => '',
            'role' => isset($kid['role']) ? $kid['role'] : 'parent',
            'year_label' => '',
            'class_label' => '',
            'photo' => '',
        );
    }
    return $out;
}
