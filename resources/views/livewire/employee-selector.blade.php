<div>
    <div class="mt-4">
        <x-input-label for="search" :value="__('Search for an employee name')" />
        <x-text-input id="search" class="block mt-1 w-full" type="text" name="search" :value="old('search')"
            wire:model="search" />
    </div>
    <ul class="py-2">
        @foreach ($users as $user)
            <li class="hover:transform mb-2 border rounded bg-white list-none rounded-sm px-3 py-3 cursor-pointer"
                style='border-bottom-width:0'>
                <h1 class="font-medium ">{{ $user->name }}</h1>

                <div class="flex items-center justify-between mt-3">
                    @if ($this->is_admin)
                        <x-primary-button type="button" class="bg-green-800"
                            wire:click="addLeader({{ $user }})">Invite as Group
                            Leader</x-primary-button>
                    @endif
                    <x-primary-button type="button" wire:click="addMember({{ $user }})">Invite as Member
                    </x-primary-button>
                </div>
            </li>
        @endforeach
    </ul>

    <hr>
    @if ($this->is_admin)
        <h1 class="py-6">Invited Group Leaders</h1>
        @foreach ($leaders as $user)
            <li class="hover:transform mb-2 border rounded bg-white list-none rounded-sm px-3 py-3 cursor-pointer"
                style='border-bottom-width:0'>
                <h1 class="font-medium ">{{ $user['name'] }}</h1>
                <input type="text" value="{{ $user['id'] }}" name="leader[{{ $user['id'] }}]"
                    id="leader[{{ $user['id'] }}]" hidden>
                <div class="flex items-center justify-between mt-3">
                    <x-primary-button type="button" wire:click="demoteLeader({{ $loop->index }})">Demote to Member
                    </x-primary-button>
                    <x-primary-button type="button" wire:click="removeLeader({{ $loop->index }})" class="bg-red-500">
                        Remove</x-primary-button>
                </div>
            </li>
            <br>
        @endforeach
    @endif
    <h1 class="py-6">Invited Members</h1>
    @foreach ($members as $user)
        <li class="hover:transform mb-2 border rounded bg-white list-none rounded-sm px-3 py-3 cursor-pointer"
            style='border-bottom-width:0'>
            <h1 class="font-medium ">{{ $user['name'] }}</h1>
            <input type="text" value="{{ $user['id'] }}" name="member[{{ $user['id'] }}]"
                id="member[{{ $user['id'] }}]" hidden>
            <div class="flex items-center justify-between mt-3">
                <x-primary-button type="button" wire:click="promoteLeader({{ $loop->index }})">Promote to Leader
                </x-primary-button>
                <x-primary-button type="button" wire:click="removeMember({{ $loop->index }})" class="bg-red-500">
                    Remove</x-primary-button>
            </div>
        </li>
        <br>
    @endforeach
</div>
