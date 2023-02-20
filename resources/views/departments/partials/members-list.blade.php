<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Members') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('View members in your department') }}
        </p>
    </header>

    <div class="container flex mx-auto w-full items-center justify-center">
        <ul class="flex flex-col w-full p-4">
            @foreach ($data->members as $group)
                <li class="border-gray-400 flex flex-row mb-2">
                    <div
                        class="select-none cursor-pointer bg-gray-200 rounded-md flex flex-1 items-center p-4  transition duration-500 ease-in-out transform hover:-translate-y-1 hover:shadow-lg">
                        <img class="flex flex-col rounded-md w-10 h-10 bg-gray-300 justify-center items-center mr-4"
                            src="https://ui-avatars.com/api/?name={{ htmlentities($group->name) }}&background=random" />
                        <div class="flex-1 pl-1 mr-16">
                            <div class="font-medium">{{ $group->name }}</div>
                            <div class="text-gray-600 text-sm">{{ $group->pivot->is_leader ? "Leader" : "Member" }}</div>
                        </div>
                        @if (auth()->user()->can('manage-departments') || $data->is_logged_in_user_group_leader)
                            @if(($group->pivot->is_leader && auth()->user()->can('manage-departments')) || $group->pivot->is_leader == false)
                            <form method="POST" action="{{ route('tenant.departments.removeFromGroup', [$data->id, $group->id]) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900"><i
                                        class="fa fa-trash fa-1x" style="font-size: 1.25rem !important;"></i></button>
                            </form>
                            @endif
                        @endif
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</section>
