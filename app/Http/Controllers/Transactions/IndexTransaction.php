<?php

namespace App\Http\Controllers\Transactions;

use App\Constants\HttpStatusConstants;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Infrastructure\Interfaces\Repositories\TransactionRepositoryInterface;
use App\Repository\TransactionRepository;
use App\Service\Responser;

class IndexTransaction extends Controller
{
    public function getThreeUserHasMostTransaction()
    {
        /* @var $accountRepo TransactionRepository*/
        $accountRepo = app(TransactionRepositoryInterface::class);

        $threeUser = $accountRepo->getThreeUserHaveMostTransaction();

        return response()->json(
            Responser::success(UserResource::collection($threeUser)),
            HttpStatusConstants::SUCCESS
        );
    }
}
