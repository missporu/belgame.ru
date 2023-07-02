<?php

use JetBrains\PhpStorm\NoReturn;

class Site
{
    /**
     * @var string
     */
    const NAME = "Портал BelGame";

    protected SafeMySQL $sql;

    public $switch = null;

    public function __construct()
    {
        $this->sql = new SafeMySQL();

        $this->SiteSetting();
    }

    public function SiteSetting()
    {
        $siteStatus = $this->sql->getRow("select * from setting_game where id = ?i", 1);
        try {
            if ($_SERVER['SCRIPT_NAME'] != '/index.php') {
                if ($siteStatus['site_status'] == 'off') {
                    throw new Exception("Сайт закрыт!");
                }
            }
            if ($_SERVER['SCRIPT_NAME'] == '/reg.php') {
                if ($siteStatus['registration'] == 'off') {
                    throw new Exception("Регистрация закрыта");
                }
            }
        } catch (Exception $e) { ?>
            <div class="text-center">
            <p style="color: red">
                <?= $e->getMessage(); ?>
            </p>
            </div><?php
            exit();
        }
    }

    public static function lineHrInContainer()
    { ?>
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <hr>
                </div>
            </div>
        </div><?php
    }

    public static function PrintMiniLine()
    { ?>
        <div class="clearfix"></div>
        <div class="separ"></div>
        <div class="clearfix"></div><?php
    }

    public static function fileName()
    {
        $fileName = $_SERVER['PHP_SELF'];
        $fileName = explode('/', $fileName);
        return $fileName[1];
    }

    /**
     * @return mixed
     */
    public static function getDomen(): mixed
    {
        return $_SERVER['HTTP_HOST'];
    }

    /**
     * @return mixed
     */
    public static function getUserAgent(): mixed
    {
        return $_SERVER['HTTP_USER_AGENT'];
    }

    /**
     * @return mixed
     */
    public static function getScriptURI(): mixed
    {
        return $_SERVER['SCRIPT_URI'];
    }

    /**
     * @return mixed
     */
    public static function getServerAddrIP(): mixed
    {
        return $_SERVER['SERVER_ADDR'];
    }

    /**
     * @return string
     */
    public static function getServerAdmin(): string
    {
        $_SERVER['SERVER_ADMIN'] = "misspo.ru@gmail.com";
        return $_SERVER['SERVER_ADMIN'];
    }

    /**
     * @return string
     */
    public static function getIp(): string
    {
        $keys = [
            'HTTP_CLIENT_IP',
            'HTTP_X_FORWARDED_FOR',
            'REMOTE_ADDR'
        ];
        foreach ($keys as $key) {
            if (!empty($_SERVER[$key])) {
                $array = explode(',', $_SERVER[$key]);
                $ip = trim(end($array));
                if (filter_var($ip, FILTER_VALIDATE_IP)) {
                    return $ip;
                }
            }
        }
    }

    /**
     * @return mixed
     */
    public static function getBrowser(): mixed
    {
        return Filter::clearString($_SERVER['HTTP_USER_AGENT']);
    }

    /**
     * @return mixed
     */
    public static function getHttpReferer(): mixed
    {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $referer = Filter::clearFullSpecialChars($_SERVER['HTTP_REFERER']);
        } else {
            $referer = Filter::clearFullSpecialChars('//' . $_SERVER['HTTP_HOST']);
        }
        return $referer;
    }

    public function errorLog($kto, $text, $type)
    {
        $this->sql->query("insert into logi set kto = ?s, text = ?s, gde = ?s, tip = ?s, r_time = ?s, r_date = ?s, soft = ?s, ip = ?s", Filter::clearFullSpecialChars($kto), Filter::clearFullSpecialChars($text), Site::fileName(), Filter::clearFullSpecialChars($type), Times::setTime(), Times::setDate(), Site::getUserAgent(), Site::getIp());
    }

    public function adminLog($kto, $text, $type)
    {
        $this->sql->query("insert into admin_log set kto = ?s, text = ?s, gde = ?s, tip = ?s, r_time = ?s, r_date = ?s, soft = ?s, ip = ?s", Filter::clearFullSpecialChars($kto), Filter::clearFullSpecialChars($text), Site::fileName(), Filter::clearFullSpecialChars($type), Times::setTime(), Times::setDate(), Site::getUserAgent(), Site::getIp());
    }

    /**
     * @param string $type
     * @param string $text
     * @param string $location
     */
    public static function session_empty(string $type = "info", string $text = "", string $location = "?")
    {
        if (!empty($text)) {
            $_SESSION[$type] = nl2br($text);
        }
        Site::_location($location);
    }

    /**
     * @param $location
     */
    #[NoReturn]
    public static function _location($location)
    {
        header("Location: " . Filter::clearFullSpecialChars($location) . "");
        exit;
    }

    /**
     * @return mixed
     */
    public static function getDateRus(): mixed
    {
        $d = date("d F");
        $d = str_replace("January", "января", $d);
        $d = str_replace("February", "февраля", $d);
        $d = str_replace("March", "марта", $d);
        $d = str_replace("April", "апреля", $d);
        $d = str_replace("May", "мая", $d);
        $d = str_replace("June", "июня", $d);
        $d = str_replace("July", "июля", $d);
        $d = str_replace("August", "августа", $d);
        $d = str_replace("September", "сентября", $d);
        $d = str_replace("October", "октября", $d);
        $d = str_replace("November", "ноября", $d);
        $d = str_replace("December", "декабря", $d);
        return Filter::clearString($d);
    }

    public function lastDay()
    {
        $tomorrow = mktime(0, 0, 0, date("m"), date("d") - 1, date("Y"));
        $lastmonth = mktime(0, 0, 0, date("m") - 1, date("d"), date("Y"));
    }

    /**
     * @param string $class
     * @param string $dataToggle
     * @param string $link
     * @param string $text
     */
    public static function linkToSiteAdd($class = "", $dataToggle = "", $link = "?", $text = ""): void
    {
        if (is_string(value: $dataToggle) && trim($dataToggle) != "" && strlen(trim($dataToggle)) > 0) {
            $dataToggle = "data-toggle=\"{$dataToggle}\"";
        } ?>
        <a href="//<?= Site::getDomen() . "/" . $link ?>" class="<?= $class ?>" <?= $dataToggle ?>><?= $text ?></a><?php
    }

    public function getSwitch()
    {
        return $this->switch;
    }

    public function setSwitch($get)
    {
        $this->switch = isset($_GET[$get]) ? Filter::clearFullSpecialChars($_GET[$get]) : null;
    }

    /**
     * @param string $class
     * @param string $src
     * @param string $alt
     * @param string $text
     */
    public static function returnImage(string $class = 'img-responsive', string $src = '?', string $alt = "", string $text = "")
    { ?>
        <img class="<?= Filter::clearFullSpecialChars($class) ?>"
             src="images/<?= Filter::clearFullSpecialChars($src) ?>"
             alt="<?= Filter::clearFullSpecialChars($alt) ?>"/>
        <?= Filter::clearFullSpecialChars($text) ?><?php
    }


}