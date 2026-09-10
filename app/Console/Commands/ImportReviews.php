<?php

namespace App\Console\Commands;

use App\Services\ReviewImporter;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Throwable;

class ImportReviews extends Command
{
    protected $signature = 'reviews:import
                            {--dry-run : Read new rows without writing reviews or images}
                            {--limit= : Import at most this many sheet rows}';

    protected $description = 'Import new customer reviews from Google Sheets and Drive';

    public function handle(ReviewImporter $importer): int
    {
        $limitOption = $this->option('limit');
        $limit = null;

        if ($limitOption !== null) {
            $limit = filter_var($limitOption, FILTER_VALIDATE_INT);

            if ($limit === false || $limit < 1) {
                $this->error('The --limit option must be a positive integer.');

                return self::FAILURE;
            }
        }

        $lock = Cache::lock('reviews:import', 300);

        if (! $lock->get()) {
            $this->error('A review import is already running.');

            return self::FAILURE;
        }

        try {
            $result = $importer->import(
                (bool) $this->option('dry-run'),
                $limit
            );

            $prefix = $result['dry_run'] ? 'Would import' : 'Imported';
            $this->info(sprintf(
                '%s %d review(s); %d image(s) downloaded; %d row(s) skipped.',
                $prefix,
                $result['imported'],
                $result['images_downloaded'],
                $result['skipped']
            ));
            $this->line('Read from sheet row '.$result['start_row'].'.');

            return self::SUCCESS;
        } catch (Throwable $exception) {
            report($exception);
            $this->error($exception->getMessage());

            return self::FAILURE;
        } finally {
            $lock->release();
        }
    }
}
