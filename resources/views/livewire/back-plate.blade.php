<div>
    <form>
        <div class="grid grid-cols-1   lg:grid-cols-5   filament-forms-component-container gap-6">  
            <div class="1/5">
                <div class="filament-forms-field-wrapper">
                    <div wire:key="bar1" class="space-y-2">
                        <div class="flex items-center justify-between space-x-2 rtl:space-x-reverse">
                            <label class="filament-forms-field-wrapper-label inline-flex items-center space-x-3 rtl:space-x-reverse" for="data.datamatrix">
                                <span class="text-sm font-medium leading-4 text-gray-700 dark:text-gray-300">
                                    QR code
                                </span>
                            </label>
                        </div>
                        <div class="filament-forms-text-input-component flex items-center space-x-2 rtl:space-x-reverse group">
                            <div class="flex-1">
                                <input wire:key="datamatrix" wire:model.defer="datamatrix" type="text"  wire:keydown.enter="searchDatamatrix" id="datamatrix" class="block w-full transition duration-75 rounded-lg shadow-sm focus:border-primary-600 focus:ring-1 focus:ring-inset focus:ring-primary-600 disabled:opacity-70 dark:bg-gray-700 dark:text-white dark:focus:border-primary-600 border-gray-300 dark:border-gray-600">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="1/5">
                <div class="filament-forms-field-wrapper">
                    <div wire:key="bar1" class="space-y-2">
                        <div class="flex items-center justify-between space-x-2 rtl:space-x-reverse">
                            <label class="filament-forms-field-wrapper-label inline-flex items-center space-x-3 rtl:space-x-reverse" for="data.datamatrix">
                                <span class="text-sm font-medium leading-4 text-gray-700 dark:text-gray-300">
                                    Zip
                                </span>
                            </label>
                        </div>
                        <div class="filament-forms-text-input-component flex items-center space-x-2 rtl:space-x-reverse group">
                            <div class="flex-1">
                                <input wire:key="datamatrix" wire:model.defer="datamatrix" type="text"  wire:keydown.enter="searchDatamatrix" id="datamatrix" class="block w-full transition duration-75 rounded-lg shadow-sm focus:border-primary-600 focus:ring-1 focus:ring-inset focus:ring-primary-600 disabled:opacity-70 dark:bg-gray-700 dark:text-white dark:focus:border-primary-600 border-gray-300 dark:border-gray-600">
                            </div>
                        </div>
                    </div>
                    <div wire:key="bar1" class="space-y-2">
                        <div class="flex items-center justify-between space-x-2 rtl:space-x-reverse">
                            <label class="filament-forms-field-wrapper-label inline-flex items-center space-x-3 rtl:space-x-reverse" for="data.datamatrix">
                                <span class="text-sm font-medium leading-4 text-gray-700 dark:text-gray-300">
                                    COD
                                </span>
                            </label>
                        </div>
                        <div class="filament-forms-text-input-component flex items-center space-x-2 rtl:space-x-reverse group">
                            <div class="flex-1">
                                <input wire:key="datamatrix" wire:model.defer="datamatrix" type="text"  wire:keydown.enter="searchDatamatrix" id="datamatrix" class="block w-full transition duration-75 rounded-lg shadow-sm focus:border-primary-600 focus:ring-1 focus:ring-inset focus:ring-primary-600 disabled:opacity-70 dark:bg-gray-700 dark:text-white dark:focus:border-primary-600 border-gray-300 dark:border-gray-600">
                            </div>
                        </div>
                    </div>                    
                </div>
            </div>
            <div class="1/5">
                <div class="filament-forms-field-wrapper">
                    <div wire:key="bar2" class="space-y-2">
                        <div class="flex items-center justify-between space-x-2 rtl:space-x-reverse">
                            <label class="filament-forms-field-wrapper-label inline-flex items-center space-x-3 rtl:space-x-reverse" for="data.cod">
                                <span class="text-sm font-medium leading-4 text-gray-700 dark:text-gray-300">
                                Reason
                                </span>
                            </label>
                        </div>
                        <div class="filament-forms-text-input-component flex items-center space-x-2 rtl:space-x-reverse group">
                            <div class="flex-1">
                                <input kire:key="cod" wire:model.defer="cod" type="text" wire:keydown.enter="searchCod" id="cod" class="block w-full transition duration-75 rounded-lg shadow-sm focus:border-primary-600 focus:ring-1 focus:ring-inset focus:ring-primary-600 disabled:opacity-70 dark:bg-gray-700 dark:text-white dark:focus:border-primary-600 border-gray-300 dark:border-gray-600">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="1/5">
                <div class="filament-forms-field-wrapper">
                    <div wire:key="bar2" class="space-y-2">
                        <div class="flex items-center justify-between space-x-2 rtl:space-x-reverse">
                            <label class="filament-forms-field-wrapper-label inline-flex items-center space-x-3 rtl:space-x-reverse" for="data.cod">
                                <span class="text-sm font-medium leading-4 text-gray-700 dark:text-gray-300">
                                is damaged ?
                                </span>
                            </label>
                        </div>
                        <div class="filament-forms-text-input-component flex items-center space-x-2 rtl:space-x-reverse group">
                            <div class="flex-1">
                                <input kire:key="cod" wire:model.defer="cod" type="checkbox"  id="cod" class="transition duration-75 rounded-lg shadow-sm focus:border-primary-600 focus:ring-1 focus:ring-inset focus:ring-primary-600 disabled:opacity-70 dark:bg-gray-700 dark:text-white dark:focus:border-primary-600 border-gray-300 dark:border-gray-600">
                            </div>
                        </div>
                    </div>
                </div>
            </div>   
            <div class="1/5">
                <button type="button" wire:click="searchCod" class="filament-button filament-button-size-md inline-flex items-center justify-center py-1 gap-1 font-medium rounded-lg border transition-colors focus:outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset dark:focus:ring-offset-0 min-h-[2.25rem] px-4 text-sm text-white shadow focus:ring-white border-transparent bg-success-600 hover:bg-success-500 focus:bg-success-700 focus:ring-offset-success-700 filament-page-button-action">Insert</button>
            </div> 
        </div>
    </form>
    <br>
    {{ $this->table }}
</div>

@push('scripts')
<script>
    window.addEventListener('livewire:load', () => {
        @this.on('focusDatamatrix', () => {
            document.getElementById('datamatrix').focus()
        })
        @this.on('focusCod', () => {
            document.getElementById('cod').focus()
        })
    })
</script>
@endpush
