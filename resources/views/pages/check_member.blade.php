@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-12"> {{-- ขยายเป็น 12 เพื่อให้วาง 5 ช่องได้พอดี --}}
            
            <h2 class="text-center mb-4 fw-bold text-primary">
                <i class="bi bi-person-vcard"></i> ตรวจสอบสถานะสมาชิก
            </h2>

            {{-- การ์ดค้นหา --}}
            <div class="card shadow-sm mb-4 border-0">
                <div class="card-body bg-light p-4 rounded">
                    <form action="{{ route('check.member') }}" method="GET">
                        <h5 class="mb-3 text-secondary"><i class="bi bi-search"></i> ค้นหาข้อมูล</h5>
                        
                        <div class="row g-2">
                            {{-- 1. รหัสสมาชิก (col-2) --}}
                            <div class="col-md-2">
                                <label class="form-label small text-muted">รหัสสมาชิก</label>
                                <input type="text" name="member_id" class="form-control" 
                                       placeholder="เช่น 132xx" value="{{ $member_id }}">
                            </div>

                            {{-- 2. เลขบัตรประชาชน (col-3) เพิ่มใหม่ --}}
                            <div class="col-md-3">
                                <label class="form-label small text-muted">เลขบัตรประชาชน</label>
                                <input type="text" name="id_card" class="form-control" 
                                       placeholder="เลข 13 หลัก" value="{{ $id_card }}">
                            </div>

                            {{-- 3. ชื่อจริง (col-2) --}}
                            <div class="col-md-2">
                                <label class="form-label small text-muted">ชื่อจริง</label>
                                <input type="text" name="first_name" class="form-control" 
                                       placeholder="ระบุชื่อ" value="{{ $first_name }}">
                            </div>

                            {{-- 4. นามสกุล (col-2) --}}
                            <div class="col-md-2">
                                <label class="form-label small text-muted">นามสกุล</label>
                                <input type="text" name="last_name" class="form-control" 
                                       placeholder="ระบุนามสกุล" value="{{ $last_name }}">
                            </div>

                            {{-- 5. เบอร์โทร (col-3) --}}
                            <div class="col-md-3">
                                <label class="form-label small text-muted">เบอร์โทรศัพท์</label>
                                <input type="text" name="phone" class="form-control" 
                                       placeholder="08xxxxxxxx" value="{{ $phone }}">
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
                                        <th>เบอร์โทรศัพท์</th> {{-- เพิ่มหัวตาราง --}}
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
                                        <td>{{ $member->province }}</td>
                                        
                                        {{-- เพิ่มข้อมูลเบอร์โทร --}}
                                        <td>
                                            @if($member->phone)
                                                <a href="tel:{{ $member->phone }}" class="text-decoration-none text-dark">
                                                    <i class="bi bi-telephone"></i> {{ $member->phone }}
                                                </a>
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
@endsection