@component('mail::message')
# Hello

We have to remainder you that ,those ads will start tomorrow.<br>

@component('mail::table')
    | Ad ID         | Ad Title         |
    | ------------- |:----------------:|
    @foreach($ads as $ad)
    | {{ $ad->id }} | {{ $ad->title }} |
    @endforeach
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
