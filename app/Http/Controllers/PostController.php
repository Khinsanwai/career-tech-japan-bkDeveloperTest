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
    public function list()
    {
        $posts = Post::with(['user', 'likes', 'tags'])
                     ->withCount('likes')
                     ->paginate(10);
    
        return new PostCollection($posts);
    }
    
    // Handle toggling the post reaction (like/unlik
    public function toggleReaction(PostToggleReactionRequest $request)
    {
        try {
            $post = Post::findOrFail($request->validated('post_id'));
            $user = Auth::user();
    
            if ($post->user_id === $user->id) {
                throw new UserLikeOwnPostException('You cannot like your own post.');
            }
    
            $existingLike = $post->likes()->where('user_id', $user->id)->first();
    
            if ($request->boolean('like')) {
                if ($existingLike) {
                    throw new UserAlreadyLikedPostException('You have already liked this post.');
                }
    
                $post->likes()->create(['user_id' => $user->id]);
    
                return response()->json([
                    'status'  => Response::HTTP_OK,
                    'message' => 'You liked this post successfully.',
                ], Response::HTTP_OK);
            }
    
            if ($existingLike) {
                $existingLike->delete();
    
                return response()->json([
                    'status'  => Response::HTTP_OK,
                    'message' => 'You unliked this post successfully.',
                ], Response::HTTP_OK);
            }
    
            return response()->json([
                'status'  => Response::HTTP_BAD_REQUEST,
                'message' => 'You have not liked this post yet.',
            ], Response::HTTP_BAD_REQUEST);
    
        } catch (UserLikeOwnPostException | UserAlreadyLikedPostException $e) {
            return response()->json([
                'status'  => Response::HTTP_BAD_REQUEST,
                'message' => $e->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status'  => Response::HTTP_NOT_FOUND,
                'message' => 'Post not found.',
            ], Response::HTTP_NOT_FOUND);
        } catch (\Throwable $e) {
            return response()->json([
                'status'  => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'Internal server error.',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    
}
