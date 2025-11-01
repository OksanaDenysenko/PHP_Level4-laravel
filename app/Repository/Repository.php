<?php

namespace App\Repository;

use Illuminate\Database\Eloquent\Model;

abstract class Repository
{
    /* @var class-string<Model> $model */
    abstract protected string $model {
        get;
    }

    /**
     * The method creates a new record in the database.
     * @param array $data
     * @return Model|null
     */
    public function create(array $data): ?Model
    {
        return $this->model::create($data);
    }

    /**
     * The method finds local ID for a given external ID.
     * @param int $externalId
     * @return int|null
     */
    public function getIdByExternalId(int $externalId): ?int
    {
        return $this->model::query()
            ->where('external_id', $externalId)
            ->value('id');
    }

    /**
     * The method finds local IDs for a given array of external IDs.
     * @param array $externalIds
     * @return array
     */
    public function getIdsByExternalIds(array $externalIds): array
    {
        return $this->model::query()
            ->whereIn('external_id', $externalIds)
            ->pluck('id')
            ->toArray();
    }

    /**
     * Method for getting a subset of columns
     * @param array $columns
     * @return mixed
     */
    public function getColumns(array $columns = ['*']): mixed
    {
        return $this->model::select($columns)->get();
    }

    /**
     *The method adds many-to-many relationships for a specific model object
     * @param Model $model
     * @param array $relationshipsData
     * @return void
     */
    public function syncRelationships(Model $model, array $relationshipsData): void
    {
        foreach ($relationshipsData as $relationName => $idsArray) {

            if (!empty($idsArray)) {
                $model->{$relationName}()->sync($idsArray);
            }
        }
    }

    /**
     * The method receives filtered data
     * @param array $filters
     * @param array $nameColumns
     * @return array
     */
    public function getByFilter(array $filters, array $nameColumns): array
    {
        $query = $this->model::query();

        foreach ($filters as $key => $value) {

            if (is_null($value) || $value === '') {

                continue;
            }

            $query->whereLike($key, $value);
        }

        return $query->get($nameColumns)->toArray();
    }
}
