<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use App\Models\User;
use Illuminate\Validation\Rule;

new #[Layout('layouts.app')] 
class extends Component {
    public $user;
    public string $name = '';
    public string $email = '';
    public $is_admin;

    public function mount(User $user) {
        $this->user = $user;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->is_admin = (int) $user->is_admin;
    }

    public function updateProfileInformation(): void
    {
        $user = $this->user;

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
            'is_admin' => ['required', 'int', 'in:0,1']
        ]);

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $this->redirect(route('users.index'), navigate:true);
    }
}; ?>

<x-slot name="header">
    <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
        {{ __('Users') }}
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
                                {{ __('Profile Information') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {{ __("Update their account's profile information and email address.") }}
                            </p>
                        </header>

                        <form wire:submit="updateProfileInformation" class="mt-6 space-y-6">
                            <div>
                                <x-input-label for="name" :value="__('Name')" />
                                <x-text-input wire:model="name" id="name" name="name" type="text"
                                    class="block w-full mt-1" required autofocus autocomplete="name" />
                                <x-input-error class="mt-2" :messages="$errors->get('name')" />
                            </div>

                            <div>
                                <x-input-label for="email" :value="__('Email')" />
                                <x-text-input wire:model="email" id="email" name="email" type="email"
                                    class="block w-full mt-1" required autocomplete="username" />
                                <x-input-error class="mt-2" :messages="$errors->get('email')" />

                            </div>
                            <div>
                                <x-input-label for="email" :value="__('Role')" />
                                <select id="countries" wire:model="is_admin"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="0">User</option>
                                    <option value="1">Admin</option>
                                </select>

                                <x-input-error class="mt-2" :messages="$errors->get('is_admin')" />

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