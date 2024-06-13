1. use a repository to find one or several entities;
2. tell those entities to do some domain logic;
3. and use the repository to persist the entities again, effectively saving the data changes.
4. Command Bus
5. Query Bus
6. Ports
7. Application Events

The Command Handlers can be used in two different ways:
They can contain the actual logic to perform the use case;
They can be used as mere wiring pieces in our architecture, receiving a Command and simply triggering logic that exists in an Application Service.