@extends('layouts.main')
@section('title', 'Quản lý Kỳ học')
@section('page-title', 'Danh sách block')
@section('content')
    <!-- CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simple-notify@0.5.5/dist/simple-notify.min.css" />
    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/simple-notify@0.5.5/dist/simple-notify.min.js"></script>
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xxl">
            <!--begin::Row-->
            <div class="mb-5">
                {{ Breadcrumbs::render('Management.block',$id ) }}
            </div>


            <div class="card card-flush p-4">
                <div class="row">
                    <div class=" col-lg-6">

                        <h1>
                            Danh sách block
                        </h1>
                    </div>
                </div>


                <div class="input-group flex-nowrap">
                    <span class="input-group-text"><i class="bi bi-bookmarks-fill fs-4"></i></span>
                    <div class="overflow-hidden flex-grow-1">
                        <select class="form-select rounded-start-0" id="blockelm">
                            <option value="0">--Chọn block--</option>
                            @foreach($data as $key => $value)
                                <option value="{{ $value->id }}" data-semeter="{{ $value->id_semeter }}">{{ $value->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 text-center my-5 p-0 d-none">
                        <button type="button" id="btnPoetry" class="btn btn-primary">Quản Lí ca thi</button>
                    </div>
                </div>
            </div>

            <!--end::Row-->
        </div>
        <!--end::Container-->
    </div>

@endsection
@section('page-script')
    <script>
        const elmBlock = document.getElementById('blockelm');
        const btnBlock = document.getElementById('btnPoetry');
        const _token = "{{ csrf_token() }}";
        const start_time =
            '{{ request()->has('start_time') ? \Carbon\Carbon::parse(request('start_time'))->format('m/d/Y h:i:s A') : \Carbon\Carbon::now()->format('m/d/Y h:i:s A') }}'
        const end_time =
            '{{ request()->has('end_time') ? \Carbon\Carbon::parse(request('end_time'))->format('m/d/Y h:i:s A') : \Carbon\Carbon::now()->format('m/d/Y h:i:s A') }}'
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" ></script>
    <script src="{{ asset('assets/js/system/semeter/semeter.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.4/moment.min.js"></script>
    <script>
        elmBlock.addEventListener("change", function() {
            var selectedOption = elmBlock.options[elmBlock.selectedIndex];
            const id = elmBlock.value;
            const id_semeter = selectedOption.dataset.semeter;
            console.log(id_semeter)
            if (id != 0){
                btnBlock.parentNode.classList.remove('d-none');
                btnBlock.addEventListener("click", function() {

                    window.location.href = `admin/poetry/${id_semeter}/${id}`; // Thay thế URL bằng URL mong muốn
                });
            }else {
                btnBlock.parentNode.classList.add('d-none');
            }
        });
    </script>
@endsection
