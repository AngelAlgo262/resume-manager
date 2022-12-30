<?php

namespace App\Http\Controllers;

use App\Mail\ResumePublished;
use App\Models\Resume;
use App\Models\Publish;
use App\Models\Theme;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

use function PHPSTORM_META\type;
use function PHPUnit\Framework\returnSelf;

class PublishController extends Controller
{

    public $rules = [
        'resume_id' => 'required|numeric',
        'theme_id' => 'required|numeric',
        'visibility' => 'nullable|string|in:public,private,hidden'
    ];

    public function __construct()
    {
        $this->middleware('auth', ['except' => 'show']);
        $this->jsonResumeApi = config('services.jsonresume.api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $publishes = auth()->user()->publishes;

        return view('publishes.index', compact('publishes'));
    }

    public function preview(Request $request)
    {
        $data = $request->validate($this->rules);
        $theme = Theme::findOrFail($data['theme_id']);
        $resume = Resume::findOrFail($data['resume_id']);

        if (auth()->user()->id !== $resume->user->id) {
            abort(Response::HTTP_FORBIDDEN);
        }

        return $this->render($resume, $theme);
    }

    private function render(Resume $resume, Theme $theme)
    {
        $response = Http::post("$this->jsonResumeApi/theme/$theme->theme", [
            'resume' => $resume->content,
        ]);

        return response($response, $response->status());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $resumes = auth()->user()->resumes;
        if (count($resumes) < 1) {
            return redirect()->route('resumes.create');
        }
        $themes = Theme::all();

        return view('publishes.edit', compact('resumes', 'themes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate($this->rules);
        $publish = auth()->user()->publishes()->create(array_merge(
            $data,
            ['url' => 'tmp'],
        ));
        $url = route('publishes.show', $publish->id);
        $publish->update(compact('url'));
        $resume = Resume::where('id', $data['resume_id'])->first();
        $theme = $publish->theme()->get()->first();

        Mail::to($request->user())->send(new ResumePublished($resume));

        return redirect()->route('publishes.index')->with('alert', [
            'type' => 'success',
            'messages' => [
                "Resume $resume->title published with theme $theme->theme at <a href='url'>$url</a>"
            ]
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Publish  $publish
     * @return \Illuminate\Http\Response
     */
    public function show(Publish $publish)
    {
        if ($publish->visibility === 'private') {
            if (!auth()->check()) {
                return redirect()->route('login');
            }
            if (auth()->user()->id !== $publish->user->id) {
                abort(Response::HTTP_FORBIDDEN);
            }
        }

        $key = "publish $publish->id";
        if (!Cache::has($key)) {
            $res = $this->render($publish->resume, $publish->theme);
            if ($res->status() != 200) {
                return $res;
            }
            Cache::put($key, $res, now()->addMinutes(30));
        }
        
        return Cache::get($key);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Publish  $publish
     * @return \Illuminate\Http\Response
     */
    public function edit(Publish $publish)
    {
        $this->authorize('update', $publish);
        $resumes = auth()->user()->resumes;
        $themes = Theme::all();

        return view('publishes.edit', compact(
            'publish',
            'resumes',
            'themes',
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Publish  $publish
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Publish $publish)
    {
        $this->authorize('update', $publish);
        $data = $request->validate($this->rules);
        $publish->update($data);

        return redirect()->route('publishes.index')->with('alert', [
            'type' => 'info',
            'messages' => ["Publish $publish->url updated"],
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Publish  $publish
     * @return \Illuminate\Http\Response
     */
    public function destroy(Publish $publish)
    {
        $this->authorize('delete', $publish);
        $publish->delete();

        return redirect()->route('publishes.index')->with('alert', [
            'type' => 'danger',
            'messages' => ["Publish $publish->url deleted"],
        ]);
    }
}
