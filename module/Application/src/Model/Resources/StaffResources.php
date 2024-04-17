<?php

declare(strict_types=1);

namespace Application\Model\Resources;

use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\Adapter\Driver\ResultInterface;
use Laminas\Db\ResultSet\ResultSetInterface;
use Laminas\Db\Sql\Select;
use Laminas\Db\Sql\Sql;
use Laminas\Db\TableGateway\TableGateway;


class StaffResources extends TableGateway
{
    /**
     * @var EmailResources
     */
    protected $emailsResources;

    /**
     * @var TelephoneResources
     */
    protected $telephoneResources;

    /**
     * @var DialogResources
     */
    protected $dialogResources;

    /**
     * Need for pagination
     *
     * @const integer CONST_PAGINATION
     */
    const CONST_PAGINATION = 20;


    /**
     * @param EmailResources $emailsResources
     * @param TelephoneResources $telephoneResources
     * @param DialogResources $dialogResources
     * @param $table
     * @param AdapterInterface $adapter
     * @param null $features
     * @param ResultSetInterface|null $resultSetPrototype
     * @param Sql|null $sql
     */
    public function __construct(
        EmailResources      $emailsResources,
        TelephoneResources  $telephoneResources,
        DialogResources     $dialogResources,
                            $table,
        AdapterInterface    $adapter,
                            $features = null,
        ?ResultSetInterface $resultSetPrototype = null,
        ?Sql                $sql = null
    ) {
        parent::__construct(
            $table,
            $adapter,
            $features,
            $resultSetPrototype,
            $sql
        );
        $this->emailsResources    = $emailsResources;
        $this->telephoneResources = $telephoneResources;
        $this->dialogResources    = $dialogResources;
    }

    /**
     * This method return all users info
     *
     * @return ResultInterface
     */
    public function getUsers(): ResultInterface
    {
        $sqlQuery = $this->sql->select()->order([
            'is_online' => Select::ORDER_DESCENDING,
            'lastname'  => Select::ORDER_ASCENDING,
        ]);
        $sqlStmt  = $this->sql->prepareStatementForSqlObject($sqlQuery);
        $handler  = $sqlStmt->execute();

        return $handler;
    }

    /**
     * Return all users info for exist dialogs
     *
     * @param integer $userId
     * @return ResultInterface
     */
    public function getExistDialogs($userId): ResultInterface
    {
        $dialogId = $this->dialogResources->getDialogsId($userId);
        $sqlQuery = $this->sql->select()->quantifier(Select::QUANTIFIER_DISTINCT)->columns([
            "lastname",
            "firstname",
            "middlename",
            "staffs.id",
            "photo"
        ], false)
            ->join(
                "messages", 'staffs.id = id_get', [],
            )
            ->where([
                'id_dialog' => $dialogId,
                new \Laminas\Db\Sql\Predicate\Expression("staffs.id != $userId")
            ]);
        $sqlStmt  = $this->sql->prepareStatementForSqlObject($sqlQuery);
        $handler  = $sqlStmt->execute();

        return $handler;
    }

    /**
     * This method send message
     *
     * @param integer $userId
     * @param integer $receiverId
     * @param string $message
     *
     * @return void
     */
    public function sendMessage($userId, $receiverId, $message)
    {
        $this->dialogResources->sendMessage($userId, $receiverId, $message);
    }

    /**
     * Return all users info for doesn't exist dialog
     *
     * @param integer $userId
     * @return ResultInterface
     */
    public function getNotExistDialogs($userId): ResultInterface
    {
        $dialogId = $this->dialogResources->getDialogsId($userId);

        $staffId  = $this->sql->select()
            ->columns([
                "id"
            ])
            ->join("messages", "staffs.id = id_get", [])
            ->where([
                'id_dialog' => $dialogId,
            ]);
        $sqlStmt  = $this->sql->prepareStatementForSqlObject($staffId);
        $staffId  = $sqlStmt->execute();
        $id       = iterator_to_array($staffId);
        $resultId = [];
        array_walk_recursive($id, function ($item) use (&$resultId) {
            $resultId[] = $item;
        });
        $sqlQuery = $this->sql->select()
            ->columns([
                "lastname",
                "firstname",
                "middlename",
                "id",
                "photo"
            ])
            ->where([
                new \Laminas\Db\Sql\Predicate\NotIn('staffs.id', $resultId)
            ]);
        $sqlStmt  = $this->sql->prepareStatementForSqlObject($sqlQuery);
        $handler  = $sqlStmt->execute();
        return $handler;
    }

