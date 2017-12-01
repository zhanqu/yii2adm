<?php

namespace app\common\uploads;
use yii;
class ConfigMapper
{
    private static $_instance = null;
    private $UPLOAD_PATH;
    private $FILE_DIR;
    private $FILE_SUB_DIR;
    private $HEAD_DIR;
    private $CHUNK_SIZE;
    private $FILE_MAXSIZE;
    private $FILE_EXTENSIONS;
    private $MIDDLEWARE_PREPROCESS;
    private $MIDDLEWARE_SAVE_CHUNK;
    private $MIDDLEWARE_DISPLAY;
    private $MIDDLEWARE_DOWNLOAD;
    private $EVENT_BEFORE_UPLOAD_COMPLETE;
    private $EVENT_UPLOAD_COMPLETE;

    private function __construct()
    {
        //disallow new instance
    }

    public static function getInstance()
    {
        if ( self::$_instance === null ) {
            self::$_instance = (new self())->applyCommonConfig();
        }

        return self::$_instance;
    }

    private function applyCommonConfig()
    {   $params = Yii::$app->params;
        $this->UPLOAD_PATH = $params['UPLOAD_PATH'];
        $this->CHUNK_SIZE = $params['CHUNK_SIZE'];
        $this->HEAD_DIR = $params['HEAD_DIR'];
        $this->FILE_SUB_DIR = $params['FILE_SUB_DIR'];

        return $this;
    }

    public function applyGroupConfig($group='file')
    {
        $params = Yii::$app->params;
        $this->FILE_DIR = $group;
        $this->FILE_MAXSIZE = $params['GROUPS'][$group]['FILE_MAXSIZE'];
        $this->FILE_EXTENSIONS = $params['GROUPS'][$group] ['FILE_EXTENSIONS'];
        $this->MIDDLEWARE_PREPROCESS = $params['GROUPS'][$group] ['MIDDLEWARE_PREPROCESS'];
        $this->MIDDLEWARE_SAVE_CHUNK =  $params['GROUPS'][$group] ['MIDDLEWARE_SAVE_CHUNK'];
        $this->MIDDLEWARE_DISPLAY =  $params['GROUPS'][$group] ['MIDDLEWARE_DISPLAY'];
        $this->MIDDLEWARE_DOWNLOAD =  $params['GROUPS'][$group] ['MIDDLEWARE_DOWNLOAD'];
        $this->EVENT_BEFORE_UPLOAD_COMPLETE =  $params['GROUPS'][$group]['EVENT_BEFORE_UPLOAD_COMPLETE'];
        $this->EVENT_UPLOAD_COMPLETE = $params['GROUPS'][$group]['EVENT_UPLOAD_COMPLETE'];
        return $this;
    }

    public static function get($property){
        return self::getInstance()->{$property};
    }

}