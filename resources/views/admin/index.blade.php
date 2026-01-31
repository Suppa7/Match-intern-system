@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="mt-5">
                    <h2 class="text-center fw-bold"> โปรดเลือกเมนูที่ต้องการดำเนินการ
                    </h2>
                </div>
            </div>
            {{-- Search --}}

            @if (session('success'))
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: "{{ session('success') }}",
                        timer: 1500
                    })
                </script>
            @endif
            <div class="col-md-10 mt-5 mx-auto">
                <div class="row">
                    {{-- Total Review --}}
                    <div class="col-md-6">
                        <div class="card lightBlueGradient">
                            <div class="card-body">
                                <a href="{{ route('admin.report') }}" class="btn d-flex align-items-center">
                                    <i class='bxr  bx-news me-2'></i> การรายงานรีวิว
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card lightBlueGradient">
                            <div class="card-body">
                               <a href="{{ route('admin.user') }}" class="btn d-flex align-items-center">
                                    <i class='bxr  bx-user-square me-2'></i> การจัดการผู้ใช้งาน
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
