<?php

namespace App\Models;

class Invoice extends Model
{


    public function create(int $amount, int $userID):int
    {
        $stmt=$this->db->prepare(
            'INSERT INTO invoices (amount, user_id)
                    VALUES (?, ?)'
        );

        $stmt->execute([$amount,$userID]);

        return (int)$this->db->lastInsertId();
    }

    public function find(int $invoiceID):array
    {
        $stmt=$this->db->prepare(
            'SELECT invoices.id, amount, full_name
                  FROM invoices 
                  LEFT JOIN users ON invoices.user_id=users.id
                  WHERE invoices.id=?'
        );

        $stmt->execute([$invoiceID]);

        $invoice= $stmt->fetch();

        return $invoice ?: [];
    }

}