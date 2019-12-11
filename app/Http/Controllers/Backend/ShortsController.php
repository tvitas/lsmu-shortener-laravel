<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Support\Facades\Auth;
use Mews\Purifier\Facades\Purifier;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Traits\Zippable;
use App\Traits\IsUser;
use App\Traits\Qrable;
use App\Short;
use App\User;


class ShortsController extends \App\Http\Controllers\Controller
{
    use Qrable, Zippable, IsUser;

    public function index(Request $request)
    {
        $filter = $request->input('q', $request->session()->get('shorts_q', ''));
        session()->put('shorts_q', $filter);

        $userId = Auth::user()->id;

        $shorts = Short::orderBy('id', 'DESC')
            ->whereHas('users',
                function ($qr) use ($userId) {
                    $qr->where('user_id', $userId);
                })->when($filter, function ($q1) use ($filter) {
                    $q1->where('url', 'LIKE', '%' . $filter . '%')
                    ->orWhere('tags', 'LIKE', '%' . $filter . '%')
                    ->orWhere('identifier', 'LIKE', '%' . $filter . '%');
                })->paginate(config('shorts.paginator.shorts', 15));
        return view('backend/shorts_list', compact('shorts'));
    }

    public function edit($id)
    {
        $users = User::orderBy('name')->isActive()->roleUser()->get();

        $userId = Auth::user()->id;

        $short = Short::whereHas('users', function ($qr) use ($userId) {
                $qr->where('user_id', $userId);
            })->where('id', $id)->first();

        if (isset($short)) {
            return view('backend/shorts_edit', compact('short', 'users'));
        }
        return abort(404, 'Not found');
    }

    public function add()
    {
        $expires = Carbon::now()->addYears(config('shorts.expires.default', 5));
        $users = User::orderBy('name')->isActive()->roleUser()->get();
        return view('backend/shorts_add', compact('expires', 'users'));
    }

    public function delete(Request $request)
    {
        $selected = collect($request->input('selected', []));
        if ($selected->isNotEmpty()) {
            Short::destroy($selected->all());
            return redirect(route('admin.shorts.index'));
        }
        return redirect()->back()->with('primary', __('Nothing to delete'));
    }

    public function save($id = null, Request $request, Short $short)
    {
        $regex = '/^[a-zA-Z0-9]{10}$/';

        $validated = $request->validate([
            'url' => 'required|url',
            'identifier' => 'sometimes|required|unique:shorts,identifier|regex:' . $regex,
            'expires' => 'required|date',
            'tags' => 'string|nullable',
            'active' => 'boolean',
            'shares.*' => 'integer|nullable',
        ]);

        if ($validated) {
            try {
                foreach ($short->getPurifyable() as $purifyable) {
                    $validated[$purifyable] = Purifier::clean($validated[$purifyable]);
                }

                $admins = User::orderBy('name')->admins()->pluck('id')->all();

                if (!isset($validated['shares'])) {
                    $validated['shares'] = [];
                }

                $final = array_merge($validated['shares'], $admins);

                $shortInstance = $short->updateOrCreate(['id' => $id], $validated);
                $shortInstance->users()->sync($final);

                return redirect()->to(route('admin.shorts.index'));
            } catch (\Illuminate\Database\QueryException $e) {
                return redirect()->back()->with('danger', $e->getMessage())->withInput();
            } catch (\Exception $e) {
                return redirect()->back()->with('danger', $e->getMessage())->withInput();
            }
        }
        return redirect()->back()->with('danger', 'Uncatchable exception');
    }

    public function show($id, Request $request)
    {
        $userId = Auth::user()->id;

        $short = Short::whereHas('users', function ($qr) use ($userId) {
                $qr->where('user_id', $userId);
            })->where('id', $id)->first();

        if (isset($short)) {
            $this->qrData[] = $short->url;
            $this->qrData[] = $request->getSchemeAndHttpHost(). '/' . $short->identifier;
            if ($this->generate()) {
                $qrOriginal = 'data:image/svg+xml;base64,' . base64_encode($this->qrGenerated['svg'][0]);
                $qrShort    = 'data:image/svg+xml;base64,' . base64_encode($this->qrGenerated['svg'][1]);
                return view('backend/shorts_view', compact('short', 'qrShort', 'qrOriginal'));
            }
        }
        return abort(404);
    }

    public function download($id, Request $request)
    {
        $userId = Auth::user()->id;

        $short = Short::whereHas('users', function ($qr) use ($userId) {
                $qr->where('user_id', $userId);
            })->where('id', $id)->get(['identifier', 'url'])->first();

        if (isset($short)) {
            try {
                $dir = 'tmp' . '/' . $short->identifier;
                $zip = null;
                $this->qrOptions['prefix']   = $request->input('file_prefix', $short->identifier);
                $this->qrOptions['size']     = $request->input('size', '150');
                $this->qrOptions['format']   = $request->input('format', ['svg']);
                $this->qrData[]  = $request->getSchemeAndHttpHost() . '/' . $short->identifier;
                $this->qrData[]  = $short->url;
                $this->qrStoreDir = $dir;
                if ($this->generateAndStore()) {
                    $this->filesToAdd = $this->qrStored;
                    $zip = $this->zip();
                    $this->cleanAfterStore();
                }
                if ($zip) {
                    return response()->download($this->zipFile)->deleteFileAfterSend();
                }
            } catch (\Exception $e) {
                return redirect()->back()->with('warning', $e->getMessage());
            }
        }
        return redirect()->back()->with('primary', __('Unknown collision. Try again later'));
    }
}
