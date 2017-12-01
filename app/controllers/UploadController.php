<?php
/**
 * Created by PhpStorm.
 * User: yappy
 * Date: 17-11-20
 * Time: 下午4:37
 */

namespace app\controllers;

use app\common\Controller;
use app\common\uploads\Upload;
use yii;

class UploadController extends Controller
{
    public $enableCsrfValidation = false;

    public function actionIndex()
    {
        return $this->renderPartial('index');
    }
    /**
     * preprocess the upload request
     *
     */
    public function actionPreprocess()
    {
        $upload = new Upload();
        return $upload->preprocess();
    }
    //public function saveChunk()
    public function actionUploading()
    {
        $upload = new Upload();
        return $upload->uploading();
    }
}