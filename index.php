<?php
require_once './system/up.php';
$user = new RegUser();

$user->_noReg(); ?>

<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <? // Site::returnImage("logotips/logo.jpg","Логотип"); ?>
            <? Site::PrintMiniLine() ?>
            <div class="col-xs-6">
                <a href="login.php" class="btn btn-lg btn-default">Войти</a>
            </div>
            <div class="col-xs-6 text-right">
                <a href="reg.php" class="btn btn-lg btn-default">Регистрация</a>
            </div>
        </div>
    </div>
</div><?php
require_once 'system/down.php';