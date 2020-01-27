<?php

namespace Models;

/**
 * Модель сущности todo
 *
 * Class Todo
 * @package Model
 */
class Todo extends BaseModel
{
    /** Данные для добавления */
    public const ADD_WITH_NAME_AND_PRIORITY = 'addNamePriority';
    public const ADD_WITH_SAME_NAME_NO_PRIORITY = 'addSameName';
    public const ADD_FOR_EDIT = 'prepareEdit';
    /** Данные для изменения */
    public const EDIT_NAME_AND_PRIORITY = 'editNameAndPriority';
    public const EDIT_PRIORITY = 'editPriority';
    public const EDIT_NAME = 'editNameInFullTodo';

    protected $file = 'todo.json';

    /** Основные поля */
    /** Название */
    public $name;
    /** Приоритет */
    public $priority;

    public function __construct($jsonBlock = null)
    {
        if (!$jsonBlock){
            $this->setRandomName();
        }

        parent::__construct($jsonBlock);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Todo
     */
    public function setName(string $name): Todo
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getPriority(): string
    {
        return $this->priority;
    }

    /**
     * @param string $priority
     * @return Todo
     */
    public function setPriority(string $priority): Todo
    {
        $this->priority = $priority;
        return $this;
    }

    public function setRandomName(int $length = 10): void
    {
        $this->name = $this->generateRandomString($length);
    }
}