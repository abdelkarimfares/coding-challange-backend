<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\GroupResource;
use App\Services\Api\GroupServiceInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

/**
 * Class Group Controller
 */
class GroupController extends Controller
{
    /**4
     * @param GroupServiceInterface $groupService
     */
    public function __construct(
        protected GroupServiceInterface $groupService
    ){}

    /**
     * Retrieve all groups
     *
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $perPage = (int)$request->input('per_page', 20);
        $pagedGroups = $this->groupService->getGroups($perPage);

        return response()->json([
            'items' => GroupResource::collection($pagedGroups->items()),
            'current_page' => $pagedGroups->currentPage(),
            'count' => $pagedGroups->count(),
            'per_page' => $pagedGroups->perPage()
        ]);
    }

    /**
     * Retrieve single group
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id)
    {
        try {
            $group = $this->groupService->getGroup($id);

            return response()->json(['data' => new GroupResource($group)]);
        } catch (ModelNotFoundException $ex) {
            return response()->json(['data' => null], 404);
        }
    }

    /**
     * Store New group
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $group = $this->groupService->addGroup($request->only(['name', 'description']));

            return response()->json(['data' => new GroupResource($group)], 201);
        } catch (ValidationException $ex) {
            return response()->json(['errors' => $ex->errors()], 403);
        } catch (\Exception $ex) {
            Log::critical($ex->getMessage());
            return response()->json(['message' => __('Internal Server Error')], 500);
        }
    }

    /**
     * Update Existing group
     *
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function update(int $id, Request $request)
    {
        try {
            $group = $this->groupService->editGroup($id, $request->only(['name', 'description']));

            return response()->json(['data' => new GroupResource($group)]);
        } catch (ValidationException $ex) {
            return response()->json(['errors' => $ex->errors()], 403);
        } catch (\Exception $ex) {
            Log::critical($ex->getMessage());
            return response()->json(['message' => __('Internal Server Error')], 500);
        }
    }

    /**
     * Delete existing group
     *
     * @param int $id
     * @return JsonResponse
     */
    public function delete(int $id)
    {
        try {
            $deleted = $this->groupService->deleteGroup($id);

            return response()->json(['deleted' => $deleted]);
        } catch (ModelNotFoundException $ex) {
            return response()->json(['message' => __('Sorry!, this group is not exists')], 404);
        } catch (\Exception|\Throwable $ex) {
            Log::critical($ex->getMessage());
            return response()->json(['message' => __('Internal Server Error')], 500);
        }
    }
}
