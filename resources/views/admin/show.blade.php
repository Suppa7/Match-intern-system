@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 mb-3">
                <div class=" mt-3">
                    <a href="{{ route('admin.report') }}" class="btn btn-secondary ">
                        <div class="d-flex align-items-center">
                            <i class='bxr  bx-chevrons-left'></i> กลับสู่หน้าหลัก
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-md-10 mb-3">
                <div class="mt-4">
                    <div class="card border-primary">
                        <div class="card-body">
                            <h2 class="text-center fw-bold">{{ $review->company_name }}</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-10 mb-3">
                <div class="d-flex justify-content-between align-items-center">
                    {{-- เพิ่ม display: flex และ align-items: center เพื่อให้ทุกอย่างอยู่บรรทัดเดียวกัน --}}
                    <div class="rating-show" style="display: flex; align-items: center;">

                        {{-- แนะนำให้ใส่ span ครอบข้อความและใส่ margin-right เพื่อเว้นระยะห่างจากดาว --}}
                        <span style="margin-right: 10px;">คะแนน:</span>

                        @foreach (range(1, 5) as $score)
                            {{-- เช็คเงื่อนไขง่ายๆ: ถ้ารอบปัจจุบัน ($score) น้อยกว่าหรือเท่ากับคะแนนที่มี ให้เป็นสีส้ม --}}
                            <span class="star {{ $review->score >= $score ? 'active' : '' }}">&#9733;</span>
                        @endforeach

                    </div>
                    <span> ผู้เขียน : {{ $review->user->name }}</span>
                </div>
            </div>
            <div class="col-md-10 mb-3">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card  d-flex align-items-center shadow-sm rounded border-primary">
                            <div class="card-body ">
                                <div class="mt-3 ">
                                    <h5>สาขาวิชาเอกที่เกี่ยวข้อง : {{ $review->type }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-primary d-flex align-items-center shadow-sm rounded">
                            <div class="card-body ">
                                <div class="mt-3 ">
                                    <h5>การคัดเลือก : {{ $review->selection }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-primary d-flex align-items-center shadow-sm rounded">
                            <div class="card-body ">
                                <div class="mt-3 ">
                                    <h5>จังหวัด: {{ $review->province }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-10 ">
                <div class="card border-primary">
                    <div class="card-body">
                        <div class="fw-bold">
                        </div>

                        <div class="mt-3">
                            @foreach ($images as $item)
                                <img src="/image/{{ $item->img_name }}" alt="ไม่พบรูป" style="height:200px">
                            @endforeach
                        </div>
                        <div class="mb-3 text-thai">
                            {{ $review->task }}
                        </div>
                        <div class="mb-3 text-thai">
                            ประสบการณ์ :<br>
                            {{ $review->comment }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
