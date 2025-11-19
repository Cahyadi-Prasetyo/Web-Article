<?php

namespace App\Http\Controllers;

use App\Models\Articles;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    // Guest - Lihat artikel yang sudah published
    public function index()
    {
        $articles = Articles::with('author')
            ->where('status', 'published')
            ->orderBy('published_at', 'desc')
            ->paginate(10);

        return response()->json($articles);
    }

    // Guest - Lihat detail artikel published
    public function show($slug)
    {
        $article = Articles::with('author')
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        return response()->json($article);
    }

    // User - Lihat artikel milik sendiri
    public function myArticles(Request $request)
    {
        $articles = Articles::where('author_id', $request->user()->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return response()->json($articles);
    }

    // User - Buat artikel baru (status: draft atau pending)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'categories' => 'required|string',
            'content' => 'required|string',
            'excerpt' => 'required|string|max:500',
            'action' => 'required|in:draft,publish', // draft atau publish
        ]);

        $slug = Str::slug($validated['title']) . '-' . time();

        // Jika action = publish, set status ke pending (menunggu approval)
        // Jika action = draft, set status ke draft
        $status = $validated['action'] === 'publish' ? 'pending' : 'draft';

        $article = Articles::create([
            'title' => $validated['title'],
            'categories' => $validated['categories'],
            'slug' => $slug,
            'content' => $validated['content'],
            'excerpt' => $validated['excerpt'],
            'status' => $status,
            'author_id' => $request->user()->id,
        ]);

        $message = $status === 'pending' 
            ? 'Article submitted for review' 
            : 'Article saved as draft';

        return response()->json([
            'message' => $message,
            'article' => $article
        ], 201);
    }

    // User - Update artikel milik sendiri (hanya jika draft atau rejected)
    public function update(Request $request, $id)
    {
        $article = Articles::where('id', $id)
            ->where('author_id', $request->user()->id)
            ->firstOrFail();

        if (!in_array($article->status, ['draft', 'rejected'])) {
            return response()->json([
                'message' => 'Cannot edit article with status: ' . $article->status
            ], 403);
        }

        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'categories' => 'sometimes|string',
            'content' => 'sometimes|string',
            'excerpt' => 'sometimes|string|max:500',
            'action' => 'sometimes|in:draft,publish', // draft atau publish
        ]);

        if (isset($validated['title'])) {
            $validated['slug'] = Str::slug($validated['title']) . '-' . time();
        }

        // Jika ada action, update status
        if (isset($validated['action'])) {
            $validated['status'] = $validated['action'] === 'publish' ? 'pending' : 'draft';
            $validated['rejection_reason'] = null; // Clear rejection reason
            unset($validated['action']); // Remove action dari data update
        }

        $article->update($validated);

        $message = isset($validated['status']) && $validated['status'] === 'pending'
            ? 'Article submitted for review'
            : 'Article updated successfully';

        return response()->json([
            'message' => $message,
            'article' => $article
        ]);
    }

    // User - Submit artikel untuk review (draft -> pending)
    public function submitForReview(Request $request, $id)
    {
        $article = Articles::where('id', $id)
            ->where('author_id', $request->user()->id)
            ->firstOrFail();

        if (!in_array($article->status, ['draft', 'rejected'])) {
            return response()->json([
                'message' => 'Only draft or rejected articles can be submitted for review'
            ], 403);
        }

        $article->update([
            'status' => 'pending',
            'rejection_reason' => null
        ]);

        return response()->json([
            'message' => 'Article submitted for review',
            'article' => $article
        ]);
    }

    // User - Hapus artikel milik sendiri (hanya draft atau rejected)
    public function destroy(Request $request, $id)
    {
        $article = Articles::where('id', $id)
            ->where('author_id', $request->user()->id)
            ->firstOrFail();

        if (!in_array($article->status, ['draft', 'rejected'])) {
            return response()->json([
                'message' => 'Cannot delete article with status: ' . $article->status
            ], 403);
        }

        $article->delete();

        return response()->json([
            'message' => 'Article deleted successfully'
        ]);
    }
}
