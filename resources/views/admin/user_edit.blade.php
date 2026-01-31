@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class=" mt-3">
                    <a href="{{ route('admin.user') }}" class="btn btn-secondary ">
                        <div class="d-flex align-items-center">
                            <i class='bxr  bx-chevrons-left'></i> กลับสู่หน้าหลัก
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-md-8">
                <div class="mt-5">
                    <h2 class="text-center fw-bold"> แก้ไขข้อมูลผู้ใช้งาน
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
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.user_update',['id'=>$id]) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <label for="" class="form-label">ชื่อผู้ใช้งาน</label>
                            <input type="text" class="form-control mb-3" name="name" id="name" value="{{ $user->name }}">
                            <label for="student_id" class="form-label">รหัสนักศึกษา</label>
                            <input type="text" class="form-control mb-3" name="student_id" id="student_id" value="{{ $user->student_id }}">
                            <div class="text-center">
                                <button class="btn btn-success">
                                    update
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
@endsection
