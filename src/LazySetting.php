<?php

namespace Step2Dev\LazySetting;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;
use JsonException;
use Step2Dev\LazySetting\Models\Setting;
use Throwable;

class LazySetting
{
    private Collection $settings;

    public function __construct()
    {
        $this->settings = Collection::make();
    }

    public static function config(string $string = ''): string|array|null
    {
        $config = [
            'table' => self::getTable(),
            'cache_key' => self::getCacheKey(),
            'cache_ttl' => self::getCacheTtl(),
            'default' => [
                'group' => self::getDefaultGroup(),
                'type' => self::getDefaultType(),
            ],
        ];

        if ($string) {
            return $config[$string] ?? null;
        }

        return $config;
    }

    public static function getCacheKey(): string
    {
        return config('lazy-setting.cache_prefix').'settings';
    }

    public static function getCacheTtl(): ?int
    {
        return config('lazy-setting.cache_ttl');
    }

    public static function getDefaultGroup(): string
    {
        return config('lazy-setting.default.group', 'default');
    }

    public static function getDefaultType(): string
    {
        return config('lazy-setting.default.type', 'string');
    }

    public static function getTable(): string
    {
        return trim((string) config('lazy-setting.table', 'settings'));
    }

    public function init(): static
    {
        if ($this->settings->isEmpty()) {
            $this->settings = cache()->rememberForever(self::getCacheKey(), fn () => Setting::get());
        }

        return $this;
    }

    public function getSettings(): Collection
    {
        return $this->init()->settings;
    }

    /**
     * @throws Throwable
     */
    public function getKeyAndGroup(string $key): array
    {
        [$key, $group] = array_pad(
            array_reverse(explode('.', $key, 2)),
            2, null);

        $key = trim((string) $key);

        throw_if(! $key, new InvalidArgumentException('Key cannot be null or empty example: "app.name" or "name" received: "'.$group.'.'.$key.'"'));

        $group = trim((string) $group) ?: self::getDefaultGroup();

        return compact('key', 'group');
    }

    public function get(string $key, mixed $default = null): ?string
    {
        return $this->getConfig($key)?->value ?? $default;
    }

    public function getConfig(string $key): ?Setting
    {
        try {
            ['group' => $group, 'key' => $key] = $this->getKeyAndGroup($key);
        } catch (InvalidArgumentException|Throwable $e) {
            Log::error(__METHOD__.' '.$e->getMessage());

            return null;
        }

        return $this->getSettings()
            ->where('group', $group)
            ->firstWhere('key', $key);
    }

    /**
     * @throws Throwable
     */
    public function set(string $key, mixed $data, ?string $type = null): Setting
    {
        if ($setting = $this->getConfig($key)) {
            $this->update($setting, $data);
        } else {
            $setting = $this->createIfNotExists($key, $data, $type);
        }

        return $setting;
    }

    public function all(): Collection
    {
        return $this->getSettings();
    }

    /**
     * @throws JsonException
     */
    public function update(Setting $setting, mixed $data): Setting
    {
        $setting->update($this->formatData($data, $setting->type));

        $this->clearCache();

        return $setting;
    }

    /**
     * @throws Throwable
     */
    public function createIfNotExists(string $key, mixed $data, ?string $type = null): Setting
    {
        $setting = Setting::firstOrCreate($this->getKeyAndGroup($key), $this->formatData($data, $type));

        $this->clearCache();

        return $setting;
    }

    public function getFieldType(?string $type = ''): string
    {
        $type = strtolower(trim($type));

        return match ($type) {
            'string', 'text', 'textarea', 'richtext' => 'string',
            'integer', 'int' => 'integer',
            'float', 'double' => 'float',
            'boolean', 'bool' => 'boolean',
            'array' => 'array',
            'json' => 'json',
            'image' => 'image',
            default => self::getDefaultType(),
        };
    }

    /**
     * @throws JsonException
     */
    final protected function formatData(array|string $data, ?string $type = null, ?array $options = []): array
    {
        $type = $this->getFieldType($type);
        $result = compact('type');

        if (! is_array($data)) {
            return [...$result, 'value' => $data];
        }

        if (! isset($data['value'])) {
            return $result;
        }

        $data['options'] ??= $options ?? [];

        $result = [...$result, ...$data];

        if (is_array($data['value'])) {
            $result['value'] = json_encode($data['value'], JSON_THROW_ON_ERROR);
        }

        return $result;
    }

    /**
     * @throws Throwable
     */
    public function create(string $key, array $data, ?string $type = null): Setting
    {
        $setting = Setting::create([
            ...$this->getKeyAndGroup($key),
            'type' => $type ?? 'string',
            'value' => $data,
        ]);

        $this->clearCache();

        return $setting;
    }

    private function clearCache(bool $refresh = true): void
    {
        cache()->forget(self::getCacheKey());

        if ($refresh) {
            $this->init();
        }
    }

    public function delete(string $key): void
    {
        $setting = $this->getConfig($key);

        $setting?->delete();

        $this->clearCache();
    }

    public function getTypes(): array
    {
        return [
            'string',
            'integer',
            'float',
            'boolean',
            'array',
            'json',
            'image',
            'richtext',
            'textarea',
        ];
    }
}
