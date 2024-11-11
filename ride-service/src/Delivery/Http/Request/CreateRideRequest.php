<?php

namespace Ride\Delivery\Http\Request;

use Common\Delivery\Http\Request\Dto\Dto;
use Common\Utils\Serialize\Trait\ObjectToArray;
use DateTimeImmutable;
use DateTimeInterface;
use Exception;
use InvalidArgumentException;
use ReflectionClass;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validation;

class CreateRideRequest
{
    use ObjectToArray;

    public string $name;

    public string $description;

    public DateTimeInterface $date;

    public DateTimeInterface $time_start;

    public DateTimeInterface $time_end;

    public string $image;

    public array $start_location;

    public array $finish_location;

    public function __construct(RequestStack $requestStack)
    {
        $request = $requestStack->getCurrentRequest();
        $data    = json_decode($request->getContent(), true);
        $this->validate($data);
        $this->fromArray($data);
    }


    protected function validate(array $data)
    {
        $validator  = Validation::createValidator();
        $constraint = new Assert\Collection([
            // the keys correspond to the keys in the input array
            'name'            => new Assert\NotBlank(),
            'description'     => new Assert\NotBlank(),
            'track'           => new Assert\NotBlank(),
            'date'            => [
                new Assert\NotBlank(),
                new Assert\DateTime([
                    'format' => 'Y-m-d\TH:i:s.v\Z',
                ]),
            ],
            'time_start'      => [
                new Assert\NotBlank(),
                new Assert\DateTime([
                    'format' => 'Y-m-d\TH:i:s.v\Z',
                ]),
            ],
            'time_end'        => [
                new Assert\NotBlank(),
                new Assert\DateTime([
                    'format' => 'Y-m-d\TH:i:s.v\Z',
                ]),
            ],
            'image'           => new Assert\NotBlank(),
            'start_location'  => new Assert\NotBlank(),
            'finish_location' => new Assert\NotBlank(),
        ]);

        $violations = $validator->validate($data, $constraint);

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
     * @return array
     */
    public function toArray(): array
    {
        return $this->propertiesToArray();
    }

    /**
     * @param string $className
     * @param array $data
     * @return object|string
     * @throws \ReflectionException
     */
    public function fromArray(array $data): void
    {
        $reflectionClass = new ReflectionClass($this);

        foreach ($data as $property => $value) {
            if ($reflectionClass->hasProperty($property)) {
                $propertyReflection = $reflectionClass->getProperty($property);
                $propertyReflection->setAccessible(true); // Позволяет устанавливать значения для приватных и защищённых свойств

                $type = $propertyReflection->getType();

                if ($type !== null) {
                    $typeName   = $type->getName();
                    $isNullable = $type->allowsNull();

                    // Обработка типов данных
                    switch ($typeName) {
                        case 'int':
                            $value = is_null($value) && $isNullable ? null : (int) $value;
                            break;
                        case 'float':
                            $value = is_null($value) && $isNullable ? null : (float) $value;
                            break;
                        case 'string':
                            $value = is_null($value) && $isNullable ? null : (string) $value;
                            break;
                        case 'bool':
                            $value = is_null($value) && $isNullable ? null : filter_var($value, FILTER_VALIDATE_BOOLEAN);
                            break;
                        case 'DateTimeInterface':
                            if (is_null($value) && $isNullable) {
                                $value = null;
                            } else {
                                try {
                                    $value = new DateTimeImmutable($value);
                                } catch (Exception $e) {
                                    throw new InvalidArgumentException("Неверный формат даты для свойства {$property}: " . $e->getMessage());
                                }
                            }
                            break;
                        // Добавьте дополнительные типы по необходимости
                        default:
                            // Для других классов можно добавить дополнительную обработку или оставить как есть
                            break;
                    }
                }

                // Установка значения свойства
                $propertyReflection->setValue($this, $value);
            }
        }
    }
}