@extends('layouts.main')
@section('title', 'Kết quả ' . $user->name)
@section('page-title', 'Kết quả làm bài của sinh viên ' . $user->name)
@section('page-style')
    <style>
        #result::-webkit-scrollbar {
            width: 15px; /* Chiều rộng của thanh scrollbar */
        }
        #result::-webkit-scrollbar-thumb {
            background-color: #999; /* Màu của thanh cuộn */
            border-radius: 15px; /* Đường viền cong của thanh cuộn */
        }
    </style>
@endsection
@section('content')
    <!-- CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simple-notify@0.5.5/dist/simple-notify.min.css"/>
    <link rel="stylesheet" href="assets/plugins/global/plugins.bundle.css">
    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/simple-notify@0.5.5/dist/simple-notify.min.js"></script>
    <script src="assets/plugins/global/plugins.bundle.js"></script>
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xxl">
            <!--begin::Row-->
            <div class="mb-5">
                {{ Breadcrumbs::render('resultCapacity',['id' => $poetry->id,'id_poetry' => $semester->id,'id_block' => $block->id]) }}
            </div>
            <div class="my-5">

            </div>
            <div class="card card-flush p-4">
                <div class="card-header">
                    <p class="card-title">
                        Chi tiết bài làm của {{ $user->name }}
                        @if(!empty($user->mssv))
                            (MSV: {{ \Illuminate\Support\Str::upper($user->mssv) }})
                        @endif
                    </p>
                </div>
                <div class="card-body pt-0">
                    <div class="row">
                        <div class="col-lg-12">
                            <div style="width:100%" class=" fs-3 pb-5">
                                <div class="row">
                                    <div class="col-12 text-center">
                                        <div class="row">
                                            <div class="col-12">
                                                <h1>Đề:
                                                    <span class="text-info">
                                                            {{ $playtopic->exam_name }}
                                                        </span>
                                                </h1>
                                                <p>
                                                    Môn thi:
                                                    <strong>
                                                        {{ $subject->code_subject }} | {{ $subject->name }}
                                                    </strong>
                                                </p>
                                                <p>
                                                    Kỳ:
                                                    <strong>
                                                        {{ $semester->name }}
                                                    </strong>
                                                </p>
                                                <span class="fs-5">
                                                        Ca {{ $poetry->start_examination_id }} - Ngày: {{ \Illuminate\Support\Carbon::parse($poetry->exam_date)->format('d-m-Y') }}
                                                    </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 overflow-scroll" style="max-height: 600px">
                                        {{--                                            <ul class="list-group-flush">--}}
                                        {{--                                                @foreach($questionsId as $key => $questionId)--}}
                                        {{--                                                    @php--}}
                                        {{--                                                        $question = $questions->where('id', $questionId)->first();--}}
                                        {{--                                                        $correctAnswer = $question->answers->where('is_correct', 1)->first();--}}
                                        {{--                                                        $resultDetail = $resultCapacityDetail->where('question_id', $question->id)->first();--}}
                                        {{--                                                        if (empty($resultDetail->answer_id)) {--}}
                                        {{--                                                            $color = 'text-warning';--}}
                                        {{--                                                        } elseif ($resultDetail->answer_id == $correctAnswer->id) {--}}
                                        {{--                                                            $color = 'text-success';--}}
                                        {{--                                                        } else {--}}
                                        {{--                                                            $color = 'text-danger';--}}
                                        {{--                                                        }--}}
                                        {{--                                                    @endphp--}}
                                        {{--                                                    <li class="list-group-item py-1">--}}
                                        {{--                                                        <a href="#question-{{ $key + 1 }}"--}}
                                        {{--                                                           class="btn w-100 {{ $color }}">--}}
                                        {{--                                                            Câu {{ $key + 1 }}--}}
                                        {{--                                                        </a>--}}
                                        {{--                                                    </li>--}}
                                        {{--                                                @endforeach--}}
                                        {{--                                            </ul>--}}
                                        <div class="card">
                                            <div class="card-header">
                                                <div class="card-title">
                                                    Thông tin bài thi
                                                </div>
                                            </div>
                                            <div class="card-body">

                                                <ul class="list-group-flush p-0">
                                                    <li class="list-group-item py-1">
                                                        <div class="row">
                                                            <div class="col-5">Điểm</div>
                                                            <div class="col-7">
                                                                <h1 class="text-{{ $result->scores < 5 ? 'danger' : 'success' }}">
                                                                    {{ $result->scores }}
                                                                </h1>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li class="list-group-item py-1">
                                                        <div class="row">
                                                            <div class="col-5">Tổng</div>
                                                            <div class="col-7 text-primary">
                                                                <strong>
                                                                    {{ $totalQuestion }} câu
                                                                </strong>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li class="list-group-item py-1">
                                                        <div class="row">
                                                            <div class="col-5">Đúng</div>
                                                            <div class="col-7 text-success">
                                                                <strong>
                                                                    {{ $result->true_answer }} câu
                                                                    ({{ $totalQuestion > 0 ? $result->true_answer / $totalQuestion * 100 : 0 }}
                                                                    %)
                                                                </strong>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li class="list-group-item py-1">
                                                        <div class="row">
                                                            <div class="col-5">Sai</div>
                                                            <div class="col-7 text-danger">
                                                                <strong>
                                                                    {{ $result->false_answer }} câu
                                                                    ({{ $totalQuestion > 0 ? $result->false_answer / $totalQuestion * 100 : 0 }}
                                                                    %)
                                                                </strong>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li class="list-group-item py-1">
                                                        <div class="row">
                                                            <div class="col-5">Chưa trả lời</div>
                                                            <div class="col-7 text-warning">
                                                                <strong>
                                                                    {{ $result->donot_answer }} câu
                                                                    ({{ $totalQuestion > 0 ? $result->donot_answer / $totalQuestion * 100 : 0 }}
                                                                    %)
                                                                </strong>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li class="list-group-item py-1">
                                                        <div class="row">
                                                            <div class="col-5">Làm bài trong</div>
                                                            <div class="col-7 text-info">
                                                                <strong>
                                                                    {{ \Illuminate\Support\Carbon::parse($result->updated_at)->longAbsoluteDiffForHumans(\Illuminate\Support\Carbon::parse($result->created_at), 3) }}
                                                                </strong>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li class="list-group-item py-1">
                                                        <div class="row">
                                                            <div class="col-5">Nộp bài lúc</div>
                                                            <div class="col-7 text-info">
                                                                <strong>
                                                                    {{ \Illuminate\Support\Carbon::parse($result->updated_at)->format('H:i d-m-Y') }}
                                                                </strong>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-8 py-3 px-5 overflow-scroll" id="result"
                                         style="max-height: 600px;">
                                        @foreach($questionsId as $key => $questionId)
                                            @php
                                                $stt = 'A';
                                                $question = $questions->where('id', $questionId)->first();
                                                $images = $question->images->toArray();
                                                $index = $key + 1;
                                                $correctAnswer = $question->answers->where('is_correct', 1)->first();
                                                    $resultDetail = $resultCapacityDetail->where('question_id', $question->id)->first();
                                                    if (empty($resultDetail->answer_id)) {
                                                        $color = 'text-warning';
                                                    } elseif ($resultDetail->answer_id == $correctAnswer->id) {
                                                        $color = 'text-success';
                                                    } else {
                                                        $color = 'text-danger';
                                                    }
                                            @endphp
                                            <div id="question-{{ $index }}" class="my-5">
                                                <div class="question-content">
                                                    <strong class="{{ $color }}">Câu {{ $index }}:</strong>
                                                    {!! renderQuesAndAns($question->content, $images, 25) !!}
                                                </div>
                                                <div class="answers ps-5">
                                                    @foreach($question->answers as $answer)
                                                        @php
                                                            $color = '';
                                                                if ($answer->is_correct == 1) {
                                                                    $color = 'bg-success text-white';
                                                                } elseif ($resultDetail?->answer_id && $resultDetail->answer_id == $answer->id) {
                                                                    $color = 'bg-danger text-white';
                                                                }
                                                        @endphp
                                                        <div class="answer ps-3 py-1 rounded my-2 {{ $color }}">
                                                            <strong>{{ $stt++ }}</strong>.
                                                            {!! renderQuesAndAns($answer->content, $images, 25) !!}
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>

            <!--end::Row-->
        </div>
        <!--end::Container-->
    </div>

