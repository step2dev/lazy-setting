<?php

namespace Step2Dev\LazySetting\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Step2Dev\LazySetting\LazySetting;

/**
 * @property string|null $group
 * @property string $key
 * @property string $value
 * @property string $type
 * @property bool $is_protected
 * @property bool $is_encrypted
 * @property bool $deletable
 * @property-read string $settingKey
 */
class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'group',
        'key',
        'type',
        'value',
        'options',
        'is_protected',
    ];

    protected $casts = [
        'group' => 'string',
        'key' => 'string',
        'type' => 'string',
        'options' => 'array',
        'is_protected' => 'boolean',
    ];

    public function getDescriptionAttribute(): string
    {
        return __('settings.'.$this->settingKey.'.desc');
    }

    public function getSettingKeyAttribute(): string
    {
        return $this->group.'.'.$this->key;
    }

    public function getTable(): string
    {
        return LazySetting::config('table') ?: parent::getTable();
    }
}
