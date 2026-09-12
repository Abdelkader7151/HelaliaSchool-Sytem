# Helalia School System (live cPanel mirror)

Private repository for **HELALIA Language School** live site code from cPanel.

## Layout

```
system.helalia-ls.org/   # School system app + control panel
public_html/             # Public website (helalia-ls.org)
```

## What is included

- Application PHP/JS/CSS/HTML and redirects
- Live `Connections/database.php` and related config (private collaborators only)
- Small brand assets (e.g. `logo.png`)

## What is excluded (server storage only)

Student photos, uploads, gallery videos, homework file storage, vendor trees (`PHPExcel`, `bower`, etc.). Those remain on cPanel and are listed in `.gitignore`.

## Deploy (manual)

1. Push to `main` on GitHub
2. Review the commit
3. In cPanel → **Git Version Control** → **Update**, then **Deploy** when ready

Clone path on server: `/home/helalia/helalia-school-system`  
Deploy copies into the live docroots (does not wipe first).

## Sync from live (maintainers)

```powershell
$env:HELALIA_FTP_USER = "helalia"
$env:HELALIA_FTP_PASSWORD = "<from password manager>"
python ..\scripts\sync-live-to-github-folder.py
python ..\scripts\verify-live-github-match.py
```
