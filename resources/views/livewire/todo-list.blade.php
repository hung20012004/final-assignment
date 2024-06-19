<div>
    <input type="text" wire:model="newTask" placeholder="Add a new task">
    <button wire:click="addTask">Add Task</button>

    <ul>
        @foreach($tasks as $index => $task)
            <li>
                {{ $task }}
                <button wire:click="removeTask({{ $index }})">Remove</button>
            </li>
        @endforeach
    </ul>

</div>
