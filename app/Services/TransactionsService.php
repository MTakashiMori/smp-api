<?php

namespace App\Services;

use App\Constants\TransactionsStatusConstants;
use App\Models\Financial;
use App\Models\FinancialCategories;
use App\Models\Transactions;
use App\Repositories\TransactionsRepository;
use App\Support\TenantContext;
use Exception;

class TransactionsService extends MainService
{

    public function __construct(TransactionsRepository $repository, private TenantContext $tenantContext)
    {
        $this->repository = $repository;
    }

    public function store($data)
    {
        $this->validateFinancialReferences($data);
        $data['status'] = TransactionsStatusConstants::ON_REVIEW;

        $transaction = $this->repository->store($data);
        $this->registerTransactionChange($transaction, 'created', [], $transaction->toArray());

        return $transaction;
    }

    public function update($data, $id)
    {
        $this->validateFinancialReferences($data);
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
        Financial::query()
            ->forTenant($this->tenantContext)
            ->findOrFail($request['financial_id']);

        $reportForStatus = function (string $status) use ($request) {
            return Transactions::query()
                ->forTenant($this->tenantContext)
                ->selectRaw('
                    SUM(CASE WHEN value >= 0 THEN value ELSE 0 END) as positive,
                    SUM(CASE WHEN value < 0 THEN value ELSE 0 END) as negative,
                    financial_categories.name
                ')
                ->leftJoin('financial_categories', 'transactions.financial_categories_id', '=', 'financial_categories.id')
                ->where('transactions.financial_id', $request['financial_id'])
                ->where('transactions.status', $status)
                ->groupBy('transactions.financial_categories_id', 'financial_categories.name')
                ->get();
        };

        return [
            'profit' => $reportForStatus(TransactionsStatusConstants::APPROVED),
            'loss' => $reportForStatus(TransactionsStatusConstants::REJECTED),
            'on_review' => $reportForStatus(TransactionsStatusConstants::ON_REVIEW),
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

    private function validateFinancialReferences(array $data): void
    {
        Financial::query()
            ->forTenant($this->tenantContext)
            ->findOrFail($data['financial_id']);

        FinancialCategories::query()
            ->forTenant($this->tenantContext)
            ->where('financial_id', $data['financial_id'])
            ->findOrFail($data['financial_categories_id']);
    }

    private function registerTransactionChange($transaction, string $action, array $oldData = [], array $newData = []): void
    {
        // Future audit trail hook: persist transaction changes here.
    }

}
