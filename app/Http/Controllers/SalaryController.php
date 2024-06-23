<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Salary;
use App\Models\Task;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Exports\CustomersExport;
use App\Exports\SalaryExport;
use Maatwebsite\Excel\Facades\Excel;


class SalaryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Salary::query();
        if ($search = $request->input('search')) {
            $query->where('month', 'like', "%{$search}%")
                ->orWhere('year','like', "%{$search}%")
                ->orWhereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
        }
        $salary = $query->get();

        return view('user.accountant.salary.index-salary', compact('salary'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        return view('user.accountant.salary.create-salary', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'staff_id'=>'required|int|max:255',
            'month'=>'required|int|max:12',
            'year'=>'required|int|max:2100',
            'base_salary'=>'required|int',
            'allowance'=>'required|int',
            'deduction'=>'required|int',
        ]);

        $salary = new Salary();
        $salary->user_id = $validatedData['staff_id'];
        $salary->year = $validatedData['year'];
        $salary->month = $validatedData['month'];
        $salary->base_salary = $validatedData['base_salary'];
        $salary->allowances = $validatedData['allowance'];
        $salary->deductions = $validatedData['deduction'];
        $salary->total_salary = $validatedData['base_salary'] + $validatedData['allowance'] - $validatedData['deduction'];
        $salary->save();
        return redirect()->route('salary.index')->with('success', 'Salary created successfully.');

    }

    /**
     * Display the specified resource.
     */
    public function show(Salary $salary)
    {
        $salary = Salary::findOrFail($salary->id);
         return view('user.accountant.salary.show-salary', compact('salary'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Salary $salary)
    {
        $salary = Salary::findOrFail($salary->id);
        $users = User::all();
         return view('user.accountant.salary.edit-salary', compact('salary', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Salary$salary)
    {
        $validatedData = $request->validate([
            'staff_id'=>'required|int|max:255',
            'month'=>'required|int|max:12',
            'year'=>'required|int|max:2100',
            'base_salary'=>'required|int',
            'allowance'=>'required|int',
            'deduction'=>'required|int',
        ]);

        $salary->user_id = $validatedData['staff_id'];
        $salary->year = $validatedData['year'];
        $salary->month = $validatedData['month'];
        $salary->base_salary = $validatedData['base_salary'];
        $salary->allowances = $validatedData['allowance'];
        $salary->deductions = $validatedData['deduction'];
        $salary->total_salary = $validatedData['base_salary'] + $validatedData['allowance'] - $validatedData['deduction'];
        $salary->update();
        return redirect()->route('salary.index')->with('success', 'Salary update successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Salary $salary)
    {
        $salary->delete();
        return redirect()->route('salary.index')->with('success', 'Salary deleted successfully.');
    }

     public function export(Request $request)
    {
      $month = $request->input('monthexport');
      $year = $request->input('yearexport');
     return Excel::download(new SalaryExport($month, $year), "bang_luong_thang_ {$month} _nam_ {$year}.xlsx");
    }
}
