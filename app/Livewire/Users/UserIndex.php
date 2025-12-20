<?php

namespace App\Livewire\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;

#[Layout('livewire.layout.app')]
#[Title('Users')]
class UserIndex extends Component
{
    use WithPagination, WithoutUrlPagination;

    protected $paginationTheme = 'tailwind';
    protected $queryString = [];
    public $filter = 'all';
    public $deleteId;
    public $forcedeleteId;
    public $search = '';

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedFilter()
    {
        $this->resetPage();
    }

    public function toggleStatus($userId)
    {
        $user = User::find($userId);
        if (! $user) {
            return;
        }
        $user->status = $user->status === 'active' ? 'inactive' : 'active';
        $user->save();
        $this->dispatch('notify', type: 'success', message: 'User status updated');
    }

    public function getCountsProperty()
    {
        return [
            'all'      => User::count(),
            'active'   => User::where('status', 'active')->count(),
            'inactive' => User::where('status', 'inactive')->count(),
            'deleted'  => User::onlyTrashed()->count(),
        ];
    }

    public function confirmDelete($id)
    {
        $this->deleteId = $id;

        $this->dispatch('confirm-delete');
    }
    
    #[On('deleteUser')]
    public function deleteUser()
    {
        User::findOrFail($this->deleteId)->delete();
        $this->dispatch('notify', type: 'success', message: 'User delete successfully');
    }
    
    public function restoreUser($id)
    {
        $user = User::onlyTrashed()->find($id);
        
        if (! $user) {
            return;
        }
        
        $user->restore();
        
        $this->dispatch('notify', type: 'success', message: 'User restored successfully');
    }
    
    public function confirmforceDeleteUser($id)
    {
        $this->forcedeleteId = $id;

        $this->dispatch('confirm-force-delete');
    }

    #[On('forceDeleteUser')]
    public function forceDeleteUser()
    {
        $id = $this->forcedeleteId;
        $user = User::onlyTrashed()->find($id);

        if (! $user) {
            return;
        }

        $user->forceDelete();

        $this->dispatch('notify', type: 'success', message: 'User permanently deleted');
    }

    public function render()
    {
        $query = User::with('roles')->latest();
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        }
        if ($this->filter === 'active') {
            $query->where('status', 'active');
        }

        if ($this->filter === 'inactive') {
            $query->where('status', 'inactive');
        }

        if ($this->filter === 'deleted') {
            $query->onlyTrashed();
        }

        return view('livewire.users.index', [
            'users'  => $query->paginate(10),
            'counts' => $this->counts,
        ]);
    }
}
