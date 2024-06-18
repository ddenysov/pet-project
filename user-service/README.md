```
src/
├── Application/
│   ├── Command/
│   │   ├── Handler/
│   │   └── CommandNameCommand.php
│   ├── Query/
│   │   ├── Handler/
│   │   └── QueryNameQuery.php
│   └── Response/
│       └── ResponseNameResponse.php
├── Domain/
│   ├── Model/
│   │   └── EntityName.php
│   ├── Ports/
│   │   └── Input/
│   │       └── EntityNameRepositoryInterface.php  (Входящие порты)
│   └── Service/
│       └── DomainServiceName.php
├── Infrastructure/
│   ├── Ports/
│   │   └── Output/
│   │       └── EntityNameRepository.php  (Исходящие порты)
│   ├── Adapter/
│   │   ├── API/
│   │   │   └── APIAdapter.php  (Внешний адаптер)
│   │   └── Persistence/
│   │       └── Doctrine/
│   │           ├── Repository/
│   │           │   ├── EntityNameRepository.php
│   │           │   └── DoctrineAdapter.php  (Адаптер для репозитория)
│   │           └── Mapping/
│   │               └── EntityName.orm.xml
│   └── CLI/
│       └── Command/
│           └── SpecificCommand.php
└── UI/
├── HTTP/
│   ├── Controller/
│   │   └── EntityNameController.php (Адаптер HTTP)
│   └── Form/
│       └── Type/
│           └── EntityTypeName.php
└── CLI/
└── Command/
└── SpecificCommandName.php
config/
│   ├── packages/
│   └── routes.yaml
public/
│   └── index.php
templates/
│   └── base.html.twig
tests/
│   ├── Application/
│   │   └── SomeApplicationTest.php
│   ├── Domain/
│   │   └── SomeDomainTest.php
│   └── Infrastructure/
│       └── SomeInfrastructure Test.php
translations/
│   └── messages.en.yaml
var/
│   ├── cache/
│   ├── log/
│   └── session/
vendor/
```

Test commit