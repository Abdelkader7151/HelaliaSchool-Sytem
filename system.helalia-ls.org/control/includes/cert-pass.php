<?php
/**
 * Same pass / promote rules as the live final certificates
 * (view_cert_final.php): start pass=1, one weak subject fails the student.
 * Year 14 (Senior Three) is success only — no next year.
 */
if (!function_exists('helalia_cert_is_pass')) {

function helalia_cert_is_pass($row)
{
    $year = isset($row['study_year']) ? (int) $row['study_year'] : 0;
    $checked = 0;
    for ($i = 1; $i <= 30; $i++) {
        $total = isset($row['subject' . $i . '_total']) ? (float) $row['subject' . $i . '_total'] : 0;
        $mark = isset($row['subject' . $i]) ? (float) $row['subject' . $i] : 0;
        $degreeTotal = isset($row['subject' . $i . '_degree_total']) ? (float) $row['subject' . $i . '_degree_total'] : 0;
        $degree = isset($row['subject' . $i . '_degree']) ? (float) $row['subject' . $i . '_degree'] : 0;

        if ($total <= 0 && $degreeTotal <= 0) {
            continue;
        }
        $checked++;

        if ($degreeTotal > 0) {
            if ((($degree / $degreeTotal) * 100) < 50) {
                return false;
            }
        } elseif ($total > 0) {
            $ratio = $mark / $total;
            if ($year > 5 && $year < 11) {
                if ($ratio < 0.283) {
                    return false;
                }
            } elseif (($ratio * 100) < 50) {
                return false;
            }
        }
    }
    return $checked > 0;
}

function helalia_cert_promote_kid($database, $edId, $certYear)
{
    $certYear = (int) $certYear;
    if ($certYear < 1 || $certYear >= 14) {
        return false;
    }
    $ed = mysqli_real_escape_string($database, (string) $edId);
    $sql = "UPDATE `kids` SET `study_year` = `study_year` + 1
            WHERE `ed_id` = '{$ed}'
              AND `study_year` = {$certYear}
              AND `study_year` < 14
            LIMIT 1";
    return (bool) mysqli_query($database, $sql);
}

}
