<?php

namespace Application\Model\Resources;

use Laminas\Db\Adapter\Driver\ResultInterface;
use Laminas\Db\Sql\Select;
use Laminas\Db\TableGateway\TableGateway;

class DialogResources extends TableGateway
{
    /**
     * @const integer OFFSET_CONST
     * Using for add offset value
     */
    const OFFSET_CONST = 20;

    /**
     * This method return dialogs id
     *
     * @param integer $userId
     * @return array
     */
    public function getDialogsId($userId){
        $predicate = $this->sql->select()->where
            ->nest()
            ->nest()
            ->equalTo('id_get', $userId)
            ->and
            ->notEqualTo('id_send', $userId)
            ->unnest()
            ->or
            ->nest()
            ->notEqualTo('id_get', $userId)
            ->and
            ->equalTo('id_send', $userId)
            ->unnest()
            ->unnest();
        $id        = $this->sql->select()->quantifier(Select::QUANTIFIER_DISTINCT)
            ->columns(["id_dialog"])
            ->where($predicate);
        $sqlStmt   = $this->sql->prepareStatementForSqlObject($id);
        $id        = $sqlStmt->execute();
        $id        = iterator_to_array($id);
        $resultId  = [];
        array_walk_recursive($id, function ($item) use (&$resultId) {
            $resultId[] = $item;
        });
        return $resultId;
    }

    /**
     * This method return array with dialog info
     *
     * @param integer $userId
     * @param ResultInterface $companion
     * @return array
     */
    public function getLastMessagesInDialogsById($userId, $companion): array
    {
        $result = [];
        foreach ($companion as $lastMessage) {
            $companionId = $lastMessage['staffs.id'];
            $predicate = $this->sql->select()->where
                ->nest()
                ->nest()
                ->equalTo('id_get', $userId)
                ->and
                ->equalTo('id_send', $companionId)
                ->unnest()
                ->or
                ->nest()
                ->equalTo('id_get', $companionId)
                ->and
                ->equalTo('id_send', $userId)
                ->unnest()
                ->unnest();
            $sqlQuery    = $this->sql->select()
                ->columns([
                        "letter",
                        "send_at",
                        "open_at",
                        "id_get",
                        "id_send",
                    ])
                ->join(
                    "staffs", "staffs.id = id_send"
                )
                ->where($predicate)
                ->order(["send_at" => Select::ORDER_DESCENDING])->limit(1);
            $sqlStmt     = $this->sql->prepareStatementForSqlObject($sqlQuery);
            $handler     = $sqlStmt->execute();
            foreach ($handler as $lastMessageAndTime) {
                $result[] = [
                    'send_at'             => $lastMessageAndTime["send_at"],
                    'letter'              => $lastMessageAndTime["letter"],
                    'open_at'             => $lastMessageAndTime["open_at"],
                    'id_get'              => $lastMessageAndTime["id_get"],
                    'id_send'             => $lastMessageAndTime["id_send"],
                    'companion'           => $lastMessage["staffs.id"],
                    'companionFirstName'  => $lastMessage["firstname"],
                    'companionLastName'   => $lastMessage["lastname"],
                    'companionMiddleName' => $lastMessage["middlename"],
                ];
            }
        }
        return $result;
    }

    /**
     * This method return all messages witch user and companion.
     *
     * @param integer $userId
     * @param integer $companionId
     * @return ResultInterface
     */
    public function getAllMessagesById($userId, $companionId): ResultInterface
    {
        $predicate = $this->sql->select()->where
            ->nest()
            ->nest()
            ->equalTo('id_get', $userId)
            ->and
            ->equalTo('id_send', $companionId)
            ->unnest()
            ->or
            ->nest()
            ->equalTo('id_get', $companionId)
            ->and
            ->equalTo('id_send', $userId)
            ->unnest()
            ->unnest();
        $id        = $this->sql->select()->columns(["id"])->where($predicate);
        $sqlStmt   = $this->sql->prepareStatementForSqlObject($id);
        $id        = $sqlStmt->execute();
        $id        = iterator_to_array($id);
        $resultId  = [];
        array_walk_recursive($id, function ($item) use (&$resultId) {
            $resultId[] = $item;
        });
        $sqlQuery = $this->sql->select()
            ->columns([
                "open_at",
                "id_get",
                "id_send",
                "id",
            ])
            ->join(
                "staffs", "staffs.id = id_send", []
            )
            ->where([
                'messages.id' => $resultId,
            ]);
        $sqlStmt  = $this->sql->prepareStatementForSqlObject($sqlQuery);
        $offset   = $sqlStmt->execute()->getAffectedRows();
        $limit    = $offset;
        if ($offset - self::OFFSET_CONST < 0) {
            $offset = 0;
        } else {
            $offset -= self::OFFSET_CONST;
        }
        $sqlQuery = $this->sql->select()
            ->columns([
                "open_at",
                "id_get",
                "id_send",
                "id",
            ])
            ->join(
                "staffs", "staffs.id = id_send", []
            )
            ->where($predicate)
            ->order(['send_at' => Select::ORDER_DESCENDING])->limit(1);
        $sqlStmt  = $this->sql->prepareStatementForSqlObject($sqlQuery);
        $isOpen   = $sqlStmt->execute()->current();
        if ($isOpen["id_get"] === $userId && $isOpen["open_at"] == null) {
            $openDate = date("Y-m-d H:i:s");
            $sqlQuery = $this->sql->update()
                ->set(['open_at' => "$openDate"])
                ->where(['id' => $isOpen["id"]]);
            $sqlStmt  = $this->sql->prepareStatementForSqlObject($sqlQuery);
            $sqlStmt->execute();
        }

        $sqlQuery = $this->sql->select()
            ->where([
                'messages.id' => $resultId,
            ])
            ->order(['send_at' => Select::ORDER_ASCENDING])->offset($offset)->limit($limit);
        $sqlStmt  = $this->sql->prepareStatementForSqlObject($sqlQuery);
        $handler  = $sqlStmt->execute();
        return $handler;
    }

