<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::latest()->paginate(10);

        return view('admin.articles.index', compact('articles'));
    }

    public function create()
    {
        return view('admin.articles.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'body' => ['required', 'string'],
            'thumbnail' => ['nullable', 'image', 'max:2048'],
            'is_published' => ['nullable', 'boolean'],
        ], [
            'title.required' => 'タイトルを入力してください。',
            'body.required' => '本文を入力してください。',
            'thumbnail.image' => 'サムネイルは画像ファイルを選択してください。',
            'thumbnail.max' => 'サムネイル画像は2MB以内で選択してください。',
        ]);

        $slug = Str::slug($validated['title']);

        if ($slug === '') {
            $slug = 'article';
        }

        $baseSlug = $slug;
        $count = 1;

        while (Article::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $count;
            $count++;
        }

        $thumbnailPath = null;

        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('articles', 'public');
        }

        Article::create([
            'title' => $validated['title'],
            'slug' => $slug,
            'excerpt' => $validated['excerpt'] ?? null,
            'body' => $validated['body'],
            'thumbnail_path' => $thumbnailPath,
            'is_published' => $request->boolean('is_published'),
            'published_at' => $request->boolean('is_published') ? now() : null,
        ]);

        return redirect()
            ->route('admin.articles.index')
            ->with('success', '記事を作成しました。');
    }

    public function edit(Article $article)
    {
        return view('admin.articles.edit', compact('article'));
    }

    public function update(Request $request, Article $article)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'body' => ['required', 'string'],
            'thumbnail' => ['nullable', 'image', 'max:2048'],
            'is_published' => ['nullable', 'boolean'],
        ], [
            'title.required' => 'タイトルを入力してください。',
            'body.required' => '本文を入力してください。',
            'thumbnail.image' => 'サムネイルは画像ファイルを選択してください。',
            'thumbnail.max' => 'サムネイル画像は2MB以内で選択してください。',
        ]);

        $thumbnailPath = $article->thumbnail_path;

        if ($request->hasFile('thumbnail')) {
            if ($article->thumbnail_path) {
                Storage::disk('public')->delete($article->thumbnail_path);
            }

            $thumbnailPath = $request->file('thumbnail')->store('articles', 'public');
        }

        $isPublished = $request->boolean('is_published');

        $article->update([
            'title' => $validated['title'],
            'excerpt' => $validated['excerpt'] ?? null,
            'body' => $validated['body'],
            'thumbnail_path' => $thumbnailPath,
            'is_published' => $isPublished,
            'published_at' => $isPublished && ! $article->published_at ? now() : $article->published_at,
        ]);

        return redirect()
            ->route('admin.articles.index')
            ->with('success', '記事を更新しました。');
    }

    public function destroy(Article $article)
    {
        if ($article->thumbnail_path) {
            Storage::disk('public')->delete($article->thumbnail_path);
        }

        $article->delete();

        return redirect()
            ->route('admin.articles.index')
            ->with('success', '記事を削除しました。');
    }
}