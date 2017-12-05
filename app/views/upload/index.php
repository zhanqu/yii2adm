<?php
/**
 * Created by PhpStorm.
 * User: yappy
 * Date: 17-11-20
 * Time: 下午4:29
 */
?>

<!DOCTYPE html>
<html lang="zh_cn">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="csrf-token" content=""><!--需要有csrf token-->
    <link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.6/css/bootstrap.min.css"/>
</head>
<body>

<div class="container">

    <div class="page-header">
        <h1>This is an example page.</h1>
    </div>

    <div class="row">
        <form method="post" action="">

            <div class="form-group " id="upload-wrapper" ><!--组件最外部需要有一个名为upload-wrapper的id，用以包装组件-->
                <label  class="col-md-2 control-label">1.分片上传：</label>
                <div class="controls" >
                    <input type="file" id="file"  onchange="upload(this,'file').success(someCallback).upload()"/><!--需要有一个名为file的id，用以标识上传的文件，upload(file,group)中第二个参数为分组名，success方法可用于声名上传成功后的回调方法名-->
                    <div class="progress " style="height: 6px;margin-bottom: 2px;margin-top: 10px;width: 200px;">
                        <div id="progressbar" style="background:blue;height:6px;width:0;"></div><!--需要有一个名为progressbar的id，用以标识进度条-->
                    </div>
                    <span style="font-size:12px;color:#aaa;" id="output">等待上传</span><!--需要有一个名为output的id，用以标识提示信息-->
                    <input type="hidden" name="file1" id="savedpath" ><!--需要有一个名为savedpath的id，用以标识文件保存路径的表单字段，还需要一个任意名称的name-->
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-2 control-label">2.base64传图DEMO</label>
                <div class="col-md-4">
                    <div class="Upload-img" style="cursor:pointer;display:inline;"  onclick="$('#pic_b').click()">
                        <img id="adImg_b" style="width:60px;height:60px;" src="/static/discount_default_img.png" />
                    </div>
                    <div style="display: none;">
                        <input type="file" name="" id="pic_b" accept="image/jpeg, image/png" onchange="uploadPic(this,'adImg_b','staff_pay_url','item_b')">
                    </div>
                    <div id="item_b"></div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">点击提交</button>
        </form>

        <hr/>

        <div id="result"></div>

    </div>
</div>
<script src="/plugins/spark-md5.min.js"></script><!--需要引入spark-md5.min.js-->
<script src="//cdn.bootcss.com/jquery/2.2.3/jquery.min.js"></script><!--需要引入jquery.min.js-->
<script src="/plugins/layer/layer.js"></script>
<script src="/js/blade-upload.js"></script><!--需要引入blade-upload.js-->
<script>
    // success(callback)中声名的回调方法需在此定义，参数callback可为任意名称，此方法将会在上传完成后被调用
    // 可使用this对象获得fileName,fileSize,uploadBaseName,uploadExt,subDir,group,savedPath等属性的值
    someCallback = function(){
        // Example
        $('#result').append(
            '<p>原文件名：<span >'+this.fileName+'</span> | 原文件大小：<span >'+parseFloat(this.fileSize / (1000 * 1000)).toFixed(2) + 'MB'+'</span> | 储存文件名：<span >'+this.savedPath.substr(this.savedPath.lastIndexOf('/') + 1)+'</span></p>'
        );
    }

</script>
</body>
</html>

