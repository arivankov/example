<?php

/**
 * Created by PhpStorm.
 * User: icemn
 * Date: 08.07.2019
 * Time: 14:01
 */
class summaryBanner
{
    const HOST = "172.16.10.12";
    const USERNAME = "wwp";
    const PASSWORD = "Ag1AGh1iAFHGAb1u01fao1bfaAAGIh1";
    const DBNAME = "wwp";

    var $link;


    function __construct()
    {
        $this->link = mysqli_connect(self::HOST,self::USERNAME, self::PASSWORD);
        if (!$this->link) {
            echo "Ошибка: Невозможно установить соединение с MySQL." . PHP_EOL;
            echo "Код ошибки error: " . mysqli_connect_errno() . PHP_EOL;
            echo "Текст ошибки error: " . mysqli_connect_error() . PHP_EOL;
            exit;
        }
        mysqli_select_db($this->link,self::DBNAME);
    }


    function getBannersList(){
        $query = "SELECT * FROM `summary_top_slider` ORDER BY `sort`";
        $result = mysqli_query($this->link,$query);
        while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
           $res[] = $row;
        }
        return $res;
    }

    function setBannerByID($id,$date, $active,$sort,$image,$name,$text,$lang = 1){

        $active = intval($active);
        $query = "UPDATE `summary_top_slider` SET 
                      `date`= {$date},
                      `active`= {$active},
                      `sort`= {$sort},
                      `image`= '{$image}',
                      `name`= '{$name}',
                      `text`= '{$text}',
                      `language_id`= {$lang} WHERE `id` = {$id}";
        $result = mysqli_query($this->link,$query);
    }

    function newBanner($date, $active = 0,$sort,$image,$name,$text,$lang = 1){

        $active = intval($active);
        $query = "INSERT INTO `summary_top_slider`(`date`, `active`, `sort`, `image`, `name`, `text`, `language_id`) VALUES 
                      ( {$date},{$active},{$sort},'{$image}','{$name}','{$text}',{$lang} )";
        $result = mysqli_query($this->link,$query);
    }

    function __destruct()
    {
        mysqli_close($this->link);
    }

}