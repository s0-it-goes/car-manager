<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{

    public function store(Request $request, Car $car)
    {
        $request->validate([
            'photos' => ['required','array'],
            'photos.*' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:10240',
            ],
        ]);


        foreach ($request->file('photos') as $photo) {

            $path = $photo->store(
                "cars/{$car->id}/photos",
                'public'
            );


            $car->photos()->create([
                'path' => $path,
            ]);

        }


        return redirect()
            ->back()
            ->with('success', 'Фото загружено')
            ->withFragment('photos');
    }


    public function destroy(Photo $photo)
    {
        Storage::disk('public')
            ->delete($photo->path);


        $photo->delete();


        return back()
            ->with('success','Фотография удалена.')
            ->withFragment('photos');
    }
}