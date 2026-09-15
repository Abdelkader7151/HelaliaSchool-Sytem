# Copy live parent/student PHP into live-emp-home/parent-live.
# Does not modify HELALIA-from-cpanel-live or the live server.

import os
import re

ROOT = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
LIVE = os.path.join(
    os.path.dirname(os.path.dirname(ROOT)),
    "HELALIA-from-cpanel-live",
    "system.helalia-ls.org",
    "app",
    "mobile",
)
DEST = os.path.join(ROOT, "parent-live")
ASSET = "https://system.helalia-ls.org/app/mobile/eng/"
ASSET_ARB = "https://system.helalia-ls.org/app/mobile/arb/"
IMGS = "https://system.helalia-ls.org/app/mobile/imgs/"
KIDS = "https://system.helalia-ls.org/kids/"
HW = "https://system.helalia-ls.org/homework/"
SITE = "https://system.helalia-ls.org/"

PAGES = [
    "kids.php",
    "kid-data.php",
    "kid-info.php",
    "update-kid-data.php",
    "homework-subjects.php",
    "kid-memo.php",
    "cert.php",
    "revision-subjects.php",
    "plan.php",
    "gallery.php",
    "album-photos.php",
    "album-videos.php",
    "notifications.php",
    "view-notifications.php",
    "ask-teacher.php",
    "ui-pages-ask-teacher.php",
    "view-question.php",
    "calendar.php",
    "absence.php",
    "submit-vacation.php",
    "view-vacation.php",
    "view_month_cert.php",
    "view_cert_small.php",
    "view_cert_big.php",
    "view_cert_big_med.php",
    "view_cert_final.php",
    "view_cert_final2.php",
    "view_cert_final_11.php",
    "view_cert.php",
    "view_cert_colors.php",
    "view_cert_eva.php",
    "view_cert_big_final.php",
    "ui-pages-gallery.php",
    "ui-pages-gallery-pictures.php",
    "ui-pages-gallery-album.php",
    "ui-pages-videos.php",
    "ui-pages-video-album.php",
    "ui-pages-album-videos.php",
    "videos.php",
    "photos.php",
    "birthday.php",
]

INCLUDES = [
    "top-nav.php",
    "left-nav.php",
    "right-nav.php",
    "footer.php",
    "footer-script.php",
    "top-script.php",
    "kid-img-up.php",
    "footer_questions.php",
]

BOOT_HEAD = """<?php
require_once dirname(__DIR__, 2) . '/includes/parent-live-boot.php';
parent_live_boot();
"""

LANG_HREF = (
    'href="../../%s/kid/<?php echo htmlspecialchars(basename($_SERVER[\'PHP_SELF\'])); ?>'
    '<?php echo !empty($_SERVER[\'QUERY_STRING\']) ? (\'?\' . $_SERVER[\'QUERY_STRING\']) : \'\'; ?>"'
)


def rewrite_assets(text, lang, include_name=None):
    base = ASSET_ARB if lang == "arb" else ASSET
    text = text.replace('href="assets/', f'href="{base}assets/')
    text = text.replace("href='assets/", f"href='{base}assets/")
    text = text.replace('src="assets/', f'src="{base}assets/')
    text = text.replace("src='assets/", f"src='{base}assets/")
    text = text.replace('src="../imgs/', f'src="{IMGS}')
    text = text.replace("src='../imgs/", f"src='{IMGS}")
    text = text.replace("../../../homework/", HW)
    text = text.replace('src="../../../kids/', f'src="{KIDS}')
    text = text.replace("src='../../../kids/", f"src='{KIDS}")
    text = text.replace("src=\"../../../uploads/", f'src="{SITE}uploads/')
    text = text.replace("src='../../../uploads/", f"src='{SITE}uploads/")
    text = text.replace('src="images/', f'src="{base}images/')
    text = text.replace('src="../images/', f'src="{base}images/')
    text = text.replace('href="kids.php"', 'href="../parent-home.php"')
    text = text.replace("href='kids.php'", "href='../parent-home.php'")
    text = text.replace('echo "kids.php"', 'echo "../parent-home.php"')
    text = text.replace("echo 'kids.php'", "echo '../parent-home.php'")
    text = re.sub(r'location:\s*kids\.php', 'Location: ../parent-home.php', text, flags=re.I)
    text = text.replace('href="ui-pages-home.php"', 'href="../parent-home.php"')
    text = text.replace("href='ui-pages-home.php'", "href='../parent-home.php'")
    text = text.replace('href="ui-app-editprofile.php"', 'href="../profile.php"')
    text = text.replace('href="ui-app-password.php"', 'href="../password.php"')
    text = text.replace('href="?exit"', 'href="../emp-view.php?exit=1"')
    if include_name == "right-nav.php":
        text = text.replace('href="../arb"', LANG_HREF % "arb")
        text = text.replace('href="../eng"', LANG_HREF % "eng")
    return text


