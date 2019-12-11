<?php
namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait Uploadable
{
    private $uploadTo = 'uploads/tmp';

    private $fileRules = [
        'files' => 'required|file|max:4096|mimetypes:text/plain,text/csv',
    ];

    private $storedFiles = [];

    public function uploadAndStore($request)
    {
        $validated = $request->validate($this->fileRules);
        if ($validated) {
            foreach ($validated as $file) {
                $this->storedFiles[] = Storage::disk('local')->putFile($this->uploadTo, $file);
            }
            return true;
        }
        return false;
    }

    public function cleanAfterStore()
    {
        foreach ($this->storedFiles as $file) {
            Storage::disk('local')->delete($file);
        }
    }
}