    /**
     * Return last message in dialog
     *
     * @param integer $userId
     * @param ResultInterface $companion
     * @return array
     */
    public function getLastMessageById($userId, $companion): array
    {
        return $this->dialogResources->getLastMessagesInDialogsById($userId, $companion);
    }

    /**
     * This method return filtered user's info for dialogs
     *
     * @param $searchLine
     * @param string $request
     * @return ResultInterface|null
     */
    public function getDialogAllFilters($searchLine, $request)
    {
        $nameRequest  = $this->sql->select()
            ->quantifier(Select::QUANTIFIER_DISTINCT)
            ->columns(["id"])
            ->where("match (lastname, firstname, middlename) against ('$searchLine*' in boolean mode)");
        $emailRequest = $this->emailsResources->emailRequest($searchLine)->combine($nameRequest);
        $sqlStmt      = $this->sql->prepareStatementForSqlObject($emailRequest);
        $id           = $sqlStmt->execute();
        $id           = iterator_to_array($id);
        $resultId     = [];
        array_walk_recursive($id, function ($item) use (&$resultId) {
            $resultId[] = $item;
        });
        if (!empty($resultId)) {
            $sqlQuery = $this->sql->select()->quantifier(Select::QUANTIFIER_DISTINCT)
                ->columns([
                    "staffs.id",
                    "lastname",
                    "firstname",
                    "middlename"
                ], false)
                ->join(
                    "emails", 'staffs.id = emails.id_staff', []
                )
                ->join(
                    "telephones", 'staffs.id = telephones.id_staff', []
                );
            if (!empty($request)) {
                $sqlQuery->where($request);
            }
            $sqlQuery->order([
                'lastname' => Select::ORDER_ASCENDING,
            ])
                ->limit(self::CONST_PAGINATION);
            $sqlStmt = $this->sql->prepareStatementForSqlObject($sqlQuery);
            $handler = $sqlStmt->execute();
            return $handler;
        }
        return null;
    }

    /**
     * This method return user's emails
     *
     * @param integer $userId
     * @return ResultInterface
     */
    public function getEmailsById($userId): ResultInterface
    {
        return $this->emailsResources->getEmails($userId);
    }

    /**
     * This method return user's telephones
     *
     * @param integer $userId
     * @return ResultInterface
     */
    public function getTelephoneById($userId): ResultInterface
    {
        return $this->telephoneResources->getTelephone($userId);
    }

    /**
     * This method return messages in dialog
     *
     * @param integer $senderId
     * @param integer $getterId
     * @return ResultInterface
     */
    public function getMessagesById($senderId, $getterId): ResultInterface
    {
        return $this->dialogResources->getAllMessagesById($senderId, $getterId);
    }

    /**
     * This method change password
     *
     * @param integer $userId
     * @param string $previousPassword
     * @param string $newPassword
     * @return void
     */
    public function changePassword($userId, $previousPassword, $newPassword)
    {
        $sqlQuery = $this->sql->update()
            ->set([
                'password' => "$newPassword"
            ])
            ->where([
                'id'       => $userId,
                'password' => "'$previousPassword'"
            ]);
        $sqlStmt  = $this->sql->prepareStatementForSqlObject($sqlQuery);
        $sqlStmt->execute();
    }

    /**
     * This method return messages in dialog, when user want load more messages
     *
     * @param integer $userId
     * @param integer $companionId
     * @param integer $iteration
     * @return ResultInterface
     */
    public function loadMessages($userId, $companionId, $iteration): ResultInterface
    {
        return $this->dialogResources->loadMessages($userId, $companionId, $iteration);
    }

