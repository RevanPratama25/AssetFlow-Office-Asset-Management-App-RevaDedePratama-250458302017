<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

class UserManager extends Component
{
    use WithPagination;

    // State Input
    public $name, $email, $password, $role = 'staf';
    public $user_id;
    
    // UI State
    public $isEditMode = false;
    public $showForm = false;
    public $search = '';

    protected function rules()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->user_id,
            'role' => 'required|in:admin,staf',
        ];

        // Password wajib hanya saat create
        if (!$this->isEditMode) {
            $rules['password'] = 'required|min:8';
        }

        return $rules;
    }

    public function render()
    {
        $users = User::where('name', 'like', '%' . $this->search . '%')
            ->orWhere('email', 'like', '%' . $this->search . '%')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.admin.user-manager', [
            'users' => $users
        ])->layout('components.admin-layout'); // Pastikan ini sesuai layout admin Anda
    }

    // --- CRUD LOGIC ---

    public function create()
    {
        $this->resetInputFields();
        $this->showForm = true;
        $this->isEditMode = false;
    }

    public function store()
    {
        $this->validate();

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'role' => $this->role,
        ]);

        session()->flash('message', 'User berhasil ditambahkan.');
        $this->cancel();
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->user_id = $id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->role;
        
        $this->isEditMode = true;
        $this->showForm = true;
    }

    public function update()
    {
        $this->validate();

        $user = User::findOrFail($this->user_id);
        
        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
        ];

        // Update password hanya jika diisi
        if (!empty($this->password)) {
            $data['password'] = Hash::make($this->password);
        }

        $user->update($data);

        session()->flash('message', 'User berhasil diperbarui.');
        $this->cancel();
    }

    public function delete($id)
    {
        if($id == auth()->id()) {
            session()->flash('error', 'Anda tidak dapat menghapus akun sendiri.');
            return;
        }
        
        User::find($id)->delete();
        session()->flash('message', 'User berhasil dihapus.');
    }

    public function cancel()
    {
        $this->showForm = false;
        $this->resetInputFields();
    }

    private function resetInputFields()
    {
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->role = 'staf';
        $this->user_id = null;
        $this->isEditMode = false;
    }
}