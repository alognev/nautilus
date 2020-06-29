<?php
/**
 * Created by PhpStorm.
 * User: aognev
 * Date: 12.07.2016
 * Time: 11:53
 */

namespace Application;

class Application
{
    public function __construct(){}

    public function init(){
        $grub = new Grabber();
        $grub->setUrl('http://www.korablik.ru/');

        $grub->replace(array('8 (800) 775-03-43' => '8 (800) 000-00-00', 'Кораблик-Р' => 'Nautilus-R')); //':abc' => ':tre', ':def' => 'Jane', ':tre' => ':abc'
        echo $grub;

        $grub->revert();
        echo $grub;

        $grub->replaceValue('Кораблик-Р', 'Nautilus-R_1');
        echo $grub;
    }
}