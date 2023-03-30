<?php
declare(strict_types=1);
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Api\UserServiceInterface;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(
        protected UserServiceInterface $userService
    )
    {
    }

    public function index()
    {
        dd($this->userService->getUsers());
    }
}
