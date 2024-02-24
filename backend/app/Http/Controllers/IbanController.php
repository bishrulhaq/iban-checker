<?php

namespace App\Http\Controllers;

use App\Models\IbanData;
use App\Models\ValidatedIban;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class IbanController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function validateIban(Request $request): JsonResponse
    {
        try {

            $validatedIBAN = $request->validate([
                'iban' => ['required']
            ]);

            $validatedWithSteps = $this->validateWithSteps($validatedIBAN['iban']);

            if ($validatedWithSteps === false) {
                return response()->json([
                    'status' => false,
                    'message' => 'The IBAN is invalid.'
                ], 422);
            }

            ValidatedIban::create([
                'iban' => $validatedIBAN['iban'],
                'user_id' => auth()->id()
            ]);

            return response()->json([
                'status' => true,
                'message' => 'The IBAN is Valid.'
            ], 200);

        } catch (ValidationException $e) {
            return response()->json([
                'errors' => $e->validator->errors()
            ], 422);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred.'
            ], 500);
        }
    }


    /**
     * @param $value
     * @return false|string
     */
    public function validateWithSteps($value): bool|string
    {

        if (!preg_match('/^[A-Z]{2}\d{2}[A-Z\d]{1,30}$/', $value)) {
            return false;
        }

        $countryCode = substr($value, 0, 2);
        $ibanData = IbanData::where('code', $countryCode)->first();

        if (!$ibanData) {
            return false;
        }

        if (strlen($value) !== $ibanData->length) {
            return false;
        }

        $rearranged = substr($value, 4) . substr($value, 0, 4);

        $digits = '';

        for ($i = 0; $i < strlen($rearranged); $i++) {
            $char = $rearranged[$i];
            if (ctype_alpha($char)) {
                $digits .= strval(ord($char) - 55);
            } else {
                $digits .= $char;
            }
        }

        $remainder = bcmod($digits, '97');
        return $remainder == 1;
    }

}
