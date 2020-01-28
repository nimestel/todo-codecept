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
class TablePage extends BasePage
{
    public const TABLE = "//table[contains(@class, 'has-mobile-cards')]";
    public const HEADER_NAME = "//th[normalize-space()='Todo']";
    public const HEADER_PRIORITY = "//th[normalize-space()='Priority']";
    public const BTN_FILTER = "//*[contains(@class, 'is-small')]";
    public const FLD_NAME = "//td[@data-label='Todo']";
    public const FLD_PRIORITY = "//td[@data-label='Priority']";
    public const FLD_EDIT = "//td[@data-label='Edit']";
    public const FLD_DELETE = "//td[@data-label='Delete']";
    public const BTN_EDIT = self::FLD_EDIT . "//button";
    public const BTN_DELETE = self::FLD_DELETE . "//button";
    
    public const MOBILE_HEADER = "//*[contains(@class, 'table-mobile-sort')]";
    public const SELECT_FILTER = self::MOBILE_HEADER . "//select";
    public const BTN_ASC_DESC = self::MOBILE_HEADER . "//button[contains(@class, 'is-primary')]";

    /**
     * Проверяет, что такая запись есть в таблице
     * @param Todo $model
     */
    public function seeTodo(Todo $model): void
    {
        $I = $this->user;
        $I->seeTo($this->getRow($model));
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
     * Открыть окно редактирования записи
     * @param Todo $model
     * @return TodoCard
     */
    public function openEditTodoWindow(Todo $model): TodoCard
    {
        $I = $this->user;

        $row = $this->getRow($model);
        $I->clickTo($row . static::BTN_EDIT);

        return new TodoCard($I);
    }

    /**
     * Открыть окно удаления записи
     * @param Todo $model
     * @return TodoCard
     */
    public function openDeleteTodoWindow(Todo $model): TodoCard
    {
        $I = $this->user;

        $row = $this->getRow($model);
        $I->clickTo($row . static::BTN_DELETE);

        return new TodoCard($I);
    }

    /**
     * Проверяет, что запись в таблице находится в указанной строке
     * @param Todo $model
     * @param int $num
     */
    public function seeRowNumberIs(Todo $model, int $num): void
    {
        $I = $this->user;

        $row = $this->getRow($model, $num);
        $I->seeTo($row);
    }

    /**
     * Возвращает локатор строки в таблице со значениями полей todo
     * В случае указания номера строки, добавляет его к локатору
     * @param BaseModel $model
     * @param null $num
     * @return string
     */
    public function getRow(BaseModel $model, $num = null): string
    {
        return static::TABLE
            . $this->getTr($num)
            . '[.'
            . $this->glueSelectors($model)
            . ']';
    }

    /**
     * Возвращает локатор элемента строки
     * В случае указания номер строки - добавляет его в локатор
     * @param int $num
     * @return string
     */
    protected function getTr(int $num = null): string
    {
        $tr = '//tr';

        if($num){
            return $tr . '[' . $num . ']';
        }

        return $tr;
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
            $fieldName = 'FLD_' . strtoupper($field);
            $rowSelectors[] = $this->fieldContains(
                constant('static::' . $fieldName),
                $value
            );
        }

        return $rowSelectors;
    }

    /**
     * Утверждает, что поле таблицы имеет определенное значение
     * @param string $field
     * @param $value
     * @return string
     */
    protected function fieldContains(string $field, $value): string
    {
        return $field . "[normalize-space()='" . $value . "']";
    }

    /**
     * Проверяет, что в таблице правильно отображаются заголовки
     */
    public function checkHeader(): void
    {
        $header = static::TABLE . "//thead//tr";
        $titles = [
            'ID',
            'Todo',
            'Priority',
            'Edit',
            'Delete'
        ];

        foreach ($titles as $title){

            $I = $this->user;

            $title = $header . "//th[normalize-space()='" . $title . "']";
            $I->seeTo($title);
        }
    }

    /**
     * Проверяет, что в таблице правильно отображаются заголовки
     */
    public function checkCellMobile(): void
    {
        $cell = static::TABLE . "//tr";
        $titles = [
            'ID',
            'Todo',
            'Priority',
            'Edit',
            'Delete'
        ];

        foreach ($titles as $title){

            $I = $this->user;

            $title = $cell . "//td[@data-label='" . $title . "']";
            $I->seeTo($title);
        }
    }

    /**
     * Сортирует значения в таблице по названию
     */
    public function sortByName(): void
    {
        $this->user->clickTo(static::HEADER_NAME);
    }

    /**
     * Сортирует значения в таблице по приоритету
     */
    public function sortByPriority(): void
    {
        $this->user->clickTo(static::HEADER_PRIORITY);
    }

    /**
     * Выбирает сортировку значений в таблице по названию
     */
    public function sortByNameMobile(): void
    {
        $this->user->selectOption(static::SELECT_FILTER, 'Todo');
    }

    /**
     * Выбирает сортировку значений в таблице по приоритету
     */
    public function sortByPriorityMobile(): void
    {
        $this->user->selectOption(static::SELECT_FILTER, 'Priority');
    }

    /**
     * Выбирает сортировку значений в таблице по возрастанию
     */
    public function sortByAscMobile(): void
    {
        $this->user->clickTo(
            static::BTN_ASC_DESC
            . "[contains(@class, 'is-desc')]"
        );
    }

    /**
     * Выбирает сортировку значений в таблице по убыванию
     */
    public function sortByDescMobile(): void
    {
        $this->user->clickTo(
            static::BTN_ASC_DESC
            . "[not(contains(@class, 'is-desc'))]"
        );
    }
}
