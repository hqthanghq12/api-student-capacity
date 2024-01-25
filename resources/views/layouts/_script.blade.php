<script>
    var hostUrl = "assets/";
</script>
<script src="https://kit.fontawesome.com/29b41ee1c8.js" crossorigin="anonymous"></script>
<!--begin::Global Javascript Bundle(used by all pages)-->
<script src="assets/plugins/global/plugins.bundle.js"></script>
<script src="assets/js/scripts.bundle.js"></script>
{{-- <script src="assets/plugins/custom/prismjs/prismjs.bundle.js"></script> --}}
<!--end::Global Javascript Bundle-->
<!--begin::Page Vendors Javascript(used by this page)-->
{{-- <script src="assets/plugins/custom/datatables/datatables.bundle.js"></script> --}}
<!-- JavaScript Bundle with Popper -->

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.js">
</script>

{{-- Set up plugin global --}}
<script src="assets/js/system/configplugins/configplugins.js"></script>
@if((!auth()->user()->hasRole('teacher')))
    <script src="{{ mix('js/echo.js') }}"></script>
    <script>

        // console.log(window.Echo);

        let statusRequests;

        let count = 0;

        const statusRequestListApi = '{{ route('admin.status-requests.list-api') }}';

        const notiBody = $('#noti-body');

        $.ajax({
            url: statusRequestListApi,
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                statusRequests = response.payload;
                count = statusRequests.length;
                $('#noti-count').text(count);
                if (statusRequests.length === 0) {
                    notiBody.append(`
                        <div class="d-flex flex-stack py-4">
                            <div class="d-flex align-items-center">
                                <div class="mb-0 me-2">
                                    <a href="#"
                                       class="fs-6 text-gray-800 text-hover-primary fw-bolder"
                                    >
                                        Không có yêu cầu mở trạng thái nào ngày hôm nay
                                    </a>
                                </div>
                            </div>
                        </div>
                    `);
                    return;
                }
                statusRequests.forEach(function (statusRequest) {
                    let html = `
                        <div class="d-flex flex-stack py-4">
                                        <!--begin::Section-->
                            <div class="d-flex align-items-center">
                                <!--begin::Title-->
                                <div class="mb-0 me-2">
                                    <a href="${statusRequest.link}"
                                       class="fs-6 text-gray-800 text-hover-primary fw-bolder"
                                    >
                                        Yêu cầu mở trạng thái
                                    </a>
                                    <div class="text-gray-400 fs-7">${statusRequest.created_by} đã tạo yêu cầu mở trạng thái mới</div>
                                </div>
                                <!--end::Title-->
                            </div>
                            <!--end::Section-->
                            <!--begin::Label-->
                            <span class="badge badge-light fs-8">${statusRequest.update_at}</span>
                            <!--end::Label-->
                        </div>
                    `;
                    notiBody.prepend(html);
                });
            }
        });

        let channel = '{{ auth()->user()->hasRole('admin') ? 'admin-channel.' . auth()->user()->campus_id : 'admin-ho-channel' }}';
        const notiIcon = $('#noti-btn');
        const notiDot = $('#noti-dot');
        let hasRead = JSON.parse(localStorage.getItem('hasRead')) || false;
        if (hasRead) {
            notiDot.hide();
        } else {
            notiDot.show();
        }
        window.Echo.channel(channel)
            .listen('StatusRequestCreateEvent', (e) => {
                hasRead = false;
                localStorage.setItem('hasRead', hasRead);
                notiDot.show();
                let msg = `${e.created_by} đã tạo yêu cầu mở trạng thái mới vào lúc ${e.created_at}`;
                @if(!auth()->user()->hasRole('admin'))
                    msg += ` tại cơ sở ${e.campus}`;
                @endif
                    msg += ` <a href="${e.link}" target="_blank">Xem chi tiết</a>`;
                new Notify({
                    status: 'success',
                    title: 'Có yêu cầu mở trạng thái mới',
                    text: `${msg}`,
                    effect: 'fade',
                    speed: 300,
                    customClass: null,
                    customIcon: null,
                    showIcon: true,
                    showCloseButton: true,
                    autoclose: true,
                    autotimeout: 5000,
                    gap: 20,
                    distance: 20,
                    type: 1,
                    position: 'right top'
                })
                $('#noti-body').prepend(`
                        <div class="d-flex flex-stack py-4">
                                        <!--begin::Section-->
                            <div class="d-flex align-items-center">
                                <!--begin::Title-->
                                <div class="mb-0 me-2">
                                    <a href="${e.link}"
                                       class="fs-6 text-gray-800 text-hover-primary fw-bolder"
                                    >
                                        Yêu cầu mở trạng thái
                                    </a>
                                    <div class="text-gray-400 fs-7">${e.created_by} đã tạo yêu cầu mở trạng thái mới</div>
                                </div>
                                <!--end::Title-->
                            </div>
                            <!--end::Section-->
                            <!--begin::Label-->
                            <span class="badge badge-light fs-8">${e.created_at}</span>
                            <!--end::Label-->
                        </div>
                    `);
                count++;
                $('#noti-count').text(count);
            });
        notiIcon.on('click', function () {
            hasRead = true;
            localStorage.setItem('hasRead', hasRead);
            notiDot.hide();
        });
    </script>
@endif
