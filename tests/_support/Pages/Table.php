<?php
/**
 * Created by PhpStorm.
 * User: t.chervyakova
 * Date: 26.01.2020
 * Time: 14:35
 */

namespace Pages;

use Models\BaseModel;
use Models\Todo;

/**
 * Список записей
 *
 * Class Table
 * @package Pages
 */
class Table extends BasePage
{
    public const TABLE = "//table[contains(@class, 'has-mobile-cards')]";
    public const FLD_ID = "//td[@data-label='ID']";
    public const FLD_NAME = "//td[@data-label='Todo']";
    public const FLD_PRIORITY = "//td[@data-label='Priority']";
    public const FLD_EDIT = "//td[@data-label='Edit']";
    public const FLD_DELETE = "//td[@data-label='Delete']";

    /**
     * Проверяет, что такая запись есть в таблице
     * @param Todo $model
     */
    public function seeTodo(Todo $model): void
    {
        $I = $this->user;
        $I->seeElement($this->getRow($model));
    }

    /**
     * Проверяет, что такой записи нет в таблице
     * @param Todo $model
     */
    public function dontSeeTodo(Todo $model): void
    {
        $I = $this->user;
        $I->dontSeeElement($this->getRow($model));
    }

    /**
     * Проверяет, что в таблице данное количество записей
     * @param Todo $model
     * @param int $count
     */
    public function seeNumberOfTodos(Todo $model, int $count): void
    {
        $I = $this->user;
        $row = $this->getRow($model);
        $I->seeNumberOfElements($row, $count);
    }

    /**
     * Возвращает локатор строки в таблице со значениями полей todo
     * @param BaseModel $model
     * @return string
     */
    public function getRow(BaseModel $model): string
    {
        return static::TABLE
            . '//tr'
            . '[.'
            . $this->glueSelectors($model)
            . ']';
    }

    /**
     * Склеивает локаторы ячеек таблицы в единый локатор
     * @param BaseModel $model
     * @return string
     */
    protected function glueSelectors(BaseModel $model): string
    {
        return implode(' and .', $this->getSelectors($model));
    }

    /**
     * Возвращает массив локаторов полей со значениями из модели
     * @param BaseModel $model
     * @return array
     */
    protected function getSelectors(BaseModel $model): array
    {
        $rowSelectors = [];

        // если нет значений для сравнения, возвращаем пустой массив
        if (empty($model)) {
            return [];
        }

        // иначе для каждого свойства модели смотрим, не пустое ли оно,
        // и если нет - предполагаем, что одноименное поле таблицы имеет то же значение
        foreach ($model as $field => $value) {
            if (!empty($value)) {
                $fieldName = 'FLD_' . strtoupper($field);
                $rowSelectors[] = $this->fieldContains(
                    constant('static::' . $fieldName),
                    $value
                );
            }
        }

        return $rowSelectors;
    }

    /**
     * Утверждает, что поле таблицы имеет определенное значение
     * @param string $field
     * @param string $value
     * @return string
     */
    protected function fieldContains(string $field, string $value): string
    {
        return $field . "[normalize-space()='" . trim($value) . "']";
    }
}
