<?php

namespace futuretek\debug;

use Yii;
use yii\debug\Panel;

/**
 * Debugger panel that collects and displays application configuration and environment.
 *
 * @property array $extensions This property is read-only.
 * @property array $phpInfo This property is read-only.
 *
 * @package futuretek\debug
 * @author  Lukas Cerny <lukas.cerny@futuretek.cz>
 * @license Apache-2.0
 * @link    http://www.futuretek.cz
 */
class ConfigPanel extends Panel
{
    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'Configuration';
    }

    /**
     * @inheritdoc
     * @throws \yii\base\InvalidParamException
     * @throws \yii\base\InvalidCallException
     */
    public function getSummary()
    {
        return Yii::$app->view->render('@vendor/futuretek/yii2-debug/views/config/summary', ['panel' => $this]);
    }

    /**
     * @inheritdoc
     * @throws \yii\base\InvalidParamException
     * @throws \yii\base\InvalidCallException
     */
    public function getDetail()
    {
        return Yii::$app->view->render('@vendor/futuretek/yii2-debug/views/config/detail', ['panel' => $this]);
    }

    /**
     * Returns data about extensions
     *
     * @return array
     */
    public function getExtensions()
    {
        $data = [];
        foreach ($this->data['extensions'] as $extension) {
            $data[$extension['name']] = $extension['version'];
        }
        ksort($data);

        return $data;
    }

    /**
     * Returns the BODY contents of the phpinfo() output
     *
     * @return array
     */
    public function getPhpInfo()
    {
        ob_start();
        phpinfo();
        $pInfo = ob_get_contents();
        ob_end_clean();
        $phpInfo = preg_replace('%^.*<body>(.*)</body>.*$%ms', '$1', $pInfo);
        $phpInfo = str_replace(['<table', '</table>'], ['<div class="table-responsive"><table class="table table-condensed table-bordered table-striped table-hover config-php-info-table" ', '</table></div>'], $phpInfo);

        return $phpInfo;
    }

    /**
     * @inheritdoc
     */
    public function save()
    {
        global $config;

        return [
            'phpVersion' => PHP_VERSION,
            'yiiVersion' => Yii::getVersion(),
            'application' => [
                'yii' => Yii::getVersion(),
                'name' => Yii::$app->name,
                'version' => Yii::$app->version,
                'env' => YII_ENV,
                'debug' => YII_DEBUG,
            ],
            'appConfig' => var_export($config, true),
            'php' => [
                'version' => PHP_VERSION,
                'xdebug' => extension_loaded('xdebug'),
                'apc' => extension_loaded('apc'),
                'memcache' => extension_loaded('memcache'),
                'memcached' => extension_loaded('memcached'),
            ],
            'extensions' => Yii::$app->extensions,
        ];
    }
}