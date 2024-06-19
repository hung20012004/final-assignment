<?php

namespace App\Livewire;

use Livewire\Component;

class TodoList extends Component
{
    public $tasks = [];
    public $newTask = '';

    public function addTask()
    {
        if (!empty($this->newTask)) {
            $this->tasks[] = $this->newTask;
            $this->newTask = '';
        }
    }



    public function removeTask($index)
    {
        unset($this->tasks[$index]);
        $this->tasks = array_values($this->tasks);
    }

    public function render()
    {
        return view('livewire.todo-list');
    }
}
