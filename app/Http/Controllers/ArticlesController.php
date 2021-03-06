<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\ArticlesRequest;

class ArticlesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['except'=> ['index', 'show']]);
    }


    public function index($slug = null)
    {

        //즉시 로드(Eager Load)
//        $articles = \App\Article::with('user')->get();
//        return view('articles.index', compact('articles'));

        //지연 로드(lazy load) - 즉시 로드하지 않고 나중에 필요할때에 관계를 로드 할 때 이 방법을 쓴다.

        $query = $slug
            ? \App\Tag::whereSlug($slug)->firstOrFail()->articles()
            : new \App\Article;

        $articles = $query->latest()->paginate(3);
        //15.4.2 뷰 디버깅
        //dd(view('articles.index', compact('articles'))->render());

        return view('articles.index', compact('articles'));

    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $article = new \App\Article;
        return view('articles.create', compact('article'));

    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArticlesRequest $request)
    {
        $user = $request->user();

        $article = $user->articles()->create(
            $request->getPayload()
        );

        if(!$article) {
            return back()->with('flash_message', '글이 저장되지 않았습니다.')
                ->withInput();
        }
        $article->tags()->sync($request->input('tags'));

        $request->getAttachments()->each(function ($attachment) use ($article) {
            $attachment->article()->associate($article);
            $attachment->save();
        });

        event(new \App\Events\ArticleEvent($article));


        return redirect(route('articles.index'))
            ->with('flash_message', '작성하신 글이 저장되었습니다.');


    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(\App\Article $article)
    {
        $comments = $article->comments()->with('replies')->whereNull('parent_id')->
            latest()->get();

        return view('articles.show', compact('article', 'comments'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(\App\Article $article)
    {
        $this->authorize('update', $article);
        return view('articles.edit', compact('article'));

    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(\App\Http\Requests\ArticlesRequest $request, \App\Article $article)
    {
        $article->update($request->all());
        $article->tags()->sync($request->input('tags'));
        flash()->message('수정하신 내용을 저장하였습니다.');

        return redirect(route('articles.show', $article->id));
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(\App\Article $article)
    {
        $this->authorize('delete', $article);
        $article->delete();

        return response()->json([], 204);
    }
}
