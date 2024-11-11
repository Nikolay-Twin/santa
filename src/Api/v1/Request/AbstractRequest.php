<?php
declare(strict_types=1);
namespace App\Api\v1\Request;

use App\Helpers\ResponseHelper;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class AbstractRequest
{
    private Request $request;
    private object $requestData;

    /**
     * @param ValidatorInterface $validator
     */
    public function __construct(protected ValidatorInterface $validator)
    {
        $this->createRequest();
        $this->populate();

        if ($this->autoValidateRequest()) {
            $this->validate();
        }
    }

    /**
     * @return void
     */
    public function validate(): void
    {
        $errors = $this->validator->validate($this);
        if (count($errors)) {
            $response = ResponseHelper::error($errors);
            $response->send();
            exit();
        }
    }

    /**
     * @return void
     */
    public function createRequest(): void
    {
        $this->request = Request::createFromGlobals();
    }

    /**
     * @return object
     */
    public function getData(): object
    {
        return $this->requestData;
    }

    /**
     * @return void
     */
    protected function populate(): void
    {
        $this->requestData = (object)$this->request->toArray();

        foreach (get_object_vars($this) as $attribute => $_) {
            if (property_exists($this->requestData, $attribute)) {
                $this->{$attribute} = $this->requestData->{$attribute};
            }
        }
    }

    /**
     * @return bool
     */
    protected function autoValidateRequest(): bool
    {
        return true;
    }
}
