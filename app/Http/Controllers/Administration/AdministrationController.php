<?php

namespace App\Http\Controllers\Administration;

use App\Actions\Administration\AdministrationAction;
use App\Http\Controllers\Controller;
use App\Models\Administration;
use App\Models\Elimination;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Intervention\Image\Facades\Image;

class AdministrationController extends Controller
{
    public function create(): \Inertia\Response
    {
        return Inertia::render($this->component('Form'), [
            'mode' => 'create'
        ]);
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $create = Administration::query()->create([
            'name' => $request->name,
            'instance' => $request->instance,
            'category' => $request->category,
            'user_id' => $request->user_id,
        ]);
        $administration = Administration::query()->find($create->id);
        return redirect()->route('administration.edit', $administration->hash);
    }

    public function show(Administration $administration): \Inertia\Response
    {
        return Inertia::render('Administration/Form', [
            'mode' => 'detail',
            'administrations' => $administration
        ]);
    }

    public function edit(Administration $administration): \Inertia\Response
    {
        $data = Administration::query()->with(['participant', 'user'])->find($administration->id);
        return Inertia::render('Administration/Form', [
            'mode' => 'edit',
            'data' => [$data, $data->hash]
        ]);
    }

    public function update(Request $request, Administration $administration): \Illuminate\Http\RedirectResponse
    {
        $update = Administration::query()->where('id', $administration->id)->update([
            'name' => $request->name,
            'instance' => $request->instance,
            'category' => $request->category,
            'user_id' => $request->user_id,
        ]);
        $administration_data = Administration::query()->find($administration->id);
        return redirect()->back()->with('data', $administration_data);
    }

    public function destroy(Administration $administration): \Illuminate\Http\RedirectResponse
    {
        $administration->delete();
        return redirect()->back();
    }

    public function dashboard(): \Inertia\Response
    {
        $administration = Administration::query()->whereHas('user', function ($query) {
            $query->where('id', Auth::id());
        })->with('participant', 'elimination')->first();
        $elimination = Elimination::query()->where('administration_id', $administration->id)->first();
        $hash = $administration ? $administration->hash : '';
        $elimination_hash = $elimination ? $elimination->hash : '';
        return Inertia::render('Dashboard', [
            'administration' => [$administration, $hash],
            'elimination' => [$elimination, $elimination_hash],
        ]);

    }

    public function addPayment(Request $request, Administration $administration): \Illuminate\Http\RedirectResponse
    {
        if(!File::isDirectory(public_path().'/img/payment/')) {
            File::makeDirectory(public_path().'/img/payment', 0777, true);
        }
        if($request->hasFile('payment') && $request->file('payment') !== null) {
            if($administration->payment) {
                if(File::exists(public_path().'/img/payment/'.$administration->payment)) {
                    unlink(public_path().'/img/payment/'.$administration->payment);
                }
            }
            $file = $request->file('payment');
            $filename = Str::slug($administration->name).'_'.time().'.'.$file->extension();
            $img = Image::make($file->path());
            $img->resize(750, 750, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path().'/img/payment/'.$filename);
            $administration->payment = $filename;
            $administration->save();
        }
        return redirect()->back();
    }

    protected function component(string $name): string
    {
        return 'Administration/'.$name;
    }
}
