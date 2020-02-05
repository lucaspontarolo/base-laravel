@extends('emails.layouts.main')
@section('preheader', 'Redefinição de senha')

@section('content')
<p>
    Você solicitou recentemente a redefinição da senha da sua conta. Use o botão abaixo para redefini-lo. <strong>Essa redefinição de senha é válida apenas pelas próximas 24 horas.</strong>
</p>
<!-- Action -->
<table class="body-action" align="center" width="100%" cellpadding="0" cellspacing="0" role="presentation">
    <tr>
        <td align="center">
            <!-- Border based button https://litmus.com/blog/a-guide-to-bulletproof-buttons-in-email-design -->
            <table width="100%" border="0" cellspacing="0" cellpadding="0" role="presentation">
                <tr>
                    <td align="center">
                        <a href="{{  $url }}" class="f-fallback button button--green" target="_blank">Resetar seu password</a>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<!-- Sub copy -->
<table class="body-sub" role="presentation">
    <tr>
        <td>
            <p class="f-fallback sub">
                Se você estiver com problemas no botão acima, copie e cole o URL abaixo no seu navegador da web.
            </p>
            <p class="f-fallback sub">{{ $url }}</p>
        </td>
    </tr>
</table>
@endsection