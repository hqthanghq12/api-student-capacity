<x-mail::message>
# Thông báo thông tin tài khoản

Xin chào,
Thông tin tải khoản:
<x-mail::table>
    | Infomation        | Detail                     |
    | ----------------- | -------------------------- |
    | Email           | {{ $email }}  |
    | Password              | {{ $password }}  |
</x-mail::table>

Xin chân thành cảm ơn,<br>
{{ config('app.name') }}
</x-mail::message>