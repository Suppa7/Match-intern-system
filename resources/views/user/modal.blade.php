<div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">
                    FILTER <span class="text-secondary">(สามารถเลือกได้หลายข้อ)</span>
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('user.filter') }}" method="GET">
                @csrf
                <div class="modal-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="type" class="form-label">ประเภทการฝึกงาน</label>
                            <select name="type" id="type" class="form-select">
                                <option value="" disabled selected hidden>โปรดเลือกประเภท</option>
                                @foreach (['ภาคฤดูร้อน', 'สหกิจ'] as $item)
                                    <option value="{{ $item }}">{{ $item }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="submajor" class="form-label">วิชาเอก</label>
                            <select name="submajor" id="submajor" class="form-select">
                                <option value="" disabled selected hidden>โปรดเลือกสาขา</option>
                                @foreach (['Finance', 'Logist', 'BIS', 'Market', 'HR', 'Mice'] as $item)
                                    <option value="{{ $item }}">{{ $item }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mt-3">
                            <label for="province" class="form-label">จังหวัด</label>
                            <select name="province" id="province" class="select2-province">
                                <option value="" selected hidden disabled>โปรดเลือกจังหวัดที่ฝึก</option>
                                @foreach (config('provinces') as $item)
                                    <option value="{{ $item }}">{{ $item }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mt-3">
                            <label for="year" class="form-label">ปีที่ริวิว</label>
                            <select name="year" id="year" class="form-select">
                                <option value="" disabled selected hidden>โปรดเลือกปี</option>
                                @for ($i = now()->year; $i >= now()->year - 2; $i--)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-6 mt-3">
                            <label for="score">คะแนนรีวิว</label>
                            <select name="score" id="score" class="form-select">
                                <option value="" disabled selected hidden>โปรดเลือกคะแนน</option>
                                @for ($i = 1; $i <= 5; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-6 mt-3">
                            <label for="">สวัสดิการ</label>
                            <select name="welfare" id="welfare" class="form-select">
                                <option value="" disabled selected hidden>โปรดเลือกสวัสดิการ</option>
                                @foreach (['มื้ออาหาร/เครื่องดื่ม', 'เครื่องแต่งกาย', 'เบี้ยเลี้ยง', 'รถรับส่ง', 'ประกันภัยต่าง ๆ', 'บริหาร/สิ่งอำนวยความสะดวก', 'ไม่มี'] as $item)
                                    <option value="{{ $item }}">{{ $item }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="modal-footer mt-5">
                            <button type="submit" class="btn btn-primary">Confirm</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>

@foreach ($review as $item)
    <div class="modal fade" id="reportModal-{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">
                        Report
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('user.report', ['id' => $item->id]) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row mb-4">
                            <div class="col-md-12 mb-3">
                                <label for="report_topic" class="form-label">หัวข้อการรายงาน <span
                                        class="text-danger">*</span></label>
                                <select name="report_topic" id="report_topic" class="form-select">
                                    <option value="" disabled selected hidden>โปรดเลือกหัวข้อ</option>
                                    @foreach (['ใช้ภาษาที่ไม่เหมาะสม/ส่อเสียด', 'เนื้อหาไม่สอดคล้องกัน', 'การใช้รูปภาพที่ไม่เหมาะสม', 'อื่น ๆ'] as $item)
                                        <option value="{{ $item }}">{{ $item }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="type" class="form-label">คำอธิบายเพิ่มเติม</label>
                                <textarea name="report_content" id="report_content" rows="5" class="form-control"></textarea>
                            </div>
                            <div class="modal-footer ">
                                <button type="submit" class="btn btn-primary">Confirm</button>
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endforeach

<script type="text/javascript">
    // In your Javascript (external .js resource or <script> tag)
    $(document).ready(function() {
        $('.select2-province').select2({
            theme: 'bootstrap-5', // สำคัญ: ต้องระบุ Theme ตรงนี้
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
