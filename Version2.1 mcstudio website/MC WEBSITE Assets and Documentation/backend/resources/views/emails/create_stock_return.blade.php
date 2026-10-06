<x-mail.base :subject="$subject">

  <div class="w-full p-10">
    {!!  html_entity_decode(Blade::render($template, compact('name', 'reason', 'order_number', 'return_items'))) !!}
  </div>
    
</x-mail.base>
