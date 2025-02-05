<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use App\Models\Product;
use Livewire\WithPagination;

new #[Layout('layouts.app')] 
class extends Component {
    use WithPagination;
    public function with(): array {
        return [
            'products' => Product::paginate(9),
        ];
    }

    public function deleteProduct($id) {
        Product::find($id)->delete();
    }
}; ?>

<x-slot name="header">
    <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
        {{ __('Products') }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="flex items-center justify-end pt-10">
            <a href="#" wire:navigate
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                Add a product
            </a>
        </div>
        <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                    @foreach ($products as $product)
                    <div wire:key="{{ $product->id }}"
                        class="max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
                        <a href="#">
                            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{
                                $product->name }}</h5>
                        </a>
                        <p class="mb-3 font-normal text-gray-700 dark:text-gray-400"><span
                                class="font-bold">Description:</span> {{
                            $product->description }}</p>
                        <p class="mb-3 font-normal text-gray-700 dark:text-gray-400"><span class="font-bold">Last
                                Updated At:</span> {{
                            $product->updated_at }}</p>
                        <p class="mb-3 font-normal text-gray-700 dark:text-gray-400"><span
                                class="font-bold">Price:</span> ${{
                            $product->price}}</p>
                        <div class="flex items-center justify-end w-full">
                            <a href="#" wire:navigate
                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                                Edit
                            </a>
                            <button type="button" wire:click="deleteProduct({{ $product->id }})"
                                wire:confirm="Are you sure you want to delete this product?"
                                class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Delete</button>
                        </div>
                    </div>
                    @endforeach
                </div>
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>