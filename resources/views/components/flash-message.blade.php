@if(session('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100 transform translate-y-0"
         x-transition:leave-end="opacity-0 transform -translate-y-2"
         class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg flex items-center justify-between">
        <div class="flex items-center gap-2">
            <span class="text-lg">✅</span>
            <span>{{ session('success') }}</span>
        </div>
        <button @click="show = false" class="text-green-400 hover:text-green-600">&times;</button>
    </div>
@endif

@if(session('error'))
    <div x-data="{ show: true }" x-show="show"
         class="mb-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg flex items-center justify-between">
        <div class="flex items-center gap-2">
            <span class="text-lg">❌</span>
            <span>{{ session('error') }}</span>
        </div>
        <button @click="show = false" class="text-red-400 hover:text-red-600">&times;</button>
    </div>
@endif

@if(session('warning'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 8000)"
         class="mb-4 p-4 bg-amber-50 border border-amber-200 text-amber-700 rounded-lg flex items-center justify-between">
        <div class="flex items-center gap-2">
            <span class="text-lg">⚠️</span>
            <span>{{ session('warning') }}</span>
        </div>
        <button @click="show = false" class="text-amber-400 hover:text-amber-600">&times;</button>
    </div>
@endif
