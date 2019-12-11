<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use League\Csv\Reader;
use Carbon\Carbon;

use App\Traits\RandomStringable;
use App\Traits\Uploadable;
use App\Traits\IsUser;

use App\Short;
use App\User;

class ImportController extends \App\Http\Controllers\Controller
{

    use Uploadable, RandomStringable, IsUser;

    public function upload(Request $request)
    {
        try {
            if ($this->uploadAndStore($request)) {
                $import = $this->import();
                $this->cleanAfterStore();
            }
        } catch (\Illuminate\Http\Exceptions\PostTooLargeException $e) {
            session()->flash('warning', $e->getMessage());
        } catch (\Exception $e) {
            session()->flash('warning', $e->getMessage());
        }
        return redirect()->back();
    }

    public function import()
    {
        $roles = User::orderBy('name')->admins()->pluck('id')->all();
        $roles[] = $this->getUserId();
        foreach ($this->storedFiles as $file) {
            $csv = Reader::createFromPath(storage_path('app/' . $file), 'r');
            $records = $csv->getRecords();
            foreach ($records as $record) {
                $short = new Short();
                $short->url = $record[0];
                if (isset($record[1])) {
                    $short->tags = $record[1];
                }
                $short->identifier = $this->randomString();
                $short->expires = Carbon::now()->addYears(config('shorts.expires.default', 5));
                $short->save();
                $short->users()->sync($roles);
            }
        }
    }
}

