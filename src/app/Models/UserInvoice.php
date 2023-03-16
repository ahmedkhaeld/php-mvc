<?php

declare(strict_types=1);
namespace App\Models;

class UserInvoice extends Model
{

    /**
     * @param User $userModel
     * @param Invoice $invoiceModel
     */
    public function __construct(protected User $userModel,protected Invoice $invoiceModel)
    {
        parent::__construct();
    }

    /**
     * @throws \Exception
     */
    public function register(array $user, array $invoice): int
    {
        try {
            $this->db->beginTransaction();

            $userID = $this->userModel->create($user['email'], $user['full_name']);
            $invoiceID = $this->invoiceModel->create($invoice['amount'], $userID);

            $this->db->commit();
        } catch (\Exception $e) {
            if ($this->db->inTransaction()){
                $this->db->rollBack();
            }
            throw $e;
        }

        return $invoiceID;
    }

}