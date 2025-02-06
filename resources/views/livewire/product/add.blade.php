<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use App\Models\Product;
use Illuminate\Validation\Rule;

new #[Layout('layouts.app')] 
class extends Component {
    public string $name = '';
    public string $description = '';
    public $price = 0.00;

    public function addProduct() {
        $this->authorize('create', Product::class);
        $validated = $this->validate([
            'name' => ['string', 'required', 'min:2', 'max:255'],
            'description' => ['string', 'nullable', 'min:2', 'max:255'],
            'price' => ['decimal:0,2', 'required'],
        ]);

        Product::create([...$validated, 'user_id' => auth()->user()->id]);
        return $this->redirect(route('products.index'), navigate: true);
    }

}; ?>

<x-slot name="header">
    <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
        {{ __('Products') }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class="max-w-screen-sm">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('Add a product') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {{ __("Fill out the form and hit save.") }}
                            </p>
                        </header>

                        <form wire:submit="addProduct" class="mt-6 space-y-6">
                            <div>
                                <x-input-label for="name" :value="__('Name')" />
                                <x-text-input wire:model="name" id="name" name="name" type="text"
                                    class="block w-full mt-1" required autofocus />
                                <x-input-error class="mt-2" :messages="$errors->get('name')" />
                            </div>

                            <div>
                                <x-input-label for="description" :value="__('Description')" />
                                <textarea wire:model="description" id="description" name="description" required
                                    id="message" rows="4"
                                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Write product description here..."></textarea>
                                <x-input-error class="mt-2" :messages="$errors->get('description')" />

                            </div>
                            <div>
                                <x-input-label for="price" :value="__('Price')" />
                                <x-text-input wire:model="price" id="price" name="price" type="number" step="0.01"
                                    class="block w-full mt-1" required />
                                <x-input-error class="mt-2" :messages="$errors->get('price')" />

                            </div>

                            <div class="flex items-center gap-4">
                                <x-primary-button>{{ __('Save') }}</x-primary-button>

                                <x-action-message class="me-3" on="user-profile-updated">
                                    {{ __('Saved.') }}
                                </x-action-message>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>