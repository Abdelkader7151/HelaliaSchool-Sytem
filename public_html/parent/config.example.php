<?php
/**
 * Copy to config.php on the server. Do not commit secrets.
 * Live app files and the database schema stay unchanged.
 */
return [
    'db_host' => 'localhost',
    'db_name' => 'helalia_control',
    'db_user' => 'helalia_user',
    'db_pass' => 'CHANGE_ME',

    'gallery_dir' => '/home/helalia/system.helalia-ls.org/gallery',
    'kids_dir' => '/home/helalia/system.helalia-ls.org/kids',
    'uploads_dir' => '/home/helalia/system.helalia-ls.org/uploads',
    'attachments_dir' => '/home/helalia/system.helalia-ls.org/attachments',

    'media_base' => 'https://system.helalia-ls.org',
    'site_url' => 'https://helalia-ls.org',
    'max_video_mb' => 32,
];
