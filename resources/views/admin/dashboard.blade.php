<x-layouts.app :title="__('Admin_Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
     <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Dashboard') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Manage modules') }}</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

       
    @if(session('success'))
        <div style="color: green;">{{ session('success') }}</div>
    @endif

    {{-- Flux is a UI component library designed specifically for Laravel Livewire applications. It offers a collection of pre-built, customizable components that streamline the development of interactive user interfaces --}}

        <p>Hello, World</p>
        <a href="{{route('admin.register')}}">Register</a>
    </div>
</x-layouts.app>
