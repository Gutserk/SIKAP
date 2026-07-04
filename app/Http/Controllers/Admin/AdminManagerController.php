<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\Password;

use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminManagerController extends Controller
{
    public function index(Request $request)
    {
        $query = Admin::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'oldest':
                    $query->oldest();
                    break;
                case 'name_asc':
                    $query->orderBy('nama_lengkap', 'asc');
                    break;
                case 'newest':
                default:
                    $query->latest();
                    break;
            }
        } else {
            $query->latest();
        }

        $admins = $query->paginate(10)->withQueryString();

        return view('admin.admins.index', compact('admins'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:100',
            'email'     => 'required|string|email|max:150|ends_with:@batam.go.id|unique:admin',
            'password'  => [
                'required',
                'string',
                Password::min(8)->letters()->mixedCase()->numbers()->symbols(),
            ],
            'password_confirmation' => [
                'required',
                'same:password',
            ],
        ], [
            'full_name.required'  => 'Nama lengkap wajib diisi.',
            'full_name.max'       => 'Nama lengkap maksimal 100 karakter.',
            'email.required'      => 'Email wajib diisi.',
            'email.email'         => 'Format email tidak valid.',
            'email.max'           => 'Email maksimal 150 karakter.',
            'email.unique'        => 'Email ini sudah terdaftar.',
            'email.ends_with'     => 'Email harus menggunakan domain @batam.go.id.',
            'password.required'   => 'Password wajib diisi.',
            'password_confirmation.required' => 'Konfirmasi password wajib diisi.',
            'password_confirmation.same'     => 'Konfirmasi password tidak cocok.',
        ]);

        $admin = Admin::create([
            'nama_lengkap' => $request->full_name,
            'email'        => $request->email,
            'kata_sandi'   => Hash::make($request->password),
        ]);

        Log::channel('audit')->info('Admin account created', [
            'new_admin_id'    => $admin->id,
            'new_admin_email' => $admin->email,
            'created_by'      => auth('admin')->id(),
            'created_by_email'=> auth('admin')->user()->email,
            'ip'              => $request->ip(),
        ]);

        return redirect()->route('admin.admins.index')->with('success', 'Admin berhasil ditambahkan.');
    }

    public function update(Request $request, Admin $admin)
    {
        $request->validate([
            'full_name' => 'required|string|max:100',
            'email'     => 'required|string|email|max:150|ends_with:@batam.go.id|unique:admin,email,' . $admin->id,
            'password'  => [
                'nullable',
                'string',
                Password::min(8)->letters()->mixedCase()->numbers()->symbols(),
            ],
            'password_confirmation' => [
                'nullable',
                'required_with:password',
                'same:password',
            ],
        ], [
            'full_name.required' => 'Nama lengkap wajib diisi.',
            'full_name.max'      => 'Nama lengkap maksimal 100 karakter.',
            'email.required'     => 'Email wajib diisi.',
            'email.email'        => 'Format email tidak valid.',
            'email.max'          => 'Email maksimal 150 karakter.',
            'email.unique'       => 'Email ini sudah terdaftar oleh admin lain.',
            'email.ends_with'    => 'Email harus menggunakan domain @batam.go.id.',
            'password_confirmation.required_with' => 'Konfirmasi password wajib diisi.',
            'password_confirmation.same'          => 'Konfirmasi password tidak cocok.',
        ]);

        $data = [
            'nama_lengkap' => $request->full_name,
            'email'        => $request->email,
        ];

        if ($request->filled('password')) {
            $data['kata_sandi'] = Hash::make($request->password);
            Log::channel('audit')->warning('Admin password changed', [
                'target_admin_id'    => $admin->id,
                'target_admin_email' => $admin->email,
                'changed_by'         => auth('admin')->id(),
                'changed_by_email'   => auth('admin')->user()->email,
                'ip'                 => $request->ip(),
            ]);
        }

        $admin->update($data);

        Log::channel('audit')->info('Admin account updated', [
            'target_admin_id'    => $admin->id,
            'target_admin_email' => $admin->email,
            'updated_by'         => auth('admin')->id(),
            'updated_by_email'   => auth('admin')->user()->email,
            'ip'                 => $request->ip(),
        ]);

        return redirect()->route('admin.admins.index')->with('success', 'Data admin berhasil diperbarui.');
    }

    public function destroy(Admin $admin)
    {
        if (auth('admin')->id() === $admin->id) {
            return redirect()->route('admin.admins.index')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        Log::channel('audit')->warning('Admin account deleted', [
            'deleted_admin_id'    => $admin->id,
            'deleted_admin_email' => $admin->email,
            'deleted_by'          => auth('admin')->id(),
            'deleted_by_email'    => auth('admin')->user()->email,
            'ip'                  => request()->ip(),
        ]);

        $admin->delete();

        return redirect()->route('admin.admins.index')->with('success', 'Admin berhasil dihapus.');
    }
}
