<div class="block mt-4 bg-white rounded-md shadow-2xl shadow-blue-900 p-6">
    <table class="table-auto table-responsive table-bordered table-striped w-full">
        <thead>
        <tr>
            <th class="border-t-0 border-b-slate-300 border-l-0 border-r-slate-300 border-r px-4 py-2 text-left"> {{__('Contact Name') }} </th>
            <th class="border-t-0 border-b-slate-300 border-l-0 border-r-slate-300 border-r px-4 py-2 text-left"> {{__('Contact Email') }} </th>
            <th class="border-t-0 border-b-slate-300 border-l-0 border-r-slate-300 border-r px-4 py-2 text-left"> {{__('Contact Number') }} </th>
            <th class="border-t-0 border-b-slate-300 border-l-0 border-r-slate-300 px-4 py-2 text-left {{ auth()->user() ? " border-r" : ""  }}"> {{__('Created At') }} </th>
            @auth
                <th class="border-t-0 border-b-slate-300 border-r-0 border-l-slate-300 px-4 py-2 text-right w-full md:w-60">
                    #
                </th>
            @endauth
        </tr>
        </thead>
        <tbody>
        @forelse($contacts as $contact)
            <tr>
                <td class="border border-slate-300 px-4 py-2">{{  $contact->name}}</td>
                <td class="border border-slate-300 px-4 py-2">{{  $contact->email_address}}</td>
                <td class="border border-slate-300 px-4 py-2">{{  $contact->formatted_contact }}</td>
                <td class="border border-slate-300 px-4 py-2">{{  $contact->created_at->format("Y-m-d H:i:s") }}</td>
                @auth
                    <td class="border border-slate-300 text-right w-60">
                        <a href="{{route('dashboard.contacts.show', $contact)}}"
                           class="text-sm bg-blue-600 text-white hover:bg-blue-700 transition ease-in-out duration-200 px-3 py-2 rounded-md mr-2">{{__('View') }}</a>
                        <a href="{{route('dashboard.contacts.edit', $contact)}}"
                           class="text-sm bg-amber-500 text-gray-800 hover:bg-amber-600 transition ease-in-out duration-200 px-3 py-2 rounded-md ">{{__('Edit') }}</a>

                        <x-danger-button
                            x-data=""
                            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion-{{$contact->id}}')"
                        >{{ __('Delete') }}</x-danger-button>

                        <x-modal name="confirm-user-deletion-{{$contact->id}}"
                                 :show="$errors->contactDeletion->isNotEmpty()" focusable>
                            <form method="post" action="{{ route('dashboard.contacts.destroy', $contact) }}"
                                  class="p-6">
                                @csrf
                                @method('delete')

                                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                    {{ __('Are you sure you want to delete this contact?') }}
                                </h2>

                                <div class="mt-6 flex justify-end">
                                    <x-secondary-button x-on:click="$dispatch('close')">
                                        {{ __('Cancel') }}
                                    </x-secondary-button>

                                    <x-danger-button class="ms-3">
                                        {{ __('Delete Contact') }}
                                    </x-danger-button>
                                </div>
                            </form>
                        </x-modal>
                    </td>
                @endauth
            </tr>
        @empty

            <tr>
                <td colspan="{{ auth()->user() ? 5 : 3 }}"
                    class="border border-slate-300 px-4 py-2 text-center">
                    {{ __('No contacts found.') }}
                </td>
            </tr>

        @endforelse

        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $contacts->links(null, request()->only(['per_page', 'filter', 'page'])) }}
</div>
