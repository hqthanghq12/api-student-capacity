@extends('layouts.main')
@section('title', 'Quản lý đánh giá năng lực')
@section('page-title', 'Thêm mới Đề thi ')
@section('content')
    <div class=" card card-flush  p-5">
        <div class="mb-5">
            {{ Breadcrumbs::render('Management.exam.create',$id,$name) }}
        </div>
        <div class="row">
            <div class="col-lg-12">
                <form id="myForm" action="{{ route('admin.exam.store', ['id' => $id]) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group mb-4">
                                <label class="form-label" for="">Tên đề bài</label>
                                <input type="text" name="name" value="{{ old('name') }}" id=""
                                    class="form-control" placeholder="">
                                @error('name')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>
                        <div class="col-lg-6">
                            <div class="form-group mb-4">
                                <label class="form-label" for="">Mô tả đề thi</label>
                                <textarea class="form-control" name="description" id="" rows="3">
                                   {{ old('description') }}
                                </textarea>
                                @error('description')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
{{--                            <div class="form-group mb-4">--}}
{{--                                <label class="form-label" for="">Cơ sở ra đề</label>--}}
{{--                                <select class="form-select" name="campus_exam">--}}
{{--                                    <option selected value="">Chọn cơ sở</option>--}}
{{--                                    @foreach($campus as $value)--}}
{{--                                        <option value="{{ $value->id }}">{{ $value->name }}</option>--}}
{{--                                    @endforeach--}}
{{--                                </select>--}}
{{--                                @error('campus_exam')--}}
{{--                                    <p class="text-danger">{{ $message }}</p>--}}
{{--                                @enderror--}}
{{--                            </div>--}}
{{--                            <div class="form-group mb-4">--}}
{{--                                <label class="form-label" for="">Thời gian làm bài</label>--}}
{{--                                <input type="text" name="time_exam" value="{{ old('time_exam') }}" id=""--}}
{{--                                       class="form-control" placeholder="">--}}
{{--                                @error('time_exam')--}}
{{--                                <p class="text-danger">{{ $message }}</p>--}}
{{--                                @enderror--}}
{{--                            </div>--}}
{{--                            @if ($round->contest->type == config('util.TYPE_CONTEST'))--}}
{{--                                <div class="form-group mb-4">--}}
{{--                                    <label class="form-label" for="">File đề thi</label>--}}
{{--                                    <input type="file" name="external_url" id=""--}}
{{--                                        value="{{ old('external_url') }}" class="form-control" placeholder="">--}}
{{--                                    @error('external_url')--}}
{{--                                        <p class="text-danger">{{ $message }}</p>--}}
{{--                                    @enderror--}}
{{--                                </div>--}}
{{--                            @endif--}}

                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Lưu</button>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('page-script')
    <script src="assets/js/system/exam/validateForm.js"></script>
    <script>
        rules.external_url = {
            required: true,
            extension: "zip,docx,word|file",
            filesize: 1048576
        }
        messages.external_url: {
            required: "Chưa nhập trường này !",
            extension: "Định dạng là zip,docx,word..",
            filesize: 'Dung lượng không quá 10MB'
        },
    </script>
    <script src="assets/js/system/validate/validate.js"></script>
@endsection
