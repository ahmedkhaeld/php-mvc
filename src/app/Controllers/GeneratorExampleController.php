<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Attributes\Route;
use App\Models\Ticket;

class GeneratorExampleController
{

    public function __construct(private Ticket $ticket)
    {
    }
    #[Route('/examples/generator')]
    public function index():void
    {
        echo '<h1>Read Ticket Table Records </h1>';
        foreach ($this->ticket->all() as $ticket) {
            echo '<p>' . $ticket['id'] . ' ' . $ticket['title'] . ' ' . $ticket['content'] . '</p>';
        }

    }



}