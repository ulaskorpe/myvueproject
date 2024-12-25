<?php

namespace App\Console\Commands\GoogleDrive;

use App\Http\Services\GoogleServices;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\File;

class ListFiles extends Command
{


   /**
     * The TransferServices instance.
     *
     * @var GoogleServices
     */
    protected $service;
    public function __construct(GoogleServices $service)
    {
        parent::__construct();
        $this->service = $service;
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'list-google-files';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $this->service->fillFilesTable( config('services.google.folder_id'));



    }
}
