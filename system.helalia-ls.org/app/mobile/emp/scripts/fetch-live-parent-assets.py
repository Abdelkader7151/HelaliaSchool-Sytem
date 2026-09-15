"""Download the live parent app CSS, JS, and 3D icons. Read-only. No upload."""
from __future__ import annotations

import shutil
import ssl
import urllib.request
from pathlib import Path

ROOT = Path(r"d:\Vertex projects\School Systems\HELALIA Language school\helalia-mobile-app\live-emp-home")
LOCAL_DEMO = Path(
    r"d:\Vertex projects\School Systems\HELALIA Language school\helalia-mobile-app\new-design\app.helalia-ls.org.app\demo\parent"
)
BASE = "https://app.helalia-ls.org/demo/parent/"
CTX = ssl.create_default_context()

REMOTE = {
    "assets/css/helalia.css": "assets/css/parent-app.css",
    "assets/js/app.js": "assets/js/app.js",
    "assets/img/logo-icon.png": "assets/img/logo-icon.png",
    "assets/img/logo.png": "assets/img/logo.png",
    "assets/img/logo-live.png": "assets/img/logo-live.png",
    "assets/img/quick/ask.webp": "assets/img/quick/ask.webp",
    "assets/img/quick/attendance.webp": "assets/img/quick/attendance.webp",
    "assets/img/quick/calendar.avif": "assets/img/quick/calendar.avif",
    "assets/img/quick/certificate.webp": "assets/img/quick/certificate.webp",
    "assets/img/quick/gallery.webp": "assets/img/quick/gallery.webp",
    "assets/img/quick/homework.webp": "assets/img/quick/homework.webp",
    "assets/img/quick/memo.webp": "assets/img/quick/memo.webp",
    "assets/img/quick/plan.webp": "assets/img/quick/plan.webp",
    "assets/img/quick/revision.webp": "assets/img/quick/revision.webp",
}


def fetch(rel: str, dest: Path) -> bool:
    dest.parent.mkdir(parents=True, exist_ok=True)
    url = BASE + rel
    try:
        with urllib.request.urlopen(url, context=CTX, timeout=60) as r:
            dest.write_bytes(r.read())
        print(f"OK  https {rel} ({dest.stat().st_size})")
        return True
    except Exception as e:
        local = LOCAL_DEMO / rel.replace("/", "\\")
        if local.is_file():
            shutil.copyfile(local, dest)
            print(f"OK  local {rel} ({dest.stat().st_size})")
            return True
        print(f"FAIL {rel} {e}")
        return False


def main() -> None:
    quick = ROOT / "assets" / "img" / "quick"
    if quick.is_dir():
        for p in quick.glob("*.png"):
            p.unlink()
            print("removed generated", p.name)
    ok = 0
    for rel, local_rel in REMOTE.items():
        if fetch(rel, ROOT / Path(*local_rel.split("/"))):
            ok += 1
    extra = """
.nav.nav--3 { grid-template-columns: repeat(3, 1fr); }
.nav__item[href*="parent-news"] { --tab-tint: color-mix(in oklab, var(--gold-deep) 72%, #4a3200); }
.kidcard__photo .kidcard__initials {
  position: absolute; inset: 0;
  display: grid; place-items: center;
  font-size: 2rem; font-weight: 800;
  color: var(--navy);
  background: color-mix(in oklab, var(--navy) 8%, var(--cream));
}
"""
    css = ROOT / "assets" / "css" / "parent-app.css"
    if css.is_file() and "nav--3" not in css.read_text(encoding="utf-8", errors="ignore"):
        with css.open("a", encoding="utf-8") as f:
            f.write(extra)
        print("appended nav--3")
    print("done", ok, "/", len(REMOTE))


if __name__ == "__main__":
    main()
