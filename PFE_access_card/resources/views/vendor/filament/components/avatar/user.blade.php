<!-- resources/views/components/avatar.blade.php -->
@props([
    'user' => filament()->auth()->user(),
])
<x-filament::avatar :src="asset('images/avatar.jpg')" :alt="__('خروج', ['name' => filament()->getUserName($user)])" :attributes="\Filament\Support\prepare_inherited_attributes($attributes)->class(['fi-user-avatar'])" />
