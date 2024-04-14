<?php

namespace App\Services;

use App\Constants\TransactionsStatusConstants;
use App\Repositories\TransactionsRepository;

class TransactionsService extends MainService
{

    public function __construct(TransactionsRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getTransactionReport($request)
    {

        $queryStart = ("
            SELECT
                SUM(case when T.value >= 0 then T.value else 0 end) as positive,
                SUM(case when T.value < 0 then T.value else 0 end) as negative,
                FC.name
            FROM transactions AS T

            LEFT JOIn financial_categories FC on T.financial_categories_id = FC.id

            WHERE T.financial_id = " . $request['financial_id'] . " AND T.status =
        " . " ");

        $queryEnd = " GROUP BY T.financial_categories_id, FC.name";

        return [
            'profit' => $this->repository->runRawSql($queryStart . "'" . TransactionsStatusConstants::APPROVED . "'" . $queryEnd),
            'loss' => $this->repository->runRawSql($queryStart . "'" . TransactionsStatusConstants::REJECTED . "'" . $queryEnd),
            'on_review' => $this->repository->runRawSql($queryStart . "'" . TransactionsStatusConstants::ON_REVIEW . "'" . $queryEnd),
        ];
    }

}
