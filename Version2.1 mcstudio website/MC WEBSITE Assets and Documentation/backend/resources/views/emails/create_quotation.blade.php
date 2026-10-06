<x-mail.base :subject="$subject">

  <div class="w-full p-10">
    {!!  html_entity_decode(Blade::render($template, compact('name', 'quotation_number', 'quotation_items'))) !!}
  </div>
    
</x-mail.base>
