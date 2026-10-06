<x-dynamic-component
    :component="$getFieldWrapperView()"
    :id="$getId()"
    :label="$getLabel()"
    :label-sr-only="$isLabelHidden()"
    :state-path="$getStatePath()"
>
    <div x-data="{ state: $wire.entangle('{{ $getStatePath() }}').defer }">
        <!-- Interact with the `state` property in Alpine.js -->

        @if ($getDescription())
            <div>{{ $getDescription() }}</div>
        @endif
        
        @foreach ($getItems() as $item)
            {{ $item }}  
        @endforeach
    </div>
</x-dynamic-component>
