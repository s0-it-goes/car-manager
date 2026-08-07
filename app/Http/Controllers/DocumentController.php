<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{

    public function store(Request $request, Car $car)
    {

        $request->validate([
            'documents' => ['required','array'],

            'documents.*' => [
                'required',
                'file',
                'max:20480',
            ],
        ]);


        foreach ($request->file('documents') as $document) {


            $path = $document->store(
                "cars/{$car->id}/documents",
                'public'
            );


            $car->documents()->create([
                'name' => $document->getClientOriginalName(),
                'path' => $path,
            ]);

        }


        return redirect()
            ->back()
            ->with('success', 'Документы загружены')
            ->withFragment('documents');
    }


    public function destroy(Document $document)
    {

        Storage::disk('public')
            ->delete($document->path);


        $document->delete();


        return back()
            ->with('success','Документ удалён.')
            ->withFragment('documents');
    }
}