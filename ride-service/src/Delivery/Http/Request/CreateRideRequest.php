<?php

namespace Ride\Delivery\Http\Request;

use Common\Delivery\Http\Request\Dto\Dto;
use Common\Utils\Serialize\Trait\ObjectToArray;
use DateTimeInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validation;

class CreateRideRequest
{
    use ObjectToArray;

    public string $name;

    public $description;

    public DateTimeInterface $date;

    public DateTimeInterface $time_start;

    public DateTimeInterface $time_end;

    public string $image;

    public array $start_location;

    public array $finish_location;

    public function __construct(RequestStack $requestStack)
    {
        $request = $requestStack->getCurrentRequest();
        $data = json_decode($request->getContent(), true);
        $this->validate($data);

        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
    }

    protected function validate(array $data)
    {
        $validator = Validation::createValidator();
        $constraint = new Assert\Collection([
            // the keys correspond to the keys in the input array
            'name' => new Assert\NotBlank(),
            'description' => new Assert\NotBlank(),
        ]);

        $violations = $validator->validate($data, $constraint);


        $errors = [];
        if (count($violations) > 0) {
            foreach ($violations as $violation) {
                $errors[] = [
                    'key' => trim($violation->getPropertyPath(), '[]'), // Имя поля, например 'email'
                    'message' => $violation->getMessage(), // Сообщение об ошибке
                ];
            }
        }

        if (count($errors) > 0) {
            throw new ValidationFailedException('errors', $violations);
        }

    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->propertiesToArray();
    }

}