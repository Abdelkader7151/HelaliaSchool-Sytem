import os
root = r"d:\Vertex projects\School Systems\HELALIA Language school\helalia-mobile-app\live-emp-home"
for lang in ("eng", "arb"):
    d = os.path.join(root, lang, "kid")
    n = 0
    for name in os.listdir(d):
        if not name.endswith(".php"):
            continue
        path = os.path.join(d, name)
        with open(path, "w", encoding="utf-8") as f:
            f.write("<?php\n")
            f.write("$staffLang = '%s';\n" % lang)
            f.write("require dirname(__DIR__, 2) . '/includes/staff.php';\n")
            f.write("require_once dirname(__DIR__, 2) . '/includes/parent-live-boot.php';\n")
            f.write("parent_live_run(basename(__FILE__));\n")
        n += 1
    print(lang, n)
