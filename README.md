
安装
----
1. git clone 
2. composer install
3. 创建数据库yii2adm,如果不使用默认的数据库名,修改environments/dev/app/config/db.php
3. ./init #安装
4. ./yii migrate #数据库初始化
5. 域名test-yii2adm-web.dev.com指向web目录
6. http://test-yii2adm-web.dev.com
7. 默认的管理员用户名和密码，admin,admin
8. 如果需要使用前台用户功能,请配置environments/dev/app/config/main-local.php里面的mailer,然后再./init 安装


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

