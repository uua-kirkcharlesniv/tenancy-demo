<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Company Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your company's profile information") }}
        </p>
    </header>

    <form method="post" action="{{ route('tenant.company.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="company" :value="__('Company')" />
            <x-text-input id="company" name="company" type="text" class="mt-1 block w-full" :value="old('company', tenant()->company)" required autofocus autocomplete="company" />
            <x-input-error class="mt-2" :messages="$errors->get('company')" />
        </div>

        {{-- <div>
            <x-input-label for="domain" :value="__('Domain')" />

            <div class="flex items-baseline">
                <div class="flex flex-col grow">
                    <div class="">
                        <x-text-input id="domain" class="block mt-1 w-full" type="text" name="domain" :value="old('domain', explode('.', tenant()->domain)[0])" required />
                    </div>
                    <div>
                        <x-input-error :messages="$errors->get('domain')" class="mt-2" />

                    </div>
                </div>

                <div class="ml-3">
                    {{ config('tenancy.central_domains')[0] }}
                </div>
            </div>
        </div> --}}

        <div>
            <x-input-label for="logo" :value="__('Logo')" />
            <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" id="logo" type="file" name="logo">
            <x-input-error class="mt-2" :messages="$errors->get('logo')" />
            <p class="mt-1 text-sm text-gray-500" id="file_input_help">PNG, JPG, JPEG only. Max file size of 5MB.</p>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
