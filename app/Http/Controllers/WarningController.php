<?php

namespace App\Http\Controllers;

use App\Models\Warning;
use App\Models\WarningDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Student;

class WarningController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lecturer = Auth::user()->lecturer;

        $warning = Warning::with([
            'warning_detail.student',
            'student_class',
        ])->whereHas('student_class', function ($query) use ($lecturer) {
            $query->where('academic_advisor_id', $lecturer->lecturer_id);
        })->get();

        return view('masterdata.warnings.index', compact('warning'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();

        $students = Student::where('class_id', $user->lecturer->student_classes->class_id)->get();

        return view('masterdata.warnings.create', compact('students'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        
        try {
            $warning = Warning::firstOrCreate(['class_id' => $user->lecturer->student_classes->class_id]);

            $warningDetail = new WarningDetail();

            $warningDetail->warning_id = $warning->warning_id;
            $warningDetail->student_id = $request->input('student_id');
            $warningDetail->warning_type = $request->input('warning_type');
            $warningDetail->reason = $request->input('reason');

            $warningDetail->save();

            return redirect()->route('masterdata.warnings.index')->with('success', 'Peringatan berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()
                ->route('masterdata.warnings.index')
                ->with('error', 'System error: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Warning $warning)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $warningDetail = WarningDetail::find($id);

        return view('masterdata.warnings.edit', compact('warningDetail'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $warningDetail = WarningDetail::find($id);

        $validated = $request->validate([
            'warning_type' => 'required',
            'reason' => 'required',
        ]);

        try {
            $warningDetail->update($validated);

            return redirect()->route('masterdata.warnings.index')->with('success', 'Peringatan ' . $warningDetail->student->student_name . ' berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()
                ->route('masterdata.warnings.index')
                ->with('error', 'System error: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $warningDetail = WarningDetail::find($id);

        try {
            $warningDetail->delete();

            return redirect()->route('masterdata.warnings.index')->with('success', 'Peringatan berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('masterdata.warnings.index')->with('error', ' System error: ' . $e->getMessage());
        }
    }
}
