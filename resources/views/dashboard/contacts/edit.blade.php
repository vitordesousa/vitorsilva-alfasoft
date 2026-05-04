<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __($header ?? 'Create Contact') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="block mt-4 rounded-md shadow-2xl shadow-blue-900 p-6">
                <form method="POST" action="{{ route('dashboard.contacts.update', $contact) }}">
                    @method('PUT')
                    @csrf

                    <!-- Name -->
                    <div>
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $contact->name)"  required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Email Address -->
                    <div class="mt-4">
                        <x-input-label for="email_address" :value="__('Email Address')" />
                        <x-text-input id="email_address" class="block mt-1 w-full" type="email" name="email_address" :value="old('email_address', $contact->email_address)" required autocomplete="email_address" />
                        <x-input-error :messages="$errors->get('email_address')" class="mt-2" />
                    </div>

                    <!-- Contact -->
                    <div class="mt-4">
                        <x-input-label for="contact" :value="__('Contact (Phone Number)')" />
                        <x-text-input id="contact" class="block mt-1 w-full" type="tel" name="contact" maxlength="9" :value="old('contact', $contact->contact)" required autocomplete="phone" />
                        <x-input-error :messages="$errors->get('contact')" class="mt-2" />
                    </div>


                    <div class="flex items-center justify-end mt-4">
                        <x-primary-button class="ms-4">
                            {{ __('Update') }}
                        </x-primary-button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
