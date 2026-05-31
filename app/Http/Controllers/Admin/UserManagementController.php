<?php

namespace App\Http\Controllers\Admin;

use App\Enums\RoleEnum;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserManagementController extends Controller
{
    public function __construct(
        private UserRepositoryInterface $userRepo,
    ) {}

    public function index(Request $request): View
    {
        $role = $request->query('role');
        $users = $role
            ? $this->userRepo->getAllByRole(RoleEnum::from($role), 15)
            : $this->userRepo->getAll(15);

        return view('admin.users.index', [
            'users' => $users,
            'currentRole' => $role,
        ]);
    }

    public function show(int $id): View
    {
        $user = $this->userRepo->findById($id);
        abort_unless($user, 404);

        return view('admin.users.show', compact('user'));
    }

    public function suspend(Request $request, int $id): RedirectResponse
    {
        $user = $this->userRepo->findById($id);
        abort_unless($user, 404);
        $this->authorize('suspend', $user);

        if ($user->is_suspended) {
            $this->userRepo->unsuspend($id);
            $message = "User {$user->name} berhasil di-unsuspend.";
        } else {
            $this->userRepo->suspend($id);
            $message = "User {$user->name} berhasil di-suspend.";
        }

        return back()->with('success', $message);
    }
}
