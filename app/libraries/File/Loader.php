<?php

namespace Games\Library\File;

use Phalcon\Di as Di;
use Phalcon\Config as Config;

class Loader
{

    /**
     * You can set some special environment for CLI or Tests
     *
     * @var string
     */
    protected static $environment;

    /**
     * This method is trying to require config.php, env/config.php and config.local.php
     *
     * @param string $filepath
     * @param bool $isOptional
     *
     * @return Config
     */
    static public function includeConfig($filepath, $isOptional = false) {
        /** @var Config $config */
        $config = new Config();

        $appendConfig = function ($fileContent) use ($config) {
            if ($fileContent instanceof Config) {
                $config->merge($fileContent);
            }
        };

        $appendConfig(self::requireFile($filepath, $isOptional));

        $environmentFilepath = self::addEnvIntoPath($filepath);
        $appendConfig(self::requireFile($environmentFilepath, true));

        $localFilepath = self::addLocalIntoFilename($filepath);
        $appendConfig(self::requireFile($localFilepath, true));

        Di::getDefault()->get('config')->merge($config);

        return $config;
    }

    /**
     * This method is trying to require filename.php, env/filename.php and filename.local.php
     *
     * @param string $filepath
     * @param bool $isOptional
     */
    static public function includeFile($filepath, $isOptional = false) {
        self::requireFile($filepath, $isOptional);

        $environmentFilepath = self::addEnvIntoPath($filepath);
        self::requireFile($environmentFilepath, true);

        $localFilepath = self::addEnvIntoPath($filepath);
        self::requireFile($localFilepath, true);
    }

    /**
     * @param string $path
     *
     * @return string
     */
    static public function addEnvIntoPath($path) {
        if (!is_string($path)) {
            throw new \InvalidArgumentException('Wrong path type. Must be string.');
        }

        $environmentPath = explode('/', $path);
        $environmentPath = array_reverse($environmentPath);
        $environmentPath[0] = self::getEnvironment() . '/' . $environmentPath[0];
        $environmentPath = array_reverse($environmentPath);
        $environmentPath = implode('/', $environmentPath);

        return $environmentPath;
    }

    /**
     * @param string $filename
     *
     * @return string
     */
    static public function addLocalIntoFilename($filename) {
        if (!is_string($filename)) {
            throw new \InvalidArgumentException('Wrong filename type. Must be string.');
        }
        return preg_replace('/\.php$/', '.local.php', $filename);
    }

    /**
     * @param string $filepath
     * @param bool $isOptional Do not throw exception if no file
     *
     * @return mixed
     * @throws \InvalidArgumentException
     */
    static public function requireFile($filepath, $isOptional = false) {
        if (!is_string($filepath)) {
            throw new \InvalidArgumentException('Wrong path type. Must be string.');
        }
        if (file_exists($filepath)) {
            return require $filepath;
        } elseif (!$isOptional) {
            throw new \InvalidArgumentException('Can\'t include file "' . $filepath . '"');
        }

        return true;
    }

    /**
     * @return string
     */
    static public function getEnvironment() {
        return self::$environment ?: APPLICATION_ENV;
    }

    /**
     * @param string $environment
     *
     * @return bool
     */
    static public function setEnvironment($environment)
    {
        if (!is_string($environment)) {
            throw new \InvalidArgumentException('Wrong path type. Must be string.');
        }
        self::$environment = (string)$environment;
        return true;
    }

}