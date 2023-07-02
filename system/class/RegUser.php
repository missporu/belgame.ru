<?php

class RegUser {
    /**
     * @var string|null
     */
    protected ?string $login = null;

    /**
     * @var string|null
     */
    private ?string $pass;

    private $user_id;

    private false|null|array $user;

    protected SafeMySQL $sql;

    public function __construct() {
        $this->sql = new SafeMySQL();
        if (isset($_COOKIE['login']) && isset($_COOKIE['IDsess'])) {
            if (!empty(trim($_COOKIE['login'])) && !empty(trim($_COOKIE['IDsess']))) {
                $this->login = trim(Filter::clearFullSpecialChars($_COOKIE['login']));
                $this->pass = trim(Filter::clearFullSpecialChars($_COOKIE['IDsess']));
            }
        } else {
            $this->login = null;
            $this->pass = null;
        }
        if ($this->userID()) {
            $this->getUser();
        }
        if ($this->getUser() == true) {

            $this->sql->query("update users set online = ?i, mesto = ?s where id = ?i limit ?i", time(), Site::fileName(), $this->userID(), 1);
        }
    }

    protected function userID() {
        if (isset($this->login) AND isset($this->pass)) {
            $users = $this->sql->getOne("select count(id) from users where login = ?s and pass = ?s limit ?i", $this->login, $this->pass, 1);
            if ($users == 1) {
                $this->user_id = $this->sql->getRow("select id from users where login = ?s and pass = ?s limit ?i", $this->login, $this->pass, 1);
                return Filter::clearInt($this->user_id['id']);
            } else {
                return null;
            }
        }
    }

    /**
     * @return bool
     */
    public function getUser(): bool {
        if(is_numeric($this->userID()) || $this->userID() <> null) {
            return true;
        } else return false;
    }

    /**
     * @param $key
     * @return mixed
     */
    public function user($key): mixed {
        if ($this->getUser() == true) {
            $this->user = $this->sql->getRow("select $key from users where id = ?i limit ?i", $this->userID(), 1);
            return $this->user[$key];
        }
    }

    /**
     * @return int
     */
    public function setUserBonus(): int {
        $bon = $this->sql->getOne("select count(id) from user_bonus where id_user = ?i limit ?i", $this->user('id'), 1);
        return Filter::clearInt($bon);
    }

    /**
     * @param $value
     * @return mixed
     */
    public function userBonus($value): mixed {
        if ($this->setUserBonus() == 1) {
            $data = $this->sql->getRow("select * from user_bonus where id_user = ?i limit ?i", $this->userID(), 1);
            return $data[$value];
        } else {
            $this->sql->query("insert into user_bonus set time = ?i, id_user = ?i, status_day = ?i, last_date = ?s", time(), $this->user('id'), 1, Times::setDate());
            Site::_location('?');
        }
    }

    public function _Reg() {
        if ($this->getUser() == false) {
            Site::session_empty('error',"Вы не авторизованы!","index.php");
        }
    }

    public function _noReg() {
        if ($this->getUser() == true) {
            Site::_location("menu.php");
        }
    }

    /**
     * @param $timeDay
     */
    public function addAitomaticBlock($timeDay) {
        $this->sql->query("update users set block = ?i, block_time = ?i where id = ?i limit ?i", 1, (time()+(60*60*24*$timeDay)), $this->userID(), 1);
    }

    /**
     * @return bool
     */
    public function getBlock(): bool {
        if($this->user('block') == 1 && $this->user('block_time') > time()) {
            return true;
        } else {
            return false;
        }
    }


    public function setBan() {
        try {
            if($this->user('ban') == 1 && $this->user('ban_time') > time()) {
                throw new Exception('Вы забанены администрацией проекта!');
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * @param $key
     * @param $value
     */
    public function addMoney($key, $value) {
        try {
            $addMoney = $this->user($key) + $value;
            $addMoney = round(Filter::clearInt($addMoney ) );
            if ($addMoney > 999999999) {
                throw new Exception("Вы превысили лимит (999999999)");
            }
            $this->sql->query("update users set $key = ?i where login = ?s limit ?i", $addMoney, $this->user(key: 'login'), 1);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * @param $userID
     */
    public function add_narushenie($userID) {
        $this->sql->query("update users set narushenie = narushenie + ?i where id = ?i", 1, $userID);
    }

    public function addNarushenieAdmin($userID) {
        $this->sql->query("update users set narushenie_admin = narushenie_admin + ?i where id = ?i", 1, $userID);
    }

    /**
     * @param $text
     * @param $type
     * @param $admin
     */
    public function UserErrorEnterFromModer($text, $type, $admin) {
        if ($this->user('dostup') <= $admin) {
            (new Site())->errorLog($this->user('name'), $text, $type);
            $this->add_narushenie($this->user('id'));
            Site::session_empty('error',"Запрет входа. Админ получил письмо. Бан выехал","menu.php");
        }
    }

    /**
     * <====  Выход  ====>
     */
    public function exitReg() {
        $this->sql->query("update users set online = ?i where id = ?i limit ?i", 0, $this->userID(), 1);
        setcookie("login", '', time()-3600);
        setcookie("IDsess", '', time()-3600);
        session_destroy();
        Site::_location("index.php");
    }

    /**
     * @param $value
     * @return bool
     */
    public function mdAmdFunction($value): bool {
        if($this->user('prava') > $value) {
            return true;
        } else return false;
    }
}