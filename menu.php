<?php
$title = 'Главная';
require_once 'system/up.php';

$sql = new SafeMySQL();
$user = new RegUser();
$site = new Site();

$user->_Reg();

try {
    if ($user->getBlock()) {
        throw new Exception('Вы заблокированы администрацией проекта!');
    }
    $site->setSwitch('a');
    switch ($site->switch) {
        default: ?>
            <div class="container">
            <div class="row">
                <div class="col-xs-12"><?
                    if ($user->user('vip_time') > time()) { ?>
                        <? Site::PrintMiniLine() ?>
                        <h5 class="text-info text-center">
                            Видео
                        </h5>
                        <? Site::PrintMiniLine() ?>
                        <div class="col-xs-12">
                            <ul class="list-group">
                                <li class="list-group-item">

                                </li>
                                <? Site::PrintMiniLine() ?>
                                <li class="list-group-item">

                                </li>
                            </ul>
                        </div>

                        <? Site::PrintMiniLine() ?>
                        <h5 class="text-info text-center">
                            Фото
                        </h5>
                        <? Site::PrintMiniLine() ?>
                        <div class="col-xs-12">
                        <ul class="list-group">
                            <li class="list-group-item">

                            </li>
                            <? Site::PrintMiniLine() ?>
                        </ul>
                        </div><?
                    } else { ?>
                        <? Site::PrintMiniLine() ?>
                        <h5 class="text-info text-center">
                            VIP
                        </h5>
                        <? Site::PrintMiniLine() ?>
                        <div class="col-xs-12">
                        <ul class="list-group">
                            <li class="list-group-item">
                                <? Site::linkToSiteAdd('btn btn-block btn-dark', 'vip.php', 'Купить VIP') ?>
                            </li>
                        </ul>
                        </div><?
                    } ?>

                    <? Site::PrintMiniLine() ?>
                    <h5 class="text-info text-center">
                        Общение
                    </h5>
                    <? Site::PrintMiniLine() ?>
                    <div class="col-xs-12">
                        <ul class="list-group">
                            <li class="list-group-item">
                                <? Site::linkToSiteAdd('btn btn-block btn-dark', 'chat.php', 'Чат') ?>
                            </li>
                            <? Site::PrintMiniLine();
                            if ($user->user('vip_time') > time()) { ?>
                                <li class="list-group-item"><?
                                    Site::linkToSiteAdd('btn btn-block btn-dark', 'mail', 'Почта') ?>
                                </li>
                                <? Site::PrintMiniLine();
                            } ?>
                            <li class="list-group-item">
                                <? Site::linkToSiteAdd('btn btn-block btn-dark', 'forum', 'Форум') ?>
                            </li>
                        </ul>
                    </div>

                    <? Site::PrintMiniLine() ?>
                    <h5 class="text-info text-center">
                        Разное
                    </h5>
                    <? Site::PrintMiniLine() ?>
                    <div class="col-xs-12">
                        <ul class="list-group">
                            <li class="list-group-item">
                                <? Site::linkToSiteAdd('btn btn-block btn-dark', 'help', 'Поддержка') ?>
                            </li>
                            <? Site::PrintMiniLine() ?>
                            <li class="list-group-item">
                                <? Site::linkToSiteAdd('btn btn-block btn-dark', 'news', 'Новости') ?>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            </div><?
            break;

        case 'exit':
            $user->exitReg();
            break;
    }
} catch (Exception $e) { ?>
    <div class="container">
    <div class="row">
        <div class="col-xs-12 text-center">
            <h3 class="red">
                <?= $e->getMessage() ?>
            </h3>
            <p class="green">
                До автоматической разблокировки
                осталось <?= Times::timeHours($user->user('block_time') - time()) ?>
            </p>
        </div>
    </div>
    </div><?php
}
require_once('system/down.php');