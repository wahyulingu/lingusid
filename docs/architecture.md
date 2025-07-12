# Project Architecture

LinguSID follows a modular and layered architecture to ensure maintainability, scalability, and separation of concerns.

## Core Layers

### 1. Controller Layer

*   **Responsibility:** Handles incoming HTTP requests, delegates business logic to the Action layer, and returns appropriate HTTP responses.
*   **Characteristics:** Kept as lean as possible. No direct interaction with Services or Repositories.
*   **Authentication/Authorization:** Handled at this layer.

### 2. Action Layer

*   **Responsibility:** Orchestrates business logic. Can access Repositories and Services.
*   **Characteristics:** Contains pure CRUD and business logic. No authentication or authorization concerns.
*   **Types:**
    *   **Regular Actions:** Do not perform validation. Use `$payload` for raw input.
    *   **Ruled Actions:** Extend `RuledAction` and implement `RuledActionContract`. Perform validation via `rules()` method. Use `$validatedPayload` for validated data.

### 3. Service Layer

*   **Responsibility:** Integrates with third-party APIs or encapsulates complex, domain-specific business logic that doesn't fit elsewhere.
*   **Characteristics:** Used for external integrations or highly specific business rules.

### 4. Repository Layer

*   **Responsibility:** Handles data access and persistence. Interacts directly with Eloquent ORM.
*   **Characteristics:** The only layer permitted to interact with Eloquent ORM.

## Directory Structure (Backend)

*   `app/Actions/`: Contains all Action classes, grouped by context (e.g., `User`, `Resident`).
*   `app/Contracts/`: Defines interfaces and contracts for various components.
*   `app/Http/Controllers/`: Houses Controller classes.
*   `app/Models/`: Eloquent models for database interaction.
*   `app/Repositories/`: Repository implementations for data access.
*   `app/Services/`: Service classes for external integrations or complex logic.
*   `app/Abstractions/Traits/`: Reusable traits.

## Frontend Structure

*   `resources/js/pages/`: Context-based directory structuring for frontend components, mirroring backend layers where applicable.
*   `resources/js/components/`: Reusable Vue components.
*   `resources/js/composables/`: Vue composables for reusable logic.

## Key Principles

*   **Dependency Injection:** Preferred method for managing dependencies, leveraging Laravel's auto-resolution.
*   **Modularity:** Code is organized into distinct, reusable modules.
*   **Separation of Concerns:** Each layer and component has a clear, single responsibility.
*   **Convention over Configuration:** Adherence to established naming conventions and patterns.
