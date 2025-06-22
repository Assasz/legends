<?php

declare(strict_types=1);

namespace Legends\Game\Infrastructure\Persistence;

use MongoDB\Client;
use MongoDB\Driver\Command;
use MongoDB\Model\BSONDocument;

final readonly class DatabaseClient
{
    private Client $mongoClient;

    public function __construct(
        private string $databaseUri,
        private string $databaseName,
    ) {
        $this->mongoClient = new Client($this->databaseUri);
    }

    public function upsert(string $collectionName, array $query, array $document): void
    {
        $upsert = new Command([
            'update' => $collectionName,
            'updates' => [
                [
                    'q' => $query,
                    'u' => $document,
                    'upsert' => true,
                    'multi' => false,
                ],
            ],
        ]);

        $this->mongoClient->getManager()->executeCommand($this->databaseName, $upsert);
    }

    public function insert(string $collectionName, array $document): void
    {
        $this->mongoClient
            ->selectCollection($this->databaseName, $collectionName)
            ->insertOne($document);
    }

    public function updateOne(string $collectionName, array $query, array $update): void
    {
        $this
            ->mongoClient
            ->selectCollection($this->databaseName, $collectionName)
            ->updateOne($query, $update);
    }

    public function getByQuery(string $collectionName, array $query, array $fields = []): array
    {
        $documents = $this->mongoClient
            ->selectCollection($this->databaseName, $collectionName)
            ->find($query, $fields);

        return array_map(
            static fn(BSONDocument $document): array => $document->getArrayCopy(),
            $documents->toArray(),
        );
    }

    public function deleteByQuery(string $collectionName, array $query): void
    {
        $this->mongoClient
            ->selectCollection($this->databaseName, $collectionName)
            ->deleteMany($query);
    }

    public function dropDatabase(): void
    {
        $this->mongoClient->dropDatabase($this->databaseName);
    }

    public function createIndex(string $collectionName, array $index, array $options = []): string
    {
        return $this->mongoClient
            ->selectCollection($this->databaseName, $collectionName)
            ->createIndex($index, $options);
    }
}
