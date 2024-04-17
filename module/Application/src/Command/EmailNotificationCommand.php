<?php

namespace Application\Command;

use Application\Model\Repositories\StaffRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class EmailNotificationCommand extends Command
{
    /**
     * @var StaffRepository
     */
    public $staffTable;

    public function __construct(StaffRepository $staffTable, string $name = null)
    {
        $this->staffTable = $staffTable;
        parent::__construct($name);
    }

    /** @var string */
    protected static $defaultName = 'email-notification-command';

    protected function configure(): void
    {
        $this->setName(self::$defaultName);
        $this->addOption('sendEmail', null, InputOption::VALUE_REQUIRED, 'Module name');
        $emails = $this->staffTable->sendEmailNotifications();
        for ($i = 0; $i < count($emails); $i++) {
            mail($emails[0]["email"], "MessageNotification", "You have the unread messages");
        }
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Send email notification' . $input->getOption('sendEmail'));

        return 0;
    }

}