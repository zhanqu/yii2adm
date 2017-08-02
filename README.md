资源压缩
----
>两套资源打包和压缩的工具,自由随意选择~~    
  
>1. assets.php #是yii默认支持的closure和yui打包和压缩   

>   ./yii asset assets.php app/config/assets-prod.php   
  
>2. assets-gulp.php #gulp方式  

>   cd tools/gulp  

>   npm install -g gulp  #安装全局的gulp命令  

>   npm update  

>   ./yii asset assets-gulp.php app/config/assets-prod.php  

持续集成部署
----
>被部署的服务器需要安装的软件  

1.composer [安装composer](https://getcomposer.org/download/)   
2.github accesstoken 配置,[Github网站生成token](https://github.com/settings/tokens)  
3.git config global github.user xxxx  
4.git config global github.accesstoken xxxx(第二步生成的)  

