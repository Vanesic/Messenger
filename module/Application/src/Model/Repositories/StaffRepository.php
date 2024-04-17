<?php

declare(strict_types=1);

namespace Application\Model\Repositories;

use Application\Model\Resources\EmailResources;
use Application\Model\Resources\TelephoneResources;
use Application\Model\Resources\StaffResources;
use Laminas\Db\Adapter\Driver\ResultInterface;

class StaffRepository
{
    /**
     * @var StaffResources
     */
    protected $staffResource;
    /**
     * @var EmailResources
     */
    protected $emailResources;
    /**
     * @var TelephoneResources
     */
    protected $telephoneResources;

    /**
     * This constant need for check gender value
     *
     * @const GENDER_CHECK
     */
    const GENDER_CHECK = -1;

    public function __construct(
        StaffResources     $staffResource,
        EmailResources     $emailsResources,
        TelephoneResources $telephoneResources
    ) {
        $this->staffResource      = $staffResource;
        $this->emailResources     = $emailsResources;
        $this->telephoneResources = $telephoneResources;
    }

    /**
     * This method return all users info
     *
     * @return ResultInterface
     */
    public function getAllUsers(): ResultInterface
    {
        return $this->staffResource->getUsers();
    }

    /**
     * Return all users info for exist dialogs
     *
     * @param integer $userId
     * @return ResultInterface
     */
    public function getAllExistDialogs($userId): ResultInterface
    {
        return $this->staffResource->getExistDialogs($userId);
    }

    /**
     * This method send message
     *
     * @param integer $userId
     * @param integer $receiverId
     * @param string $message
     */
    public function sendMessage($userId, $receiverId, $message)
    {
        $this->staffResource->sendMessage($userId, $receiverId, $message);
    }

    /**
     * Return all users info for doesn't exist dialog
     *
     * @param integer $userId
     * @return ResultInterface
     */
    public function getAllNotExistDialogs($userId): ResultInterface
    {
        return $this->staffResource->getNotExistDialogs($userId);
    }

    /**
     * Return last message in dialog
     *
     * @param integer $userId
     * @param ResultInterface $companion
     * @return array
     */
    public function getLastMessage($userId, $companion): array
    {
        return $this->staffResource->getLastMessageById($userId, $companion);
    }

    /**
     * This method delete profile
     *
     * @param array $data
     * @return ResultInterface
     */
    public function deleteProfile($data): ResultInterface
    {
        return $this->staffResource->deleteProfile($data);
    }

    /**
     * This method return user's emails
     *
     * @param integer $userId
     * @return ResultInterface
     */
    public function getEmail($userId): ResultInterface
    {
        return $this->staffResource->getEmailsById($userId);
    }

    /**
     * This method return user's telephones
     *
     * @param integer $userId
     * @return ResultInterface
     */
    public function getTelephone($userId): ResultInterface
    {
        return $this->staffResource->getTelephoneById($userId);
    }

    /**
     * This method return messages in dialog
     *
     * @param integer $senderId
     * @param integer $getterId
     * @return ResultInterface
     */
    public function getMessages($senderId, $getterId): ResultInterface
    {
        return $this->staffResource->getMessagesById($senderId, $getterId);
    }

    /**
     * This method return sender name for dialog
     *
     * @param integer $senderId
     * @return array
     */
    public function getSenderName($senderId): array
    {
        return $this->staffResource->getSenderName($senderId);
    }

    /**
     * This method change password
     *
     * @param integer $userId
     * @param string $previousPassword
     * @param string $newPassword
     */
    public function changePassword($userId, $previousPassword, $newPassword)
    {
        $this->staffResource->changePassword($userId, $previousPassword, $newPassword);
    }

    /**
     * This method update emails when profile edit
     *
     * @param array $emails
     */
    public function updateEmails($emails)
    {
        $this->staffResource->setEmailsById($emails);
    }

    /**
     * This method update telephones when profile edit
     *
     * @param array $telephones
     */
    public function updateTelephones($telephones)
    {
        $this->staffResource->setTelephonesById($telephones);
    }

    /**
     * This method reset password
     *
     * @param string $email
     */
    public function passwordRecovery($email)
    {
        $this->staffResource->passwordRecovery($email);
    }

    /**
     * This method register user in system
     *
     * @param string $email
     * @param string $password
     * @param string $post
     * @return array
     */
    public function registerUser($email, $password, $post): array
    {
        return $this->staffResource->register($email, $password, $post);
    }

    /**
     * This method update emails when profile edit
     *
     * @param int $userId
     * @return ResultInterface
     */
    public function getUserInfo($userId): array
    {
        return $this->staffResource->getUserInfo($userId);
    }

    /**
     * This method update user's info when profile edit
     *
     * @param array $data
     * @return ResultInterface
     */
    public function updateUserInfo($data): ResultInterface
    {
        return $this->staffResource->updateUserInfo($data);
    }

