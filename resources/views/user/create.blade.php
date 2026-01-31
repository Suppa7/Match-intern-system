@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="mt-4">
                    <h2 class="text-center fw-bold">Write the Review</h2>
                </div>
            </div>
            <div class="col-md-10 mt-3">
                <form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="mb-3">
                                <label for="company_name" class="form-label">ประเภทการฝึกงาน<span
                                        class="text-danger">*</span></label>
                                <select name="type" id="type" class="form-select">
                                    <option value=""disabled selected hidden>โปรดเลือกประเภท</option>
                                    @foreach (['ภาคฤดูร้อน','สหกิจ'] as $item)
                                        <option value="{{ $item }}">{{ $item }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="company_name" class="form-label">ชื่อสถานประกอบการ<span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="company_name" required>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">สาขาวิชาเอกที่เกี่ยวข้อง <span
                                        class="text-danger">*</span></label>
                                <select name="submajor" id="submajor" class="form-select" required>
                                    <option value="" disabled selected hidden>โปรดเลือกสาขา</option>
                                    @foreach (['Finance', 'Logist', 'BIS', 'Market', 'HR', 'Mice'] as $item)
                                        <option value="{{ $item }}">{{ $item }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="selection" class="form-label">การคัดเลือก<span
                                        class="text-danger">*</span></label>
                                <select name="selection" id="selection" class="form-select" required>
                                    <option value="" disabled selected hidden>โปรดเลือกสาขา</option>
                                    @foreach (['การสัมภาษณ์', 'การสอบ', 'การส่งผลงาน', 'ไม่มี'] as $item)
                                        <option value="{{ $item }}">{{ $item }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="province" class="form-label">จังหวัด<span class="text-danger">*</span></label>
                                <select name="province" id="province" class="select2-province">
                                    <option value="" selected hidden disabled>โปรดเลือกจังหวัดที่ฝึก</option>
                                    @foreach (config('provinces') as $item)
                                        <option value="{{ $item }}">{{ $item }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="task" class="form-label">ภาระงานที่ได้รับมอบหมาย<span
                                        class="text-danger">*</span></label>
                                <textarea name="task" id="task" rows="4" class="form-control" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="welfare" class="form-label">สวัสดิการ <span
                                        class="text-secondary">(เลือกได้มากกว่า 1 ข้อ)</span><span
                                        class="text-danger">*</span></label>
                                <select name="welfare[]" id="welfare" class="select2-welfare" multiple>
                                    @foreach (['มื้ออาหาร/เครื่องดื่ม', 'เครื่องแต่งกาย', 'เบี้ยเลี้ยง', 'รถรับส่ง','ประกันภัยต่าง ๆ','บริหาร/สิ่งอำนวยความสะดวก','ไม่มี'] as $item)
                                        <option value="{{ $item }}">{{ $item }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="file" class="form-label">รูปภาพการฝึกงาน <span
                                        class="text-secondary">(ไม่บังคับ)</span></label>
                                <input type="file" name="img[]" class="form-control" multiple>
                            </div>
                            <div class="mb-3">
                                <label for="score" class="d-block">ความพึงพอใจต่อสถานประกอบการ<span
                                        class="text-danger">*</span></label>
                                <div class="rating">
                                    @foreach ([5, 4, 3, 2, 1] as $item)
                                        <input type="radio" class="" name="score" id="score{{ $item }}"
                                            value="{{ $item }}" required>
                                        <label for="score{{ $item }}"></label>
                                    @endforeach
                                </div>
                            </div>
                            <div class="">
                                <label for="comment" class="form-label">ประสบการณ์ที่ได้รับ <span
                                        class="text-danger">*</span></label>
                                <textarea name="comment" id="comment" rows="3" class="form-control" required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="text-center mt-3">
                        <button type="submit" class="btn btn-success me-2">ยืนยัน</button>
                        <a href="{{ route('user.index') }}" class="btn btn-secondary">กลับสู่หน้าหลัก</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        // In your Javascript (external .js resource or <script> tag)
        $(document).ready(function() {
            $('.select2-province').select2({
                theme: 'bootstrap-5', // สำคัญ: ต้องระบุ Theme ตรงนี้
                placeholder: 'โปรดเลือกจังหวัดที่ฝึก',
                width: '100%'
            });
        });

        $(document).ready(function() {
            $('.select2-welfare').select2({
                theme: 'bootstrap-5', // สำคัญ: ต้องระบุ Theme ตรงนี้
                placeholder: 'โปรดเลือกสวัสดิการที่ได้รับ',
                width: '100%'
            });
        });
    </script>
@endsection
