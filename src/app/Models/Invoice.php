<?php

namespace App\Models;

use App\Enums\InvoiceStatus;
use PDO;

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

    public function all(InvoiceStatus $status):array
    {
        //now we are passing the status as enum, so we can't pass any int value

        $stmt=$this->db->prepare(
            'SELECT id, amount, full_name
                  FROM invoices 
                WHERE status=?
                 '
        );

        $stmt->execute([$status->value]);

        $invoices= $stmt->fetchAll(PDO::FETCH_OBJ);

        return $invoices ?: [];
    }

}