<?php

declare(strict_types = 1);

namespace App\Models;

use Generator;

class Ticket extends Model
{
    public function all(): Generator
    {
        $stmt = $this->db->query(
            'SELECT id, title, content
             FROM tickets'
        );

        return $this->fetchLazy($stmt);
    }
}