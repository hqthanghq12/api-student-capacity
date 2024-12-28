<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
    <base href="../../../">
    <title>FPT Polytechnic - Cổng đánh giá năng lực sinh viên</title>
    <meta charset="utf-8"/>
    <meta name="description"
          content="The most advanced Bootstrap Admin Theme on Themeforest trusted by 94,000 beginners and professionals. Multi-demo, Dark Mode, RTL support and complete React, Angular, Vue &amp; Laravel versions. Grab your copy now and get life-time updates for free."/>
    <meta name="keywords"
          content="Metronic, bootstrap, bootstrap 5, Angular, VueJs, React, Laravel, admin themes, web design, figma, web development, free templates, free admin themes, bootstrap theme, bootstrap template, bootstrap dashboard, bootstrap dak mode, bootstrap button, bootstrap datepicker, bootstrap timepicker, fullcalendar, datatables, flaticon"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta property="og:locale" content="en_US"/>
    <meta property="og:type" content="article"/>
    <meta property="og:title"
          content="Metronic - Bootstrap 5 HTML, VueJS, React, Angular &amp; Laravel Admin Dashboard Theme"/>
    <meta property="og:url" content="https://keenthemes.com/metronic"/>
    <meta property="og:site_name" content="Keenthemes | Metronic"/>
    <link rel="canonical" href="https://preview.keenthemes.com/metronic8"/>
    <link rel="shortcut icon" href="{{ asset('assets/media/logos/poly-favicon.ico') }}"/>
    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,600,700"/>
    <!--end::Fonts-->
    <!--begin::Global Stylesheets Bundle(used by all pages)-->
    <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css"/>
    <!--end::Global Stylesheets Bundle-->
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_body" class="bg-body">
<!--begin::Main-->
<!--begin::Root-->
<div class="d-flex flex-column flex-root">
    <!--begin::Authentication - Sign-in -->
    <div
        class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed"
        style="background-image: url(assets/media/illustrations/sketchy-1/14.png">
        <!--begin::Content-->
        <div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
            <!--begin::Logo-->
            <a href="javascript:;" class="mb-12">
                <img alt="Logo" src="{{ asset('assets/media/logos/logo-ptcd.png') }}" class="h-60px"/>
            </a>
            <!--end::Logo-->
            <!--begin::Wrapper-->
            <div class="w-lg-500px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">
                <!--begin::Form-->
                <div class="form w-100" novalidate="novalidate" id="kt_sign_in_form" action="#">
                    <!--begin::Heading-->
                    <div class="text-center mb-10">
                        <!--begin::Title-->
                        <h1 class="text-dark mb-3">Đăng nhập</h1>
                        <!--end::Title-->
                    </div>
                    <!--begin::Actions-->
                    <form class="text-center" action="{{ route('auth.redirect-google') }}" method="post">
                        {{--                    <form class="text-center" action="{{ route('google-auth.callback') }}" method="post">--}}
                        @csrf
                        <input type="hidden" name="login_type" id="login_type">
                        <div class="form-group mb-3">
                            @error('campus_id')
                            <div class="alert-danger py-3 mb-2">{{ $message }}</div>
                            @enderror
                            @if(session('msg'))
                                <div class="alert-danger py-3 mb-2">{{ session('msg') }}</div>
                            @endif
                            <select name="campus_id" id="" class="form-select">
                                <option value="">Chọn cơ sở</option>
                                @foreach($campuses as $campus)
                                    <option
                                        value="{{ $campus->id }}"
                                        @if(old('campus_id') === $campus->id) selected @endif
                                    >
                                        PTCĐ {{ $campus->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            @error('email')
                            <div class="alert-danger py-3 mb-2">{{ $message }}</div>
                            @enderror
{{--                            <select name="email" id="" class="form-select">--}}
{{--                                <option value="">Chọn tài khoản</option>--}}
{{--                                @foreach($users as $user)--}}
{{--                                    <option--}}
{{--                                        value="{{ $user->email }}"--}}
{{--                                        @if(old('email') === $user->email) selected @endif--}}
{{--                                    >--}}
{{--                                        {{ $user->email }}--}}
{{--                                        - {{ $user->roles[0]->name == 'super admin' ? "Admin HO" : $user->roles[0]->name }} @if($user->roles[0]->name !== 'super admin')--}}
{{--                                            - Cơ sở {{ $user->campus->name }}--}}
{{--                                        @endif--}}
{{--                                    </option>--}}
{{--                                @endforeach--}}
{{--                            </select>--}}
                        </div>
                        <!--begin::Google link-->
{{--                        <button--}}
{{--                            class="btn btn-flex flex-center btn-light btn-lg w-100 mb-5 text-center"--}}
{{--                            name="normal_login"--}}
{{--                            onclick="document.querySelector('#login_type').value = 0"--}}
{{--                        >--}}
{{--                            Đăng nhập--}}
{{--                        </button>--}}
                        <button
                            class="btn btn-flex flex-center btn-light btn-lg w-100 mb-5 text-center"
                            name="google_login"
                            onclick="document.querySelector('#login_type').value = 1"
                        >
                            <img alt="Logo" src="assets/media/svg/brand-logos/google-icon.svg"
                                 class="h-20px me-3"/>Đăng nhập với Google
                        </button>
                        <!--end::Google link-->
                    </form>
                    <!--end::Actions-->
                </div>
                <!--end::Form-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Content-->
        <!--begin::Footer-->
        {{--        <div class="d-flex flex-center flex-column-auto p-10">--}}
        {{--            <!--begin::Links-->--}}
        {{--            <div class="d-flex align-items-center fw-bold fs-6">--}}
        {{--                <a href="javascript:;" class="text-muted text-hover-primary px-2">Phát triển bởi Xưởng thực hành BM--}}
        {{--                    CNTT - Fpoly HN</a>--}}
        {{--            </div>--}}
        {{--            <!--end::Links-->--}}
        {{--        </div>--}}
        <!--end::Footer-->
    </div>
    <!--end::Authentication - Sign-in-->
</div>
<!--end::Root-->
<!--end::Main-->
<!--begin::Javascript-->
<script>
    var hostUrl = "{{ asset('assets') . '/' }}";
</script>
<script>
    {{--const users = @json($users);--}}
    const campusElement = document.querySelector('select[name="campus_id"]');
    // const userElement = document.querySelector('select[name="email"]');
    // const adminHo = users.filter(user => user.roles[0].name === 'super admin');
    // const usersNotAdminHo = users.filter(user => user.roles[0].name !== 'super admin');
    // campusElement.addEventListener('change', e => {
    //     userFil = usersNotAdminHo.filter(user => user.campus_id == e.target.value);
    //     userFil = [...adminHo, ...userFil];
    //     userElement.innerHTML =
    //         `<option value="">Chọn tài khoản</option>`
    //         + userFil.map(user => {
    //             let name = user.roles[0].name === 'super admin' ? "Admin HO" : user.roles[0].name;
    //             let text = `${user.email} - ${name}`
    //             if (user.roles[0].name !== 'super admin') {
    //                 text += ` - Cơ sở ${user.campus.name}`;
    //             }
    //
    //             return `<option value="${user.email}|${user.roles[0].id}">${text}</option>`
    //         }).join('')
    //     ;
    // })
    // userFil = adminHo;
    // userElement.innerHTML =
    //     `<option value="">Chọn tài khoản</option>`
    //     + userFil.map(user => `<option value="${user.email}|${user.roles[0].id}">${user.email} - Admin HO</option>`).join('');
</script>
<!--begin::Global Javascript Bundle(used by all pages)-->
<script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
<script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
<!--end::Global Javascript Bundle-->
<!--end::Javascript-->
</body>
<!--end::Body-->

</html>
