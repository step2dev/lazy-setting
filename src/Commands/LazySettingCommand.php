<?php

namespace Step2Dev\LazySetting\Commands;

use Illuminate\Console\Command;

class LazySettingCommand extends Command
{
    public $signature = 'lazy-setting';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
