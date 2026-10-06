<x-dynamic-component
    :component="$getFieldWrapperView()"
    :id="$getId()"
    :label="$getLabel()"
    :label-sr-only="$isLabelHidden()"
    :state-path="$getStatePath()"
>
    <div x-data="{ state: $wire.entangle('{{ $getStatePath() }}').defer }">

        @if ($getDescription())
            <div>{{ $getDescription() }}</div>
        @endif
        
        @foreach ($getItems() as $item)
          <span>&#123;&#123;</span> {{ "$".$item }} <span>&#125;&#125;</span>{{ $loop->last ? '' : ',' }}
        @endforeach
    </div>
</x-dynamic-component>
