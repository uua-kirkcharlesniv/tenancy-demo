<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Manage & Invite members') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Invite members to be a part of your group, or to lead') }}
        </p>
    </header>

    <form method="POST" action="{{ route('tenant.groups.update', $data->id) }}" class="mt-6 space-y-6">
        @csrf
        @method('POST')

        <div class="grid grid-cols-2 gap-8">
            <div>
                <!-- Name -->
                <div class="mt-4">
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $data->name)"
                        required autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>
                <br>

                <div class="flex items-center gap-4">
                    <x-primary-button>{{ __('Update') }}</x-primary-button>

                    @if (session('status') === 'group-updated')
                        <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                            class="text-sm text-gray-600">{{ __('Saved') }}</p>
                    @endif
                </div>
            </div>
            <div>
                <livewire:employee-selector 
                :group_id="$data->id" />
            </div>
        </div>
    </form>



</section>
