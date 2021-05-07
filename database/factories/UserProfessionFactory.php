<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\UserProfession;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserProfessionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UserProfession::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'profession_id' => User::factory()
        ];
    }
}
