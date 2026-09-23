<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\TemplateProduct;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class TemplateController extends Controller
{
    public function __invoke(): View
    {
        $templateProducts = Schema::hasTable('template_products')
            ? TemplateProduct::query()
                ->active()
                ->with('blocks.rows.downloads')
                ->orderBy('sort_order')
                ->orderBy('name')
                ->get()
            : collect();

        return view('template.index', [
            'templateProducts' => $templateProducts,
        ]);
    }
}
