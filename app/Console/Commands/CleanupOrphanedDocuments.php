<?php

namespace App\Console\Commands;

use App\Models\Document;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class CleanupOrphanedDocuments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:cleanup-orphaned-documents {--dry-run : Show what would be deleted without actually deleting}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean up orphaned document files that exist in storage but not in database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting orphaned documents cleanup...');

        $dryRun = $this->option('dry-run');

        $storageFiles = $this->getAllStorageFiles();
        $this->info('Found '.count($storageFiles).' files in storage');

        $databaseFiles = Document::whereNotNull('file_path')->pluck('file_path')->toArray();
        $this->info('Found '.count($databaseFiles).' files in database');

        $orphanedFiles = array_diff($storageFiles, $databaseFiles);

        if (empty($orphanedFiles)) {
            $this->info('No orphaned files found!');

            return 0;
        }

        $this->warn('Found '.count($orphanedFiles).' orphaned files:');

        $totalSize = 0;
        foreach ($orphanedFiles as $file) {
            $size = Storage::disk('local')->size($file);
            $totalSize += $size;
            $this->line("  - {$file} (".$this->formatBytes($size).')');
        }

        $this->info('Total size to be freed: '.$this->formatBytes($totalSize));

        if ($dryRun) {
            $this->info('DRY RUN: No files were deleted. Run without --dry-run to actually delete files.');

            return 0;
        }

        if (! $this->confirm('Do you want to delete these orphaned files?')) {
            $this->info('Operation cancelled.');

            return 0;
        }

        $deletedCount = 0;
        $deletedSize = 0;

        foreach ($orphanedFiles as $file) {
            try {
                $size = Storage::disk('local')->size($file);
                if (Storage::disk('local')->delete($file)) {
                    $deletedCount++;
                    $deletedSize += $size;
                    $this->line("Deleted: {$file}");
                } else {
                    $this->error("Failed to delete: {$file}");
                }
            } catch (Exception $e) {
                $this->error("Error deleting {$file}: ".$e->getMessage());
            }
        }

        $this->info("Cleanup complete! Deleted {$deletedCount} files, freed ".$this->formatBytes($deletedSize));

        return 0;
    }

    /**
     * Get all files from the documents storage directory
     */
    private function getAllStorageFiles(): array
    {
        $files = Storage::disk('local')->allFiles('work-application-documents');

        return array_filter($files, function ($file) {
            return pathinfo($file, PATHINFO_EXTENSION) === 'pdf';
        });
    }

    /**
     * Format bytes into readable format
     */
    private function formatBytes($bytes, $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];

        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, $precision).' '.$units[$i];
    }
}
