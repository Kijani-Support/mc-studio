<x-mail.base :subject="$subject">

  <div class="w-full p-10">
    {!!  html_entity_decode(Blade::render($template, compact('name', 'purchase_order_number', 'purchase_order_items'))) !!}
  </div>
    
</x-mail.base>
