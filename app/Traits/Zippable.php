<?php
namespace App\Traits;

use Chumper\Zipper\Facades\Zipper;

Trait Zippable
{
    protected $zipFile;

    private   $filesToAdd;

    private   $extractToDir;

    public function zip()
    {
        if (!$this->zipFile) {
            $this->zipFile = storage_path('app/archive.zip');
        }
        try {
            $zip = Zipper::make($this->zipFile);
            foreach ($this->filesToAdd as $file) {
                $zip->add($file);
            }
        } catch (\Exception $e) {
            session()->flash('warning', $e->getMessage());
            return false;
        }
        $zip->close();
        return true;
    }

    public function unzip()
    {
        if (!$this->extractToDir) {
            $this->extractToDir = storage_path('app');
        }

        try {
            $zip = Zipper::make($this->zipFile);
            $zip->extractTo($this->extractToDir);
        } catch (\Exception $e) {
            session()->flash('warning', $e->getMessage());
            return false;
        }
        return false;
    }
}
