@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-300 focus:border-nav-green focus:ring-navgreen rounded-md shadow-sm']) !!}>
