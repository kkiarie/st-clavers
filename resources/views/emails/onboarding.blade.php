<x-mail::message>
<p>Hello {{$details->name}},

Your account has been created succesfully, login in with the password <b>{{$details->temp_password}}</b> then proceed to set your own password.

</p>




<x-mail::button :url="''">
LOGIN
</x-mail::button>


Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
