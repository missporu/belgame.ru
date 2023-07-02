<?php


class Page extends Site
{
    public static string $title;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return string
     */
    public static function getTitle(): string
    {
        return self::$title;
    }

    /**
     * @param string $title
     */
    public static function setTitle(string $title): void
    {
        self::$title = $title;
    }


}