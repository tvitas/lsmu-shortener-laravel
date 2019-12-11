<?php
namespace App\Traits;

use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

Trait Qrable
{

    protected $qrOptions = [
        'size' => 100,
        'format' => ['svg'],
        'prefix' => '',
    ];

    protected $qrData = [];

    protected $qrGenerated = [];

    protected $qrStored = [];

    protected $qrStoreDir = 'tmp';

    public function generate()
    {
        if ($this->qrableValidator()) {
            try {
                foreach ($this->qrData as $item) {
                    foreach ($this->qrOptions['format'] as $format) {
                        $this->qrGenerated[$format][] = QrCode::format($format)->size($this->qrOptions['size'])->generate($item);
                    }
                }
                return true;
            } catch (\Exception $e) {
                session()->flash('info', $e->getMessage());
                return false;
            }
        }
        return false;
    }

    public function generateAndStore()
    {
        $qrs = false;
        if (empty($this->qrGenerated)) {
            $qrs = $this->generate();
        }
        if ($qrs) {
            Storage::disk('local')->makeDirectory($this->qrStoreDir);
            $i = 0;
            foreach($this->qrGenerated as $format => $data) {
                foreach ($data as $content) {
                    $file = $this->qrStoreDir . '/'
                    . $i . '-' . Str::slug($this->qrOptions['prefix'])
                    . '-' . $this->qrOptions['size']
                    . '.' . $format;

                    Storage::disk('local')->put($file, $content);
                    $this->qrStored[] = storage_path('app/' . $file);
                    $i ++;
                }
            }
            return true;
        }
        return false;
    }

    public function cleanAfterStore()
    {
        return Storage::disk('local')->deleteDirectory($this->qrStoreDir);
    }

    private function qrableValidator()
    {
        if (
                (!isset($this->qrOptions['size']))
                or (empty($this->qrOptions['size']))
                or (!isset($this->qrOptions['format']))
                or (empty($this->qrOptions['format']))
                or (empty($this->qrData))
            ) {
            return false;
        }
        return true;
    }
}
