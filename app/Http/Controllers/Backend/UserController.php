<?php
namespace App\Http\Controllers\Backend;

use Illuminate\Support\Facades\Hash;
use Mews\Purifier\Facades\Purifier;
use Illuminate\Http\Request;
use App\User;

class UserController
{
    public function index(Request $request)
    {
        $filter = $request->input('qu', $request->session()->get('users_q', ''));
        session()->put('users_q', $filter);

        $users = User::orderBy('name')->when($filter, function ($q0) use ($filter) {
            $q0->where('name', 'LIKE', '%' . $filter .'%')
                ->orWhere('email', 'LIKE', '%' . $filter . '%');
            })->paginate(config('shorts.paginator.users', 15));
        return view('backend/users_list', compact('users'));
    }

    public function add()
    {
        return view('backend/users_add');
    }

    public function delete(Request $request)
    {
        $selected = collect($request->input('selected', []));
        if ($selected->isNotEmpty()) {
            User::destroy($selected->all());
            return redirect(route('admin.users.index'));
        }
        return redirect()->back()->with('primary', __('Nothing to delete'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('backend/users_edit', compact('user'));
    }


    public function save($id = null, Request $request)
    {
        $request->merge([
            'name' => Purifier::clean($request->name),
            'email' => Purifier::clean($request->email),
        ]);

        $validated = $request->validate([
                'name' => 'required|string',
                'email' => 'required|string',
                'role' => 'required|string',
                'password' => 'nullable|string|min:6|confirmed',
                'active' => 'boolean',
            ]);

        if ($validated) {
            try {
                if (!empty($validated['password'])) {
                    $validated['password'] = Hash::make($validated['password']);
                } else {
                    unset($validated['password']);
                }
                $instance = User::updateOrCreate(['id' => $id], $validated);
                return redirect()->to(route('admin.users.index'));
            } catch (\Illuminate\Database\QueryException $e) {
                return redirect()->back()->with('danger', $e->getMessage())->withInput();
            } catch (\Exception $e) {
                return redirect()->back()->with('danger', $e->getMessage())->withInput();
            }
        }
        return redirect()->back()->with('danger', 'Uncatchable exception');
    }
}

