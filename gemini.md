# Development Workflow Notes

- Always create new branches from the `main` branch unless instructed otherwise.
- When creating a new feature, implementation should stop at the Action layer. Do not create controllers or frontend components unless explicitly requested.
- Always create new features in a new branch unless instructed otherwise.
- Every action that requires validation must extend `RuledAction` and implement `RuledActionContract`.
- The method used for operations inside an action should be `handler()` not `handle()`.
- Traits should be stored in `App/Abstractions/Traits/[context]/[TraitName]Trait.php`.
- All `Action`, `Contract`, `Service`, `Model`, `Helper`, and `Enum` files must follow the naming convention: `[Context]/FileName[Type].php` (e.g., `App/Actions/User/CreateUserAction.php`, `App/Contracts/Action/InvokeableActionContract.php`, `App/Models/User.php`, `App/Enums/UserRoleEnum.php`).