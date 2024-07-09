<?php

declare(strict_types=1);

namespace Creatuity\AdminActionNotification\Command;

use Creatuity\AdminActionNotification\Model\Notification\RunNotificationRules;
use Magento\Framework\Console\Cli;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SendNotificationsCommand extends Command
{
    public function __construct(
        private readonly RunNotificationRules $runNotificationRules
    )
    {
        parent::__construct('creatuity:admin-notifications:send');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->runNotificationRules->execute();

        return Cli::RETURN_SUCCESS;
    }
}