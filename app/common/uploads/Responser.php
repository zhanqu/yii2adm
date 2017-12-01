<?php

namespace app\common\uploads;
use yii;
use yii\web\Response;
class Responser
{

    public static function returnResult($params)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $params;
    }

    public static function reportError($message, $deleteFiles = false, $uploadHead = '', $uploadPartialFile = '')
    {
        if ( $deleteFiles ) {
            @unlink($uploadHead);
            @unlink($uploadPartialFile);
        }

        $result = [
            'error' => '错误：' . $message,
        ];
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $result;
    }
}