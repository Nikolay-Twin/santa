<?php
declare(strict_types=1);
namespace App\Helpers;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\ConstraintViolationList;

class ResponseHelper
{
    /**
     * @param string $message
     * @return JsonResponse
     */
    public static function success(string $message): JsonResponse
    {
        return new JsonResponse([
            'status' => 'ok',
            'message' => $message,
        ], 200);
    }


    /**
     * @param ConstraintViolationList|array|string $errors
     * @param int $code
     * @return JsonResponse
     */
    public static function error(ConstraintViolationList|array|string $errors, int $code = 400): JsonResponse
    {
        $outErrors = [];
        if ($errors instanceof ConstraintViolationList) {
            foreach ($errors as $message) {
                $outErrors[] = [
                    'property' => $message->getPropertyPath(),
                    'value' => $message->getInvalidValue(),
                    'message' => $message->getMessage(),
                ];
            }
        } elseif (is_array($errors)) {
            $outErrors = $errors;
        } else {
            $outErrors = [$errors];
        }

        return new JsonResponse([
            'status' => 'failed',
            'errors' => $outErrors,
        ], $code);
    }
}
