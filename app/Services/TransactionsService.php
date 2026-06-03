<?php

namespace App\Services;

use App\Constants\TransactionsStatusConstants;
use App\Repositories\TransactionsRepository;
use Exception;

class TransactionsService extends MainService
{

    public function __construct(TransactionsRepository $repository)
    {
        $this->repository = $repository;
    }

    public function store($data)
    {
        $data['status'] = TransactionsStatusConstants::ON_REVIEW;

        $transaction = $this->repository->store($data);
        $this->registerTransactionChange($transaction, 'created', [], $transaction->toArray());

        return $transaction;
    }

    public function update($data, $id)
    {
        $transaction = $this->findTransaction($id);

        if ($transaction->status === TransactionsStatusConstants::APPROVED) {
            throw new Exception('Approved transactions cannot be edited', 403);
        }

        $oldData = $transaction->toArray();
        $data['status'] = TransactionsStatusConstants::ON_REVIEW;

        $transaction->update($data);
        $transaction->refresh();

        $this->registerTransactionChange($transaction, 'updated', $oldData, $transaction->toArray());

        return $transaction;
    }

    public function approve($id)
    {
        return $this->changeStatus($id, TransactionsStatusConstants::APPROVED, 'approved');
    }

    public function reject($id)
    {
        return $this->changeStatus($id, TransactionsStatusConstants::REJECTED, 'rejected');
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

    private function changeStatus($id, string $status, string $action)
    {
        $transaction = $this->findTransaction($id);
        $oldData = $transaction->toArray();

        $transaction->update([
            'status' => $status,
        ]);
        $transaction->refresh();

        $this->registerTransactionChange($transaction, $action, $oldData, $transaction->toArray());

        return $transaction;
    }

    private function findTransaction($id)
    {
        $transaction = $this->repository->show($id);

        if (!$transaction) {
            throw new Exception('Transaction not found', 404);
        }

        return $transaction;
    }

    private function registerTransactionChange($transaction, string $action, array $oldData = [], array $newData = []): void
    {
        // Future audit trail hook: persist transaction changes here.
    }

}
