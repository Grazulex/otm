<x-filament::page>

<form wire:submit.prevent="submit">
    <input type="file" wire:model="file">

    @error('file')
    <div class="error text-danger">* {{ $message }}</div>
    @enderror

    <button type="submit" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
        Submit
    </button>
</form>

</x-filament::page>
