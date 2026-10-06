<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
 
    @if($subject = $attributes->get('subject'))

    <title>{{ $subject }}</title>
    
    @endif
</head>
<body>
    <div class="flex items-center justify-center min-h-screen p-5 bg-green-300 min-w-screen">
        
        <div class="flex flex-col">

            @include('partials.mail.header')
            
            <div class="bg-white dark:bg-darkmode-700 rounded-lg">
                {{ $slot }}
            </div>
            
            @include('partials.mail.footer')

        </div>

    </div>
</body>
</html>