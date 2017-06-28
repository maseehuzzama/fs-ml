@component('mail::message')

Dear Sir/Madam,


{{$content['message']}}


Thanks,

@component('mail::table')
| Name                    | Email                    | Phone                |Company                |
|------------------------:| ------------------------:|:--------------------:|:--------------------:|
| {{$content['name']}}    | {{$content['email']}}    | {{$content['phone']}}|{{$content['company']}}|

@endcomponent


@endcomponent
