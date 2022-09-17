<?php

namespace App\Http\Controllers\Participant;

use App\Http\Controllers\Controller;
use App\Models\Participant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class ParticipantController extends Controller
{
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $data = new Participant();
        $data->name = $request->name;
        $data->role = $request->role;
        if(!File::isDirectory(public_path().'/img/identity/')) {
            File::makeDirectory(public_path().'/img/identity/', 0777, true);
        }
        $file = $request->file('identity');
        $file_name = Str::slug($request->name, '-').'_'.time().'.'.$file->extension();
        $img = Image::make($file->path());
        $img->resize(750, 750, function ($constraint) {
            $constraint->aspectRatio();
        })->save(public_path().'/img/identity/'.$file_name);
        $data->identity = $file_name;
        $data->administration_id = $request->administration_id;
        $data->save();
        return redirect()->back();
    }

    public function update(Request $request, int $id): void
    {
        $participant = Participant::query()->find($id);
        $participant->name = $request->name;
        $participant->role = $request->role;
        if($request->hasFile('identity')) {
            if(File::exists(public_path().'/img/identity/'.$participant->identity)) {
                unlink(public_path().'/img/identity/'.$participant->identity);
            }
            if(!File::isDirectory(public_path().'/img/identity/')) {
                File::makeDirectory(public_path().'/img/identity/', 0777, true);
            }
            $file = $request->file('identity');
            $file_name = Str::slug($request->name, '-').'_'.time().'.'.$file->extension();
            $img = Image::make($file->path());
            $img->resize(750, 750, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path().'/img/identity/'.$file_name);
            $participant->identity = $file_name;
        }
        $participant->administration_id = $request->administration_id;
        $participant->save();
    }

    public function destroy(int $id): \Illuminate\Http\RedirectResponse
    {
        $participant = Participant::query()->find($id);
        if(File::exists(public_path().'/img/identity/'.$participant->identity)) {
            unlink(public_path().'/img/identity/'.$participant->identity);
        }
        $participant->delete();
        return redirect()->back();
    }
}
