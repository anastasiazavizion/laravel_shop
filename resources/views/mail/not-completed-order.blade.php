<x-mail::message>
# Not completed order

<div>
    Hello, {{$order->name}} {{$order->lastname}}!<br>
    You have not completed order, total is {{$order->total}}$
</div>
    job_batches
<x-mail::button :url="$url">
Continue shopping
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
