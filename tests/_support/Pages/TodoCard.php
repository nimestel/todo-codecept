<?php
/**
 * Created by PhpStorm.
 * User: t.chervyakova
 * Date: 26.01.2020
 * Time: 14:34
 */

namespace Pages;

use Models\Todo;

/**
 * Карточка заполнения
 *
 * Class TodoCard
 * @package Pages
 */
class TodoCard extends MainPage
{
    public const CARD = "//*[@class='modal-card']";
    public const FLD_TITLE = self::CARD . "//*[contains(@class, 'is-clearfix')]//input";
    public const FLD_PRIORITY = self::CARD . "//label[.='Priority']/following-sibling::div//select";
    public const BTN_CLOSE = self::CARD . "//button[contains(text(),'Close')]";
    public const BTN_SAVE = self::CARD . "//button[contains(@class,'is-primary')]";
    public const BTN_CLOSE_LARGE = 'button.modal-close.is-large';

    /**
     * Добавить todo
     * @param Todo $model
     */
    public function add(Todo $model): void
    {
        $I = $this->user;
        $MainPage = new MainPage($I);
        $MainPage->openAddTodoWindow();
        $this->fillFields($model);
        $this->save();
    }

    /**
     * Добавить несколько todo
     * @param array $models
     */
    public function addAFew(array $models): void
    {
        foreach ($models as $model) {
            $I = $this->user;
            $MainPage = new MainPage($I);
            $MainPage->openAddTodoWindow();
            $this->fillFields($model);
            $this->save();
        }
    }

    /**
     * Изменить todo
     * @param Todo $modelBefore
     * @param Todo $modelAfter
     */
    public function edit(Todo $modelBefore, Todo $modelAfter): void
    {
        $I = $this->user;
        $Table = new TablePage($I);
        $Table->openEditTodoWindow($modelBefore);
        $this->fillFields($modelAfter);
        $this->save();
    }

    /**
     * Нажать на кнопку сохранения
     */
    public function save(): void
    {
        $I = $this->user;
        $I->click(static::BTN_SAVE);
        $I->waitForElementNotVisible(static::CARD);
    }

    /**
     * Нажать на кнопку отмены
     */
    public function close(): void
    {
        $I = $this->user;
        $I->click(static::BTN_CLOSE);
        $I->waitForElementNotVisible(static::CARD);
    }

    /**
     * Заполнить поля карточки todo
     * @param Todo $model
     */
    public function fillFields(Todo $model): void
    {
        $I = $this->user;

        foreach ($model as $field => $value) {
            if ($value === null) {
                continue;
            }
            switch ($field) {
                case "name":
                    $I->typeText(static::FLD_TITLE, $value);
                    break;
                case "priority":
                    $I->selectOption(static::FLD_PRIORITY, $value);
            }
        }
    }
}