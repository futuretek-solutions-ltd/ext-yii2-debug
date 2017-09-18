<?php

namespace futuretek\debug;

use Yii;
use yii\db\Query;
use yii\debug\Panel;

/**
 * Debugger panel that displays application options.
 *
 * @package futuretek\debug
 * @author  Lukas Cerny <lukas.cerny@futuretek.cz>
 * @license Apache-2.0
 * @link    http://www.futuretek.cz
 */
class OptionPanel extends Panel
{
    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'Options';
    }

    /**
     * @inheritdoc
     * @throws \yii\base\InvalidParamException
     * @throws \yii\base\InvalidCallException
     */
    public function getSummary()
    {
        if (!$this->isOptionInstalled()) {
            return '';
        }

        return Yii::$app->view->render('@vendor/futuretek/yii2-debug/views/option/summary', ['panel' => $this]);
    }

    /**
     * @inheritdoc
     * @throws \yii\base\InvalidParamException
     * @throws \yii\base\InvalidCallException
     */
    public function getDetail()
    {
        if (!$this->isOptionInstalled()) {
            return '';
        }

        return Yii::$app->view->render('@vendor/futuretek/yii2-debug/views/option/detail');
    }

    /**
     * Check if option table is present
     *
     * @return bool
     */
    protected function isOptionInstalled()
    {
        return Yii::$app->db->schema->getTableSchema('option') !== null;
    }

    /**
     * Get all options
     *
     * @return array
     */
    public static function getOptions()
    {
        return (new Query())
            ->select(['name', 'title', 'value'])
            ->from('option')
            ->orderBy(['name' => SORT_ASC])
            ->all();
    }
}