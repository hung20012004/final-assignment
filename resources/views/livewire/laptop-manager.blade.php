<div>
        <input type="text" wire:model="newLaptop" placeholder="Add new laptop">
        <button wire:click="addLaptop" >Add</button>
        <ul>
            @foreach($laptops as $index=> $laptop)
                <li>
                    {{ $laptop }}
                    <button wire:click="removeLaptop({{ $index }})">Remove</button>
                </li>
            @endforeach
        </ul>
        <button wire:click="save" >Save</button>
</div>
