<?php
/**
 * Created by PhpStorm.
 * User: aognev
 * Date: 12.07.2016
 * Time: 12:19
 */

namespace Application;

class Grabber
{
    static public $content, $replacements, $url;

    const REQUEST_TIMEOUT = 10;

    public function __construct($url = '')
    {
        if (!empty($url)) {
            $this->setUrl($url);
        }
    }

    /**
     * @description Замена содердимого
     * @param array $replacements
     * @throws \Exception
     */
    public function replace(array $replacements = array())
    {
        $this->setReplacements($replacements);
        $this->checkClosingReplacements();
        $this->setContent( $this->request() );
        $this->setContent( $this->parseTagsRecursive($this->getContent()) );
    }

    /**
     * @description Замена по одному значению
     * @param $search
     * @param $replace
     */
    public function replaceValue($search, $replace){
        $this->replace(array(
            $search => $replace
        ));
    }

    /**
     * @description Замена исходными данными, через потомка, инициализированного в предке
     */
    public function revert(){
        $revertService = new Revert();
        $revertService->revert();
    }

    /**
     * @description Проверяет конфликт данных на случай бесконечной цикличности замены
     * @param bool|true $removeLoop удалять данные, которые могут вызвать зацикливание, или выводить ошибку
     * @throws \Exception
     */
    protected function checkClosingReplacements($removeLoop = true)
    {
        foreach (array_keys(self::$replacements) as $replacementsKey) {
            foreach (self::$replacements as $key => $replacementsValue) {
                if (strpos($replacementsValue, $replacementsKey) !== false && // если есть значение на замену, равное значению подмены
                    strpos(self::$replacements[$replacementsKey], $key) !== false // а значение подмены в свою очередь равно значению на замену :)
                ) {
                    if ($removeLoop)
                        unset(self::$replacements[$replacementsKey]);
                    else throw new \Exception('Конфликт данных для замены');
                }
            }
        }
    }

    /**
     * @description Рекурсивная замена текста
     * @param $input
     * @return mixed
     */
    public function parseTagsRecursive($input)
    {
        if (is_array($input)) {
            $input = self::$replacements[$input[1]];
        }

        return preg_replace_callback('/(' . implode('|', array_keys(self::$replacements)) . ')/', "self::parseTagsRecursive", $input);
    }

    /**
     * @description Получить содержимое сайта
     * @return mixed
     * @throws \Exception
     */
    protected function request()
    {
        if (!$this->getUrl()) {
            throw new \Exception('Не указан URL');
        }

        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->getUrl());
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, self::REQUEST_TIMEOUT);
            curl_setopt($ch, CURLOPT_TIMEOUT, self::REQUEST_TIMEOUT);
            curl_setopt($ch, CURLINFO_HEADER_OUT, true);

            $result = curl_exec($ch);
            $info = curl_getinfo($ch);
            curl_close($ch);

            if (!isset($info['http_code']) || $info['http_code'] !== 200) {
                throw new \Exception('Не удалось получить данные по указаному адресу: ' . $this->getUrl());
            }

            return $result;
        } catch (\Exception $e) {
            throw new \Exception('Произошла ошибка при получении данных: ' . $e->getMessage());
        }
    }

    public function setUrl($url)
    {
        if (is_string($url)) {
            self::$url = $url;
        } else {
            throw new \Exception('Не верный параметр URL');
        }
    }

    public function getUrl()
    {
        return self::$url;
    }

    public function getReplacements(){
        return self::$replacements;
    }

    public function setReplacements(array $replacements){
        self::$replacements = $replacements;
    }

    public function setContent($content){
        self::$content = $content;
    }

    public function getContent(){
        return self::$content;
    }

    /**
     * @description Вывод результата
     * @return mixed
     */
    public function __toString(){
        return $this->getContent();
    }
}