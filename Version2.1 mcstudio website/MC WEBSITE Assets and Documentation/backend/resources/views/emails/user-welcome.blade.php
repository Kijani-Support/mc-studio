<x-mail.base :subject="$subject">

  <div class="w-full p-10">
    {!!  html_entity_decode(Blade::render($template, compact('name', 'email', 'link'))) !!}
  </div>
    
</x-mail.base>
