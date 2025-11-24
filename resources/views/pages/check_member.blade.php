@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            
            <h2 class="text-center mb-4 fw-bold text-primary">
                <i class="bi bi-person-vcard"></i> ตรวจสอบสถานะสมาชิก
            </h2>

            {{-- การ์ดค้นหา --}}
            <div class="card shadow-sm mb-4 border-0">
                <div class="card-body bg-light p-4 rounded">
                    <form action="{{ route('check.member') }}" method="GET">
                        <h5 class="mb-3 text-secondary"><i class="bi bi-search"></i> ค้นหาข้อมูล</h5>
                        
                        <div class="row g-2">
                            <div class="col-md-2">
                                <label class="form-label small text-muted">รหัสสมาชิก</label>
                                <input type="text" name="member_id" class="form-control" placeholder="เช่น 132xx" value="{{ $member_id }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small text-muted">เลขบัตรประชาชน</label>
                                <input type="text" name="id_card" class="form-control" placeholder="เลข 13 หลัก" value="{{ $id_card }}">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label small text-muted">ชื่อจริง</label>
                                <input type="text" name="first_name" class="form-control" placeholder="ระบุชื่อ" value="{{ $first_name }}">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label small text-muted">นามสกุล</label>
                                <input type="text" name="last_name" class="form-control" placeholder="ระบุนามสกุล" value="{{ $last_name }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small text-muted">เบอร์โทรศัพท์</label>
                                <input type="text" name="phone" class="form-control" placeholder="08xxxxxxxx" value="{{ $phone }}">
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-primary px-5 rounded-pill shadow-sm">
                                    <i class="bi bi-search"></i> ค้นหาข้อมูล
                                </button>
                                @if($member_id || $id_card || $first_name || $last_name || $phone)
                                    <a href="{{ route('check.member') }}" class="btn btn-outline-secondary px-4 rounded-pill ms-2">
                                        ล้างค่า
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- ส่วนแสดงผลลัพธ์ --}}
            @if(isset($hasSearch) && $hasSearch)
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">ผลการค้นหา ({{ $members->total() }} รายการ)</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0 align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>รหัสสมาชิก</th>
                                        <th>ชื่อ - นามสกุล</th>
                                        <th>วันที่สมัคร</th>
                                        <th>จังหวัด</th>
                                        <th>เบอร์โทรศัพท์</th>
                                        <th>สถานะ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($members as $member)
                                    <tr>
                                        <td>
                                            <span class="badge bg-info text-dark" style="font-size: 0.9rem;">
                                                {{ $member->member_id }}
                                            </span>
                                        </td>
                                        <td>
                                            {{ $member->title_name }}{{ $member->first_name }} {{ $member->last_name }}
                                        </td>
                                        <td>
                                            <span class="text-muted">
                                                <i class="bi bi-calendar-event"></i> 
                                                {{ $member->registry_date ? \Carbon\Carbon::parse($member->registry_date)->format('d/m/Y') : '-' }}
                                            </span>
                                        </td>
                                        
                                        {{-- 1. แก้ไขจังหวัดให้เป็นปุ่มกด Popup --}}
                                        <td>
                                            <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3"
                                                data-bs-toggle="modal" 
                                                data-bs-target="#addressModal"
                                                data-name="{{ $member->title_name }}{{ $member->first_name }} {{ $member->last_name }}"
                                                data-addr="{{ $member->loc_addr }}"
                                                data-tambon="{{ $member->tambon }}"
                                                data-amphur="{{ $member->amphur }}"
                                                data-province="{{ $member->province }}"
                                                data-zip="{{ $member->zip_code }}">
                                                <i class="bi bi-geo-alt-fill"></i> {{ $member->province ?? 'ไม่ระบุ' }}
                                            </button>
                                        </td>
                                        
                                        {{-- 2. แก้ไขเบอร์โทรให้ลิงก์ถูกต้อง --}}
                                        <td>
    @if($member->phone)
        {{-- เปลี่ยนเป็น span ธรรมดา ไม่ต้องมี href --}}
        <span class="text-dark fw-bold">
            <i class="bi bi-telephone-fill text-success"></i> {{ $member->phone }}
        </span>
    @else
        <span class="text-muted">-</span>
    @endif
</td>
                                        <td>
                                            <span class="badge bg-success rounded-pill">ปกติ</span>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5 text-muted">
                                            <i class="bi bi-emoji-frown display-4 d-block mb-3"></i>
                                            <h5>ไม่พบข้อมูลที่ตรงกัน</h5>
                                            <p class="small">กรุณาตรวจสอบความถูกต้องของข้อมูลที่กรอก</p>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @if($members->count() > 0)
                    <div class="card-footer bg-white">
                        {{ $members->withQueryString()->links() }}
                    </div>
                    @endif
                </div>
            @endif

        </div>
    </div>
</div>

{{-- 3. Modal Popup แสดงที่อยู่ --}}
<div class="modal fade" id="addressModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="bi bi-house-door-fill"></i> รายละเอียดที่อยู่</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 text-center">
                <h5 class="fw-bold text-primary mb-3" id="modalName"></h5>
                <div class="p-3 bg-light rounded border">
                    <p class="mb-1 text-muted small">ที่อยู่จัดส่งเอกสาร</p>
                    <h5 class="mb-0" id="modalFullAddress"></h5>
                </div>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">ปิดหน้าต่าง</button>
            </div>
        </div>
    </div>
</div>

{{-- 4. Script สำหรับใส่ข้อมูลลง Modal --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var addressModal = document.getElementById('addressModal');
        addressModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            
            // ดึงข้อมูลจากปุ่ม
            var name = button.getAttribute('data-name');
            var addr = button.getAttribute('data-addr') || '-';
            var tambon = button.getAttribute('data-tambon') ? 'ต.' + button.getAttribute('data-tambon') : '';
            var amphur = button.getAttribute('data-amphur') ? 'อ.' + button.getAttribute('data-amphur') : '';
            var province = button.getAttribute('data-province') ? 'จ.' + button.getAttribute('data-province') : '';
            var zip = button.getAttribute('data-zip') || '';

            // รวมที่อยู่ให้สวยงาม
            var fullAddress = [addr, tambon, amphur, province, zip].filter(Boolean).join(' ');

            // ใส่ข้อมูลลงใน Modal
            document.getElementById('modalName').textContent = name;
            document.getElementById('modalFullAddress').textContent = fullAddress;
        });
    });
</script>
@endsection