@endsection
@section('page-script')
    <script id="MathJax-script" async src="assets/js/custom/apps/mathjax/tex-mml-chtml.js"></script>
    <script>
        window.MathJax = {
            tex: {
                inlineMath: [['$', '$'], ['\\(', '\\)']]
            }
        };

        function notify(message) {
            new Notify({
                status: 'success',
                title: 'Thành công',
                text: `${message}`,
                effect: 'fade',
                speed: 300,
                customClass: null,
                customIcon: null,
                showIcon: true,
                showCloseButton: true,
                autoclose: true,
                autotimeout: 3000,
                gap: 20,
                distance: 20,
                type: 1,
                position: 'right top'
            })
        }

        function wanrning(message) {
            new Notify({
                status: 'warning',
                title: 'Đang chạy',
                text: `${message}`,
                effect: 'fade',
                speed: 300,
                customClass: null,
                customIcon: null,
                showIcon: true,
                showCloseButton: true,
                autoclose: true,
                autotimeout: 3000,
                gap: 20,
                distance: 20,
                type: 1,
                position: 'right top'
            })
        }

        function errors(message) {
            new Notify({
                status: 'error',
                title: 'Lỗi',
                text: `${message}`,
                effect: 'fade',
                speed: 300,
                customClass: null,
                customIcon: null,
                showIcon: true,
                showCloseButton: true,
                autoclose: true,
                autotimeout: 3000,
                gap: 20,
                distance: 20,
                type: 1,
                position: 'right top'
            })
        }

        function formatDate(DateValue) {

            var date = new Date(DateValue);

            var day = date.getDate();
            var month = date.getMonth() + 1; // Ghi chú: Tháng bắt đầu từ 0 (0 = tháng 1)
            var year = date.getFullYear();

            const formattedDate = day + "-" + month + "-" + year;
            return formattedDate;
        }

        const _token = "{{ csrf_token() }}";
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.4/moment.min.js"></script>
    {{--    Thêm --}}

@endsection
