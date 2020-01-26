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
    public const ADD_WITH_NAME_AND_PRIORITY = 'addNamePriority';
    public const ADD_WITH_SAME_NAME_NO_PRIORITY = 'addSameName';

    protected $file = 'todo.json';

    /** Номер */
    public $id;
    /** Название */
    public $name;
    /** Приоритет */
    public $priority;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return Todo
     */
    public function setId(int $id): Todo
    {
        $this->id = $id;
        return $this;
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
     * @return mixed
     */
    public function getPriority()
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
}