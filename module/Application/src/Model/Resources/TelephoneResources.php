<?php

declare(strict_types=1);

namespace Application\Model\Resources;

use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\Adapter\Driver\ResultInterface;
use Laminas\Db\ResultSet\ResultSetInterface;
use Laminas\Db\Sql\Select;
use Laminas\Db\Sql\Sql;
use Laminas\Db\TableGateway\TableGateway;

class TelephoneResources extends TableGateway
{
    /**
     * @param $table
     * @param AdapterInterface $adapter
     * @param null $features
     * @param ResultSetInterface|null $resultSetPrototype
     * @param Sql|null $sql
     */
    public function __construct(
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
    }

    /**
     * This method return all telephones by user id
     *
     * @param int $userId
     * @return ResultInterface
     */
    public function getTelephone($userId): ResultInterface
    {
        $asd     = $this->sql->select()->columns(["telephone"], false)
            ->where(["id_staff" => $userId]);
        $sqlStmt = $this->sql->prepareStatementForSqlObject($asd);
        return $sqlStmt->execute();
    }

    /**
     * This method edit telephones
     *
     * @param array $telephones
     * @return void
     */
    public function setTelephone($telephones)
    {
        $oldTelephones = [];
        foreach ($this->getTelephone($telephones['userId']) as $telephone) {
            $oldTelephones[] = $telephone['telephone'];
        }

        $telephonesRemove = array_diff($oldTelephones, $telephones['telephones']);
        $telephonesInsert = array_diff($telephones['telephones'], $oldTelephones);

        if (!empty($telephonesRemove) || count($telephonesInsert) > 1) {
            $this->deleteTelephone($telephonesRemove);
        }

        if (!empty($telephonesInsert)) {
            foreach ($telephonesInsert as $telephoneInsert) {
                $this->insertTelephone($telephones['userId'], $telephoneInsert);
            }
        }
    }

    /**
     * This method delete telephone
     *
     * @param $telephoneRemove
     * @return void
     */
    public function deleteTelephone($telephoneRemove)
    {
        $sqlQuery = $this->sql->delete()->where(["telephone" => $telephoneRemove]);
        $sqlStmt  = $this->sql->prepareStatementForSqlObject($sqlQuery);
        $handler  = $sqlStmt->execute();
    }

    /**
     * This method insert telephone
     *
     * @param $userId
     * @param $telephoneInsert
     * @return void
     */
    public function insertTelephone($userId, $telephoneInsert)
    {
        $sqlQuery = $this->sql->insert()->values([
                "id_staff"  => "$userId",
                "telephone" => "$telephoneInsert",
            ]);
        $sqlStmt  = $this->sql->prepareStatementForSqlObject($sqlQuery);
        $handler  = $sqlStmt->execute();
    }

    /**
     * This method return telephone request
     *
     * @param string $searchLine
     * @return Select
     */
    public function telephoneRequest($searchLine):Select
    {
        $request = $this->sql->select()
            ->quantifier(Select::QUANTIFIER_DISTINCT)
            ->columns(["id_staff"])
            ->where("match (telephone) against ('$searchLine*' in boolean mode)");
        return $request;
    }
}