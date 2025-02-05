<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use App\Models\Product;
use App\Models\CartItem;
use Livewire\WithPagination;

new #[Layout('layouts.app')] 
class extends Component {
    use WithPagination;
    public function with(): array {
        return [
            'products' => Product::paginate(9),
        ];
    }

    public function addToCart($id) {
        $product = Product::find($id);
        if (!$product) abort(404);
        $cartItem = CartItem::where([
            'user_id' => auth()->user()->id,
            'product_id' => $id,
        ]);
        if ($cartItem->exists()) {
            $cartItem->increment('quantity');
        } else {
            CartItem::create([
                'user_id' => auth()->user()->id,
                'product_id' => $id,
            ]);
        }

        $this->dispatch('cart-updated');
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
                <x-action-message class="mb-5 me-3" on="cart-updated">
                    {{ __('Cart Updated.') }}
                </x-action-message>
                <div class="grid gap-4 mb-10 md:grid-cols-2 lg:grid-cols-3">
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
                            <button type="button" wire:click="addToCart({{ $product->id }})"
                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
                                wire:loading.attr="disabled">Add
                                to cart</button>

                        </div>
                    </div>
                    @endforeach
                </div>
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>