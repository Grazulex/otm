<div>
    <div class="grid grid-cols-1   lg:grid-cols-3   filament-forms-component-container gap-6">

        <div wire:key="K7Y2HUQwVADxJ5GkdehJ.data.type.Filament\Forms\Components\Radio" class="1/3">
            <div class="filament-forms-field-wrapper">
                <div class="space-y-2">
                    <div class="flex items-center justify-between space-x-2 rtl:space-x-reverse">
                        <label class="filament-forms-field-wrapper-label inline-flex items-center space-x-3 rtl:space-x-reverse" for="data.type">
                            <span class="text-sm font-medium leading-4 text-gray-700 dark:text-gray-300">
                                Type
                            </span>
                            <div class="grid-cols-1      filament-forms-radio-component flex flex-wrap gap-3">
                                <div class="flex items-start gap-2">
                                    <div class="flex items-center h-5">
                                        <input x-data="{}" wire:model="type" name="type" id="type-cod" type="radio" value="cod" wire:model.defer="type" class="focus:ring-primary-500 h-4 w-4 text-primary-600 disabled:opacity-70 dark:bg-gray-700 dark:checked:bg-primary-500 border-gray-300 dark:border-gray-500">
                                    </div>
                                    <div class="text-sm">
                                        <label for="data.type-cod" class="font-medium text-gray-700 dark:text-gray-200">
                                            COD
                                        </label>
                                    </div>
                                </div>
                                <div class="flex items-start gap-2">
                                    <div class="flex items-center h-5">
                                        <input x-data="{}" wire:model="type" name="type" id="type-non-cod" type="radio" value="non-cod" wire:model.defer="type" class="focus:ring-primary-500 h-4 w-4 text-primary-600 disabled:opacity-70 dark:bg-gray-700 dark:checked:bg-primary-500 border-gray-300 dark:border-gray-500">
                                    </div>
                                    <div class="text-sm">
                                        <label for="data.type-non-cod" class="font-medium text-gray-700 dark:text-gray-200">
                                            NON COD
                                        </label>
                                    </div>
                                </div>
                                <div class="flex items-start gap-2">
                                    <div class="flex items-center h-5">
                                        <input x-data="{}" wire:model="type" name="type" id="type-rush" type="radio" value="rush" wire:model.defer="type" class="focus:ring-primary-500 h-4 w-4 text-primary-600 disabled:opacity-70 dark:bg-gray-700 dark:checked:bg-primary-500 border-gray-300 dark:border-gray-500">
                                    </div>
                                    <div class="text-sm">
                                        <label for="data.type-rush" class="font-medium text-gray-700 dark:text-gray-200">
                                            RUSH
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div wire:key="Bqhkl4dbPyTTVNrh6o82.data.datamatrix.Filament\Forms\Components\TextInput" class="1/3">
            <div class="filament-forms-field-wrapper">
                <div class="space-y-2">
                    <div class="flex items-center justify-between space-x-2 rtl:space-x-reverse">
                        <label class="filament-forms-field-wrapper-label inline-flex items-center space-x-3 rtl:space-x-reverse" for="data.datamatrix">
                            <span class="text-sm font-medium leading-4 text-gray-700 dark:text-gray-300">
                                Datamatrix (square)
                            </span>
                        </label>
                    </div>
                    <div class="filament-forms-text-input-component flex items-center space-x-2 rtl:space-x-reverse group">
                        <div class="flex-1">
                            <input x-data="{}" wire:model="datamatrix" type="text"  wire:keydown.enter="searchDatamatrix" id="datamatrix" class="block w-full transition duration-75 rounded-lg shadow-sm focus:border-primary-600 focus:ring-1 focus:ring-inset focus:ring-primary-600 disabled:opacity-70 dark:bg-gray-700 dark:text-white dark:focus:border-primary-600 border-gray-300 dark:border-gray-600">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div wire:key="Bqhkl4dbPyTTVNrh6o82.data.cod.Filament\Forms\Components\TextInput" class="1/3">
            <div class="filament-forms-field-wrapper">
                <div class="space-y-2">
                    <div class="flex items-center justify-between space-x-2 rtl:space-x-reverse">
                        <label class="filament-forms-field-wrapper-label inline-flex items-center space-x-3 rtl:space-x-reverse" for="data.cod">
                            <span class="text-sm font-medium leading-4 text-gray-700 dark:text-gray-300">
                            COD barcode (up)
                            </span>
                        </label>
                    </div>
                    <div class="filament-forms-text-input-component flex items-center space-x-2 rtl:space-x-reverse group">
                        <div class="flex-1">
                            <input @if($cod_is_disable) disabled @endif x-data="{}" wire:model="cod" type="text" wire:keydown.enter="searchCod" id="cod" class="block w-full transition duration-75 rounded-lg shadow-sm focus:border-primary-600 focus:ring-1 focus:ring-inset focus:ring-primary-600 disabled:opacity-70 dark:bg-gray-700 dark:text-white dark:focus:border-primary-600 border-gray-300 dark:border-gray-600">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    {{ $this->table }}
</div>
