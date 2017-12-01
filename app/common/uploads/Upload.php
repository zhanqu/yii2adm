<?php
/**
 * Created by PhpStorm.
 * User: yappy
 * Date: 17-11-20
 * Time: 下午6:01
 */

namespace app\common\uploads;
use yii;

class Upload
{

    private $receiver;

    public function __construct()
    {

        $this->receiver = Receiver::getInstance();
        ConfigMapper::getInstance()->applyGroupConfig(Yii::$app->request->post('group'));

        //$this->middleware(ConfigMapper::get('MIDDLEWARE_PREPROCESS'))->only('preprocess');
       // $this->middleware(ConfigMapper::get('MIDDLEWARE_SAVE_CHUNK'))->only('saveChunk');
    }
    public function preprocess(){
        $request = Yii::$app->request;
        $fileName = $request->post('file_name', 0);
        $fileSize = $request->post('file_size', 0);
        $fileHash = $request->post('file_hash', 0);
        $result = [
            'error'          => 0,
            'chunkSize'      => ConfigMapper::get('CHUNK_SIZE'),
            'subDir'         => ConfigMapper::get('FILE_SUB_DIR'),
            'uploadBaseName' => '',
            'uploadExt'      => '',
            'savedPath'      => '',
        ];

        if ( ! ($fileName && $fileSize) ) {
            return Responser::reportError('缺少必要的文件参数');
        }

        $this->receiver->uploadExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        if ( $error = $this->filterBySize($fileSize) ) {
            return Responser::reportError($error);
        }

        if ( $error = $this->filterByExt($this->receiver->uploadExt) ) {
            return Responser::reportError($error);
        }
        # 检测是否可以秒传
        /* if ( $fileHash ) {
             if ( RedisHandler::hashExists($fileHash) ) {
                 $result['savedPath'] = RedisHandler::getFilePathByHash($fileHash);
export_ticket
                 return Responser::returnResult($result);
             }
         }*/
        # 创建子目录

        if ( ! is_dir($uploadFileSubFolderPath = $this->receiver->getUploadFileSubFolderPath()) ) {
            @mkdir($uploadFileSubFolderPath, 0777,true);
        }

        # 预创建文件
        if ( $error = $this->receiver->createFile() ) {
            return Responser::reportError($error);
        }

        $result['uploadExt'] = $this->receiver->uploadExt;
        $result['uploadBaseName'] = $this->receiver->uploadBaseName;

        return Responser::returnResult($result);
    }
    public function filterBySize($fileSize)
    {
        $MAXSIZE = ConfigMapper::get('FILE_MAXSIZE') * 1000 * 1000;
        # 文件大小过滤
        if ( $fileSize > $MAXSIZE && $MAXSIZE != 0 ) {
            return '文件过大';
        }

        return false;
    }
    public function filterByExt($uploadExt)
    {
        $EXTENSIONS = ConfigMapper::get('FILE_EXTENSIONS');
        # 文件类型过滤
        if ( ($EXTENSIONS != '' && ! in_array($uploadExt, explode(',', $EXTENSIONS))) || in_array($uploadExt, static::getDangerousExtList()) ) {
            return '文件类型不正确';
        }

        return false;
    }
    private static function getDangerousExtList()
    {
        return ['php', 'part', 'html', 'shtml', 'htm', 'shtm', 'js', 'jsp', 'asp', 'java', 'py', 'sh', 'bat', 'exe', 'dll', 'cgi', 'htaccess', 'reg', 'aspx', 'vbs'];
    }

    public function uploading()
    {
        $request = Yii::$app->request;
        $this->receiver->chunkTotalCount = $request->post('chunk_total', 0);# 分片总数
        $this->receiver->chunkIndex = $request->post('chunk_index', 0);# 当前分片号
        $this->receiver->uploadBaseName = $request->post('upload_basename', 0);# 文件临时名
        $this->receiver->uploadExt = $request->post('upload_ext', 0); # 文件扩展名
        $this->receiver->file = yii\web\UploadedFile::getInstanceByName($this->receiver->fileparam);# 文件
        $subDir = $request->post('sub_dir', 0);# 子目录名
        $this->receiver->uploadHead = $this->receiver->getUploadHeadPath();
        $this->receiver->uploadPartialFile = $this->receiver->getUploadPartialFilePath($subDir);
        $result = [
            'error'     => 0,
            'savedPath' => '',
        ];

        if ( ! ($this->receiver->chunkTotalCount && $this->receiver->chunkIndex && $this->receiver->uploadExt && $this->receiver->uploadBaseName && $subDir) ) {
            return Responser::reportError('缺少必要的文件块参数', true, $this->receiver->uploadHead, $this->receiver->uploadPartialFile);
        }
        # 防止被人为跳过验证过程直接调用保存方法，从而上传恶意文件
        if ( ! is_file($this->receiver->uploadPartialFile) ) {
            return Responser::reportError('此文件不被允许上传', true, $this->receiver->uploadHead, $this->receiver->uploadPartialFile);
        }

       /* if ( $this->receiver->file->getError() > 0 ) {
            return Responser::reportError($this->receiver->file->getErrorMessage(), true, $this->receiver->uploadHead, $this->receiver->uploadPartialFile);
        }*/

      /*  if ( ! $this->receiver->file->isValid() ) {
            return Responser::reportError('文件必须通过HTTP POST上传', true, $this->receiver->uploadHead, $this->receiver->uploadPartialFile);
        }*/
        # 头文件指针验证，防止断线造成的重复传输某个文件块
        if ( @file_get_contents($this->receiver->uploadHead) != $this->receiver->chunkIndex - 1 ) {
            return Responser::returnResult($result);
        }
        # 写入数据到预创建的文件
        if ( $error = $this->receiver->writeFile() ) {
            return Responser::reportError($error, true, $this->receiver->uploadHead, $this->receiver->uploadPartialFile);
        }
        # 判断文件传输完成
        if ( $this->receiver->chunkIndex === $this->receiver->chunkTotalCount ) {
            @unlink($this->receiver->uploadHead);
            # 触发上传完成前事件
            if ( ! empty($beforeUploadCompleteEvent = ConfigMapper::get('EVENT_BEFORE_UPLOAD_COMPLETE')) ) {
                event(new $beforeUploadCompleteEvent($this->receiver));
            }

            if ( ! ($result['savedPath'] = $this->receiver->renameTempFile()) ) {
                return Responser::reportError('重命名文件失败', true, $this->receiver->uploadHead, $this->receiver->uploadPartialFile);
            }

            RedisHandler::setOneHash(pathinfo($this->receiver->savedPath, PATHINFO_FILENAME), $this->receiver->savedPath);
            # 触发上传完成事件
            if ( ! empty($uploadCompleteEvent = ConfigMapper::get('EVENT_UPLOAD_COMPLETE')) ) {
                event(new $uploadCompleteEvent($this->receiver));
            }

        }

        return Responser::returnResult($result);
    }

}