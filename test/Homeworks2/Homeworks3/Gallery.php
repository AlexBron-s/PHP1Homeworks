<?php

namespace Homeworks2\Homeworks3;

use DB\Query;
use Homeworks\Homework5;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class Gallery
{
    public function getGallery()
    {
        $url = 'action.php?class_name=Homeworks2\Homeworks3\Gallery&func_name=getImg&img_id=';
        $imgs = (new Query())
            ->select(['img_id' => 'img.id', 'path'])
            ->table('img')
            ->execute();

        foreach ($imgs as &$img) {
            $img->url = $url.$img->img_id;
        }

        $loader = new FilesystemLoader('templates');
        $twig = new Environment($loader);
        echo $twig->render('gallery.html', ['imgs' => $imgs]);
    }

    public function getImg($post)
    {
        (new Homework5())->updateImgAddViews($post['img_id']);

        $img = (new Query())
            ->table('img')
            ->where(['id' => $post['img_id']])
            ->execute();

        if(!$img) {
            $img[]['err'] = "Картинка не найдена";
        }

        $loader = new FilesystemLoader('templates');
        $twig = new Environment($loader);
        echo $twig->render('img.html', ['img' => $img[0]]);
    }
}