    /**
     * This method return sender name for dialog
     *
     * @param integer $senderId
     * @return array
     */
    public function getSenderName($senderId): array
    {
        $sqlQuery = $this->sql->select()->columns(
            [
                "lastname",
                "firstname",
                "middlename",
                "is_online",
                "photo"
            ])->where(['id' => $senderId]);
        $sqlStmt  = $this->sql->prepareStatementForSqlObject($sqlQuery);
        $handler  = $sqlStmt->execute()->current();
        return $handler;
    }

    /**
     * This method update emails when profile edit
     *
     * @param array $emails
     * @return void
     */
    public function setEmailsById($emails)
    {
        $this->emailsResources->setEmails($emails);
    }

    /**
     * This method update telephones when profile edit
     *
     * @param array $telephones
     * @return void
     */
    public function setTelephonesById($telephones)
    {
        $this->telephoneResources->setTelephone($telephones);
    }

    /**
     * This method update emails when profile edit
     *
     * @param int $userId
     * @return array
     */
    public function getUserInfo($userId): array
    {
        $sqlQuery = $this->sql->select()->where(['id' => $userId]);
        $sqlStmt  = $this->sql->prepareStatementForSqlObject($sqlQuery);
        $handler  = $sqlStmt->execute()->current();
        return $handler;
    }

    /**
     * This method update user's info when profile edit
     *
     * @param array $data
     * @return ResultInterface
     */
    public function updateUserInfo($data): ResultInterface
    {
        $sqlQuery = $this->sql->update()
            ->set([
                "firstname"  => $data["firstName"],
                "lastname"   => $data["lastName"],
                "middlename" => $data["middleName"],
                "gender"     => (bool)$data["gender"],
                "photo"      => $data["photo"],
                "dob"        => $data["dob"],
                "skype"      => $data["skype"]
            ])
            ->where(['id' => $data["userId"]]);
        $sqlStmt  = $this->sql->prepareStatementForSqlObject($sqlQuery);
        $handler  = $sqlStmt->execute();
        return $handler;
    }

    /**
     * This method update user's info when admin edit profile
     *
     * @param array $data
     * @return ResultInterface
     */
    public function updateUserAdminInfo($data): ResultInterface
    {
        $sqlQuery = $this->sql->update()
            ->set([
                "firstname"  => $data["firstName"],
                "lastname"   => $data["lastName"],
                "middlename" => $data["middleName"],
                "photo"      => $data["photo"],
                "gender"     => (bool)$data["gender"],
                "dob"        => $data["dob"],
                "skype"      => $data["skype"],
                'is_admin'   => (bool)$data['isAdmin'],
                "is_online"  => (bool)$data['isActive'],
                "password"   => $data["password"],
            ])
            ->where(['id' => $data["userId"]]);
        $sqlStmt  = $this->sql->prepareStatementForSqlObject($sqlQuery);
        $handler  = $sqlStmt->execute();
        return $handler;
    }

    /**
     * This method delete profile
     *
     * @param array $data
     * @return ResultInterface
     */
    public function deleteProfile($data): ResultInterface
    {
        $sqlQuery = $this->sql->delete()->where(['id' => $data["userId"]]);
        $sqlStmt  = $this->sql->prepareStatementForSqlObject($sqlQuery);
        $handler  = $sqlStmt->execute();
        return $handler;
    }

    /**
     * This method return user's photo
     *
     * @param integer $userId
     * @return array
     */
    public function getPhoto($userId): array
    {
        $sqlQuery = $this->sql->select()->columns(["photo"])->where(['id' => $userId]);
        $sqlStmt  = $this->sql->prepareStatementForSqlObject($sqlQuery);
        $handler  = $sqlStmt->execute()->current();
        return $handler;
    }

