<?php

namespace App\Console\Commands;

use App\Models\Category;
use Illuminate\Console\Command;

class ProcessScheduledPublishing extends Command
{
    protected $signature = 'app:process-scheduled-publishing';
    protected $description = 'Publish/unpublish categories based on scheduled dates';

    public function handle(): void
    {
        $published = Category::whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->where('is_active', false)
            ->update(['is_active' => true]);

        $unpublished = Category::whereNotNull('unpublish_at')
            ->where('unpublish_at', '<=', now())
            ->where('is_active', true)
            ->update(['is_active' => false]);

        $this->info("Published: {$published}, Unpublished: {$unpublished}");
    }
}
