<?php
namespace Homeworks;

use DB\Query;

class Homework5
{
    public function paragraph1()
    {
        $url = 'action.php?class_name=Homeworks\Homework5&func_name=getImg&img_id=';

        require_once 'DB\Query.php';
        $imgs = (new Query())->table('img')->execute();

        foreach ($imgs as $img) {
            echo '<a href="'.$url.$img->id.'"><img src="'.$img->path.'" width="240"></a>';
        }

    }

    public function getImg($post)
    {
        require_once 'DB\Query.php';

        $this->updateImgAddViews($post['img_id']);

        $imgs = (new Query())->table('img')->where(['id' => $post['img_id']])->execute();

        echo '<p><img src="'.$imgs[0]->path.'"></p>';
        echo '<p>Популярность: '.$imgs[0]->views.'</p>';
    }

    public function updateImgAddViews($id)
    {
        require_once 'DB\Query.php';
        (new Query())->table('img')->update(['views' => 'views + 1'])->where(['id' => $id])->execute();
    }
}
