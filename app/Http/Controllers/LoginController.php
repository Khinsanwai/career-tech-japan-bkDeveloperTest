<?php


namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Resources\LoginResource;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        try {
            // Retrieve the user based on the validated email
            $user = User::where('email', $request->validated('email'))->firstOrFail();

            // Attempt to authenticate using the ctj-api guard
            if (!Auth::guard('ctj-api')->attempt($request->validated())) {
                throw new AuthenticationException('Invalid credentials');
            }

            // Return user data with the LoginResource
            return LoginResource::make($user);

        } catch (AuthenticationException $e) {
            return response()->json([
                'status'  => Response::HTTP_UNAUTHORIZED,
                'message' => $e->getMessage(),
            ], Response::HTTP_UNAUTHORIZED);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status'  => Response::HTTP_NOT_FOUND,
                'message' => 'User not found.',
            ], Response::HTTP_NOT_FOUND);

        } catch (\Throwable $e) {
            return response()->json([
                'status'  => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'Internal server error.',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }
}
