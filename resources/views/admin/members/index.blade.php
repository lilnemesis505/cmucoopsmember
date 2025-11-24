@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-people-fill"></i> จัดการข้อมูลสมาชิก</h2>
        <a href="{{ route('admin.members.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> เพิ่มสมาชิกรายคน
        </a>
    </div>

    {{-- ส่วน Import Excel --}}
    <div class="card mb-4 border-success">
        <div class="card-header bg-success text-white">
            <i class="bi bi-file-earmark-spreadsheet"></i> นำเข้าข้อมูลจาก Excel
        </div>
        <div class="card-body">
            <form action="{{ route('admin.members.import') }}" method="POST" enctype="multipart/form-data" class="row align-items-center">
                @csrf
                <div class="col-auto">
                    <label>เลือกไฟล์ Excel (.xlsx, .csv):</label>
                </div>
                <div class="col-auto">
                    <input type="file" name="file" class="form-control" required>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-success">Upload & Import</button>
                </div>
                <div class="col-auto"><button type="button" class="btn btn-danger me-2" data-bs-toggle="modal" data-bs-target="#clearDataModal">
            <i class="bi bi-trash-fill"></i> ล้างข้อมูลทั้งหมด
        </button></div>
            </form>
            <small class="text-muted">* คำเตือน ในการอัพโหลด excel ให้อัพทีละช่วงปี ไม่ให้อัพทีละหลายๆหน้า</small>
        </div>
    </div>

    {{-- ส่วนแสดงผล Error/Success --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

   {{-- ตารางข้อมูล --}}
    <div class="card shadow-sm">
        <div class="card-header bg-white py-3">
            <form action="{{ route('admin.members.index') }}" method="GET">
                <div class="row g-2">
                    {{-- 1. รหัสสมาชิก --}}
                    <div class="col-md-2">
                        <input type="text" name="member_id" class="form-control" 
                               placeholder="รหัสสมาชิก" 
                               value="{{ request('member_id') }}">
                    </div>

                    {{-- 2. ชื่อ --}}
                    <div class="col-md-3">
                        <input type="text" name="first_name" class="form-control" 
                               placeholder="ชื่อจริง" 
                               value="{{ request('first_name') }}">
                    </div>

                    {{-- 3. นามสกุล --}}
                    <div class="col-md-3">
                        <input type="text" name="last_name" class="form-control" 
                               placeholder="นามสกุล" 
                               value="{{ request('last_name') }}">
                    </div>

                    {{-- 4. เบอร์โทร --}}
                    <div class="col-md-3">
                        <input type="text" name="phone" class="form-control" 
                               placeholder="เบอร์โทรศัพท์" 
                               value="{{ request('phone') }}">
                    </div>

                    {{-- ปุ่มค้นหา --}}
                    <div class="col-md-1 d-grid">
                        <button class="btn btn-outline-primary" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </div>
                
                {{-- ปุ่มล้างค่าค้นหา (ถ้าต้องการ) --}}
                @if(request()->anyFilled(['member_id', 'first_name', 'last_name', 'phone']))
                <div class="mt-2 text-end">
                    <a href="{{ route('admin.members.index') }}" class="text-danger small text-decoration-none">
                        <i class="bi bi-x-circle"></i> ล้างการค้นหา
                    </a>
                </div>
                @endif
            </form>
        </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">รหัสสมาชิก</th>
                            <th scope="col">เลขบัตร ปชช.</th>
                            <th scope="col">ชื่อ - นามสกุล</th>
                            <th scope="col">ข้อมูลการสมัคร</th>
                            <th scope="col" style="width: 25%;">ที่อยู่</th>
                            <th scope="col">เบอร์โทร</th>
                            <th scope="col" class="text-end">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($members as $member)
                        <tr>
                            <td>{{ $members->firstItem() + $loop->index }}</td>
                            <td><span class="badge bg-secondary">{{ $member->member_id }}</span></td>
                            
                            {{-- เพิ่มเลขบัตรประชาชน --}}
                            <td>{{ $member->id_card ?? '-' }}</td>
                            
                            <td>
                                {{ $member->title_name }}{{ $member->first_name }} {{ $member->last_name }}
                            </td>

                            {{-- เพิ่มวันที่สมัครและสัญชาติ --}}
                            <td>
                                <div class="small text-muted">
                                    <i class="bi bi-calendar"></i> {{ $member->registry_date ?? '-' }}
                                </div>
                                <div class="small text-muted">
                                    <i class="bi bi-flag"></i> {{ $member->nation ?? '-' }}
                                </div>
                            </td>

                            {{-- รวมที่อยู่ให้แสดงในช่องเดียว --}}
                            <td>
                                <small class="text-muted" style="line-height: 1.4;">
                                    {{ $member->loc_addr }} 
                                    {{ $member->tambon ? 'ต.'.$member->tambon : '' }} 
                                    {{ $member->amphur ? 'อ.'.$member->amphur : '' }} 
                                    {{ $member->province ? 'จ.'.$member->province : '' }} 
                                    {{ $member->zip_code }}
                                </small>
                            </td>

                            <td>{{ $member->phone ?? '-' }}</td>
                            
                            <td class="text-end">
                                <button type="button" class="btn btn-sm btn-warning mb-1" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#editMemberModal"
                                {{-- ฝังข้อมูลลงในปุ่ม --}}
                                    data-id="{{ $member->id }}"
                                    data-member-id="{{ $member->member_id }}"
                                    data-id-card="{{ $member->id_card }}"
                                    data-title-name="{{ $member->title_name }}"
                                    data-first-name="{{ $member->first_name }}"
                                    data-last-name="{{ $member->last_name }}"
                                    data-nation="{{ $member->nation }}"
                                    data-registry-date="{{ $member->registry_date }}"
                                    data-phone="{{ $member->phone }}"
                                    data-loc-addr="{{ $member->loc_addr }}"
                                    data-tambon="{{ $member->tambon }}"
                                    data-amphur="{{ $member->amphur }}"
                                    data-province="{{ $member->province }}"
                                    data-zip-code="{{ $member->zip_code }}">
                                <i class="bi bi-pencil"></i>
                                </button>
                                <form action="{{ route('admin.members.destroy', $member->id) }}" method="POST" class="d-inline" onsubmit="return confirm('ยืนยันการลบข้อมูลสมาชิกรายนี้?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger mb-1">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox display-4 d-block mb-2"></i>
                                ไม่พบข้อมูลสมาชิก
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            {{ $members->links() }}
        </div>
    </div>
</div>
<div class="modal fade" id="clearDataModal" tabindex="-1" aria-labelledby="clearDataLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="clearDataLabel">
                    <i class="bi bi-exclamation-triangle-fill"></i> คำเตือน: ล้างข้อมูลทั้งหมด
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="{{ route('admin.members.truncate') }}" method="POST">
                @csrf
                @method('DELETE')
                
                <div class="modal-body">
                    <p class="text-danger fw-bold">คุณกำลังจะลบข้อมูลสมาชิก "ทั้งหมด" ออกจากระบบ!</p>
                    <p>ข้อมูลจะไม่สามารถกู้คืนได้ เพื่อความปลอดภัย กรุณากรอกรหัสผ่านของคุณเพื่อยืนยัน:</p>
                    
                    <div class="mb-3">
                        <label for="password" class="form-label">รหัสผ่าน Admin:</label>
                        <input type="password" class="form-control" name="password" required placeholder="กรอกรหัสผ่านของคุณ...">
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-danger">ยืนยันลบข้อมูลทั้งหมด</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="editMemberModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg"> {{-- ใช้ modal-lg เพื่อให้กว้างขึ้น --}}
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title"><i class="bi bi-pencil-square"></i> แก้ไขข้อมูลสมาชิก</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form id="editMemberForm" method="POST">
                @csrf
                @method('PUT')
                
                <div class="modal-body">
                    <div class="row g-3">
                        {{-- ข้อมูลส่วนตัว --}}
                        <div class="col-md-6">
                            <label class="form-label">รหัสสมาชิก</label>
                            <input type="text" class="form-control" name="member_id" id="modal_member_id">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">เลขบัตรประชาชน</label>
                            <input type="text" class="form-control" name="id_card" id="modal_id_card">
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">คำนำหน้า</label>
                            <input type="text" class="form-control" name="title_name" id="modal_title_name">
                        </div>
                        <div class="col-md-5">
                            <label class="form-label">ชื่อ</label>
                            <input type="text" class="form-control" name="first_name" id="modal_first_name">
                        </div>
                        <div class="col-md-5">
                            <label class="form-label">นามสกุล</label>
                            <input type="text" class="form-control" name="last_name" id="modal_last_name">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">วันสมัคร</label>
                            <input type="text" class="form-control" name="registry_date" id="modal_registry_date" placeholder="วว/ดด/ปปปป">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">เบอร์โทรศัพท์</label>
                            <input type="text" class="form-control" name="phone" id="modal_phone">
                        </div>

                        <hr class="my-4">
                        <h6 class="text-muted mb-2">ที่อยู่</h6>

                        <div class="col-12">
                            <label class="form-label">ที่อยู่ (บ้านเลขที่/หมู่)</label>
                            <input type="text" class="form-control" name="loc_addr" id="modal_loc_addr">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">ตำบล</label>
                            <input type="text" class="form-control" name="tambon" id="modal_tambon">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">อำเภอ</label>
                            <input type="text" class="form-control" name="amphur" id="modal_amphur">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">จังหวัด</label>
                            <input type="text" class="form-control" name="province" id="modal_province">
                        </div>
                         <div class="col-md-3">
                            <label class="form-label">รหัสไปรษณีย์</label>
                            <input type="text" class="form-control" name="zip_code" id="modal_zip_code">
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-warning">บันทึกการแก้ไข</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- JavaScript เพื่อดึงค่าใส่ Modal --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var editMemberModal = document.getElementById('editMemberModal');
        editMemberModal.addEventListener('show.bs.modal', function (event) {
            // ปุ่มที่กดเปิด Modal
            var button = event.relatedTarget;
            
            // ดึง ID เพื่อสร้าง Action URL
            var id = button.getAttribute('data-id');
            
            // อัปเดต Action ของ Form ให้ชี้ไปที่ Route Update ที่ถูกต้อง
            // เช่น /admin/members/13203
            var form = document.getElementById('editMemberForm');
            form.action = '/admin/members/' + id; 

            // ดึงข้อมูลจาก data-attributes ใส่ลงใน Input
            document.getElementById('modal_member_id').value = button.getAttribute('data-member-id');
            document.getElementById('modal_id_card').value = button.getAttribute('data-id-card');
            document.getElementById('modal_title_name').value = button.getAttribute('data-title-name');
            document.getElementById('modal_first_name').value = button.getAttribute('data-first-name');
            document.getElementById('modal_last_name').value = button.getAttribute('data-last-name');
            document.getElementById('modal_registry_date').value = button.getAttribute('data-registry-date');
            document.getElementById('modal_phone').value = button.getAttribute('data-phone');
            
            document.getElementById('modal_loc_addr').value = button.getAttribute('data-loc-addr');
            document.getElementById('modal_tambon').value = button.getAttribute('data-tambon');
            document.getElementById('modal_amphur').value = button.getAttribute('data-amphur');
            document.getElementById('modal_province').value = button.getAttribute('data-province');
            document.getElementById('modal_zip_code').value = button.getAttribute('data-zip-code');
        });
    });
</script>
@endsection