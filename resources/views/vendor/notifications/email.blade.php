@component('mail::message')
Hello,<br>
<br>
You have raised a request for password reset. Please click on below link <link> to reset your password
This password reset link will expire in 10 minutes.
If you did not request a password request, no further action is required
{{-- Subcopy --}}
@isset($actionText)

@lang(
"copy and paste the URL below\n".
'into your web browser:',['actionText' => $actionText,]) 

<span class="break-all">[{{ $displayableActionUrl }}]({{ $actionUrl }})</span>

@endisset

&nbsp;&nbsp;&nbsp;&nbsp;Regards,<br>
<img src="http://work.probsoltechnology.net/images/logo/materialize-logo.png" style="height: 70px;width: 85px;" class="logo" alt="w4work Logo"><br>
w4work Team
@endcomponent