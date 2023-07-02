<?php
$title = 'Регистрация';
require_once('system/up.php');
$user = new RegUser();
$user->_noReg();

if (isset($_POST['reg'])) {
    $gold = 10;
    $baks = 100;
    $userDoubleIp = $sql->getRow("select login, pass, email, ip from users where ip = ?s limit ?i", Site::getIp(), 1);

    /**
     * Рефералам
     */

    $referal['id'] = 0;
    if (isset($_POST['ref']) && !empty($_POST['ref'])) {
        if (is_numeric($_POST['ref'])) {
            $ref = Filter::clearFullSpecialChars(string: $_POST['ref']);
        }
        if (!empty($ref) || trim(string: $ref) == "" || strlen(string: trim(string: $ref)) < 3) {
            $ref = "";
        }

        if (Site::getIp() == $userDoubleIp['ip']) {
            Site::session_empty(type: 'error', text: "Себя приглашать нельзя");
        }

        $referal = $sql->getRow("select id from users where login = ?s limit ?i", $ref, 1);
        $gold = 30;
        $baks = 300;
    }

    /**
     * Проверка имени
     */

    if (!empty($_POST['login'])) {

        if (strlen(string: trim(string: $_POST['login'])) < 3 || trim(string: $_POST['login']) == "") {
            Site::session_empty(type: 'error', text: "Поле 'Имя' должно быть от 3х символов");
        }

        $name = trim(string: Filter::clearFullSpecialChars(string: $_POST['login']));
        if (is_numeric($name)) {
            Site::session_empty(type: 'error', text: "В имени не могут быть только цифры");
        }

        $usr = $sql->getOne("select count(id) from users where login = ?s", $name);
        if ($usr >= 1) {
            Site::session_empty(type: 'error', text: "Это имя занято");
        }

    } else {
        $name = null;
        Site::session_empty(type: 'error', text: "Не заполнено поле 'Логин'");
    }

    /**
     * Проверка паролей
     */

    if (!empty($_POST['pass']) || !empty($_POST['pass2'])) {
        if ($_POST['pass'] != $_POST['pass2']) {
            Site::session_empty(type:'error', text: "Пароли не совпадают!");
        }

        if (strlen(string: $_POST['pass']) < 7 || trim(string: $_POST['pass']) == "" || strlen(string: $_POST['pass2']) < 7 || trim(string: $_POST['pass2']) == "") {
            Site::session_empty(type: 'error', text: "Поле 'Пароль' должно быть от 7 символов");
        }

        $pass2 = Filter::clearFullSpecialChars(string: $_POST['pass2']);
        $pass = Filter::clearFullSpecialChars(string: $_POST['pass']);
        $pass = password_hash(password: $pass, algo: PASSWORD_DEFAULT);
    } else {
        $pass = null;
        Site::session_empty(type: 'error', text: "Не заполнено поле 'Пароль'");
    }

    if ($name == $pass) {
        Site::session_empty(type: 'error', text: "Логин и пароль не должны совпадать");
    }

    /**
     * Проверка мыла на валидность
     */

    if (filter_var(value: $_POST['email'], filter: FILTER_VALIDATE_EMAIL)) {

        $email_b = Filter::clearFullSpecialChars(string: $_POST['email']);
        $usm = $sql->getOne("select count(id) from users where email = ?s", $email_b);

        if ($usm >= 1) {
            Site::session_empty(type: 'error', text: "Эта почта уже используется");
        }

    } else {
        $email_b = null;
        Site::session_empty(type: 'error', text: "E-mail адрес указан неверно.");
    }

    $sex = Filter::clearFullSpecialChars(string: $_POST['sex']);

    $sql->query("insert into users set login = ?s, pass = ?s, email = ?s, ip = ?s, browser = ?s, referal = ?i, refer = ?s, data_reg = ?s, time_reg = ?s, sex = ?s, prava = ?i, online = ?i, gold = ?i, raiting = ?i, refer_gold = ?i, news = ?i, donat_bonus = ?i, slovo = ?s, vip = ?i, vip_time = ?i", $name, $pass, $email_b, Site::getIp(), Site::getBrowser(), $referal['id'], Site::getHttpReferer(), Times::setDate(), Times::setTime(), $sex, 1, time(), 0, 0, 0, 0, 0, $_POST['pass2'], 0, 0);

    setcookie('login', $name, time() + 86400 * 365, '/');
    setcookie('IDsess', $pass, time() + 86400 * 365, '/');
    Site::session_empty(type: 'ok', text: "Регистрация прошла успешно! Приятного просмотра!", location: "menu.php");
} else {
    $ref = "";
    if (!empty($_GET['ref'])) {
        $ref = Filter::clearFullSpecialChars(string: $_GET['ref']);
    } ?>
    <div class="container">
    <div class="row">
        <div class="col-md-12 form-login">
            <form class="form-horizontal" action="" method="post">
                <div class="col-xs-12 text-center">
                    <span class="heading">РЕГИСТРАЦИЯ</span>
                </div>
                <div class="form-group">
                    <div class="col-xs-1 text-right">
                        <label for="inputLogin" data-toggle="tooltip" data-placement="top"
                               title="Введите ваш ник в игре"><i class="fa fa-user"></i></label>
                    </div>
                    <div class="col-xs-11">
                        <input data-toggle="tooltip" data-placement="top" title="Логин" type="login"
                               class="form-control" id="inputLogin" name="login" maxlength="16" placeholder="Логин">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-xs-1 text-right">
                        <label for="inputPassword" data-toggle="tooltip" data-placement="top" title="Введите пароль"><i
                                    class="fa fa-lock"></i></label>
                    </div>
                    <div class="col-xs-11">
                        <input data-toggle="tooltip" data-placement="top" title="Введите пароль" type="password"
                               class="form-control" id="inputPassword" name="pass" placeholder="Пароль">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-xs-1 text-right">
                        <label for="inputPassword2" data-toggle="tooltip" data-placement="top" title="Повторите пароль"><i
                                    class="fa fa-lock"></i> <i class="fa fa-lock"></i></label>
                    </div>
                    <div class="col-xs-11">
                        <input data-toggle="tooltip" data-placement="top" title="Повторите пароль" type="password"
                               class="form-control" id="inputPassword2" name="pass2" placeholder="Повторите пароль">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-xs-1 text-right">
                        <label data-toggle="tooltip" data-placement="top" title="E-mail" for="inputEmail"><i
                                    class="fa fa-envelope-o" aria-hidden="true"></i></label>
                    </div>
                    <div class="col-xs-11">
                        <input data-toggle="tooltip" data-placement="top" title="E-mail" type="email"
                               class="form-control" id="inputEmail" name="email" placeholder="E-mail">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-xs-1 text-right">
                        <label data-toggle="tooltip" data-placement="top" title="Пригласил на сайт" for="inputReferal"><i
                                    class="fa fa-handshake-o" aria-hidden="true"></i></label>
                    </div>
                    <div class="col-xs-11">
                        <input data-toggle="tooltip" data-placement="top" title="Пригласил на сайт" type="email"
                               class="form-control" id="inputReferal" name="ref" placeholder="<?= $ref ?>" disabled>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-xs-1 text-right">
                        <label for="sex">Пол</label>
                    </div>
                    <div class="col-xs-11">
                        <select name="sex" id="sex" class="form-control">
                            <option class="form-control" value="m">Мужской</option>
                            <option class="form-control" value="w">Женский</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-xs-12 text-center">
                        <button type="submit" class="btn btn-md btn-default" name="reg">Регистрация</button>
                    </div>
                </div>
            </form>
            <div class="clearfix"></div>
            <div class="separ"></div>
            <div class="col-xs-12 text-center">
                <small class="text-info">
                    Нажимая кнопку <b class="text-info">"Регистрация"</b> вы автоматически принимаете <b><a
                                class="text-info" href="good.php">правила</a></b> нашего сайта.
                </small>
            </div>
            <div class="clearfix"></div>
            <div class="separ"></div>
        </div>
    </div>
    </div><?php
}
require_once('system/down.php');