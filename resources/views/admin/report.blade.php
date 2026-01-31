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
                <div class="">
                    <table class="table table-bordered table-hover ">
                        <thead class="table table-dark text-center">
                            <th>ลำดับ</th>
                            <th>ชื่อหัวข้อ</th>
                            <th>ผู้รายงาน</th>
                            <th>รายละเอียด</th>
                            <th>รีวิว</th>
                            <th>เพิ่มเติม</th>
                        </thead>
                        <tbody>
                            @forelse($report as $items)
                                <tr class="align-middle">
                                    <td class="text-center"> {{ $loop->iteration }}</td>
                                    <td> {{ $items->review->company_name }}</td>
                                    <td class="text-center"> {{ $items->user->name }} ({{ $items->user->student_id }})</td>
                                    <td class="text-center">
                                        <a type="button" data-bs-toggle="modal"
                                            data-bs-target="#modalDetail-{{ $items->id }}"
                                            class="btn btn-info btn-sm d-inline-flex align-items-center justify-content-center">
                                            <i class='bx bx-eye-alt me-2'></i>
                                            <span>show detail</span>
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.show', ['id' => $items->review->id]) }}"
                                            class="btn btn-info btn-sm d-inline-flex align-items-center justify-content-center">
                                            <i class='bxr  bx-search-alt'></i>
                                            <span>show review</span>
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        <div class="dropdown ms-auto">
                                            <button type="button" class="btn p-0 " data-bs-toggle="dropdown">
                                                <i class="icon-base bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu ">
                                                <form
                                                    action="{{ route('admin.delete_review', ['id' => $items->id]) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Are you sure you want to delete this curriculums?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger d-flex align-items-center text-primary">
                                                        <i class="icon-base bx bx-trash me-1"></i> Delete Review
                                                    </button>
                                                </form>
                                                <a class="dropdown-item d-flex align-items-center text-primary"
                                                    href="{{ route('user.myfavor', ['id' => $items->id]) }}">
                                                    <i class='bxr  bx-undo me-1'></i>  Delete report
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">ไม่พบการรายงานรีวิว</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @include('admin.modal')
@endsection
