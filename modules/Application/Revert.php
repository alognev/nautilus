<?php
/**
 * Created by PhpStorm.
 * User: aognev
 * Date: 12.07.2016
 * Time: 12:19
 */

namespace Application;

class Revert extends Grabber
{

    protected function revertReplacements()
    {
        $this->setReplacements(array_flip(
            $this->getReplacements()
        ));
    }

    public function revert()
    {
        $this->revertReplacements();
        $this->replace($this->getReplacements());
        $this->revertReplacements(); // возвращаем массив замены в исходное состояние
    }
}