    /**
     * This method return messages in dialog, when user want load more messages
     *
     * @param integer $senderId
     * @param integer $getterId
     * @param integer $iteration
     * @return ResultInterface
     */
    public function loadMessages($senderId, $getterId, $iteration): ResultInterface
    {
        $predicate = $this->sql->select()->where
            ->nest()
            ->nest()
            ->equalTo('id_get', $senderId)
            ->and
            ->equalTo('id_send', $getterId)
            ->unnest()
            ->or
            ->nest()
            ->equalTo('id_get', $getterId)
            ->and
            ->equalTo('id_send', $senderId)
            ->unnest()
            ->unnest();
        $id        = $this->sql->select()->columns(["id"])->where($predicate);
        $sqlStmt   = $this->sql->prepareStatementForSqlObject($id);
        $id        = $sqlStmt->execute();
        $id        = iterator_to_array($id);
        $resultId  = [];
        array_walk_recursive($id, function ($item) use (&$resultId) {
            $resultId[] = $item;
        });
        $sqlQuery = $this->sql->select()
            ->where([
                'id' => $resultId,
            ]);
        $sqlStmt  = $this->sql->prepareStatementForSqlObject($sqlQuery);
        $offset   = $sqlStmt->execute()->getAffectedRows();
        $limit    = 0;
        if (($offset - self::OFFSET_CONST * $iteration) > 0) {
            $limit = $offset - self::OFFSET_CONST * $iteration;
        }
        $iteration++;
        if (($offset - self::OFFSET_CONST * $iteration) > 0) {
            $offset = $offset - self::OFFSET_CONST * $iteration;
        } else {
            $offset = 0;
        }
        $sqlQuery = $this->sql->select()
            ->where
            ([
                'id' => $resultId,
            ])->order(['send_at' => Select::ORDER_ASCENDING])->offset($offset)->limit($limit);
        $sqlStmt  = $this->sql->prepareStatementForSqlObject($sqlQuery);
        $handler  = $sqlStmt->execute();
        return $handler;
    }

    /**
     * This method set isNotificated on true
     *
     * @param $usersId
     * @return void
     */
    public function setNotificationTrue($usersId)
    {
        if (!empty($usersId)) {
            $sqlQuery = $this->sql->update()
                ->set(['is_notificated' => 1])
                ->where(['id_get' => $usersId[0]['id_staff']]);
            $sqlStmt  = $this->sql->prepareStatementForSqlObject($sqlQuery);
            $handler  = $sqlStmt->execute();
        }
    }

    /**
     * This method send message (add message in database)
     *
     * @param integer $userId
     * @param integer $receiverId
     * @param string $message
     * @return ResultInterface
     */
    public function sendMessage($userId, $receiverId, $message): ResultInterface
    {
        $predicate = $this->sql->select()->where
            ->nest()
            ->nest()
            ->equalTo('id_get', $userId)
            ->and
            ->equalTo('id_send', $receiverId)
            ->unnest()
            ->or
            ->nest()
            ->equalTo('id_get', $receiverId)
            ->and
            ->equalTo('id_send', $userId)
            ->unnest()
            ->unnest();
        $sqlQuery = $this->sql->select()->columns(["id_dialog"])
            ->where($predicate)->limit(1);
        $sqlStmt  = $this->sql->prepareStatementForSqlObject($sqlQuery);
        $handler  = $sqlStmt->execute();
        foreach ($handler as $dialogId) {
            $sendAt   = date("Y-m-d H:i:s");
            $dialogId = $dialogId["id_dialog"];
            $sqlQuery = $this->sql->insert()
                ->columns([
                        "letter",
                        "send_at",
                        "id_dialog",
                        "open_at",
                        "id_get",
                        "id_send"
                    ])
                ->values([
                        "$message",
                        "$sendAt",
                        "$dialogId",
                        null,
                        "$receiverId",
                        "$userId",
                    ]);
            $sqlStmt  = $this->sql->prepareStatementForSqlObject($sqlQuery);
            $handler  = $sqlStmt->execute();
            return $handler;
        }
        $sqlQuery = $this->sql->select()->columns(["id_dialog"])
            ->order(['id_dialog' => Select::ORDER_DESCENDING])->limit(1);
        $sqlStmt  = $this->sql->prepareStatementForSqlObject($sqlQuery);
        $handler  = $sqlStmt->execute();
        foreach ($handler as $dialogId) {
            $newIdDialog = $dialogId["id_dialog"] + 1;
            $sendAt      = date("Y-m-d H:i:s");
            $sqlQuery    = $this->sql->insert()
                ->columns([
                        "letter",
                        "send_at",
                        "id_dialog",
                        "open_at",
                        "id_get",
                        "id_send"
                    ])
                ->values([
                        "$message",
                        "$sendAt",
                        "$newIdDialog",
                        null,
                        "$receiverId",
                        "$userId",
                    ]);
            $sqlStmt     = $this->sql->prepareStatementForSqlObject($sqlQuery);
            $handler     = $sqlStmt->execute();
        }
        return $handler;
    }
}