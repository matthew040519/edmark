<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SupplierModel;

class SupplierController extends Controller
{
    //
    public function index()
    {

        $supplier = SupplierModel::all();

        return view('admin.supplier')->with('supplier', $supplier);

    }

    public function addsupplier(Request $request)
    {
        $supplier = new SupplierModel();
        $supplier->supplier_name = $request->supplier_name;
        $supplier->address = $request->address;
        $supplier->contact_number = $request->contact_number;
        $supplier->save();

        // return redirect('supplier');
        return redirect()->back()->with('status', 'Supplier Add Successfully');

    }

    public function updatesupplier(Request $request)
    {
        SupplierModel::where('id', $request->id)->update(['supplier_name' => $request->supplier_name, 'address' => $request->address, 'contact_number' => $request->contact_number]);

        return redirect()->back()->with('status', 'Supplier Updated Successfully');

    }
}
