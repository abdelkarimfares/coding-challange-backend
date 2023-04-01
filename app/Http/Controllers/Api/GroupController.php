<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\GroupResource;
use App\Services\Api\GroupServiceInterface;
use Illuminate\Http\JsonResponse;

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
    public function index()
    {
        return response()->json(['groups' => GroupResource::collection($this->groupService->getGroups())]);
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
}
