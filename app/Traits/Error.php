<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait Error
{
    protected function formatError(\Exception $error): array
    {
        if ($error instanceof \Illuminate\Validation\ValidationException) {
            return $this->formatValidationError($error);
        } else {
            return $this->formatExceptionError($error);
        }
    }

    protected function formatExceptionError($error): array
    {
        $errorsArray = explode('--', $error->getMessage());
        $errorStatus = count($errorsArray) > 1 ? (int) $errorsArray[1] : 500;

        $errorData = explode('|', $errorsArray[0]);
        $errorMessage = $errorData[0];
        $errorText = count($errorData) > 1 ? $errorData[1] : '';

        return [
            'errorMessage' => $errorMessage,
            'errorText' => $errorText,
            'errorCode' => $error->getCode(),
            'errorStatus' => $errorStatus,
        ];
    }

    protected function formatValidationError($error): array
    {
        $errorText = array_map(function ($errorsArray) {
            return implode(', ', array_values($errorsArray));
        }, $error->errors());
        $errorText = implode(', ', array_values($errorText));
        return [
            'errorMessage' => 'Data validation error',
            'errorText' => $errorText,
            'errorCode' => 13335,
            'errorStatus' => 403,
        ];
    }

    protected function errorResponse(\Exception $error): JsonResponse
    {
        $errorData = $this->formatError($error);
        return response()->json($errorData, $errorData['errorStatus']);
    }
}
