<?php

register_menu("Clear System Cache", true, "clear_cache", 'SETTINGS', '');

function clear_cache()
{
    global $ui;
    _admin();
    $ui->assign('_title', 'Clear Cache');
    $ui->assign('_system_menu', 'settings');
    $admin = Admin::_info();
    $ui->assign('_admin', $admin);

    $compiledCacheDir = 'ui/compiled';
    $templateCacheDir = 'system/cache';

    try {
        // Clear the compiled cache
        $ui->setCacheDir($compiledCacheDir);
        $CACHE_PATH = $ui->getCacheDir();
        $files = scandir($CACHE_PATH);
        foreach ($files as $file) {
            $ext = pathinfo($file, PATHINFO_EXTENSION);
            if (is_file($CACHE_PATH . DIRECTORY_SEPARATOR . $file) && $ext == 'temp') {
                unlink($CACHE_PATH . DIRECTORY_SEPARATOR . $file);
            }
        }
        // Clear the template cache
        $ui->setCacheDir($templateCacheDir);
        $templateCacheFiles = glob($ui->getCacheDir() . '/*');
        foreach ($templateCacheFiles as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }

        // Cache cleared successfully
        r2(U . 'dashboard', 's', Lang::T("Cache cleared successfully!"));
    } catch (Exception $e) {
        // Error occurred while clearing the cache
        r2(U . 'dashboard', 'e', Lang::T("Error occurred while clearing the cache: ") . $e->getMessage());
    }
}