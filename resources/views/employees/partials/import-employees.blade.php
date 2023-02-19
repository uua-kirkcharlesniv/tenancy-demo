<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Import employees') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Batch import employees from CSV/XLSX format') }}
        </p>
    </header>
    <br>
    <a href="#">
        <x-primary-button class="bg-blue-800">Download sample template</x-primary-button>
    </a>

    <form method="post" action="{{ route('tenant.employees.import') }}" class="mt-6 space-y-6">
        @csrf
        @method('post')

        <div>
            <x-input-label for="file" :value="__('File')" />
            <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" id="file" type="file" name="file">
            <x-input-error class="mt-2" :messages="$errors->get('file')" />
            <p class="mt-1 text-sm text-gray-500" id="file_input_help">XLS, XLSX, and CSV only. Max file size of 10MB.</p>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Import') }}</x-primary-button>

            @if (session('status') === 'manager-addded')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600">{{ __('Saved') }}</p>
            @endif
        </div>
    </form>
</section>
