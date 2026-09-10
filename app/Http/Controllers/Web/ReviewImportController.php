<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\ReviewImporter;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Throwable;

class ReviewImportController extends Controller
{
    /**
     * Compatibility endpoint for the old get_data_review.php URL.
     */
    public function __invoke(Request $request, ReviewImporter $importer): JsonResponse
    {
        $expectedToken = trim((string) config('reviews.import_token', ''));

        if (
            $expectedToken !== ''
            && ! hash_equals(
                $expectedToken,
                (string) $request->query('token', '')
            )
        ) {
            return response()->json([
                'message' => 'Unauthorized review import request.',
            ], 403);
        }

        $lock = Cache::lock('reviews:import', 300);

        if (! $lock->get()) {
            return response()->json([
                'message' => 'A review import is already running.',
            ], 409);
        }

        try {
            return response()->json($importer->import());
        } catch (Throwable $exception) {
            report($exception);

            return response()->json([
                'message' => $exception->getMessage(),
            ], 500);
        } finally {
            $lock->release();
        }
    }
}
