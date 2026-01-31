@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="mt-4">
                    <h2 class="text-center fw-bold">Edit the Review</h2>
                </div>
            </div>
            <div class="col-md-10 mt-3">
                <form action="{{ route('user.update', ['id' => $id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card border">
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
                                        <option value="{{ $item }}" {{ $review->type == $item ? 'selected' :''}}>{{ $item }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="company_name" class="form-label">ชื่อสถานประกอบการ<span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="company_name"
                                    value="{{ $review->company_name }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="submajor" class="form-label">สาขาวิชาเอกที่เกี่ยวข้อง <span
                                        class="text-danger">*</span></label>
                                <select name="submajor" id="submajor" class="form-select" required>
                                    <option value="" disabled selected hidden>โปรดเลือกสาขา</option>
                                    @foreach (['Finance', 'Logist', 'BIS', 'Market', 'HR', 'Mice'] as $item)
                                        <option value="{{ $item }}" {{ $review->submajor == $item ? 'selected' : '' }}>
                                            {{ $item }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="selection" class="form-label">การคัดเลือก<span
                                        class="text-danger">*</span></label>
                                <select name="selection" id="selection" class="form-select" required>
                                    <option value="" disabled selected hidden>โปรดเลือกสาขา</option>
                                    @foreach (['การสัมภาษณ์', 'การสอบ', 'การส่งผลงาน', 'ไม่มี'] as $item)
                                        <option value="{{ $item }}"
                                            {{ $review->selection == $item ? 'selected' : '' }}>{{ $item }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="province" class="form-label">จังหวัด<span class="text-danger">*</span></label>
                                <select name="province" id="province" class="select2-province">
                                    <option value="" selected hidden disabled>โปรดเลือกจังหวัดที่ฝึก</option>
                                    @foreach (config('provinces') as $item)
                                        <option value="{{ $item }}"
                                            {{ $review->province == $item ? 'selected' : '' }}>{{ $item }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="task" class="form-label">ภาระงานที่ได้รับมอบหมาย<span
                                        class="text-danger">*</span></label>
                                <textarea name="task" id="task" rows="4" class="form-control" required>
                                    {{ $review->task }}
                                </textarea>
                            </div>
                            <div class="mb-3">
                                <label for="welfare" class="form-label">สวัสดิการ <span
                                        class="text-secondary">(เลือกได้มากกว่า 1 ข้อ)</span><span
                                        class="text-danger">*</span></label>
                                <select name="welfare[]" id="welfare" class="select2-welfare" multiple required>
                                    @foreach (['มื้ออาหาร/เครื่องดื่ม', 'เครื่องแต่งกาย', 'เบี้ยเลี้ยง', 'รถรับส่ง', 'ประกันภัยต่าง ๆ', 'บริหาร/สิ่งอำนวยความสะดวก', 'ไม่มี'] as $item)
                                        <option value="{{ $item }}" @selected(in_array($item, $reviewWelfare))>
                                            {{ $item }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-info">ตัวอย่างรูปภาพปัจจุบัน</label>
                                <div class="d-flex flex-wrap gap-2 mb-2">
                                    @if ($review->ImageReview && $review->ImageReview->count() > 0)
                                        {{-- สมมติว่า Relation ชื่อ images --}}
                                        @foreach ($review->ImageReview as $image)
                                            <div class="position-relative border p-1 rounded">
                                                {{-- แก้ไข $item เป็น $image --}}
                                                <img src="{{ asset('image/' . $image->img_name) }}" class="img-thumbnail"
                                                    style="width: 150px; height: 150px; object-fit: cover;">

                                                <div class="form-check mt-1">
                                                    {{-- Checkbox สำหรับลบ --}}
                                                    <input class="form-check-input" type="checkbox" name="delete_images[]"
                                                        value="{{ $image->id }}" id="del_img_{{ $image->id }}">
                                                    <label class="form-check-label text-danger"
                                                        for="del_img_{{ $image->id }}">
                                                        ลบรูปนี้
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <p class="text-danger">รีวิวนี้ยังไม่มีการเพิ่มรูปภาพ</p>
                                    @endif
                                </div>

                                <label for="file" class="form-label">เพิ่มรูปภาพใหม่ <span
                                        class="text-secondary">(เลือกเพิ่มได้หลายรูป)</span></label>
                                <input type="file" name="img[]" class="form-control" multiple accept="image/*">
                            </div>
                            <div class="">
                                <label for="score" class="d-block">ความพึงพอใจต่อสถานประกอบการ<span
                                        class="text-danger">*</span></label>
                                <div class="rating">
                                    @foreach ([5, 4, 3, 2, 1] as $item)
                                        <input type="radio" class="" name="score" id="score{{ $item }}"
                                            value="{{ $item }}" @checked($review->score == $item) required>
                                        <label for="score{{ $item }}"></label>
                                    @endforeach
                                </div>
                            </div>
                            <div class="mb-2">
                                <label for="comment" class="form-label">ประสบการณ์ที่ได้รับ <span
                                        class="text-danger">*</span></label>
                                <textarea name="comment" id="comment" rows="3" class="form-control" required>
                                    {{ $review->comment }}
                                </textarea>
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
                placeholder: 'โปรดเลือกจังหวัดที่ฝึก',
                width: '100%'
            });
        });
    </script>
@endsection
