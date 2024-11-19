<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Patient;
use Hidehalo\Nanoid\Client;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AnalysisHistory>
 */
class AnalysisHistoryFactory extends Factory
{
    protected $model = \App\Models\AnalysisHistory::class;

    public function definition()
    {
        $client = new Client();
        $nanoid = $client->generateId(12);

        return [
            'history_id' => 'ah_' . $nanoid,
            'patient_id' => Patient::factory(),
            'diagnosis' => $this->faker->sentence(),
            'tingkat_keyakinan' => $this->faker->randomElement(['Low', 'Medium', 'High']),
            'jumlah_sel' => $this->faker->numberBetween(1000, 10000),
            'sel_abnormal' => $this->faker->numberBetween(100, 1000),
            'rata_rata_keyakinan' => $this->faker->randomFloat(2, 0.5, 1.0),
            'rekomendasi_medis' => $this->faker->paragraph(),
            'timestamp' => $this->faker->dateTime(),
        ];
    }
}
