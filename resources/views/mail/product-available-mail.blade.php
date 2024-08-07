<x-mail::message>
    # Introduction

    <x-mail::panel>
        <div>Hello, {{$user->name}} {{$user->lastname}}</div>
        <div>Product {{$product->title}} is available now!</div>
    </x-mail::panel>

    <x-mail::button :url="$url">
        {{$product->title}}
    </x-mail::button>

    Thanks,<br>
    {{ config('app.name') }}
</x-mail::message>
