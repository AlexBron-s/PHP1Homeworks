<?php
namespace Homeworks;
class Homework3
{

    /**
     * С помощбю цикла while вывести все числа в промежутке от 0 до 100 которые деляться на 3 без остатка
     */
    public function paragraph1()
    {
        $result = null;
        $i = 0;
        while ($i < 101) {
            if ($i % 3 == 0) {
                $result[] = $i;
            }
            $i++;
        }
        return $result;
    }

    /**
     * С помощбю цикла do...while вывести стрки цифр от 0 до 10 с чётное, нечётное
     */
    public function paragraph2()
    {
        $result = null;
        $i = 0;
        do {
            if ($i == 0) {
                $result[] = "$i - это ноль";
            } elseif ($i & 1) {
                $result[] = "$i - это нечётное";
            } else {
                $result[] = "$i - это чётное";
            }
        } while ($i++ < 10);
        return $result;
    }

    /**
     * С вывести массив где область как ключ в в нём массив горадов
     */
    public function paragraph3()
    {
        $regions = array(
            'Московская область' => array(
                'Балашиха',
                'Подольск',
                'Мытищи',
                'Химки'
            ),
            'Кемеровская область' => array(
                'Кемерово',
                'Новокузнецк',
                'Прокопьевск',
                'Белово'
            ),
            'Томская область' => array(
                'Томск',
                'Северск',
                'Стрежевой',
                'Асино'
            ),
            'Новосибирская область' => array(
                'Новосибирск',
                'Куйбышев',
                'Бердск',
                'Кольцово'
            ),
        );

        foreach ($regions as $region => $cities) {
            echo $region.':<br/>';
            $i = 0;
            foreach ($cities as $city) {
                if ($i++ != 0) {
                    echo ', ';
                }
                echo $city;
            }
            echo '<br/>';
        }
    }

    /**
     * Функция транслитерации строк
     */
    public function paragraph4($post)
    {
        $map = array(
            "а"=>"a","б"=>"b","в"=>"v","г"=>"g","д"=>"d",
            "е"=>"e", "ё"=>"yo","ж"=>"j","з"=>"z","и"=>"i",
            "й"=>"i","к"=>"k","л"=>"l", "м"=>"m","н"=>"n",
            "о"=>"o","п"=>"p","р"=>"r","с"=>"s","т"=>"t",
            "у"=>"y","ф"=>"f","х"=>"h","ц"=>"c","ч"=>"ch",
            "ш"=>"sh","щ"=>"sh","ы"=>"i","э"=>"e","ю"=>"u",
            "я"=>"ya",
            "А"=>"A","Б"=>"B","В"=>"V","Г"=>"G","Д"=>"D",
            "Е"=>"E","Ё"=>"Yo","Ж"=>"J","З"=>"Z","И"=>"I",
            "Й"=>"I","К"=>"K","Л"=>"L","М"=>"M","Н"=>"N",
            "О"=>"O","П"=>"P","Р"=>"R","С"=>"S","Т"=>"T",
            "У"=>"Y","Ф"=>"F","Х"=>"H","Ц"=>"C","Ч"=>"Ch",
            "Ш"=>"Sh","Щ"=>"Sh","Ы"=>"I","Э"=>"E","Ю"=>"U",
            "Я"=>"Ya",
            "ь"=>"","Ь"=>"","ъ"=>"","Ъ"=>"",
            "ї"=>"j","і"=>"i","ґ"=>"g","є"=>"ye",
            "Ї"=>"J","І"=>"I","Ґ"=>"G","Є"=>"YE"
        );

        return strtr($post['string'], $map);
    }

    /**
     * Функция заменяеть в строке пробелы на подчёркивание
     */
    public function paragraph5($post)
    {
        return strtr($post['string'], ' ', '_');
    }

    /**
     * Вывести от 0 до 9 используя тело цикла
     */
    public function paragraph7()
    {
        $result = null;
        for ($i = 0; $i <= 9; $result[] = $i++) {}
        return $result;
    }

    /**
     * С вывести только горада начинающися на К
     */
    public function paragraph8()
    {
        $regions = array(
            'Московская область' => array(
                'Балашиха',
                'Подольск',
                'Мытищи',
                'Химки'
            ),
            'Кемеровская область' => array(
                'Кемерово',
                'Новокузнецк',
                'Прокопьевск',
                'Белово'
            ),
            'Томская область' => array(
                'Томск',
                'Северск',
                'Стрежевой',
                'Асино'
            ),
            'Новосибирская область' => array(
                'Новосибирск',
                'Куйбышев',
                'Бердск',
                'Кольцово'
            ),
        );

        $i = 0;
        foreach ($regions as $cities) {
            foreach ($cities as $city) {
                $first = mb_substr($city, 0, 1);
                if ($first == 'К') {
                    if ($i++ != 0) {
                        echo ', ';
                    }
                    echo $city;
                }
            }
        }
    }

    public function paragraph9($post)
    {
        $post['string'] = $this->paragraph4($post);
        return $this->paragraph5($post);
    }
}