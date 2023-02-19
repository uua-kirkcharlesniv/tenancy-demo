<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Company Employees') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Delete, or promote employees to your company') }}
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
                @foreach (App\Models\User::role('employee')->get() as $manager)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $manager->name }}
                        </th>
                        <td class="px-6 py-4">
                            {{ $manager->email }}
                        </td>
                        <td class="px-6 py-4">
                            <form method="POST" action="{{ route('tenant.employees.delete', $manager->id) }}">
                                @csrf
                                @method('delete')
                                <x-primary-button>{{ __('Delete') }}</x-primary-button>
                            </form>
                            @can('manage-company')
                            <br>
                            <form method="POST" action="{{ route('tenant.employees.promote', $manager->id) }}">
                                @csrf
                                @method('patch')
                                <x-primary-button class="bg-green-500">{{ __('Promote') }}</x-primary-button>
                            </form>
                            @endcan
                        </td>
                    </tr>             
                @endforeach
            </tbody>
        </table>
    </div>
</section>
