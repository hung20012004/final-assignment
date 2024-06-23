<!-- resources/views/salaries/index.blade.php -->
<x-app-layout>
    <div class="container">
        <div class="row mt-3">
            <div class="col">
                <x-breadcrumb :links="[
                    ['url' => route('salary.index'), 'label' => 'Salaries'],
                ]" />
            </div>
        </div>
        <div class="row justify-content-center mt-2 mb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Quản lý bảng lương</h5>
                            <div>
                                <a href="{{ route('salary.create') }}" class="btn btn-primary">Tạo mới</a>
                                <button class="btn btn-success" data-toggle="modal" data-target="#exportModal">Xuất Excel</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Existing code -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exportModal" tabindex="-1" role="dialog" aria-labelledby="exportModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exportModalLabel">Xuất bảng lương</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('salary.export') }}" method="GET">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="month">Tháng</label>
                            <select name="month" id="month" class="form-control" required>
                                @for ($m = 1; $m <= 12; $m++)
                                    <option value="{{ $m }}">{{ $m }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="year">Năm</label>
                            <select name="year" id="year" class="form-control" required>
                                @for ($y = date('Y') - 10; $y <= date('Y'); $y++)
                                    <option value="{{ $y }}">{{ $y }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-success">Xuất</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>