<?php

namespace User\Infrastructure\Adapter\Persistence\Memory\Data;

class UsersDataset
{
    public static function all(): array
    {
        return [
            [
                'name' => 'Michael',
                'id' => 'a0203b55-78b4-46b4-8d8b-2428cfc87a64'
            ],
            [
                'name' => 'Jessica',
                'id' => '0c0a1a41-3f25-4536-87f7-b6468c2901f7'
            ],
            [
                'name' => 'John',
                'id' => '11f4d3ef-a15e-46e1-a1bf-e2c82e66c344'
            ],
            [
                'name' => 'Emily',
                'id' => 'a742024d-5939-408c-b65a-1bfdbeb6c6ac'
            ],
            [
                'name' => 'James',
                'id' => '22e76822-8d0f-4daa-a5c8-ca4d7b3f3b25'
            ],
            [
                'name' => 'Linda',
                'id' => 'b0586b4a-6e87-464f-83f1-9f98f29a2f3c'
            ],
            [
                'name' => 'Robert',
                'id' => '9e15f64c-573b-4729-b245-5d5b1c539233'
            ],
            [
                'name' => 'Sarah',
                'id' => '720b575c-91cc-445a-9b28-7d38134736a6'
            ],
            [
                'name' => 'William',
                'id' => 'f1ff9929-4860-42d5-beb2-4465431e9a67'
            ],
            [
                'name' => 'Karen',
                'id' => '397fa4aa-4adf-4c4e-b43d-3f5a3b9c44f5'
            ],
        ];
    }
}