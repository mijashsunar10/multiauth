<div>
    {{-- The Master doesn't talk, he acts. --}}
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Users') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Manage all the users') }}</flux:subheading>
        <flux:separator variant="subtle" />
    </div>


               @if (session('success'))
                <div 
                    x-data="{ show: true }" 
                    x-show="show"
                    x-transition
                    class="mb-4 p-4 flex justify-between items-center text-sm text-green-700 bg-green-100 border border-green-400 rounded dark:bg-green-200 dark:text-green-900"
                >
                    <span>{{ session('success') }}</span>
                    <button @click="show = false" class="text-xl font-bold leading-none">&times;</button>
                </div>
            @endif


    <div>
        <div class="overflow-x-auto">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">ID</th>
                    <th scope="col" class="px-6 py-3">Name</th>
                    <th scope="col" class="px-6 py-3">Email</th>
                    <th scope="col" class="px-6 py-3">User Role</th>
                    <th scope="col" class="px-6 py-3">Created At</th>
                      <th scope="col" class="px-6 py-3">Actions</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($users as $user)


                    <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800">
                        <td class="px-6 py-2 font-medium text-gray-900 dark:text-white">{{$user->id}}</td>
                        <td class="px-6 py-2 text-gray-600 dark:text-gray-300">{{$user->name}}</td>
                        <td class="px-6 py-2 text-gray-600 dark:text-gray-300">{{$user->email}}</td>
                        
                        <td class="px-6 py-2 text-gray-600 dark:text-gray-300">{{$user->role}}</td>

                         <td class="px-6 py-2 text-gray-600 dark:text-gray-300">{{$user->created_at}}</td>
            
                        <td class="px-6 py-2 flex items-center gap-2">
                            <button class="px-3 py-2 text-xs font-medium text-white bg-blue-600 rounded hover:bg-blue-700">
                                Edit
                            </button>
                            <button class="px-3 py-2 text-xs font-medium text-white bg-red-600 rounded hover:bg-red-700">
                                Delete
                            </button>

                            @if($user->isSuspended())
                            <button wire:click="suspend({{ $user->id}})" class="flex items-center px-3 py-2 text-xs font-medium text-white bg-green-600 rounded hover:bg-green-700">
                               <flux:icon.check class="w-4 h-4" /> UnSuspend
                            </button>
                          
                            @else
                             <button wire:click="suspend({{ $user->id}})" class="flex items-center px-3 py-2 text-xs font-medium text-white bg-red-600 rounded hover:bg-red-700">
                               <flux:icon.x-circle class="w-4 h-4" />  Suspend
                            </button>

                              @endif
                        </td>
                    </tr>

                @endforeach
            </tbody>
        </table>
    </div>


    </div>

</div>
