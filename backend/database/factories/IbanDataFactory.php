<?php

namespace Database\Factories;

use App\Models\IbanData;
use Illuminate\Database\Eloquent\Factories\Factory;

class IbanDataFactory extends Factory
{
    protected $model = IbanData::class;

    public function definition()
    {
        $data = [
            ['country' => 'Albania', 'length' => 28, 'code' => 'AL', 'format' => 'AL2!n8!n16!c'],
            ['country' => 'Andorra', 'length' => 24, 'code' => 'AD', 'format' => 'AD2!n4!n4!n12!c'],
            ['country' => 'Austria', 'length' => 20, 'code' => 'AT', 'format' => 'AT2!n5!n11!n'],
        ];

        $entry = $this->faker->randomElement($data);

        return [
            'country' => $entry['country'],
            'length' => $entry['length'],
            'code' => $entry['code'],
            'format' => $entry['format'],
        ];
    }
}
