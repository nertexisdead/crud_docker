<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class GuestController extends Controller
{
    public function guestsList()
    {
        $guests = Guest::all();

        if ($guests->count() > 0) {
            return response()->json($guests, 200);
        } else {
            return response()->json(['message' => 'No guests found'], 404);
        }
    }

    public function guestsEdit($id)
    {
        $guest = Guest::find($id);

        if ($guest) {
            return response()->json($guest, 200);
        } else {
            return response()->json(['message' => 'Guest not found'], 404);
        }
    }

    public function guestsSave(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:guests',
                'phone' => 'required|string|max:20|unique:guests',
                'country' => 'nullable|string|max:255'
            ]);

            if (!isset($validatedData['country']) || empty($validatedData['country'])) {
                $validatedData['country'] = $this->determineCountry($validatedData['phone']);
            }

            $guest = Guest::create($validatedData);

            $responseData = [
                'first_name' => $guest->first_name,
                'last_name' => $guest->last_name,
                'email' => $guest->email,
                'phone' => $guest->phone,
                'country' => $guest->country,
            ];

            return response()->json($responseData, 201);
        } catch (ValidationException $e) {
            return response()->json([
                'errors' => $e->errors()
            ], 422);
        }
    }


    public function guestsUpdate(Request $request, $id)
    {
        $guest = Guest::find($id);

        if (!$guest) {
            return response()->json(['error' => 'Guest not found.'], 404);
        }

        try {

            $validatedData = $request->validate([
                'first_name' => 'sometimes|required|string|max:255',
                'last_name' => 'sometimes|required|string|max:255',
                'email' => [
                    'sometimes',
                    'required',
                    'string',
                    'email',
                    'max:255',
                    Rule::unique('guests')->ignore($guest->id)
                ],
                'phone' => [
                    'sometimes',
                    'required',
                    'string',
                    'max:20',
                    Rule::unique('guests')->ignore($guest->id)
                ],
                'country' => 'nullable|string|max:255'
            ]);

            if (!isset($validatedData['country']) || empty($validatedData['country'])) {
                $validatedData['country'] = $this->determineCountry($validatedData['phone']);
            }

            $guest->update($validatedData);
            $guest = $guest->refresh();

            $responseData = [
                'first_name' => $guest->first_name,
                'last_name' => $guest->last_name,
                'email' => $guest->email,
                'phone' => $guest->phone,
                'country' => $guest->country,
            ];

            return response()->json($responseData, 200);
        } catch (ValidationException $e) {
            return response()->json([
                'errors' => $e->errors()
            ], 422);
        }
    }


    public function guestsDelete($id)
    {
        $guest = Guest::find($id);

        if (!$guest) {
            return response()->json(['error' => 'Guest not found.'], 404);
        }

        try {
            $guest->delete();

            return response()->json(['message' => 'Guest was deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete guest.'], 500);
        }
    }

    public function determineCountry($phone)
    {
        if (strpos($phone, '+7') === 0) {
            return 'Россия';
        } elseif (strpos($phone, '+1') === 0) {
            return 'США';
        } elseif (strpos($phone, '+44') === 0) {
            return 'Великобритания';
        } elseif (strpos($phone, '+33') === 0) {
            return 'Франция';
        } elseif (strpos($phone, '+49') === 0) {
            return 'Германия';
        } else {
            return 'Неизвестная страна';
        }
    }

}
