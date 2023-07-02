<?php
class Admin extends RegUser {

    /**
     * @var int
     */
    private int $admin;

    /**
     * @return bool
     */
    public function returnAdmin(): bool {
        return parent::user(key: 'prava') == $this->admin;
    }

    /**
     * @param int $admin
     * @return Admin
     */
    public function setAdmin(int $admin): Admin {
        $this->admin = Filter::clearInt(string: $admin);
        return $this;
    }

    /**
     * @return int
     */
    public function getAdmin(): int {
        return $this->admin;
    }

}