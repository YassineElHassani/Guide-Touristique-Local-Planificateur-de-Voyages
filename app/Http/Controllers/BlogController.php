<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogComment;
use App\Models\categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    /**
     * Display a listing of all blog posts.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        try {
            $blogs = Blog::published()
                ->with('user')
                ->withCount('comments')
                ->orderBy('created_at', 'desc')
                ->paginate(9);
            
            $featuredBlogs = Blog::published()
                ->featured()
                ->with('user')
                ->take(3)
                ->get();
            
            $categories = Blog::select('category')
                ->distinct()
                ->whereNotNull('category')
                ->get()
                ->pluck('category');
            
            return view('admin.blogs.index', compact('blogs', 'featuredBlogs', 'categories'));
        } catch (\Exception $e) {
            Log::error('Error loading blogs: ' . $e->getMessage());
            return view('admin.blogs.index')
                ->with('error', 'There was an error loading the blog posts. Please try again later.');
        }
    }

    /**
     * Show the form for creating a new blog post.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function create()
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You need to be logged in to create a blog post.');
        }
        
        try {
            $categories = categories::all();
            
            return view('admin.blogs.create', compact('categories'));
        } catch (\Exception $e) {
            Log::error('Error loading blog create form: ' . $e->getMessage());
            return redirect()->route('admin.blogs.index')
                ->with('error', 'There was an error loading the create form. Please try again later.');
        }
    }

    /**
     * Store a newly created blog post in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You need to be logged in to create a blog post.');
        }
        
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'category' => 'nullable|string|max:100',
                'excerpt' => 'nullable|string|max:500',
                'published' => 'nullable|boolean',
                'featured' => 'nullable|boolean',
            ]);
            
            $blogData = [
                'user_id' => Auth::id(),
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'content' => $request->content,
                'category' => $request->category,
                'excerpt' => $request->excerpt ?? Str::limit(strip_tags($request->content), 150),
                'published' => $request->has('published') ? true : false,
                'featured' => $request->has('featured') ? true : false,
            ];
            
            // Handle image upload
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('blogs', 'public');
                $blogData['image'] = $imagePath;
            }
            
            $blog = Blog::create($blogData);
            
            return redirect()->route('blogs.show', $blog->slug)
                ->with('success', 'Blog post created successfully.');
        } catch (\Exception $e) {
            Log::error('Error creating blog post: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error creating blog post: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified blog post.
     *
     * @param  string  $slug
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function show($slug)
    {
        try {
            $blog = Blog::where('slug', $slug)
                ->with(['user', 'comments.user'])
                ->firstOrFail();
            
            // Increment view count
            $blog->increment('views');
            
            // Get related blog posts
            $relatedBlogs = Blog::published()
                ->where('id', '!=', $blog->id)
                ->where(function($query) use ($blog) {
                    $query->where('category', $blog->category)
                        ->orWhere('user_id', $blog->user_id);
                })
                ->with('user')
                ->take(3)
                ->get();
            
            // Get latest blog posts
            $latestBlogs = Blog::published()
                ->where('id', '!=', $blog->id)
                ->with('user')
                ->orderBy('created_at', 'desc')
                ->take(4)
                ->get();
            
            return view('admin.blogs.show', compact('blog', 'relatedBlogs', 'latestBlogs'));
        } catch (\Exception $e) {
            Log::error('Error showing blog post: ' . $e->getMessage());
            return redirect()->route('admin.blogs.index')
                ->with('error', 'The blog post you are looking for does not exist or has been removed.');
        }
    }

    /**
     * Show the form for editing the specified blog post.
     *
     * @param  string  $slug
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit($slug)
    {
        try {
            $blog = Blog::where('slug', $slug)->firstOrFail();
            
            // Check if user is authenticated and is the author of the blog post
            if (!Auth::check() || Auth::id() !== $blog->user_id) {
                return redirect()->route('blogs.show', $blog->slug)
                    ->with('error', 'You are not authorized to edit this blog post.');
            }
            
            $categories = categories::all();
            
            return view('admin.blogs.edit', compact('blog', 'categories'));
        } catch (\Exception $e) {
            Log::error('Error editing blog post: ' . $e->getMessage());
            return redirect()->route('admin.blogs.index')
                ->with('error', 'The blog post you are trying to edit does not exist or has been removed.');
        }
    }

    /**
     * Update the specified blog post in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $slug
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $slug)
    {
        try {
            $blog = Blog::where('slug', $slug)->firstOrFail();
            
            // Check if user is authenticated and is the author of the blog post
            if (!Auth::check() || Auth::id() !== $blog->user_id) {
                return redirect()->route('admin.blogs.show', $blog->slug)
                    ->with('error', 'You are not authorized to edit this blog post.');
            }
            
            $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'category' => 'nullable|string|max:100',
                'excerpt' => 'nullable|string|max:500',
                'published' => 'nullable|boolean',
                'featured' => 'nullable|boolean',
            ]);
            
            $blogData = [
                'title' => $request->title,
                'content' => $request->content,
                'category' => $request->category,
                'excerpt' => $request->excerpt ?? Str::limit(strip_tags($request->content), 150),
                'published' => $request->has('published') ? true : false,
                'featured' => $request->has('featured') ? true : false,
            ];
            
            // Update slug if title has changed
            if ($blog->title !== $request->title) {
                $blogData['slug'] = Str::slug($request->title);
            }
            
            // Handle image upload
            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($blog->image) {
                    Storage::disk('public')->delete($blog->image);
                }
                $imagePath = $request->file('image')->store('events', 'public');
                $blogData['image'] = $imagePath;
            }
            
            $blog->update($blogData);
            
            return redirect()->route('admin.blogs.show', $blog->slug)
                ->with('success', 'Blog post updated successfully.');
        } catch (\Exception $e) {
            Log::error('Error updating blog post: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error updating blog post: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified blog post from storage.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($slug)
    {
        try {
            $blog = Blog::where('slug', $slug)->firstOrFail();
            
            // Check if user is authenticated and is the author of the blog post or an admin
            if (!Auth::check() || (Auth::id() !== $blog->user_id && Auth::user()->role !== 'admin')) {
                return redirect()->route('admin.blogs.show', $blog->slug)
                    ->with('error', 'You are not authorized to delete this blog post.');
            }
            
            // Delete image if exists
            if ($blog->image) {
                Storage::delete('public/' . $blog->image);
            }
            
            // Delete associated comments
            BlogComment::where('blog_id', $blog->id)->delete();
            
            $blog->delete();
            
            return redirect()->route('admin.blogs.index')
                ->with('success', 'Blog post deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error deleting blog post: ' . $e->getMessage());
            return redirect()->route('admin.blogs.index')
                ->with('error', 'Error deleting blog post: ' . $e->getMessage());
        }
    }

    /**
     * Display blog posts by category.
     *
     * @param  string  $category
     * @return \Illuminate\Contracts\View\View
     */
    public function byCategory($category)
    {
        try {
            $blogs = Blog::published()
                ->where('category', $category)
                ->with('user')
                ->withCount('comments')
                ->orderBy('created_at', 'desc')
                ->paginate(9);
            
            $categories = Blog::select('category')
                ->distinct()
                ->whereNotNull('category')
                ->get()
                ->pluck('category');
            
            return view('blogs.by_category', compact('blogs', 'category', 'categories'));
        } catch (\Exception $e) {
            Log::error('Error loading blogs by category: ' . $e->getMessage());
            return view('blogs.by_category')
                ->with('error', 'There was an error loading the blog posts. Please try again later.');
        }
    }

    /**
     * Search blog posts.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\View\View
     */
    public function search(Request $request)
    {
        try {
            $query = $request->input('query');
            $categoryFilter = $request->input('category');
            
            $blogsQuery = Blog::published()->with('user')->withCount('comments');
            
            if (!empty($query)) {
                $blogsQuery->where(function ($q) use ($query) {
                    $q->where('title', 'like', '%' . $query . '%')
                      ->orWhere('content', 'like', '%' . $query . '%');
                });
            }
            
            if (!empty($categoryFilter)) {
                $blogsQuery->where('category', $categoryFilter);
            }
            
            $blogs = $blogsQuery->orderBy('created_at', 'desc')->paginate(9);
            
            $categories = Blog::select('category')
                ->distinct()
                ->whereNotNull('category')
                ->get()
                ->pluck('category');
            
            return view('blogs.search_results', compact('blogs', 'query', 'categoryFilter', 'categories'));
        } catch (\Exception $e) {
            Log::error('Error searching blogs: ' . $e->getMessage());
            return view('blogs.search_results')
                ->with('error', 'There was an error searching for blog posts. Please try again later.');
        }
    }

    /**
     * Store a newly created comment in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $slug
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeComment(Request $request, $slug)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'You need to be logged in to comment on a blog post.');
        }
        
        try {
            $blog = Blog::where('slug', $slug)->firstOrFail();
            
            $request->validate([
                'content' => 'required|string',
            ]);
            
            BlogComment::create([
                'blog_id' => $blog->id,
                'user_id' => Auth::id(),
                'content' => $request->content,
            ]);
            
            return redirect()->route('admin.blogs.show', $blog->slug)
                ->with('success', 'Comment added successfully.');
        } catch (\Exception $e) {
            Log::error('Error adding comment: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Error adding comment: ' . $e->getMessage());
        }
    }

    /**
     * Display a listing of all blog posts for admin.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function adminIndex() 
    {
        try {
            $blogs = Blog::with('user')
                ->withCount('comments')
                ->orderBy('created_at', 'desc')
                ->paginate(15);
            
            return view('admin.blogs.index', compact('blogs'));
        } catch (\Exception $e) {
            Log::error('Error loading admin blogs: ' . $e->getMessage());
            return redirect()->route('admin.dashboard.index')
                ->with('error', 'Error loading blogs: ' . $e->getMessage());
        }
    }

    /**
     * Toggle the published status of a blog post.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateStatus(Request $request, $id)
    {
        try {
            $blog = Blog::findOrFail($id);
            
            $request->validate([
                'published' => 'required|boolean',
            ]);
            
            $blog->update([
                'published' => $request->published,
            ]);
            
            return redirect()->route('admin.blogs.index')
                ->with('success', 'Blog published status updated successfully.');
        } catch (\Exception $e) {
            Log::error('Error updating blog status: ' . $e->getMessage());
            return redirect()->route('admin.blogs.index')
                ->with('error', 'Error updating blog status: ' . $e->getMessage());
        }
    }

    /**
     * Toggle the featured status of a blog post.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggleFeatured($id)
    {
        try {
            $blog = Blog::findOrFail($id);
            $blog->featured = !$blog->featured;
            $blog->save();
            
            return redirect()->route('admin.blogs.index')
                ->with('success', 'Blog featured status toggled successfully.');
        } catch (\Exception $e) {
            Log::error('Error toggling blog featured status: ' . $e->getMessage());
            return redirect()->route('admin.blogs.index')
                ->with('error', 'Error toggling blog featured status: ' . $e->getMessage());
        }
    }

    /**
     * Display all comments for admin.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function adminComments()
    {
        try {
            $comments = BlogComment::with(['user', 'blog'])
                ->orderBy('created_at', 'desc')
                ->paginate(15);
            
            return view('admin.comments', compact('comments'));
        } catch (\Exception $e) {
            Log::error('Error loading admin comments: ' . $e->getMessage());
            return redirect()->route('admin.dashboard.index')
                ->with('error', 'Error loading comments: ' . $e->getMessage());
        }
    }

    /**
     * Display specific comment for admin.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function showComment($id)
    {
        try {
            $comment = BlogComment::with(['user', 'blog'])->findOrFail($id);
            
            return view('admin.comments.show', compact('comment'));
        } catch (\Exception $e) {
            Log::error('Error showing comment: ' . $e->getMessage());
            return redirect()->route('admin.comments.index')
                ->with('error', 'Error showing comment: ' . $e->getMessage());
        }
    }

    /**
     * Update the comment.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateComment(Request $request, $id)
    {
        try {
            $comment = BlogComment::findOrFail($id);
            
            $request->validate([
                'content' => 'required|string',
            ]);
            
            $comment->update([
                'content' => $request->content,
            ]);
            
            return redirect()->route('admin.comments.index')
                ->with('success', 'Comment updated successfully.');
        } catch (\Exception $e) {
            Log::error('Error updating comment: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error updating comment: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified comment from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroyComment($id)
    {
        try {
            $comment = BlogComment::findOrFail($id);
            $comment->delete();
            
            return redirect()->back()
                ->with('success', 'Comment deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error deleting comment: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Error deleting comment: ' . $e->getMessage());
        }
    }

    /**
     * Display the user's blog posts.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function myBlogs()
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'You need to be logged in to view your blog posts.');
        }
        
        try {
            $blogs = Blog::where('user_id', Auth::id())
                ->withCount('comments')
                ->orderBy('created_at', 'desc')
                ->paginate(10);
            
            return view('blogs.my_blogs', compact('blogs'));
        } catch (\Exception $e) {
            Log::error('Error loading my blogs: ' . $e->getMessage());
            return redirect()->route('blogs.index')
                ->with('error', 'Error loading your blog posts. Please try again later.');
        }
    }
}