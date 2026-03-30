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

    /**
     * ユーザーがリマインダ―登録しているVtuberのChannelIDを取得する
     */
    public function fetchRegisteredChannelIds(string $userId): array
    {
        $statement = $this->pdo->prepare('SELECT channel_id FROM users_notification_list WHERE id = ?');
        $statement->execute([$userId]);

        return $statement->fetchAll(\PDO::FETCH_COLUMN);
    }
}