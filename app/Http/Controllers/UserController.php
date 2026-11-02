<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.user.index', compact('users'));
    }

    public function store(Request $request)
    {
        $messages = [
            'image.image' => 'Field image harus berupa file gambar.',
            'image.mimes' => 'Field image hanya boleh berupa file dengan format: jpeg, jpg, atau png.',
            'image.max' => 'Ukuran file pada field image tidak boleh lebih dari 1 MB.',
            'email.required' => 'Field email wajib diisi.',
            'email.email' => 'Field email harus berisi alamat email yang valid.',
            'email.max' => 'Field email tidak boleh lebih dari 255 karakter.',
            'email.unique' => 'Field email sudah terdaftar. Silakan gunakan email lain.',
        ];

        $request->validate([
            'image' => 'image|mimes:jpeg,jpg,png|max:1024',
            'email' => 'required|email|max:255|unique:users',
        ], $messages);

        // Upload dan simpan gambar
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('profil-pic', 'public');
        } else {
            $imagePath = 'profil-pic/default.jpg';
        }

        // Simpan data ke dalam database
        $data = $request->only(['nama', 'alamat', 'email', 'role_id']);
        $data['image'] = $imagePath;
        $data['password'] = Hash::make('password');
        $data['is_active'] = 1;
        User::create($data);

        return redirect()->back()->with('success', 'User berhasil ditambahkan!');
    }

    public function show(User $user)
    {
        return json_encode($user);
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $messages = [
            'image.image' => 'Field image harus berupa file gambar.',
            'image.mimes' => 'Field image hanya boleh berupa file dengan format: jpeg, jpg, atau png.',
            'image.max' => 'Ukuran file pada field image tidak boleh lebih dari 1 MB.',
        ];

        $request->validate([
            'image' => 'image|mimes:jpeg,jpg,png|max:1024',
        ], $messages);

        // Simpan data ke dalam database
        $data = $request->only(['nama', 'alamat', 'email', 'role_id']);

        if ($request->file('image')) {
            if ($request->oldImage && $request->oldImage <> 'profil-pic/default.jpg') {
                Storage::delete($request->oldImage);
            }
            $imagePath = $request->file('image')->store('profil-pic');
            $data['image'] = $imagePath;
        }
        $data['is_active'] = $request->status;

        User::where('id', $user->id)->update($data);

        return redirect()->back()->with('success', 'User berhasil diupdate!');
    }

    public function destroy(User $user)
    {
        if ($user->image && $user->image <> 'profil-pic/default.jpg') {
            Storage::delete($user->image);
        }
        User::destroy('id', $user->id);
        return redirect()->back()->with('success', 'User berhasil dihapus.');
    }

    public function resetPassword(User $user)
    {
        User::where('id', $user->id)->update(['password' => Hash::make('password')]);
        return redirect()->route('admin.master.user.index')->with('success', 'Password berhasil direset');
    }
}