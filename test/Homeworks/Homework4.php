<?php
namespace Homeworks;
class Homework4
{
    public function paragraph1()
    {
        $url = '/img';

        foreach (glob("D:/xampp/www/test/$url/*.png") as $fileName) {
            $new_url = $url . '/' . basename($fileName);
            echo '<a href="'.$new_url.'"><img src="'.$new_url.'" width="240"></a>';
        }

    }
}