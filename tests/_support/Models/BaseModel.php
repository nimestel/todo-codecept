<?php

namespace Models;

/**
 * Базовый класс для моделей
 *
 * Class BaseModel
 * @package Model
 */
class BaseModel
{
    /** Путь к папке с файлами данных */
    protected const PATH = '/fixtures/';
    /** Название файла с данными */
    protected $file = '';
    /** Данные из файла */
    protected $data;

    public function __construct($jsonBlock = null)
    {
        if (!$jsonBlock){
            return;
        }

        $this->set($jsonBlock);
    }

    protected function set($jsonBlock)
    {
        $this->data = $this->getData($this->file);
        $this->initModel($this->data[$jsonBlock]);
    }

    /**
     * Получает данные из json-файла
     *
     * @param string $file
     * @return array
     */
    protected function getData(string $file): array
    {
        if (empty($file)) {
            return [];
        }

        $fullFilePath = codecept_data_dir() . static::PATH . $file;
        $res = file_get_contents($fullFilePath);

        return json_decode($res, true);
    }

    /**
     * Присвоить полям модели значения из файла json
     * @param array $data
     */
    protected function initModel(array $data): void
    {
        foreach ($data as $field => $value) {
            if (property_exists($this, $field)) {
                $this->$field = $value;
            }
        }
    }

    /**
     * Генерирует строку из сочетания перечисленных символов указанной длины
     * @param int $length
     * @return bool|string
     */
    public function generateRandomString($length = 10)
    {
        $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!,.?(){}[]:;\/-_+=`~  ';
        return trim(substr(str_shuffle(str_repeat($chars,
            ceil($length / strlen($chars)))), 1, $length));
    }

}