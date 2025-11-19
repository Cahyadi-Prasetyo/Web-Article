<?php

namespace App\Http\Controllers;

use App\Models\Articles;
use Illuminate\Http\Request;

class AdminArticleController extends Controller
{
    // Admin - Lihat semua artikel
    public function index(Request $request)
    {
        $status = $request->query('status');
        
        $query = Articles::with('author')->orderBy('created_at', 'desc');
        
        if ($status) {
            $query->where('status', $status);
        }

        $articles = $query->paginate(20);

        return response()->json($articles);
    }

    // Admin - Lihat artikel pending (menunggu approval)
    public function pending()
    {
        $articles = Articles::with('author')
            ->where('status', 'pending')
            ->orderBy('created_at', 'asc')
            ->paginate(20);

        return response()->json($articles);
    }

    // Admin - Approve artikel (pending -> published)
    public function approve($id)
    {
        $article = Articles::findOrFail($id);

        if ($article->status !== 'pending') {
            return response()->json([
                'message' => 'Only pending articles can be approved'
            ], 403);
        }

        $article->update([
            'status' => 'published',
            'published_at' => now(),
            'rejection_reason' => null
        ]);

        return response()->json([
            'message' => 'Article approved and published',
            'article' => $article
        ]);
    }

    // Admin - Reject artikel (pending -> rejected)
    public function reject(Request $request, $id)
    {
        $validated = $request->validate([
            'rejection_reason' => 'required|string|max:1000'
        ]);

        $article = Articles::findOrFail($id);

        if ($article->status !== 'pending') {
            return response()->json([
                'message' => 'Only pending articles can be rejected'
            ], 403);
        }

        $article->update([
            'status' => 'rejected',
            'rejection_reason' => $validated['rejection_reason']
        ]);

        return response()->json([
            'message' => 'Article rejected',
            'article' => $article
        ]);
    }

    // Admin - Unpublish artikel (published -> archived)
    public function unpublish($id)
    {
        $article = Articles::findOrFail($id);

        if ($article->status !== 'published') {
            return response()->json([
                'message' => 'Only published articles can be unpublished'
            ], 403);
        }

        $article->update([
            'status' => 'archived'
        ]);

        return response()->json([
            'message' => 'Article unpublished',
            'article' => $article
        ]);
    }

    // Admin - Hapus artikel apapun
    public function destroy($id)
    {
        $article = Articles::findOrFail($id);
        $article->delete();

        return response()->json([
            'message' => 'Article deleted successfully'
        ]);
    }
}
