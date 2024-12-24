<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GenerateSwaggerDocs extends Command
{
    protected $signature = 'swagger:generate';
    protected $description = 'Generate Swagger documentation';

    public function handle()
    {
        $this->info('Generating Swagger documentation...');
        exec('vendor\bin\openapi --output public/docs/swagger.json app');
        $this->info('Swagger documentation generated successfully!');
    }
}

