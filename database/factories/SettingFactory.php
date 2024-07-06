<?php

namespace Step2Dev\LazySetting\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Step2Dev\LazySetting\Models\Setting;

class SettingFactory extends Factory
{
    protected $model = Setting::class;

    public function definition(): array
    {
        return [
            'group'        => $this->faker->word,
            'key'          => $this->faker->word,
            'type'         => $this->faker->randomElement([
                'text',
                'textarea',
                'select',
                'multiselect',
                'choice',
                'number',
                'toggle',
                'checkbox',
                'radio',
                'password',
                'file',
                'color',
                'date',
                'time',
                'datetime',
            ]),
            'value'        => $this->faker->word,
            'options'      => [
                'is_protected' => $this->faker->boolean,
                'deletable'    => $this->faker->boolean,
            ],
            'is_encrypted' => $this->faker->boolean,
        ];
    }
}
