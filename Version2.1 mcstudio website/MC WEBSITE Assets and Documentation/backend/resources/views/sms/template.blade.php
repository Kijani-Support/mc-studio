@extends('layouts.app')

@section('content')
    <section>
        <div class="w-full rounded-lg">
            <pre class="p-2 bg-gray-100 dark:bg-gray-900">
                {!! $data !!}
            </pre>
        </div>
    </section>
@endsection
