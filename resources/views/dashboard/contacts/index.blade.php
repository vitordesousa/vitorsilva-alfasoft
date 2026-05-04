<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __($header ?? 'Contacts') }}
        </h2>
    </x-slot>

    <div class="py-6">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="flex justify-end">
                <a href="{{route('dashboard.contacts.create')}}"
                   class="text-sm bg-green-600 text-white hover:bg-green-700 transition ease-in-out duration-200 px-3 py-2 rounded-md mb-4 inline-block">{{__('Add New Contact') }}</a>
            </div>

            <div class="my-4 py-3">

                <form method="GET" action="{{ route('dashboard.contacts.index') }}"
                      class=" flex flex-row items-center content-center justify-start">

                    <div class="w-full">
                        <x-input-label for="filter" :value="__('Filter Contacts')"/>

                        <x-text-input id="filter" class="block mt-1 w-full"
                                      type="search"
                                      name="filter"
                                      :placeholder="__('Search by name, email or contact number')"
                                      :value="request('filter')"
                                      required/>

                        <x-input-error :messages="$errors->get('filter')" class="mt-2"/>
                    </div>
                    <div class="flex items-center justify-end mt-6">
                        <x-primary-button class="ms-3">
                            {{ __('Search') }}
                        </x-primary-button>
                        <x-secondary-button class="ms-3" onclick="window.location='{{ route('dashboard.contacts.index') }}'">
                            {{ __('Clear') }}
                        </x-secondary-button>
                    </div>
                </form>
            </div>

            <x-contacts.contacts-table :contacts="$contacts" />
        </div>
    </div>
</x-app-layout>
