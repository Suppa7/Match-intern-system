@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class=" mt-3">
                    <a href="{{ route('admin.index') }}" class="btn btn-secondary ">
                        <div class="d-flex align-items-center">
                            <i class='bxr  bx-chevrons-left'></i> กลับสู่หน้าหลัก
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-md-8">
                <div class="mt-5">
                    <h2 class="text-center fw-bold"> ผู้ใช้ในระบบทั้งหมด
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
                <div class="">
                    <table class="table table-bordered table-hover ">
                        <thead class="table table-dark text-center">
                            <th>ลำดับ</th>
                            <th>ชื่อผู้ใช้</th>
                            <th>รหัสนักศึกษา</th>
                            <th>เพิ่มเติม</th>
                        </thead>
                        <tbody>
                            @forelse($user as $items)
                                <tr class="align-middle">
                                    <td class="text-center"> {{ $loop->iteration }}</td>
                                    <td> {{ $items->name }}</td>
                                    <td class="text-center">{{ $items->student_id }}</td>
                                    <td class="text-center">
                                        <div class="dropdown ms-auto">
                                            <button type="button" class="btn p-0 " data-bs-toggle="dropdown">
                                                <i class="icon-base bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu ">
                                                <a href="{{ route('admin.user_edit',['id'=> $items->id]) }}" class="dropdown-item text-warning d-flex align-items-center">
                                                    <i class="bx bx-edit me-1"></i>แก้ไขข้อมูล
                                                </a>
                                                <form action="{{ route('admin.user_destroy', ['id' => $items->id]) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('แน่ใจว่าจะลบบัญชีนี้หรือไม่');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="dropdown-item text-danger d-flex align-items-center ">
                                                        <i class="icon-base bx bx-trash me-1"></i> ลบบัญชี
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">ไม่พบข้อมูลผู้ใช้งาน</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $user->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
