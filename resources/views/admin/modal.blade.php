@foreach ($report as $item)
    <div class="modal fade" id="modalDetail-{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">
                        การรายงานรีวิว
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="type" class="form-label fw-bold">หัวข้อการรายงาน</label>
                            <p style="text-indent: 2em;">{{ $item->report_topic }}</p>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="submajor" class="form-label fw-bold">คำอธิบายเพิ่มเติม</label>
                            <p style="text-indent: 2em; white-space: pre-line;">{{ $item->report_content ?? 'ไม่มี' }}
                            </p>
                        </div>
                        <div class="modal-footer ">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach
