<x-app-layout>
    <div class="container">
        <div class="container-fluid">
            <div class="row mx-lg-5 mx-md-0">
                <x-breadcrumb :links="[
                    ['url' => route('salary.index'), 'label' => 'Salary'],
                    ['url' => route('salary.create'), 'label' => 'Create Salary for Staff'],
                ]" />
            </div>
            <div class="row justify-content-center mx-1 px-1">
                <div class="col-md-12 col-lg-11 col-sm-12">
                    <div class="px-4 py-5 bg-white shadow-sm mb-5 rounded">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form action="{{ route('salary.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="staf_name">Staff:</label>
                                <select name="staff_id" id="staff_id" class="form-control">
                                    <option value="">--- Chọn nhân viên---</option>
                                    @foreach ($users as $key => $user)
                                        <option value="{{ $user->id }}" {{ old('staff_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('user_id'))
                                    <div style="color: red;">{{ $errors->first('user_id') }}</div>
                                @endif
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="month">Month:</label>
                                    <select name="month" id="month" class="form-control" required>
                                        <option></option>
                                        @for ($m = 1; $m <= 12; $m++)
                                            <option value="{{ $m }}" {{ old('month') == $m ? 'selected' : '' }}>{{ $m }}</option>
                                        @endfor
                                    </select>
                                    @if ($errors->has('month'))
                                        @foreach ($errors->get('month') as $message)
                                            <div style="color: red;">{{ $message }}</div>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="year">Year</label>
                                   <select name="year" id="year" class="form-control" required>
                                    <option value=""></option>
                                        @for ($y = date('Y') - 10; $y <= date('Y'); $y++)
                                            <option value="{{ $y }}" {{ old('year') == $y ? 'selected' : '' }}>{{ $y }}</option>
                                        @endfor
                                    </select>
                                    @if ($errors->has('year'))
                                        <div style="color: red;">{{ $errors->first('year') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="base_salary">Lương cơ bản</label>
                                <input type="number" class="form-control money" id="base_salary" name="base_salary" required oninput="calculateTotalSalary()">
                                @if ($errors->has('base_salary'))
                                    <div style="color: red;">{{ $errors->first('base_salary') }}</div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="allowance">Phụ cấp</label>
                                <input type="number" class="form-control money" id="allowance" name="allowance" required oninput="calculateTotalSalary()">
                                @if ($errors->has('allowance'))
                                    <div style="color: red;">{{ $errors->first('allowance') }}</div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="deduction">Khấu trừ</label>
                                <input type="number" class="form-control money" id="deduction" name="deduction" required oninput="calculateTotalSalary()">
                                @if ($errors->has('deduction'))
                                    <div style="color: red;">{{ $errors->first('deduction') }}</div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="totalSalary">Total Salary:</label>
                                <label id="totalSalary">0</label>
                            </div>
                            <button type="submit" class="btn btn-primary">Create</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @if (session('success'))
            <div class="alert alert-success mt-2" id="success-message">
                {{ session('success') }}
            </div>
        @endif
    </div>
</x-app-layout>

<script>
    function calculateTotalSalary() {
        // Lấy giá trị từ các trường input
        const baseSalary = parseFloat(document.getElementById('base_salary').value) || 0;
        const allowances = parseFloat(document.getElementById('allowance').value) || 0;
        const deductions = parseFloat(document.getElementById('deduction').value) || 0;

        // Tính toán tổng lương
        const totalSalary = baseSalary + allowances - deductions;

        // Cập nhật label tổng lương
        document.getElementById('totalSalary').innerText = totalSalary.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' });
    }

    @if (session('redirect'))
        // Hiển thị thông báo tạm thời
        setTimeout(function() {
            document.getElementById('success-message').style.display = 'none';
            window.location.href = "{{ route('customers.index') }}";
        }, 500); // 3 giây
    @endif
</script>