<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Company Managers') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Add, or delete managers to your company') }}
        </p>
    </header>


    <div class="relative overflow-x-auto mt-6">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Name
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Email
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach (App\Models\User::role('manager')->get() as $manager)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $manager->name }}
                        </th>
                        <td class="px-6 py-4">
                            {{ $manager->email }}
                        </td>
                        <td class="px-6 py-4">
                            <form method="POST" action="{{ route('tenant.company.deleteManager', $manager->id) }}">
                                @csrf
                                @method('delete')
                                <x-primary-button class="bg-red-500">{{ __('Delete') }}</x-primary-button>
                            </form>
<br>
                            <form method="POST" action="{{ route('tenant.company.demoteManager', $manager->id) }}">
                                @csrf
                                @method('patch')
                                <x-primary-button>{{ __('Demote') }}</x-primary-button>
                            </form>
                        </td>
                    </tr>             
                @endforeach
            </tbody>
        </table>
    </div>
</section>
