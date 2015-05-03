<?php

namespace Games\Library\File;

use Phalcon\Di as Di;
use Phalcon\Config as Config;

class Loader
{

    /**
     * @param string $path
     *
     * @return string
     */
    static public function addEnvIntoPath($path)
    {
        $environmentPath = explode('/', $path);
        $environmentPath = array_reverse($environmentPath);
        $environmentPath[0] = APPLICATION_ENV . '/' . $environmentPath[0];
        $environmentPath = array_reverse($environmentPath);
        $environmentPath = implode('/', $environmentPath);
        return $environmentPath;
    }

    /**
     * @param string $filename
     *
     * @return string
     */
    static public function addLocalIntoFilename($filename)
    {
        return preg_replace('/\.php$/', '.local.php', $filename);
    }

    /**
     * This method is trying to require config.php, env/config.php and config.local.php
     *
     * @param string $filepath
     * @param bool $isOptional
     *
     * @return Config
     */
    static public function includeConfig($filepath, $isOptional = false)
    {
        /** @var Config $config */
        $config = new Config();

        if (!$isOptional || file_exists($filepath)) {
            $config->merge(require $filepath);
        }

        $environmentFilepath = self::addEnvIntoPath($filepath);
        if (file_exists($environmentFilepath)) {
            $config->merge(require $environmentFilepath);
        }

        $localFilepath = self::addLocalIntoFilename($filepath);
        if (file_exists($localFilepath)) {
            $config->merge(require $localFilepath);
        }

        Di::getDefault()->get('config')->merge($config);

        return $config;
    }

    /**
     * This method is trying to require filename.php, env/filename.php and filename.local.php
     *
     * @param string $filepath
     * @param bool $isOptional
     */
    static public function includeFile($filepath, $isOptional = false)
    {
        if (!$isOptional || file_exists($filepath)) {
            require $filepath;
        }

        $environmentFilepath = self::addEnvIntoPath($filepath);
        if (file_exists($environmentFilepath)) {
            require $environmentFilepath;
        }

        $localFilepath = self::addEnvIntoPath($filepath);
        if (file_exists($localFilepath)) {
            require $localFilepath;
        }
    }


}