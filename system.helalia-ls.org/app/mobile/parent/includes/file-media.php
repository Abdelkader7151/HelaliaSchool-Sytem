<?php
// ============================================================
// file-media.php — simple helpers for memo / homework / revision
// Style: keep it simple zay el code el adeem (parent-plan.php)
// ============================================================

/**
 * parent_file_ext
 * Betgb el extension beta3 el file (pdf, jpg, docx...)
 * Example: homework-123.pdf -> pdf
 */
function parent_file_ext($file){
  return strtolower(pathinfo(trim((string)$file), PATHINFO_EXTENSION));
}

/**
 * parent_show_banner
 * Bet3red el banner beta3 el memo/homework/revision.
 *
 * Law soora (jpg/png/gif/webp) -> <img>
 * Law PDF / word / excel / ay file tany -> link "Open file"
 *
 * Leh keda?
 * Android WebView beyboz law 7atet PDF gowa <img>
 * iPhone momken ye3ady, bas Android beyb2a glitchy
 * Fa a7san: soora = img, file = link (zay parent-plan.php)
 *
 * $banner = esm el file fe folder homework/
 * $lang   = eng aw arb (3ashan text el zorar)
 */
function parent_show_banner($banner, $lang = 'eng'){
  // mafeesh file? mat3melsh 7aga
  if($banner == NULL || trim((string)$banner) == '' || strcasecmp((string)$banner, 'null') == 0){
    return;
  }

  $path = '../../../../homework/'.$banner;
  if(file_exists($path) != 1){
    return;
  }

  $ext = parent_file_ext($banner);

  // ----- soora? e3mel img -----
  if($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png' || $ext == 'gif' || $ext == 'webp' || $ext == 'bmp'){
    echo '<img src="'.$path.'" alt=" ">';
    return;
  }

  // ----- PDF / office / ba2y el types -> open link -----
  // Android ye2dar yeftah el PDF men el link a7san men <img>
  $label = ($lang == 'arb') ? 'فتح الملف' : 'Open file';
  echo '<a class="fold__item" href="'.$path.'" target="_blank" rel="noopener">';
  if(function_exists('file_icon')){
    echo file_icon($path).' ';
  }
  echo '<span class="fold__item-title">'.$label.'</span>';
  if($ext != ''){
    echo ' <span class="fold__item-meta">'.strtoupper($ext).'</span>';
  }
  echo '</a>';
}
