@component('mail::message')
    Xin chào {{ $user->name }}
    <p>Đây là email khôi phục mật khẩu của bạn</p>
    @component('mail::button', ['url'=>url('reset-password/'.$user->remember_token)])
        Đặt lại mật khẩu
    @endcomponent
    <p>Nếu có vấn đề với việc đặ lại mật khẩu, hãy liên hệ lại với chúng tôi.</p>
    Xin cảm ơn, <br>
    {{ config('app.name') }}
@endcomponent
