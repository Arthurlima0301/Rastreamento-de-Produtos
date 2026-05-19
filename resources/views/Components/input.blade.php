@props([
    'name',
    'label' => null,
    'type' => 'text',
    'value' => null,
    'id' => null,
])

@php
    $id = $id ?? $name;
    $fieldValue = old($name, $value ?? '');
@endphp

<flux:input
    :type="$type"
    :name="$name"
    :id="$id"
    :label="$label"
    :value="$fieldValue"
    {{ $attributes->class('') }}
/>
