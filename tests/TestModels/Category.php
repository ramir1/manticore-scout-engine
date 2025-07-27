<?php

namespace RomanStruk\ManticoreScoutEngine\Tests\TestModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Category extends Model
{
    use HasFactory, Searchable;

    protected $guarded = [];

    public $timestamps = false;

    protected static function newFactory()
    {
        return CategoryFactory::new();
    }

    public function scoutIndexMigration(): array
    {
        return [
            'fields' => [
                'id' => ['type' => 'bigint'],
                'name' => ['type' => 'text'],
            ],
            'settings' => [
                'min_infix_len' => '1',
                'prefix_fields' => 'name',
                'expand_keywords' => '1',
                'bigram_index' => 'all',
            ],
            'silent' => false,
        ];
    }

    public function toSearchableArray(): array
    {
        return [
            'name' => $this->name,
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