<?php

namespace Common\Delivery\Http\Request;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validation;

abstract class Request
{
    protected array $values;

    /**
     * @param RequestStack $requestStack
     */
    public function __construct(RequestStack $requestStack)
    {
        $request      = $requestStack->getCurrentRequest();
        $this->values = json_decode($request->getContent(), true) ?? $request->query->all();
        $this->validate($this->values);
    }

    /**
     * @param array $data
     * @return void
     */
    protected function validate(array $data)
    {
        $validator  = Validation::createValidator();
        $violations = $validator->validate($data, $this->rules());

        $errors = [];
        if (count($violations) > 0) {
            foreach ($violations as $violation) {
                $errors[] = [
                    'key'     => trim($violation->getPropertyPath(), '[]'), // Имя поля, например 'email'
                    'message' => $violation->getMessage(),                  // Сообщение об ошибке
                ];
            }
        }

        if (count($errors) > 0) {
            throw new ValidationFailedException('errors', $violations);
        }
    }

    /**
     * @return Collection
     */
    abstract public function rules(): Collection;

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->values;
    }
}