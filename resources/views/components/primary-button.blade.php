<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-[#1E45FB] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#1E45FB]/90 focus:bg-[#1E45FB]/90 active:bg-[#1E45FB] focus:outline-none focus:ring-2 focus:ring-[#1E45FB] focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
