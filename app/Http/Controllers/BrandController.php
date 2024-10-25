<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;

class BrandController extends Controller
{
    use ValidatesRequests;

    /**
     * Display a listing of the brands.
     *
     * @return View|Factory
     */
    public function index(): View|Factory
    {
        $brands = Brand::all();
        return view('brand.index', compact('brands'));
    }

    /**
     * Store a newly created brand in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required|string|max:100|unique:brand,name',
        ]);

        Brand::create(['name' => $request->name]);

        Alert::success('Success', 'Brand successfully created');
        return redirect()->route('brand.index');
    }

    /**
     * Display the specified brand.
     *
     * @param  int  $id
     * @return View|Factory
     */
    // public function show(int $id): View|Factory
    // {
    //     $brand = Brand::findOrFail($id);
    //     return view('brand.show', compact('brand'));
    // }

    /**
     * Update the specified brand in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return RedirectResponse
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required|string|max:100|unique:brand,name,' . $id,
        ]);

        $brand = Brand::findOrFail($id);
        $brand->update(['name' => $request->name]);

        Alert::success('Success', 'Brand successfully updated');
        return redirect()->route('brand.index');
    }

    /**
     * Remove the specified brand from storage.
     *
     * @param  int  $id
     * @return RedirectResponse
     */
    public function destroy($id)
    {
        try {
            $brand = Brand::findOrFail($id);
            $brand->delete();

            Alert::success('Success', 'Data Brand Berhasil Dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            // Memeriksa kode error 1451, yaitu constraint violation karena relasi foreign key
            if ($e->getCode() == 23000) {
                Alert::error('Error', 'Data Brand Tidak Bisa Dihapus Karena Masih Berelasi dengan Data Lain');
            } else {
                Alert::error('Error', 'Terjadi Kesalahan saat Menghapus Data Brand');
            }
        }

        return redirect()->route('brand.index');
    }

}
