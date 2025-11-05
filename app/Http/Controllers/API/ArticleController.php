<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Articles;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class ArticleController extends Controller
{
    /**
     * Display a listing of published articles (public access)
     */
    public function index(Request $request)
    {
        $query = Articles::with('author:id,name,email')
            ->where('status', 'published')
            ->orderBy('published_at', 'desc');

        // Filter by category if provided
        if ($request->has('category')) {
            $query->where('categories', 'like', '%' . $request->category . '%');
        }

        // Search by title or content
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('content', 'like', '%' . $search . '%')
                  ->orWhere('excerpt', 'like', '%' . $search . '%');
            });
        }

        $articles = $query->paginate(10);

        return response()->json([
            'message' => 'Articles retrieved successfully',
            'data' => $articles
        ]);
    }

    /**
     * Display the specified article by slug (public access)
     */
    public function show(string $slug)
    {
        $article = Articles::with('author:id,name,email')
            ->where('slug', $slug)
            ->where('status', 'published')
            ->first();

        if (!$article) {
            return response()->json([
                'message' => 'Article not found'
            ], 404);
        }

        return response()->json([
            'message' => 'Article retrieved successfully',
            'data' => $article
        ]);
    }

    /**
     * Store a newly created article (admin only)
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'categories' => 'required|string',
                'content' => 'required|string',
                'excerpt' => 'required|string|max:500',
                'status' => 'required|in:draft,published,archived',
                'published_at' => 'nullable|date'
            ]);

            $slug = Str::slug($request->title);
            $originalSlug = $slug;
            $counter = 1;

            // Ensure unique slug
            while (Articles::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }

            $publishedAt = null;
            if ($request->status === 'published') {
                $publishedAt = $request->published_at ? $request->published_at : now();
            } elseif ($request->published_at) {
                $publishedAt = $request->published_at;
            }

            $article = Articles::create([
                'title' => $request->title,
                'categories' => $request->categories,
                'slug' => $slug,
                'content' => $request->content,
                'excerpt' => $request->excerpt,
                'status' => $request->status,
                'published_at' => $publishedAt,
                'author_id' => $request->user()->id
            ]);

            return response()->json([
                'message' => 'Article created successfully',
                'data' => $article->load('author:id,name,email')
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to create article',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified article (admin only)
     */
    public function update(Request $request, string $id)
    {
        try {
            $article = Articles::find($id);

            if (!$article) {
                return response()->json([
                    'message' => 'Article not found'
                ], 404);
            }

            $request->validate([
                'title' => 'sometimes|required|string|max:255',
                'categories' => 'sometimes|required|string',
                'content' => 'sometimes|required|string',
                'excerpt' => 'sometimes|required|string|max:500',
                'status' => 'sometimes|required|in:draft,published,archived',
                'published_at' => 'nullable|date'
            ]);

            $updateData = $request->only([
                'title', 'categories', 'content', 'excerpt', 'status', 'published_at'
            ]);

            // Update slug if title changed
            if ($request->has('title') && $request->title !== $article->title) {
                $slug = Str::slug($request->title);
                $originalSlug = $slug;
                $counter = 1;

                while (Articles::where('slug', $slug)->where('id', '!=', $id)->exists()) {
                    $slug = $originalSlug . '-' . $counter;
                    $counter++;
                }
                $updateData['slug'] = $slug;
            }

            // Set published_at if status changed to published and no published_at is set
            if ($request->has('status') && $request->status === 'published' && !$article->published_at && !$request->has('published_at')) {
                $updateData['published_at'] = now();
            }

            $article->update($updateData);

            return response()->json([
                'message' => 'Article updated successfully',
                'data' => $article->fresh()->load('author:id,name,email')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to update article',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified article (admin only)
     */
    public function destroy(string $id)
    {
        try {
            $article = Articles::find($id);

            if (!$article) {
                return response()->json([
                    'message' => 'Article not found'
                ], 404);
            }

            $article->delete();

            return response()->json([
                'message' => 'Article deleted successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to delete article',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get all articles for admin (including drafts and archived)
     */
    public function adminIndex(Request $request)
    {
        try {
            $query = Articles::with('author:id,name,email')
                ->orderBy('created_at', 'desc');

            // Filter by status if provided
            if ($request->has('status') && $request->status) {
                $query->where('status', $request->status);
            }

            // Filter by category if provided
            if ($request->has('category') && $request->category) {
                $query->where('categories', 'like', '%' . $request->category . '%');
            }

            // Search by title or content
            if ($request->has('search') && $request->search) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('title', 'like', '%' . $search . '%')
                      ->orWhere('content', 'like', '%' . $search . '%')
                      ->orWhere('excerpt', 'like', '%' . $search . '%');
                });
            }

            $articles = $query->paginate(10);

            return response()->json([
                'message' => 'Articles retrieved successfully',
                'data' => $articles
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve articles',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
