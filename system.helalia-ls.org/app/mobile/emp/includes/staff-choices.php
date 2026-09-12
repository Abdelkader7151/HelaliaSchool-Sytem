<?php

function staff_role_switch_tile()
{
    if (!function_exists('dual_has_dual') || !dual_has_dual()) {
        return null;
    }
    return array('swap', 'role_switch', staff_nav_path('choose-role.php'), 't-gold');
}

function staff_render_choices()
{
    global $L;

    $prependEmployee = array();
    $role = staff_role_switch_tile();
    if ($role) {
        $prependEmployee[] = $role;
    }

    $hasContent = staff_home_tools_grid();
    $hasContent = staff_home_extra($prependEmployee) || $hasContent;

    if (!$hasContent) {
        echo '<div class="tool-empty"><p>' . staff_h($L['choices_empty']) . '</p></div>';
    }
}
