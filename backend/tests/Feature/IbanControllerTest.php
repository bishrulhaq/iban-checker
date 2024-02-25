<?php

namespace Tests\Feature;

use App\Models\IbanData;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class IbanControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testValidIbanValidation()
    {

        IbanData::factory()->create([
            "country" => "Albania",
            "length" => 28,
            "code" => "AL",
            "format" => "AL2!n8!n16!c"
        ]);

        $password = 'test-password';
        $user = User::factory()->create(['password' => bcrypt($password)]);

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => $password,
        ]);
        $token = $user->createToken(Str::random(10))->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson('/api/validate-iban?iban=AL47212110090000000235698741');

        $response->assertStatus(200)
            ->assertJson(['status' => true, 'message' => 'The IBAN is Valid.']);
    }

    public function testInValidIbanValidation()
    {

        IbanData::factory()->create([
            "country" => "Albania",
            "length" => 28,
            "code" => "AL",
            "format" => "AL2!n8!n16!c"
        ]);

        $password = 'test-password';
        $user = User::factory()->create(['password' => bcrypt($password)]);

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => $password,
        ]);
        $token = $user->createToken(Str::random(10))->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson('/api/validate-iban?iban=CL47212110089700000235698741');


        $response->assertStatus(422)
            ->assertJson(['status' => false, 'message' => 'The IBAN is invalid.']);
    }
}
