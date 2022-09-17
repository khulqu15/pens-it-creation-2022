<?php

namespace App\Actions\Administration;

use App\Enums\CategoryAdministrationEnum;
use App\Models\Administration;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;

class AdministrationAction
{
    public mixed $administration;
    public mixed $inputs;
    public int $id;

    public function __construct(Administration $administration, Request $request, int $id = null)
    {
        $this->administration = $administration;
        $this->inputs = $request->validate([
            'name' => 'required',
            'instance' => ['required', new Enum(CategoryAdministrationEnum::class)],
            'category' => 'required',
            'user_id' => 'required',
        ]);
        if($id)
            $this->id = $id;
    }

    public function store(): \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
    {
        $administration = Administration::query()->create([
            'name' => $this->inputs['name'],
            'instance' => $this->inputs['instance'],
            'category' => $this->inputs['category'],
            'user_id' => $this->inputs['user_id'],
        ]);
        return $administration;
    }

    public function update(): \Illuminate\Database\Eloquent\Builder|array|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
    {
        $administration = Administration::query()->find($this->id);
        $administration->name = $this->inputs['name'];
        $administration->instance = $this->inputs['instance'];
        $administration->category = $this->inputs['category'];
        $administration->save();
        return $administration;
    }
}
