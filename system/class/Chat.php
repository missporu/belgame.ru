<?php

class Chat extends Pagination {

    public function chatForeach() {

    }

    public function ChatAll() {
        parent::setCount(0, 0);
        if (parent::getCount() > 0) {
            $this->chatForeach();
        }
    }
}