    /**
     * This method login user
     *
     * @param string $email
     * @param string $password
     * @return array
     */
    public function loginUser($email, $password)
    {
        $sqlQuery = $this->sql->select()
            ->columns([
                'id',
                'is_admin',
            ])
            ->join("emails", 'staffs.id = id_staff', [])
            ->where([
                'email'    => "$email",
                'password' => "$password"
            ]);;
        $sqlStmt  = $this->sql->prepareStatementForSqlObject($sqlQuery);
        $handler  = $sqlStmt->execute()->current();
        $sqlQuery = $this->sql->update()
            ->set(["is_online" => 1])
            ->where(['id' => $handler["id"]]);
        $sqlStmt  = $this->sql->prepareStatementForSqlObject($sqlQuery);
        $sqlStmt->execute();
        return $handler;
    }

    /**
     * This method login user
     *
     * @param $userId
     * @return void
     */
    public function unloginUser($userId): void
    {
        $sqlQuery = $this->sql->update()
            ->set(['is_online' => 0])
            ->where(['id' => $userId]);
        $sqlStmt  = $this->sql->prepareStatementForSqlObject($sqlQuery);
        $sqlStmt->execute();
    }

    /**
     * This method send email notifications for unread messages
     *
     * @return array
     */
    public function sendEmailNotifications()
    {
       return $this->emailsResources->sendEmailNotifications();
    }

    /**
     * This method reset password
     *
     * @param string $email
     * @return void
     */
    public function passwordRecovery($email)
    {
        $sqlQuery = $this->sql->select()
            ->join("emails", 'staffs.id = id_staff')
            ->where(['email' => $email]);
        $sqlStmt  = $this->sql->prepareStatementForSqlObject($sqlQuery);
        $handler  = $sqlStmt->execute()->current();
        if ($handler) {
            $success = mail(
                $handler['email'],
                "password recovery",
                "qwerty12345",
            );
            $sqlQuery = $this->sql->update()
                ->set(['password' => "qwerty12345"])
                ->where(['id' => $handler["id_staff"]]);
            $sqlStmt  = $this->sql->prepareStatementForSqlObject($sqlQuery);
            $handler  = $sqlStmt->execute();
        }
    }

    /**
     * This method register user in system
     *
     * @param string $email
     * @param string $password
     * @return array
     */
    public function register($email, $password): array
    {
            $sqlQuery = $this->sql->insert()->columns([
                "password"
            ])
                ->values(["$password"]);
            $sqlStmt  = $this->sql->prepareStatementForSqlObject($sqlQuery);
            $handler  = $sqlStmt->execute();
        $this->emailsResources->setEmailForRegister($email);

        $sqlQuery = $this->sql->select()->columns(["id"], false)
            ->order(['id' => Select::ORDER_DESCENDING])->limit(1);
        $sqlStmt  = $this->sql->prepareStatementForSqlObject($sqlQuery);
        $handler  = $sqlStmt->execute()->current();
        return $handler;
    }

    /**
     * This method get user's info by filter
     *
     * @param $searchLine
     * @param $request
     * @return ResultInterface|null
     */
    public function getUsersAllFilters($searchLine, $request)
    {
        $nameRequest  = $this->sql->select()->quantifier(Select::QUANTIFIER_DISTINCT)
            ->columns(["id"])
            ->where("match (lastname, firstname, middlename) against ('$searchLine*' in boolean mode)");
        $emailRequest = $this->emailsResources->emailRequest($searchLine)->combine($nameRequest);
        $sqlStmt      = $this->sql->prepareStatementForSqlObject($emailRequest);
        $id           = $sqlStmt->execute();
        $id           = iterator_to_array($id);
        $resultId     = [];
        array_walk_recursive($id, function ($item) use (&$resultId) {
            $resultId[] = $item;
        });
        if (!empty($resultId)) {
            $sqlQuery = $this->sql->select()->quantifier(Select::QUANTIFIER_DISTINCT)
                ->columns([
                    "firstname",
                    "lastname",
                    "is_online",
                    "staffs.id",
                    "photo"
                ], false)
                ->join("emails", 'staffs.id = emails.id_staff', [])
                ->join("telephones", 'staffs.id = telephones.id_staff', [])
                ->where(['staffs.id' => $resultId]);
            if (!empty($request)) {
                $sqlQuery->where($request);
            }
            $sqlQuery->order([
                'is_online' => Select::ORDER_DESCENDING,
                'lastname'  => Select::ORDER_ASCENDING,
            ])
                ->limit(self::CONST_PAGINATION);
            $sqlStmt = $this->sql->prepareStatementForSqlObject($sqlQuery);
            $handler = $sqlStmt->execute();
            return $handler;
        }
        return null;
    }

