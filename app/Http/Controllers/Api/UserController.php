<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Services\Api\UserServiceInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

/**
 * User Controller class
 */
class UserController extends Controller
{
    /**
     * @param UserServiceInterface $userService
     */
    public function __construct(
        protected UserServiceInterface $userService
    ){}

    /**
     * Get All users
     *
     * @return JsonResponse
     */
    public function index()
    {
        $pagedUsers = $this->userService->getUsers();
        return response()->json([
            'items' => UserResource::collection($pagedUsers->items()),
            'current_page' => $pagedUsers->currentPage(),
            'count' => $pagedUsers->total(),
            'per_page' => $pagedUsers->perPage()
        ]);
    }

    /**
     * Get User By Id
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id)
    {
        try {
            $user = $this->userService->getUser($id);

            return response()->json(['data' => new UserResource($user, true)]);
        } catch (ModelNotFoundException) {
            return response()->json(['data' => null], 404);
        }
    }

    /**
     * Store New user
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $data = $this->getRequestedData($request);
        $data['type'] = 'customer';

        try {
            $user = $this->userService->addUser($data);

            return response()->json(['data' => new UserResource($user)], 201);
        } catch (ValidationException $ex) {
            return response()->json(['errors' => $ex->errors()], 403);
        } catch (\Exception $ex) {
            Log::critical($ex->getMessage());
            return response()->json(['message' => __('Internal Server Error')], 500);
        }
    }

    /**
     * Update Existing User
     *
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function update(int $id, Request $request)
    {
        $data = $this->getRequestedData($request);
        try {
            $user = $this->userService->editUser($id, $data);

            return response()->json(['data' => new UserResource($user)]);
        } catch (ValidationException $ex) {
            return response()->json(['errors' => $ex->errors()], 403);
        } catch (\Exception $ex) {
            Log::critical($ex->getMessage());
            return response()->json(['message' => __('Internal Server Error')], 500);
        }
    }

    /**
     * Delete existing user
     *
     * @param int $id
     * @return JsonResponse
     */
    public function delete(int $id)
    {
        try {
            $deleted = $this->userService->deleteUser($id);

            return response()->json(['deleted' => $deleted], 200);
        } catch (ModelNotFoundException $ex) {
            return response()->json(['message' => __('Sorry!, this user is not exists')], 404);
        } catch (\Exception|\Throwable $ex) {
            Log::critical($ex->getMessage());
            return response()->json(['message' => __('Internal Server Error')], 500);
        }
    }

    /**
     * Get the posted Data from request
     *
     * @param Request $request
     * @return array
     */
    protected function getRequestedData(Request $request): array
    {
        return $request->only([
            'username',
            'firstname',
            'lastname',
            'phone',
            'age',
            'type',
            'email',
            'password',
            'groups'
        ]);
    }
}
