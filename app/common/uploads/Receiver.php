<?php

namespace app\common\uploads;
//use Symfony\Component\HttpFoundation\File\UploadedFile;
use yii;
use yii\web\UploadedFile;
class Receiver
{
    public $uploadHead;
    public $uploadPartialFile;
    public $chunkIndex;
    public $chunkTotalCount;
    public $file;
    public $uploadExt;
    public $uploadBaseName;
    public $savedPath;
    public $fileparam = 'file';
    private static $_instance;

    public function init()
    {
        if (\Yii::$app->request->get('fileparam')) {
            $this->fileparam = \Yii::$app->request->get('fileparam');
        }
    }

    public static function getInstance()
    {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self;
        }
        return self::$_instance;
    }
    /**
     * filter and create the file
     */
    public function createFile()
    {
        $this->uploadBaseName = $this->generateTempFileName();
        $this->uploadPartialFile = $this->getUploadPartialFilePath();
        $this->uploadHead = $this->getUploadHeadPath();
        if ( ! (touch($this->uploadPartialFile) && touch($this->uploadHead)) ) {
            return '无法创建文件';
        }

        return false;
    }

    /**
     * write data to the existing file
     */
    public function writeFile()
    {
        # 写入上传文件内容
        if ( @file_put_contents($this->uploadPartialFile, @file_get_contents($this->file->tempName), FILE_APPEND) === false ) {
            return '写文件失败';
        }
        # 写入头文件内容
        if ( @file_put_contents($this->uploadHead, $this->chunkIndex) === false ) {
            return '写头文件失败';
        }

        return false;
    }

    public function renameTempFile()
    {
        $savedFileHash = $this->generateSavedFileHash($this->uploadPartialFile);

        if ( RedisHandler::hashExists($savedFileHash) ) {
            $this->savedPath = RedisHandler::getFilePathByHash($savedFileHash);
        } else {
            $this->savedPath = ConfigMapper::get('FILE_DIR') . DIRECTORY_SEPARATOR . ConfigMapper::get('FILE_SUB_DIR') . DIRECTORY_SEPARATOR . $savedFileHash . '.' . $this->uploadExt;

            if ( ! @rename($this->uploadPartialFile,  Yii::getAlias('@storage').ConfigMapper::get('UPLOAD_PATH') . DIRECTORY_SEPARATOR . $this->savedPath) ) {
                return false;
            }
        }

        return $this->savedPath;
    }

    public function getUploadPartialFilePath($subDir = null)
    {
        if ( $subDir === null ) {
            $subDir =  ConfigMapper::get('FILE_SUB_DIR');
        }

        return  Yii::getAlias('@storage').ConfigMapper::get('UPLOAD_PATH') . DIRECTORY_SEPARATOR . ConfigMapper::get('FILE_DIR') . DIRECTORY_SEPARATOR . $subDir . DIRECTORY_SEPARATOR . $this->uploadBaseName . '.' . $this->uploadExt . '.part';
    }

    public function getUploadHeadPath()
    {
        return  Yii::getAlias('@storage').ConfigMapper::get('UPLOAD_PATH') . DIRECTORY_SEPARATOR . ConfigMapper::get('HEAD_DIR') . DIRECTORY_SEPARATOR . $this->uploadBaseName . '.head';
    }

    public function getUploadFileSubFolderPath()
    {
        return  Yii::getAlias('@storage').ConfigMapper::get('UPLOAD_PATH') . DIRECTORY_SEPARATOR . ConfigMapper::get('FILE_DIR') . DIRECTORY_SEPARATOR . ConfigMapper::get('FILE_SUB_DIR');
    }

    protected function generateSavedFileHash($filePath)
    {
        return md5_file($filePath);
    }

    protected function generateTempFileName()
    {
        return time() . mt_rand(100, 999);
    }


}