    /**
     * This method return user's info by pagination
     *
     * @param integer $pageNumber
     * @return ResultInterface
     */
    public function getUsersByPagination($pageNumber): ResultInterface
    {
        $startNumber = ((int)$pageNumber * self::CONST_PAGINATION) - self::CONST_PAGINATION;
        $endNumber   = (int)$pageNumber * self::CONST_PAGINATION;
        $sqlQuery    = $this->sql->select()->columns(
            [
                "firstname",
                "lastname",
                "is_online",
                "id",
                "photo"
            ], false)
            ->order([
                'is_online' => Select::ORDER_DESCENDING,
                'lastname'  => Select::ORDER_ASCENDING,
            ])->limit($endNumber)->offset($startNumber);
        $sqlStmt     = $this->sql->prepareStatementForSqlObject($sqlQuery);
        $handler     = $sqlStmt->execute();
        return $handler;
    }

    /**
     * This method return exist dialog by pagination
     *
     * @param integer $userId
     * @param integer $pageNumber
     * @return ResultInterface
     */
    public function getExistDialogForPagination($userId, $pageNumber): ResultInterface
    {
        $startNumber = ((int)$pageNumber * self::CONST_PAGINATION) - self::CONST_PAGINATION;
        $endNumber   = (int)$pageNumber * self::CONST_PAGINATION;
        $dialogId    = $this->dialogResources->getDialogsId($userId);
        $sqlQuery    = $this->sql->select()->quantifier(Select::QUANTIFIER_DISTINCT)->columns([
            "lastname",
            "firstname",
            "middlename",
            "staffs.id",
            "photo"
        ], false)
            ->join(
                "messages", 'staffs.id = id_get', [],
            )
            ->where([
                'id_dialog' => $dialogId,
                new \Laminas\Db\Sql\Predicate\Expression("staffs.id != $userId")
            ])->limit($endNumber)->offset($startNumber);;
        $sqlStmt = $this->sql->prepareStatementForSqlObject($sqlQuery);
        $handler = $sqlStmt->execute();

        return $handler;
    }

    /**
     * This method return doesn't exist dialog by pagination
     *
     * @param integer $userId
     * @param integer $pageNumber
     * @return ResultInterface
     */
    public function getNotExistDialogForPagination($userId, $pageNumber): ResultInterface
    {
        $startNumber = ((int)$pageNumber * self::CONST_PAGINATION) - self::CONST_PAGINATION;
        $endNumber   = (int)$pageNumber * self::CONST_PAGINATION;
        $dialogId    = $this->dialogResources->getDialogsId($userId);

        $staffId  = $this->sql->select()
            ->columns([
                "id"
            ])
            ->join("messages", "staffs.id = id_get", [])
            ->where([
                'id_dialog' => $dialogId,
            ]);
        $sqlStmt  = $this->sql->prepareStatementForSqlObject($staffId);
        $staffId  = $sqlStmt->execute();
        $id       = iterator_to_array($staffId);
        $resultId = [];
        array_walk_recursive($id, function ($item) use (&$resultId) {
            $resultId[] = $item;
        });
        $sqlQuery = $this->sql->select()
            ->columns([
                "lastname",
                "firstname",
                "middlename",
                "id",
                "photo"
            ])
            ->where([
                new \Laminas\Db\Sql\Predicate\NotIn('staffs.id', $resultId)
            ])
            ->limit($endNumber)->offset($startNumber);
        $sqlStmt  = $this->sql->prepareStatementForSqlObject($sqlQuery);
        $handler  = $sqlStmt->execute();
        return $handler;
    }
}
