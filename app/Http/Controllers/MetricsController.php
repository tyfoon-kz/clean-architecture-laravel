<?php

namespace App\Http\Controllers;

use App\Support\Metrics\MetricsRenderer;
use Illuminate\Http\Response;

class MetricsController extends Controller
{
    public function __invoke(MetricsRenderer $renderer): Response
    {
        return response($renderer->render(), 200, [
            'Content-Type' => 'text/plain; version=0.0.4; charset=utf-8',
        ]);
    }
}
