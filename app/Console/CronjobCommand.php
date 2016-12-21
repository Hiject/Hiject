<?php

/*
 * This file is part of Jitamin.
 *
 * Copyright (C) 2016 Jitamin Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jitamin\Console;

use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Cronjob command class.
 */
class CronjobCommand extends BaseCommand
{
    private $commands = [
        'projects:daily-stats',
        'notification:overdue-tasks',
        'trigger:tasks',
    ];

    protected function configure()
    {
        $this
            ->setName('cronjob')
            ->setDescription('Execute daily cronjob');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        foreach ($this->commands as $command) {
            $job = $this->getApplication()->find($command);
            $job->run(new ArrayInput(['command' => $command]), new NullOutput());
        }
    }
}
