<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $data->name }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                @include('departments.partials.members-list')
            </div>
        </div>
    </div>
    
    @if (auth()->user()->can('manage-departments') || $data->is_logged_in_user_group_leader)
        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    @include('departments.partials.manage-group')
                </div>
            </div>
        </div>
    @endif


</x-app-layout>
