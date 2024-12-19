<?php


namespace App\Http\Controllers;

use App\Exceptions\UserAlreadyLikedPostException;
use App\Exceptions\UserLikeOwnPostException;
use App\Http\Requests\PostToggleReactionRequest;
use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;


class PostController extends Controller
{
    // Fetching paginated posts with likes count and tags
    public function list(Request $request)
    {
        $posts = Post::withCount('likes')  
                     ->with('tags')         
                     ->latest()              
                     ->paginate(10);        

        // Return paginated posts using the PostResource collection
        return PostResource::collection($posts);
    }

    // Handle toggling the post reaction (like/unlik
    public function toggleReaction(PostToggleReactionRequest $request)
    {
        try {
            // Retrieve the post with the likes relationship for the current user
            $post = Post::with(['likes' => function ($query) {
                $query->where('user_id', Auth::id());  // Only get the likes for the authenticated user
            }])->findOrFail($request->post_id);  // Find the post by ID

            // Check if the user is trying to like their own post
            if ($post->author_id === Auth::id()) {
                throw new UserLikeOwnPostException("You cannot like your own post.");
            }

            // Check if the user has already liked the post
            $userLike = $post->likes->first(); // Check if the user has already liked the post

            if ($request->like) {
                // If the user hasn't liked the post, add a like
                if (!$userLike) {
                    $post->likes()->create([
                        'user_id' => Auth::id(),
                    ]);
                    return response()->json([
                        'status'  => Response::HTTP_OK,
                        'message' => 'You liked this post successfully.',
                    ]);
                }

                return response()->json([
                    'status'  => Response::HTTP_CONFLICT,
                    'message' => 'You have already liked this post.',
                ], Response::HTTP_CONFLICT);
            }

            // If the user is unliking the post and has already liked it
            if ($userLike) {
                $userLike->delete(); // Remove like
                return response()->json([
                    'status'  => Response::HTTP_OK,
                    'message' => 'You unliked this post successfully.',
                ]);
            }

            // If the user tries to unlike without having liked the post
            return response()->json([
                'status'  => Response::HTTP_NOT_FOUND,
                'message' => 'You have not liked this post.',
            ], Response::HTTP_NOT_FOUND);

        } catch (UserLikeOwnPostException $e) {
            return response()->json([
                'status'  => Response::HTTP_FORBIDDEN,
                'message' => $e->getMessage(),
            ], Response::HTTP_FORBIDDEN);
        } catch (\Throwable $e) {
            return response()->json([
                'status'  => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