    /**
     * This method update user's info when admin edit profile
     *
     * @param array $data
     * @return ResultInterface
     */
    public function updateUserAdminInfo($data): ResultInterface
    {
        return $this->staffResource->updateUserAdminInfo($data);
    }

    /**
     * This method return user's photo
     *
     * @param integer $userId
     * @return array
     */
    public function getPhoto($userId): array
    {
        return $this->staffResource->getPhoto($userId);
    }

    /**
     * This method return user's photo
     *
     * @param integer $userId
     * @return void
     */
    public function unloginUser($userId): void
    {
        $this->staffResource->unloginUser($userId);
    }

    /**
     * This method get user's info by filter
     *
     * @param string $searchLine
     * @param string $post
     * @param string $gender
     * @param string $dobBefore
     * @param string $dobAfter
     * @return ResultInterface|null
     */
    public function getUsersByFilters(
        $searchLine,
        $post,
        $gender,
        $dobBefore,
        $dobAfter
    ) {
        $request = $this->getRequestString($post, $gender, $dobBefore, $dobAfter);
        return $this->staffResource->getUsersAllFilters($searchLine ,$request);
    }

    /**
     * This method get user's info by admin filter
     *
     * @param string $searchLine
     * @param string $post
     * @param string $gender
     * @param string $dobBefore
     * @param string $dobAfter
     * @param boolean $admin
     * @param boolean $active
     * @return ResultInterface|null
     */
    public function getUsersAdminByFilters(
        $searchLine,
        $post,
        $gender,
        $dobBefore,
        $dobAfter,
        $admin,
        $active
    ) {
        $request = $this->getRequestString($post, $gender, $dobBefore, $dobAfter);
        if (!empty($admin) && empty($request)) {
            $request .= "is_admin = " . $admin;
        } else if (!empty($admin) && !empty($request)) {
            $request .= " and is_admin = " . $admin;
        }
        if (!empty($active) && empty($request)) {
            $request .= "is_online = " . $active;
        } else if (!empty($active) && !empty($request)) {
            $request .= " and is_online = " . $active;
        }
        return $this->staffResource->getUsersAllFilters($searchLine, $request);
    }

    /**
     * This method return all dialogs by filters
     *
     * @param string $searchLine
     * @param string $post
     * @param string $gender
     * @param string $dobBefore
     * @param string $dobAfter
     * @return ResultInterface|null
     */
    public function getDialogsByFilters(
        $searchLine,
        $post,
        $gender,
        $dobBefore,
        $dobAfter
    ) {
        $request = $this->getRequestString($post, $gender, $dobBefore, $dobAfter);
        return $this->staffResource->getDialogAllFilters($searchLine, $request);
    }

    /**
     * This method return request string
     *
     * @param string $post
     * @param string $gender
     * @param string $dobBefore
     * @param string $dobAfter
     * @return string
     */
    public function getRequestString($post, $gender, $dobBefore, $dobAfter) :string
    {
        $request = "";
        if ($post !== 'Choose post' && empty($request)) {
            $request .= "post = " . "'$post'";
        } else if ($post !== 'Choose post' && !empty($request)) {
            $request .= " and post = " . "'$post'";
        }

        if ($gender !== self::GENDER_CHECK && empty($request)) {
            $request .= "gender = " . $gender;
        } else if ($gender !== self::GENDER_CHECK && !empty($request)) {
            $request .= " and gender = " . $gender;
        }

        if ($dobAfter != null && $dobBefore != null && empty($request)) {
            $request .= "dob between " . "'$dobBefore'" . " and " . "'$dobAfter'";
        } else if ($dobAfter != null && $dobBefore != null && !empty($request)) {
            $request .= " and dob between " . "'$dobBefore'" . " and " . "'$dobAfter'";
        }

        if ($dobAfter != null && $dobBefore == null && empty($request)) {
            $request .= "dob <= " . "'$dobAfter'";
        } else if ($dobAfter != null && $dobBefore == null && !empty($request)) {
            $request .= " and dob <= " . "'$dobAfter'";
        }

        if ($dobAfter == null && $dobBefore != null && empty($request)) {
            $request .= "dob >=" . "'$dobBefore'";
        } else if ($dobAfter == null && $dobBefore != null && !empty($request)) {
            $request .= " and dob >=" . "'$dobBefore'";
        }
        return $request;
    }

    /**
     * This method return user's info by pagination
     *
     * @param integer $pageNumber
     * @return ResultInterface
     */
    public function getUsersByPagination($pageNumber): ResultInterface
    {
        return $this->staffResource->getUsersByPagination($pageNumber);
    }

    /**
     * This method send email notifications for unread messages
     *
     * @return array
     */
    public function sendEmailNotifications()
    {
        return $this->staffResource->sendEmailNotifications();
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
        return $this->staffResource->loginUser($email, $password);
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
        return $this->staffResource->getExistDialogForPagination($userId, $pageNumber);
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
        return $this->staffResource->getNotExistDialogForPagination($userId, $pageNumber);
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
        return $this->staffResource->loadMessages($userId, $companionId, $iteration);
    }
}