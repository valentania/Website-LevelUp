@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-300 focus:border-[#1E45FB] focus:ring-[#1E45FB] rounded-md shadow-sm']) }}>
