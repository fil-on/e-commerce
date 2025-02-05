<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use App\Models\CartItem;
use Livewire\WithPagination;

new #[Layout('layouts.app')] 
class extends Component {
    use WithPagination;
    public function with(): array {
        $cartItems = CartItem::where(['user_id' => auth()->id()])->get();
        return [
            'cartItems' => $cartItems,
            'grandTotal' => $cartItems->sum(fn ($item) => $item->quantity * $item->product->price),
        ];
    }

    public function removeProduct($id) {
        CartItem::find($id)->delete();
    }
}; ?>

<x-slot name="header">
    <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
        {{ __('Cart') }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class="relative mb-10 overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 rtl:text-right dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Product
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Price
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Quantity
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Total
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cartItems as $cartItem)
                            <tr wire:key="{{ $cartItem->id }}"
                                class="bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                                <td scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    <p class="font-bold">{{ $cartItem->product->name }}</p>
                                    <p class="font-bold text-gray-400">{{ $cartItem->product->description }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    ${{ number_format($cartItem->product->price, 2) }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $cartItem->quantity }}
                                </td>
                                <td class="px-6 py-4">
                                    ${{ number_format($cartItem->quantity * $cartItem->product->price, 2) }}
                                </td>
                                <td class="px-6 py-4">
                                    <button type="button" wire:click="removeProduct({{ $cartItem->id }})"
                                        wire:confirm="Are you sure you want to remove this product from your cart?"
                                        class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">
                                        Remove
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                            <tr class="bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                                <td scope="row" colspan="3"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    GRAND TOTAL
                                </td>
                                <td class="px-6 py-4 text-lg font-bold">
                                    ${{ number_format($grandTotal, 2) }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="flex items-center justify-end w-full">
                    <button type="button"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
                        wire:loading.attr="disabled">CHECKOUT</button>
                </div>
            </div>
        </div>
    </div>
</div>