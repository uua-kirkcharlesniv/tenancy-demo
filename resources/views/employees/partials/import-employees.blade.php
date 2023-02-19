<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Import employees') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Batch import employees from CSV/XLSX format') }}
        </p>
    </header>

    <form method="post" action="{{ route('tenant.company.addManager') }}" class="mt-6 space-y-6">
        @csrf
        @method('post')


        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Import') }}</x-primary-button>

            @if (session('status') === 'manager-addded')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600">{{ __('Saved') }}</p>
            @endif
        </div>
    </form>
</section>
