<?php
ini_set('date.timezone','Asia/Shanghai');
function autoload($className)
{
    $className = ltrim($className, '\\');
    $fileName  = '';
    $namespace = '';
    if ($lastNsPos = strrpos($className, '\\')) {
        $namespace = substr($className, 0, $lastNsPos);
        $className = substr($className, $lastNsPos + 1);
        $fileName  = dirname(__DIR__).'/' . str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
    }
    $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';
    require $fileName;
}

spl_autoload_register('autoload');

/**
 * composer 下载的日志模块
 */
require_once __DIR__ . '/composer/autoload_real.php';
return ComposerAutoloaderInit8869ca3ab429ab467fa48b3f95f64902::getLoader();