<?php
$title = 'VIP';
require_once 'system/up.php';

$user = new RegUser();
$site = new Site();
$sql = new SafeMySQL();
$admin = new Admin();

$user->_Reg();

try {
    if($user->getBlock() and $admin->setAdmin(admin: 1983)->returnAdmin() == false) {
        throw new Exception(message: 'Вы заблокированы администрацией проекта!');
    }
    $site->setSwitch('a');
    switch ($site->switch) {
        default: ?>
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <h2 class="text-center">VIP аккаунт</h2><?
                        Site::PrintMiniLine();
                        Site::linkToSiteAdd(class: "btn btn-block btn-success", link: "vip.php?a=500", text: "Купить VIP на сутки (500р)");
                        Site::linkToSiteAdd(class: "btn btn-block btn-success", link: "vip.php?a=3000", text: "Купить VIP на 7 дней (3000 р)");
                        Site::linkToSiteAdd(class: "btn btn-block btn-success", link: "vip.php?a=55000", text: "Купить VIP на 1 месяц (55000 р)"); ?>
                    </div>
                    <? Site::PrintMiniLine(); ?>
                    <div class="col-xs-12">
                        <p class="text-info text-center">
                            VIP аккаунт позволяет просматривать фото и видео Miss Po без ограничений.
                        </p>
                    </div>
                </div>
            </div><?php
            break;

        case '500':
            if (isset($_POST['day'])) {
                if ($user->user('gold') < 500) {
                    Site::session_empty('error', 'У вас недостаточно денег! Пополните баланс!');
                }
                $vipTime = time() + (60*60*24);
                $sql->query("update users set gold = gold - ?i, vip = ?i, vip_time = ?i where id = ?i", 500, 1, $vipTime, $user->user('id'));
                Site::session_empty('ok', 'Вы успешно купили VIP на 24 часа!', 'menu');
            } else { ?>
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <p class="text-danger text-center">Стоимость 500 руб (с баланса аккаунта)</p>
                            <? Site::PrintMiniLine() ?>
                            <form action="?a=500" method="post">
                                <input class="btn btn-block btn-success" type="submit" name="day" value="Купить VIP на день">
                            </form>
                        </div>
                    </div>
                </div><?php
            }
            break;

        case '3000':
            if (isset($_POST['week'])) {
                if ($user->user('gold') < 3000) {
                    Site::session_empty('error', 'У вас недостаточно денег! Пополните баланс!');
                }
                $vipTime = time() + (60*60*24*7);
                $sql->query("update users set gold = gold - ?i, vip = ?i, vip_time = ?i where id = ?i", 3000, 1, $vipTime, $user->user('id'));
                Site::session_empty('ok', 'Вы успешно купили VIP на 7 дней!', 'menu');
            } else { ?>
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <form action="?a=3000" method="post">
                                <input class="btn btn-block btn-success" type="submit" name="week" value="Купить VIP на неделю">
                            </form>
                        </div>
                    </div>
                </div><?php
            }
            break;

        case '55000':
            if (isset($_POST['month'])) {
                if ($user->user('gold') < 55000) {
                    Site::session_empty('error', 'У вас недостаточно денег! Пополните баланс!');
                }
                $vipTime = time() + (60*60*24*30);
                $sql->query("update users set gold = gold - ?i, vip = ?i, vip_time = ?i where id = ?i", 55000, 1, $vipTime, $user->user('id'));
                Site::session_empty('ok', 'Вы успешно купили VIP на месяц!', 'menu');
            } else { ?>
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <form action="?a=55000" method="post">
                                <input class="btn btn-block btn-success" type="submit" name="month" value="Купить VIP на месяц">
                            </form>
                        </div>
                    </div>
                </div><?php
            }
            break;
    }
} catch (Throwable $e) { ?>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 text-center">
                <h3 class="red">
                    <?= $e->getMessage() ?>
                </h3>
                <p class="green">
                    До автоматической разблокировки осталось <?= Times::timeHours(time: $user->user(key: 'block_time') - time()) ?>
                </p>
            </div>
        </div>
    </div><?php
}
require_once 'system/down.php';