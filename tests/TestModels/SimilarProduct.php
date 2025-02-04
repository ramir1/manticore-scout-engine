<?php

namespace RomanStruk\ManticoreScoutEngine\Tests\TestModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use RomanStruk\ManticoreScoutEngine\Mysql\ManticoreVector;

class SimilarProduct extends Model
{
    use HasFactory, Searchable;

    protected $guarded = [];

    protected $casts = [
        'vector' => 'array',
    ];

    protected static function newFactory()
    {
        return SimilarProductFactory::new();
    }

    public function scoutIndexMigration(): array
    {
        return [
            'fields' => [
                'id' => ['type' => 'bigint'],
                'name' => ['type' => 'text'],
                'vector' => ['type' => "float_vector knn_type='hnsw' knn_dims='4' hnsw_similarity='l2'"],
            ],
            'settings' => [],
        ];
    }


    public function toSearchableArray(): array
    {
        return [
            'id' => (int) $this->id,
            'name' => $this->name,
            'vector' => new ManticoreVector(...$this->vector),
        ];
    }

    /**
     * Get all Scout related metadata.
     */
    public function scoutMetadata(): array
    {
        return [
            'cutoff' => 0,
            'max_matches' => 1000,
        ];
    }
}