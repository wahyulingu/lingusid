# Development Workflow Notes

- **JavaScript Runtime:** Prioritize using `bun` for all JavaScript-related tasks (installing dependencies, running scripts). If `bun` is not available, use `npm` or `yarn` as an alternative.
- Always create new branches from the `develop` branch unless instructed otherwise.
- When creating a new feature, implementation should stop at the Action layer. Do not create controllers or frontend components unless explicitly requested.
- Always create new features in a new branch unless instructed otherwise.
- When developing a feature, do not modify files outside the feature's context unless specifically requested.
- Every action that requires validation must extend `RuledAction` and implement `RuledActionContract`.
- **Action Method Convention:** When creating an Action class, it must conform to the existing abstraction. The `handler()` method is the main method where the core logic or task is executed, while the `handle()` method is used to trigger the action. When creating any PHP class, it is crucial to adhere to the established abstraction for the class, method, or contract, if one exists.
    - There are two types of Action classes:
        1.  **Regular Actions:** These do not perform validation. Their `handler()` method will receive an empty array for `$validatedPayload`. In this case, use the `$payload` argument to access the raw input data.
        2.  **Ruled Actions:** These extend `RuledAction` and implement `RuledActionContract`, requiring a `rules()` method. Their `handler()` method's `$validatedPayload` argument will contain data that has already been validated and potentially manipulated by the validation process. The `$payload` argument will contain the original, unvalidated data. Always prefer `$validatedPayload` for validated data in Ruled Actions.
    - **Calling Actions:**
        - Use the `execute()` method when you have an instance of the Action class (e.g., via dependency injection in a Controller). This method is suitable for direct calls within a class where the Action is resolved.
        - Use the static `handle()` method when you need to call an Action without instantiating it manually (e.g., in a service provider or a simple script). This method resolves the Action from the service container.
        - Never directly call the `handler()` method, as it is protected and intended for internal use within the Action class.
- Traits should be stored in `App/Abstractions/Traits/[context]/[TraitName]Trait.php`.
- All `Action`, `Contract`, `Service`, `Model`, `Helper`, and `Enum` files must follow the naming convention: `[Context]/FileName[Type].php` (e.g., `App/Actions/User/CreateUserAction.php`, `App/Contracts/Action/InvokeableActionContract.php`, `App/Models/User.php`, `App/Enums/UserRoleEnum.php`).
- When developing new features, analyze existing code for consistent design patterns, structure, and architecture.
- Prioritize modular and reusable code. If small, reusable code is needed, add it to `App/Helpers` and group it into classes based on characteristics and usage context.
- **Testing Guidelines:**
    - For PHPUnit, always include `use PHPUnit\Framework\Attributes\Test;` at the top of your test files. Use the `#[Test]` attribute and name methods descriptively (e.g., `test_feature_behavior`) instead of using `it_` prefixes.
    - When testing, focus on running only relevant tests. Avoid running the entire test suite, especially after an error.
    - Apply fixes carefully, limiting changes to the immediate context of the feature to prevent unintended side effects.
- Do not run tests unless explicitly asked, as it slows down the development process.
- **Code Quality:** Always strive to write clean, maintainable, and efficient code. Adhere to established coding standards, design patterns, and best practices to ensure high-quality and scalable solutions.

## Architectural Rules

- **Dependency Injection:** Always prefer automatic dependency injection (type-hinting) provided by the framework. Manual binding to the service container should only be used in complex scenarios, such as when defining singletons, contextual bindings, or when an interface needs to be bound to a specific implementation. Avoid unnecessary manual binding to maintain code clarity and leverage the framework's auto-resolution capabilities.
- **Repository Layer:** Only the repository layer is permitted to interact directly with Eloquent ORM for data access.
- **Service Layer:** Services are designated for integrating with third-party APIs or encapsulating complex, domain-specific business logic that doesn't fit elsewhere.
- **Action Layer:** Actions are responsible for orchestrating business logic. They can access Repositories and Services to perform their tasks. Actions should only contain pure CRUD and business logic, without authentication or authorization concerns.
- **Controller Layer:** Controllers must be kept as lean as possible. Their sole responsibility is to handle HTTP requests and delegate the execution of business logic to the Action layer. Controllers are not permitted to access Services directly. Authentication and authorization logic should be handled at the Controller layer.
  Do not modify Laravel's built-in code or vendor code without confirmation.
- **Routing:** Group routes by prefix and middleware. Prioritize `Route::resource` and ensure clear naming conventions.
- **Frontend Structure:** Apply context-based directory structuring (similar to backend layers like Actions, Repositories) to frontend components and files. The `resources/js/pages/Dashboard/Index.vue` component serves as the reference for creating new page components. Always use components from the Laravel starter kit as a reference for consistent UI development, such as `resources/js/pages/Dashboard/Index.vue`, `resources/js/pages/Auth/*`, and `resources/js/pages/Settings/*`.

## Tool Usage

- **External Tasks:** I will not run external tasks or instances such as development servers. Please run these in a separate terminal session and provide me with any relevant data, such as error reports or output logs.
- **File Paths:** Always use absolute paths when referring to files with tools like 'read_file' or 'write_file'. Relative paths are not supported. You must provide an absolute path.
- **Parallelism:** Execute multiple independent tool calls in parallel when feasible (i.e. searching the codebase).
- **Command Execution:** Use the 'run_shell_command' tool for running shell commands, remembering the safety rule to explain modifying commands first.
- **Background Processes:** Use background processes (via `&`) for commands that are unlikely to stop on their own, e.g. `node server.js &`. If unsure, ask the user.
- **Interactive Commands:** Try to avoid shell commands that are likely to require user interaction (e.g. `git rebase -i`). Use non-interactive versions of commands (e.g. `npm init -y` instead of `npm init`) when available, and otherwise remind the user that interactive shell commands are not supported and may cause hangs until canceled by the user.
- **Remembering Facts:** Use the 'save_memory' tool to remember specific, _user-related_ facts or preferences when the user explicitly asks, or when they state a clear, concise piece of information that would help personalize or streamline _your future interactions with them_ (e.g., preferred coding style, common project paths they use, personal tool aliases). This tool is for user-specific information that should persist across sessions. Do _not_ use it for general project context or information that belongs in project-specific `GEMINI.md` files. If unsure whether to save something, you can ask the user, "Should I remember that for you?"
- **Respect User Confirmations:** Most tool calls (also denoted as 'function calls') will first require confirmation from the user, where they will either approve or cancel the function call. If a user cancels a function call, respect their choice and do _not_ try to make the function call again. It is okay to request the tool call again _only_ if the user requests that same tool call on a subsequent prompt. When a user cancels a function call, assume best intentions from the user and consider inquiring if they prefer any alternative paths forward.
- **Language Preference:** English should only be used for code and file structure. Text displayed to the user on screen may be in languages other than English. If you provide instructions for code generation (e.g., tables, models, actions, classes, methods, variables) in Indonesian, I will translate them to English before processing.
