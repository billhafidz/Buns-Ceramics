<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLanggananRequest;
use App\Http\Requests\UpdateLanggananRequest;
use App\Models\Langganan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LanggananController extends Controller
{
    public function index(Request $request)
    {
        if (session('user')) {
            redirect('/')->with('error', 'nyasar bang?');
        }
        if (!session('admin_logged_in')) {
            return redirect('/')->with('error', 'Mau ngapain bang');
        }

        $search = $request->input('search');

        $langganans = Langganan::when($search, function ($query) use ($search) {
            return $query->where('pilihan_subs', 'like', '%' . $search . '%')
                ->orWhere('penjelasan_subs', 'like', '%' . $search . '%')
                ->orWhere('harga_subs', 'like', '%' . $search . '%')
                ->orWhereJsonContains('benefit_subs', $search);
        })
            ->paginate(5)
            ->appends(['search' => $search]);

        return view('admin-buns.classes.index', compact('langganans', 'search'));
    }

    public function store(StoreLanggananRequest $request)
    {
        try {
            $data = $request->validated();
            
            // Handle benefit_subs - ensure it's properly formatted
            if (isset($data['benefit_subs']) && is_array($data['benefit_subs'])) {
                // Remove empty values
                $data['benefit_subs'] = array_filter($data['benefit_subs'], function($value) {
                    return !empty(trim($value));
                });
                
                // Re-index array to avoid gaps
                $data['benefit_subs'] = array_values($data['benefit_subs']);
                
                // Check if we still have benefits after filtering
                if (empty($data['benefit_subs'])) {
                    if ($request->ajax()) {
                        return response()->json([
                            'errors' => [
                                'benefit_subs' => ['At least one benefit is required.']
                            ]
                        ], 422);
                    }
                    return back()->withErrors(['benefit_subs' => 'At least one benefit is required.'])->withInput();
                }
                
                $data['benefit_subs'] = json_encode($data['benefit_subs']);
            }
            
            $data['status'] = 'active';

            // Handle image upload
            if ($request->hasFile('gambar_subs')) {
                $imagePath = $request->file('gambar_subs')->store('langganan_images', 'public');
                $data['gambar_subs'] = basename($imagePath);
            }

            Langganan::create($data);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Kelas berhasil ditambahkan.',
                    'redirect' => route('admin-buns.classes.index')
                ]);
            }

            return redirect()->route('admin-buns.classes.index')
                ->with('success', 'Kelas berhasil ditambahkan.');

        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'errors' => [
                        'general' => ['An error occurred while saving the class.']
                    ]
                ], 422);
            }
            
            return back()->withErrors(['general' => 'An error occurred while saving the class.'])->withInput();
        }
    }

    public function edit($id)
    {
        $langganan = Langganan::findOrFail($id);
        return view('admin-buns.classes.edit', compact('langganan'));
    }

    public function update(UpdateLanggananRequest $request, $id)
    {
        $langganan = Langganan::findOrFail($id);
        $data = $request->validated();
        
        // Handle benefit_subs
        if (isset($data['benefit_subs']) && is_array($data['benefit_subs'])) {
            $data['benefit_subs'] = array_filter($data['benefit_subs'], function($value) {
                return !empty(trim($value));
            });
            $data['benefit_subs'] = array_values($data['benefit_subs']);
            $data['benefit_subs'] = json_encode($data['benefit_subs']);
        }

        // Handle image removal
        if ($request->has('remove_image') && $request->remove_image == '1') {
            // Delete existing image if any
            if ($langganan->gambar_subs) {
                Storage::delete('public/langganan_images/' . $langganan->gambar_subs);
                $data['gambar_subs'] = null;
            }
        }

        // Handle new image upload
        if ($request->hasFile('gambar_subs')) {
            // Delete existing image if any
            if ($langganan->gambar_subs) {
                Storage::delete('public/langganan_images/' . $langganan->gambar_subs);
            }

            $imagePath = $request->file('gambar_subs')->store('langganan_images', 'public');
            $data['gambar_subs'] = basename($imagePath);
        }

        // Update status if provided
        if ($request->has('status')) {
            $langganan->status = $request->status;
        }

        $langganan->update($data);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Kelas berhasil diperbarui.',
                'redirect' => route('admin-buns.classes.index')
            ]);
        }

        return redirect()->route('admin-buns.classes.index')
            ->with('success', 'Kelas berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $langganan = Langganan::findOrFail($id);

        if ($langganan->gambar_subs) {
            Storage::delete('public/langganan_images/' . $langganan->gambar_subs);
        }

        $langganan->delete();

        return redirect()->route('admin-buns.classes.index')->with('success', 'Kelas berhasil dihapus.');
    }

    public function toggleStatus($id_langganan)
    {
        try {
            $langganan = Langganan::findOrFail($id_langganan);

            // Toggle status between active and deactive
            $langganan->status = ($langganan->status === 'active') ? 'deactive' : 'active';
            $langganan->save();

            $statusText = ucfirst($langganan->status);

            return redirect()->route('admin-buns.classes')->with('success', "Status Class berhasil diubah menjadi $statusText!");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}