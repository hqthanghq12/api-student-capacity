<?php
$ROLE_HAS_ADMINS = 'admin|super admin';
$ROLE_JUDGE = 'admin|super admin|judge|teacher';
$TYPE_CAPACITY = 1;
return [
//    [
//        "icon" => '
//        <!--begin::Svg Icon | path: icons/duotune/communication/com013.svg-->
//        <span class="svg-icon svg-icon-primary svg-icon-2x">
//            <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/Code/Question-circle.svg--><svg
//                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
//                width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
//                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
//                    <rect x="0" y="0" width="24" height="24" />
//                    <circle fill="#000000" opacity="0.3" cx="12" cy="12"
//                        r="10" />
//                    <path
//                        d="M12,16 C12.5522847,16 13,16.4477153 13,17 C13,17.5522847 12.5522847,18 12,18 C11.4477153,18 11,17.5522847 11,17 C11,16.4477153 11.4477153,16 12,16 Z M10.591,14.868 L10.591,13.209 L11.851,13.209 C13.447,13.209 14.602,11.991 14.602,10.395 C14.602,8.799 13.447,7.581 11.851,7.581 C10.234,7.581 9.121,8.799 9.121,10.395 L7.336,10.395 C7.336,7.875 9.31,5.922 11.851,5.922 C14.392,5.922 16.387,7.875 16.387,10.395 C16.387,12.915 14.392,14.868 11.851,14.868 L10.591,14.868 Z"
//                        fill="#000000" />
//                </g>
//            </svg>
//            <!--end::Svg Icon-->
//        </span>
//        <!--end::Svg Icon-->
//        ',
//        "name" => "Quản lí môn học",
//        "role" => $ROLE_HAS_ADMINS,
//        "subs-menu" => [
//            [
//                "name" => "Danh sách Môn học",
//                "param" => '?type=' . $TYPE_CAPACITY,
//                "link" => "admin.subject.list",
//                "role" => $ROLE_HAS_ADMINS
//            ]
////            ,
////            [
////                "name" => "Bộ câu hỏi ",
////                "param" => '',
////                "link" => "admin.question.index",
////                "role" => $ROLE_HAS_ADMINS
////            ]
//            ,
//
//        ]
//    ], // Test nang luc
//    [
//            "icon" => '
//        <!--begin::Svg Icon | path: icons/duotune/communication/com013.svg-->
//        <span class="svg-icon svg-icon-primary svg-icon-2x">
//            <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/Code/Question-circle.svg--><svg
//                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
//                width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
//                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
//                    <rect x="0" y="0" width="24" height="24" />
//                    <circle fill="#000000" opacity="0.3" cx="12" cy="12"
//                        r="10" />
//                    <path
//                        d="M12,16 C12.5522847,16 13,16.4477153 13,17 C13,17.5522847 12.5522847,18 12,18 C11.4477153,18 11,17.5522847 11,17 C11,16.4477153 11.4477153,16 12,16 Z M10.591,14.868 L10.591,13.209 L11.851,13.209 C13.447,13.209 14.602,11.991 14.602,10.395 C14.602,8.799 13.447,7.581 11.851,7.581 C10.234,7.581 9.121,8.799 9.121,10.395 L7.336,10.395 C7.336,7.875 9.31,5.922 11.851,5.922 C14.392,5.922 16.387,7.875 16.387,10.395 C16.387,12.915 14.392,14.868 11.851,14.868 L10.591,14.868 Z"
//                        fill="#000000" />
//                </g>
//            </svg>
//            <!--end::Svg Icon-->
//        </span>
//        <!--end::Svg Icon-->
//        ',
//            "name" => "Quản lí",
//            "role" => $ROLE_HAS_ADMINS,
//            "subs-menu" => [
//                [
//                    "name" => "Sinh viên",
//                    "param" => '?type=' . $TYPE_CAPACITY,
//                    "link" => "admin.students.list",
//                    "role" => $ROLE_HAS_ADMINS
//                ]
//            ]
//        ],
//    [
//        "icon" => '
//        <!--begin::Svg Icon | path: icons/duotune/communication/com013.svg-->
//        <span class="svg-icon svg-icon-primary svg-icon-2x">
//            <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/Code/Question-circle.svg--><svg
//                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
//                width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
//                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
//                    <rect x="0" y="0" width="24" height="24" />
//                    <circle fill="#000000" opacity="0.3" cx="12" cy="12"
//                        r="10" />
//                    <path
//                        d="M12,16 C12.5522847,16 13,16.4477153 13,17 C13,17.5522847 12.5522847,18 12,18 C11.4477153,18 11,17.5522847 11,17 C11,16.4477153 11.4477153,16 12,16 Z M10.591,14.868 L10.591,13.209 L11.851,13.209 C13.447,13.209 14.602,11.991 14.602,10.395 C14.602,8.799 13.447,7.581 11.851,7.581 C10.234,7.581 9.121,8.799 9.121,10.395 L7.336,10.395 C7.336,7.875 9.31,5.922 11.851,5.922 C14.392,5.922 16.387,7.875 16.387,10.395 C16.387,12.915 14.392,14.868 11.851,14.868 L10.591,14.868 Z"
//                        fill="#000000" />
//                </g>
//            </svg>
//            <!--end::Svg Icon-->
//        </span>
//        <!--end::Svg Icon-->
//        ',
//        "name" => "Học kỳ",
//        "role" => $ROLE_HAS_ADMINS,
//        "subs-menu" => [
//            [
//                "name" => "Quản Lí học kỳ",
//                "param" => '?type=' . $TYPE_CAPACITY,
//                "link" => "admin.semeter.index",
//                "role" => $ROLE_HAS_ADMINS
//            ]
//        ]
//    ], // Test học kỳ
//    [
//        "icon" => '
//        <!--begin::Svg Icon | path: icons/duotune/communication/com013.svg-->
//        <span class="svg-icon svg-icon-primary svg-icon-2x">
//            <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/Code/Question-circle.svg--><svg
//                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
//                width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
//                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
//                    <rect x="0" y="0" width="24" height="24" />
//                    <circle fill="#000000" opacity="0.3" cx="12" cy="12"
//                        r="10" />
//                    <path
//                        d="M12,16 C12.5522847,16 13,16.4477153 13,17 C13,17.5522847 12.5522847,18 12,18 C11.4477153,18 11,17.5522847 11,17 C11,16.4477153 11.4477153,16 12,16 Z M10.591,14.868 L10.591,13.209 L11.851,13.209 C13.447,13.209 14.602,11.991 14.602,10.395 C14.602,8.799 13.447,7.581 11.851,7.581 C10.234,7.581 9.121,8.799 9.121,10.395 L7.336,10.395 C7.336,7.875 9.31,5.922 11.851,5.922 C14.392,5.922 16.387,7.875 16.387,10.395 C16.387,12.915 14.392,14.868 11.851,14.868 L10.591,14.868 Z"
//                        fill="#000000" />
//                </g>
//            </svg>
//            <!--end::Svg Icon-->
//        </span>
//        <!--end::Svg Icon-->
//        ',
//        "name" => "Sinh Viên",
//        "role" => $ROLE_HAS_ADMINS,
//        "subs-menu" => [
//            [
//                "name" => "Quản Lí sinh viên",
//                "param" => '?type=' . $TYPE_CAPACITY,
//                "link" => "manage.student.list",
//                "role" => $ROLE_HAS_ADMINS
//            ]
//        ]
//    ], // Test sinh viên
    [
        "icon" => '
            <!--begin::Svg Icon | path: icons/duotune/communication/com013.svg-->
            <span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/General/Settings-2.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                    <rect x="0" y="0" width="24" height="24"/>
                    <path d="M5,8.6862915 L5,5 L8.6862915,5 L11.5857864,2.10050506 L14.4852814,5 L19,5 L19,9.51471863 L21.4852814,12 L19,14.4852814 L19,19 L14.4852814,19 L11.5857864,21.8994949 L8.6862915,19 L5,19 L5,15.3137085 L1.6862915,12 L5,8.6862915 Z M12,15 C13.6568542,15 15,13.6568542 15,12 C15,10.3431458 13.6568542,9 12,9 C10.3431458,9 9,10.3431458 9,12 C9,13.6568542 10.3431458,15 12,15 Z" fill="#000000"/>
                </g>
            </svg>
             <!--end::Svg Icon--></span>
        ',
        "name" => "Cấu hình",
        "role" => $ROLE_HAS_ADMINS,
        "subs-menu" => [
            [
                "name" => "Tài khoản",
                "role" => $ROLE_HAS_ADMINS,
                "param" => '',
                "link" => "admin.acount.list",
            ],
            [
                "name" => "Quản lí cơ sở ",
                "param" => '',
                "link" => "admin.basis.list",
                "role" => $ROLE_HAS_ADMINS
            ]
        ]
    ]
];
