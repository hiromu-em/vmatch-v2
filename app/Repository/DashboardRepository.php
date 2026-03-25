<?php
declare(strict_types=1);

namespace Repository;

class DashboardRepository
{
    public function __construct(private \PDO $pdo)
    {
    }

    public function fetchVtuberRecords(): array
    {
        $statement = $this->pdo->prepare('SELECT * FROM vtuber_list');
        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_UNIQUE | \PDO::FETCH_ASSOC);
    }
}