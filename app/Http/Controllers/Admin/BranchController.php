<?php

namespace App\Http\Controllers\Admin;

use App\Models\Branch;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function index()
    {
        $branches = Branch::all();
        return view('admin.branches.index', compact('branches'));
    }

    public function create()
    {
        return view('admin.branches.create');
    }

    public function store(Request $request)
    {
        return redirect()->route('admin.branches.index');
    }

    public function edit($id)
    {
        $branch = Branch::findOrFail($id);
        return view('admin.branches.edit', compact('branch'));
    }

    public function update(Request $request, $id)
    {
        return redirect()->route('admin.branches.index');
    }

    public function destroy($id)
    {
        return redirect()->route('admin.branches.index');
    }

    public function activate($id)
    {
        return redirect()->back();
    }

    public function deactivate($id)
    {
        return redirect()->back();
    }
}
