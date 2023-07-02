<?php

class Pagination extends RegUser {

    public $pages;
    public $page;
    public $count;
    public $getAll;
    public $pagePagin;

    public function navigationPages () {
        $get = 'page';
        if ($this->page != 1) {
            $pervpage = '<a href=?'.$get.'='. ($this->page - 1) .'>&#171; Prev</a> | ';
        }
        if ($this->page != $this->pages) {
            $nextpage = ' | <a href=?'.$get.'='. ($this->page + 1) .'>Next &#187;</a></a>';
        }
        if ($this->page>4) {
            $pagel = ' <a href=?'.$get.'=1>1</a> ...| ';
        } else {
            $pagel = '';
        }
        if (($this->pages-3) != $page and ($this->pages-3) >= $page) {
            $pagep = ' |... <a href=?'.$get.'='.$this->pages.'>'.$this->pages.'</a> ';
        } else {
            $pagep = '';
        }
        if (empty($pagel)) {
            if ($this->page - 3 > 0) {
                $page3left = ' <a href=?'.$get.'='. ($this->page - 3) .'>'. ($this->page - 3) .'</a> | ';
            }
        } else {
            $page3left = '';
        }
        if ($this->page - 2 > 0) {
            $page2left = ' <a href=?'.$get.'='. ($this->page - 2) .'>'. ($this->page - 2) .'</a> | ';
        }
        if ($this->page - 1 > 0) {
            $page1left = '<a href=?'.$get.'='. ($this->page - 1) .'>'. ($this->page - 1) .'</a> | ';
        }
        if (empty($pagep)) {
            if ($this->page + 3 <= $this->pages) {
                $page3right = ' | <a href=?'.$get.':'. ($this->page + 3) .'>'. ($this->page + 3) .'</a>';
            }
        } else {
            $page3right = '';
        }
        if ($page + 2 <= $this->pages) {
            $page2right = ' | <a href=?' . $get . '=' . ($this->page + 2) . '>' . ($this->page + 2) . '</a>';
        }
        if ($page + 1 <= $this->pages) {
            $page1right = ' | <a href=?'.$get.'='. ($this->page + 1) .'>'. ($this->page + 1) .'</a>';
        }
        if ($this->pages > 1) { ?>
            <div class="col-xs-12 text-center">
            <div class="col-xs-12 text-center">
                <hr>
            </div><?
            echo $pervpage.$pagel.$page3left.$page2left.$page1left.'<b>'.$this->page.'</b>'.$page1right.$page2right.$page3right.$pagep.$nextpage; ?>
            <div class="col-xs-12 text-center">
                <hr>
            </div>
            </div><?
        }
    }

    public function pagination (int $type, int $privat) {
        $this->setCount($type, $privat);
        if ($this->getCount() > 0) {
            $this->pages;
            if (isset($_GET['page'])) {
                $this->page = abs(intval($_GET['page']));
            } else {
                $this->page = 1;
            }
            $from = ($this->page - 1) * 10;
        }
        $this->getAll = $this->sql->getAll("select * from chat where type = ?i and privat = ?i and login = ?s order by id desc limit ?i, ?i", $type, $privat, parent::user('login'), $from, 10);
    }

    /**
     * @param int $type
     * @param int $privat
     * @return int
     */
    public function setCount (int $type, int $privat): int {
        try {
            if (!parent::getUser()) {
                throw new Exception('Error 121 - ' . __CLASS__ . ' SetCount');
            }
            $this->count = $this->sql->getOne("select count(id) from chat where type = ?i and privat = ?i and user = ?s", $type, $privat, parent::user('login'));
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * @return mixed
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * @return mixed
     */
    public function getPages() {
        return $this->pages;
    }

    public function setPages() {
        $this->pages = ceil($this->getCount() / 10);
    }

    /**
     * @return mixed
     */
    public function getPagePagin()
    {
        return $this->pagePagin;
    }

    /**
     * @param mixed $pagePagin
     */
    public function setPagePagin($pagePagin): void
    {
        $this->pagePagin = $pagePagin;
    }
}