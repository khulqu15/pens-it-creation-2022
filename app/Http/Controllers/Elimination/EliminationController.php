<?php

namespace App\Http\Controllers\Elimination;

use App\Http\Controllers\Controller;
use App\Models\Elimination;
use Illuminate\Http\Request;

class EliminationController extends Controller
{
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        Elimination::query()->create([
            'link' => $request->link,
            'administration_id' => $request->administration_id,
            'is_eliminated' => 0,
        ]);
        return redirect()->back();
    }

    public function update(Request $request, Elimination $elimination): \Illuminate\Http\RedirectResponse
    {
        $elimination->update([
            'link' => $request->link,
            'administration_id' => $request->administration_id,
        ]);
        return redirect()->back();
    }

    public function setEliminated(Request $request, int $id): \Illuminate\Http\RedirectResponse
    {
        $data = Elimination::query()->find($id);
//        var_dump($request->is_eliminated);
//        exit;
        $data->is_eliminated = $request->is_eliminated;
        $data->save();
        return redirect()->back();
    }
}
