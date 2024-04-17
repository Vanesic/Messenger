<?php

declare(strict_types=1);

namespace Application\Model\Resources;

use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\Adapter\Driver\ResultInterface;
use Laminas\Db\ResultSet\ResultSetInterface;
use Laminas\Db\Sql\Select;
use Laminas\Db\Sql\Sql;
use Laminas\Db\TableGateway\TableGateway;

class EmailResources extends TableGateway
{
    /**
     * @var DialogResources
     */
    protected $dialogResources;

    /**
     * @param DialogResources $dialogResources
     * @param $table
     * @param AdapterInterface $adapter
     * @param null $features
     * @param ResultSetInterface|null $resultSetPrototype
     * @param Sql|null $sql
     */
    public function __construct(
        DialogResources     $dialogResources,
        $table,
        AdapterInterface $adapter,
        $features = null,
        ?ResultSetInterface $resultSetPrototype = null,
        ?Sql $sql = null
    ) {
        parent::__construct(
            $table,
            $adapter,
            $features,
            $resultSetPrototype,
            $sql
        );
        $this->dialogResources = $dialogResources;
    }

    /**
     * This method send email notifications for unread messages
     *
     * @return array
     */
    public function sendEmailNotifications()
    {
        var_dump(1);
        $startDate = time();
        $dateValue = date('Y-m-d H:i:s', strtotime('-15 minutes', $startDate));
        $predicate = $this->sql->select()
            ->where
            ->nest()
            ->greaterThanOrEqualTo('send_at', $dateValue)
            ->and
            ->isNull('open_at')
            ->and
            ->isNotNull('is_notificated')
            ->unnest();

        $sqlQuery = $this->sql->select()->quantifier(Select::QUANTIFIER_DISTINCT)
            ->columns([
                "email",
                "id_staff"
            ])
            ->join("messages", "id_staff = id_get", [])
            ->where($predicate);
        $sqlStmt  = $this->sql->prepareStatementForSqlObject($sqlQuery);
        $emails   = $sqlStmt->execute();
        $this->dialogResources->setNotificationTrue(iterator_to_array($emails));
        $email = iterator_to_array($emails);
        return $email;
    }

    /**
     * This method return emails by id
     *
     * @param integer $userId
     * @return ResultInterface
     */
    public function getEmails($userId): ResultInterface
    {
        $asd     = $this->sql->select()
            ->columns(["email"], false)
            ->where(["id_staff" => $userId])->order(['email' => Select::ORDER_ASCENDING]);
        $sqlStmt = $this->sql->prepareStatementForSqlObject($asd);
        return $sqlStmt->execute();
    }

    /**
     * This method update emails
     *
     * @param array $emails
     *
     * @return void
     */
    public function setEmails($emails)
    {
        $oldEmails = [];
        foreach ($this->getEmails($emails['userId']) as $email) {
            $oldEmails[] = $email['email'];
        }

        $emailsRemove = array_diff($oldEmails, $emails['emails']);
        $emailsInsert = array_diff($emails['emails'], $oldEmails);


        if (!empty($emailsRemove) || count($emailsInsert) > 1) {
            $this->deleteEmail($emailsRemove);
        }

        if (!empty($emailsInsert)) {
            for ($i = 0; $i < count($emailsInsert); $i++) {
                $this->insertEmail($emailsInsert[$i], $emails['userId']);
            }
        }
    }

    /**
     * This method delete emails
     *
     * @param array $emailRemove
     *
     * @return void
     */
    public function deleteEmail($emailRemove)
    {
        $sqlQuery = $this->sql->delete()->where(["email" => $emailRemove]);
        $sqlStmt  = $this->sql->prepareStatementForSqlObject($sqlQuery);
        $handler  = $sqlStmt->execute();
    }

    /**
     * This method return emails by id
     *
     * @param integer $userId
     * @param string $emailInsert
     *
     * @return void
     */
    public function insertEmail($emailInsert, $userId)
    {
        if(!empty($emailInsert)) {
            $sqlQuery = $this->sql->insert()
                ->values([
                    "id_staff" => $userId,
                    "email"    => "$emailInsert",
                ]);
            $sqlStmt  = $this->sql->prepareStatementForSqlObject($sqlQuery);
            $handler  = $sqlStmt->execute();
        }
    }

    /**
     * This method set email for register user
     *
     * @param string $email
     * @return ResultInterface
     */
    public function setEmailForRegister($email): ResultInterface
    {
        try {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL))
                throw new \Exception("Incorrect email!");
            $sqlQuery = $this->sql->select()->columns(["email"])
                ->where([
                    'email' => "'$email'"
                ]);
            $sqlStmt  = $this->sql->prepareStatementForSqlObject($sqlQuery);
            $handler  = $sqlStmt->execute();
            foreach ($handler as $emailExist) {
                if ($emailExist['email'] != null) {
                    throw new \Exception('This email is already used');
                }
            }
        } catch (\Exception $exception) {
        }
        $sqlQuery = $this->sql->select()
            ->columns(["id_staff"])
            ->order(['id_staff' => Select::ORDER_DESCENDING])->limit(1);
        $sqlStmt  = $this->sql->prepareStatementForSqlObject($sqlQuery);
        $handler  = $sqlStmt->execute();

        foreach ($handler as $maxId) {
            $staffId  = $maxId['id_staff'];
            $sqlQuery = $this->sql->insert()
                ->columns(["email", "id_staff"])
                ->values(["$email", "$staffId"]);
            $sqlStmt  = $this->sql->prepareStatementForSqlObject($sqlQuery);
            $handler  = $sqlStmt->execute();
            return $handler;
        }
        return $handler;
    }

    /**
     * This method return email request
     *
     * @param string $searchLine
     * @return Select
     */
    public function emailRequest($searchLine) : Select
    {
        $request = $this->sql->select()
            ->quantifier(Select::QUANTIFIER_DISTINCT)
            ->columns(["id_staff"])
            ->where("match (email) against ('$searchLine*' in boolean mode)");
        return $request;
    }
}