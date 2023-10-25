<?php

register_menu("Clear Cache", true, "clear_cache", 'SETTINGS', '');

function clear_cache()
{
    global $ui;
    _admin();
    $ui->assign('_title', 'Clear Cache');
    $ui->assign('_system_menu', 'settings');
    $admin = Admin::_info();
    $ui->assign('_admin', $admin);

    $ui->setCacheDir('ui/compiled'); // Set the cache directory path

// Clear the cache
$cacheDir = $ui->getCacheDir();
$cacheFiles = glob($cacheDir . '/*');
foreach ($cacheFiles as $file) {
    if (is_file($file)) {
        unlink($file);
    }
}
  //echo 'Cache cleared successfully!';
  r2(U . 'dashboard', 's', Lang::T("Cache cleared successfully!"));
}
