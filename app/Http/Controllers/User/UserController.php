<?php

namespace App\Http\Controllers\User;

use App\Actions\Fortify\CreateNewUser;
use App\Http\Controllers\Controller;
use App\Models\Administration;
use App\Models\Elimination;
use App\Models\Participant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index(Request $request) {
        $administration = Administration::query()->whereHas('user', function ($query) {
            $query->where('id', Auth::id());
        })->with('participant', 'elimination')->first();
        $hash = $administration ? $administration->hash : '';

        $users = User::query()
            ->when($request->get('name'), function ($query) use($request) {
                $query->where('name', 'LIKE', '%'.$request->get('name').'%');
            })
            ->when($request->get('role'), function ($query) use($request) {
                $query->where('role', $request->get('role'));
            })
            ->orderBy('created_at', $request->get('sort') ? $request->get('sort') : 'desc')
            ->paginate(10);

        if($administration) {
            $elimination = Elimination::query()->where('administration_id', $administration->id)->first();
            $elimination_hash = $elimination ? $elimination->hash : '';
        }
        return Inertia::render('User', [
            'administration' => [$administration, $hash],
            'users' => $users,
            'elimination' => $administration ? [$elimination, $elimination_hash] : [],
        ]);
    }

    public function destroy(int $id): \Illuminate\Http\RedirectResponse
    {
        $administration = Administration::query()->where('user_id', $id)->first();
        if($administration !== null) {
            Participant::query()->where('administration_id', $administration->id)->delete();
            Elimination::query()->where('administration_id', $administration->id)->delete();
            $administration->delete();
        }
        User::query()->find($id)->delete();
        return redirect()->back();
    }

//    public function register(Request $request) {
//        (new \App\Actions\Fortify\CreateNewUser)->create((array)$request);
//        $request->user()->sendEma
//    }
}
