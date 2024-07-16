<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Contracts\PornstarImporterInterface;

class ImportPornstars extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import-pornstars';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetches json file of pornstars and imports in the database';

    public function __construct(protected PornstarImporterInterface $pornstarImporter)
    {
        parent::__construct();
    }

    public function handle(): void
    {
        $this->output->writeln('Importing pornstars...');
        $this->pornstarImporter->import();
        $this->output->writeln('Finished importing.');
    }
}
