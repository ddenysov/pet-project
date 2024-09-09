<?php

namespace Common\Infrastructure\QueryBuilder\Doctrine;

use Common\Application\QueryBuilder\Port\QueryBuilder as QueryBuilderPort;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;

class QueryBuilder implements QueryBuilderPort
{
    private \Doctrine\DBAL\Query\QueryBuilder $queryBuilder;

    private array $parameters = [];

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    /**
     * @param string $name
     * @return $this
     */
    public function table(string $name): static
    {
        $this->parameters = [];
        $this->queryBuilder = $this->entityManager->getConnection()
            ->createQueryBuilder()
            ->select('*')
            ->from($name);

        return $this;
    }

    /**
     * @return array
     * @throws Exception
     */
    public function get(): array
    {
        return $this->queryBuilder
            ->setParameters($this->parameters)
            ->executeQuery()
            ->fetchAllAssociative();
    }

    /**
     * @throws Exception
     */
    public function first(): array
    {
        return $this->queryBuilder
            ->setParameters($this->parameters)
            ->executeQuery()
            ->fetchAssociative();
    }

    /**
     * @param string $column
     * @param string $operand
     * @param string $value
     * @return $this
     */
    public function where(string $column, string $operand, string $value): static
    {
        $this->queryBuilder->where($column . ' = ?');
        $this->parameters[] = $value;

        return $this;
    }

    /**
     * @param string $id
     * @return array
     * @throws Exception
     */
    public function id(string $id): array
    {
        return $this->where('id', '=', $id)->first();
    }

    public function limit()
    {

    }
}