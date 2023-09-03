<?php

namespace App\Services;

use Spatie\Browsershot\Browsershot;
use Illuminate\Support\Facades\Log;
use App\Services\BrowserShotService;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class BrowserShotService
{
    private $browserShot = null;

    public function __construct()
    {
        $this->browserShot = new Browsershot();
    }

    public function getScreenShot(string $url)
    {
        if (!$url) {
            return '';
        }
        try {
            $filename = uniqid();
            $process = new Process(['node', '../screenshot.cjs', $url, $filename]);
            $process->run();
            if (!$process->isSuccessful()) {
                throw new ProcessFailedException($process);
            }
            Log::info('Screenshot Output.', ['message' => $process->getOutput()]);
            return config('app.url') . '/storage/' . $filename . '.png';
        } catch (\Exception $e) {
            Log::error('Screenshot Error.', ['message' => $e->getMessage()]);
        }
        return '';
    }
}

