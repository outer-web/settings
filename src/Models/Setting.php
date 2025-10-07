<?php

declare(strict_types=1);

namespace Outerweb\Settings\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;

/**
 * @property int $id
 * @property string $key
 * @property mixed $value
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Setting extends Model
{
    protected $fillable = [
        'key',
        'value',
    ];

    /**
     * @return array{
     *     value: 'json',
     * }
     */
    protected function casts(): array
    {
        return [
            'value' => 'json',
        ];
    }

    public function getTable(): string
    {
        return Config::string('settings.database.table', 'settings');
    }
}