def strip_bootstrap(text):
    text = re.sub(
        r"<\?php\s*require_once\('\.\./Connections/database\.php'\);",
        BOOT_HEAD,
        text,
        count=1,
        flags=re.I,
    )
    text = re.sub(r'\s*include\("includes/logout\.php"\);', "", text, count=1)
    text = re.sub(r'\s*include\("includes/access\.php"\);', "", text, count=1)
    text = re.sub(r'\s*include\("includes/functions\.php"\);', "", text, count=1)
    text = re.sub(r'\s*include\("includes/confirm_parent\.php"\);', "", text, count=1)
    return text


def write_stub_includes(lang_dir):
    inc = os.path.join(lang_dir, "includes")
    os.makedirs(inc, exist_ok=True)
    open(os.path.join(inc, "access.php"), "w", encoding="utf-8").write("<?php\n")
    open(os.path.join(inc, "logout.php"), "w", encoding="utf-8").write("<?php\n")
    open(os.path.join(inc, "functions.php"), "w", encoding="utf-8").write("<?php\n")
    open(os.path.join(inc, "confirm_parent.php"), "w", encoding="utf-8").write(
        "<?php\n"
        "$kidId = 0;\n"
        "if (isset($_GET['id'])) { $kidId = (int) $_GET['id']; }\n"
        "elseif (isset($_GET['kid_id'])) { $kidId = (int) $_GET['kid_id']; }\n"
        "if ($kidId > 0 && function_exists('dual_owns_kid') && !dual_owns_kid($kidId)) {\n"
        "    header('Location: ../parent-home.php');\n"
        "    exit;\n"
        "}\n"
    )


def copy_lang(lang):
    src = os.path.join(LIVE, lang)
    dest = os.path.join(DEST, lang)
    os.makedirs(dest, exist_ok=True)
    write_stub_includes(dest)
    src_inc = os.path.join(src, "includes")
    dest_inc = os.path.join(dest, "includes")
    for name in INCLUDES:
        path = os.path.join(src_inc, name)
        if not os.path.isfile(path):
            continue
        text = open(path, encoding="utf-8", errors="ignore").read()
        text = rewrite_assets(text, lang, include_name=name)
        if name == "left-nav.php":
            switch_title = "تبديل الحساب" if lang == "arb" else "Switch role"
            switch_item = (
                "\n            <li class=\"lvl1 \">\n"
                "                <div class=\" waves-effect \">\n"
                "                    <a href=\"../choose-role.php\">\n"
                "                        <i class=\"mdi mdi-swap-horizontal\" style=\"color:white\"></i>\n"
                f"                        <span class=\"title\">{switch_title}</span>\n"
                "                    </a>\n"
                "                </div>\n"
                "            </li>\n"
            )
            marker = (
                "                        <span class=\"title\">Home</span>\n"
                "                    </a>\n"
                "                </div>\n"
                "            </li>"
            )
            if marker in text and "choose-role.php" not in text:
                text = text.replace(marker, marker + switch_item, 1)
        open(os.path.join(dest_inc, name), "w", encoding="utf-8").write(text)

    copied = []
    for name in PAGES:
        path = os.path.join(src, name)
        if not os.path.isfile(path):
            continue
        text = open(path, encoding="utf-8", errors="ignore").read()
        text = strip_bootstrap(text)
        text = rewrite_assets(text, lang)
        if name == "kid-data.php":
            text = text.replace(
                "    if($totalRows_get_kids>0){\n        $image_name = $_POST['old_img'];",
                "    $okPhoto = (function_exists('dual_owns_kid') && dual_owns_kid($_GET['id'])) || $totalRows_get_kids>0;\n"
                "    if($okPhoto){\n        $image_name = $_POST['old_img'];",
            )
        open(os.path.join(dest, name), "w", encoding="utf-8").write(text)
        copied.append(name)
    return copied


def write_wrappers(lang, files):
    wrap_dir = os.path.join(ROOT, lang, "kid")
    os.makedirs(wrap_dir, exist_ok=True)
    extra = {
        "ui-pages-home.php": "kids.php",
        "ui-app-editprofile.php": "../profile.php",
        "ui-app-password.php": "../password.php",
    }
    all_files = list(files) + list(extra.keys())
    for name in all_files:
        path = os.path.join(wrap_dir, name)
        if name in extra:
            open(path, "w", encoding="utf-8").write(
                "<?php\n"
                f"$staffLang = '{lang}';\n"
                "require dirname(__DIR__, 2) . '/includes/staff.php';\n"
                f"header('Location: {extra[name]}');\n"
                "exit;\n"
            )
            continue
        open(path, "w", encoding="utf-8").write(
            "<?php\n"
            f"$staffLang = '{lang}';\n"
            "require dirname(__DIR__, 2) . '/includes/staff.php';\n"
            "require_once dirname(__DIR__, 2) . '/includes/parent-live-boot.php';\n"
            "parent_live_run(basename(__FILE__));\n"
        )


def main():
    if not os.path.isdir(LIVE):
        raise SystemExit("Live dump not found: " + LIVE)
    all_files = set()
    for lang in ("eng", "arb"):
        copied = copy_lang(lang)
        write_wrappers(lang, copied)
        all_files.update(copied)
        print(lang, "copied", len(copied))
    print("unique", len(all_files))


if __name__ == "__main__":
    main()
