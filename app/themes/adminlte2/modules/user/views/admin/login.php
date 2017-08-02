<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var yii\widgets\ActiveForm $form
 * @var amnah\yii2\user\models\forms\LoginForm $model
 */

$this->title = Yii::t('user', 'Login');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="login-box">
    <div class="login-logo">
        <a href="/">企业后台登录</a>
    </div>
    <div class="login-box-body">

        <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
        <?= $form->field($model, 'email',['template'=>"<div class=\"form-group has-feedback\">{input}<span class=\"glyphicon glyphicon-envelope form-control-feedback\"></span><div class=\"\">{error}</div></div>"])->textInput(['placeholder'=>'邮箱/用户名']) ?>

        <?= $form->field($model, 'password',['template'=>"<div class=\"form-group has-feedback\">{input}<span class=\"glyphicon glyphicon-lock form-control-feedback\"></span><div class=\"\">{error}</div></div>"])->passwordInput(['placeholder'=>'密码']) ?>

        <?= $form->field($model, 'rememberMe', [
            'template' => "{label}<div class=\"form-group\">{input}</div>\n<div class=\"\">{error}</div>",
        ])->checkbox() ?>

        <div class="form-group">
                <?= Html::submitButton(Yii::t('user', 'Login'), ['class' => 'btn btn-primary','style'=>'width:100%']) ?>

        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>
