# Development Workflow Notes

- Always create new branches from the `main` branch unless instructed otherwise.
- When creating a new feature, implementation should stop at the Action layer. Do not create controllers or frontend components unless explicitly requested.
- Always create new features in a new branch unless instructed otherwise.
- Every action that requires validation must extend `RuledAction` and implement `RuledActionContract`.
- The method used for operations inside an action should be `handler()` not `handle()`.
- Traits should be stored in `App/Abstractions/Traits/[context]/[TraitName]Trait.php`.
- All `Action`, `Contract`, `Service`, `Model`, `Helper`, and `Enum` files must follow the naming convention: `[Context]/FileName[Type].php` (e.g., `App/Actions/User/CreateUserAction.php`, `App/Contracts/Action/InvokeableActionContract.php`, `App/Models/User.php`, `App/Enums/UserRoleEnum.php`).
- When developing new features, analyze existing code for consistent design patterns, structure, and architecture.
- Prioritize modular and reusable code. If small, reusable code is needed, add it to `App/Helpers` and group it into classes based on characteristics and usage context.
- **Testing Guidelines:**
    - For PHPUnit, always include `use PHPUnit\Framework\Attributes\Test;` at the top of your test files. Use the `#[Test]` attribute and name methods descriptively (e.g., `test_feature_behavior`) instead of using `it_` prefixes.
    - When testing, focus on running only relevant tests. Avoid running the entire test suite, especially after an error.
    - Apply fixes carefully, limiting changes to the immediate context of the feature to prevent unintended side effects.
- Do not run tests unless explicitly asked, as it slows down the development process.

## Architectural Rules

- **Repository Layer:** Only the repository layer is permitted to interact directly with Eloquent ORM for data access.
- **Service Layer:** Services are designated for integrating with third-party APIs or encapsulating complex, domain-specific business logic that doesn't fit elsewhere.
- **Action Layer:** Actions are responsible for orchestrating business logic. They can access Repositories and Services to perform their tasks. Actions should only contain pure CRUD and business logic, without authentication or authorization concerns.
- **Controller Layer:** Controllers must be kept as lean as possible. Their sole responsibility is to handle HTTP requests and delegate the execution of business logic to the Action layer. Controllers are not permitted to access Services directly. Authentication and authorization logic should be handled at the Controller layer.
Do not modify Laravel's built-in code or vendor code without confirmation.