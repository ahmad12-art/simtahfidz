<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class BackupDatabase extends Command
{
    protected $signature = 'backup:database';

    protected $description = 'Membuat cadangan (dump) database MySQL ke storage/app/backups';

    public function handle(): int
    {
        $database = config('database.connections.mysql.database');
        $username = config('database.connections.mysql.username');
        $password = config('database.connections.mysql.password');
        $host = config('database.connections.mysql.host');

        $filename = 'backups/simtahfidz_'.now()->format('Ymd_His').'.sql';
        $path = storage_path('app/'.$filename);

        Storage::makeDirectory('backups');

        $command = sprintf(
            'mysqldump --host=%s --user=%s --password=%s %s > %s 2>&1',
            escapeshellarg($host),
            escapeshellarg($username),
            escapeshellarg($password),
            escapeshellarg($database),
            escapeshellarg($path)
        );

        exec($command, $output, $resultCode);

        if ($resultCode !== 0) {
            $this->error('Backup gagal. Pastikan mysqldump tersedia di server.');

            return self::FAILURE;
        }

        $this->info("Backup berhasil disimpan di storage/app/{$filename}");

        return self::SUCCESS;
    }
}
