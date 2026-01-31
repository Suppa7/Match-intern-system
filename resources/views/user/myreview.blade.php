@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class=" mt-3">
                    <a href="{{ route('user.index') }}" class="btn btn-secondary ">
                        <div class="d-flex align-items-center">
                            <i class='bxr  bx-chevrons-left'></i> กลับสู่หน้าหลัก
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-md-8">
                <div class="mt-5">
                    <h2 class="text-center fw-bold">My Review</h2>
                </div>
            </div>
            <div class="col-md-10 mt-5 mx-auto">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card mb-3">
                            <div class="card-body text-center">
                                <h5>ข้อมูลส่วนตัว</h5>
                                <img src="https://icons.veryicon.com/png/o/miscellaneous/standard/avatar-15.png"
                                    height="50px" alt="avatar icon">
                                <div class="">
                                    <p>Name : {{ Auth::user()->name }} </p>
                                    <p>Student ID : {{ Auth::user()->student_id }}</p>
                                </div>
                            </div>
                        </div>

                        {{-- 2. ปุ่มเมนู (ย้ายมาไว้ตรงนี้ ต่อจาก Profile) --}}
                        <div class="d-grid gap-2"> {{-- ใช้ d-grid gap-2 แทน a-full เพื่อให้ปุ่มเต็มและเว้นระยะ --}}
                            <a href="{{ route('user.create') }}" class="btn btn-outline-primary">
                                <i class='bx bx-edit-alt'></i> Write the Review
                            </a>
                            <a href="{{ route('user.myreview') }}" class="btn btn-outline-primary">
                                <i class='bx bx-file-detail'></i> My Review
                            </a>
                            <a href="{{ route('user.favorite_page') }}" class="btn btn-outline-primary">
                                <i class='bx bx-star'></i> My Favorite
                            </a>
                        </div>
                    </div>
                    {{-- Total Review --}}
                    <div class="col-md-8">
                        <div class="card lightBlueGradient">
                            <div class="card-body">
                                @forelse ($review as $item)
                                    <div class="card h-100 shadow-sm mb-3">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-3">
                                                <h5 class="card-title fw-bold m-0 me-2">{{ $item->company_name }}</h5>
                                                <span class="badge text-bg-primary me-1">{{ $item->type }}</span>
                                                <span class="badge text-bg-info">{{ $item->created_at->format('Y') }}</span>
                                                <div class="dropdown ms-auto">
                                                    <button type="button" class="btn p-0 " data-bs-toggle="dropdown">
                                                        <i class="icon-base bx bx-dots-vertical-rounded"></i>
                                                    </button>
                                                    <div class="dropdown-menu ">
                                                        <a class="dropdown-item d-flex align-items-center text-warning"
                                                            href="{{ route('user.myfavor', ['id' => $item->id]) }}">
                                                            @if ($item->UserFavorite)
                                                                <i class='bx  bx-star me-2'></i> remove from My favorite
                                                            @else
                                                                <i class='bx  bx-star me-2'></i> add to My favorite
                                                            @endif
                                                        </a>
                                                        @if($item->user_id == Auth::user()->id)
                                                            <a class="dropdown-item d-flex align-items-center text-primary"
                                                                href="{{ route('user.edit', ['id' => $item->id]) }}">
                                                                    <i class='bxr  bx-edit me-2'></i> edit
                                                            </a>
                                                        @endif
                                                        <a href="" 
                                                            class="dropdown-item text-danger d-flex align-items-center">
                                                            <i class='bxr  bx-block me-2'></i> Report
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center">

                                                <div class="rating-show">
                                                    @foreach (range(1, 5) as $score)
                                                        {{-- เช็คเงื่อนไขง่ายๆ: ถ้ารอบปัจจุบัน ($score) น้อยกว่าหรือเท่ากับคะแนนที่มี ให้เป็นสีส้ม --}}
                                                        <span
                                                            class="star {{ $item->score >= $score ? 'active' : '' }}">&#9733;</span>
                                                    @endforeach
                                                </div>
                                                <a href="{{ route('user.show', ['id' => $item->id]) }}"
                                                    class="btn btn-primary btn-sm">
                                                    Detail
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="card h-100 shadow-sm mb-3">
                                        <div class="card-body d-flex justify-content-center align-items-center">
                                            <a href="{{ route('user.create') }}"
                                                class="btn btn-outline-secondary d-flex align-items-center">
                                                <i class='bxr bx-plus-circle me-2'></i> Write the Review
                                            </a>
                                        </div>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                        {{-- ย้ายมาไว้ตรงนี้ (ใน col-md-8 แต่รูดลงมาจาก card นิดนึง) --}}
                        <div class="mt-3">
                            {{ $review->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
