<?php

namespace App\Console\Commands;

use App\Support\LegacyTemplateImporter;
use Illuminate\Console\Command;

class ImportLegacyTemplates extends Command
{
    protected $signature = 'template:import-legacy';

    protected $description = 'Import the original template download catalog into the template manager';

    public function handle(LegacyTemplateImporter $importer): int
    {
        $stats = $importer->import();

        $this->info(sprintf(
            'Imported %d products, %d blocks, %d rows, and %d downloads. Skipped %d existing or empty products.',
            $stats['products'],
            $stats['blocks'],
            $stats['rows'],
            $stats['downloads'],
            $stats['skipped'],
        ));

        return self::SUCCESS;
    }
}
