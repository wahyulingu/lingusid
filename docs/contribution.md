# Contribution Guidelines

We welcome contributions to the LinguSID project! Please follow these guidelines to ensure a smooth and collaborative development process.

## How to Contribute

1.  **Fork the repository:** Start by forking the LinguSID repository to your GitHub account.

2.  **Clone your forked repository:**

    ```bash
    git clone https://github.com/your-username/LinguSID.git
    cd LinguSID
    ```

3.  **Create a new branch:** Always create a new branch for your features or bug fixes. Use a descriptive name.

    ```bash
    git checkout -b feature/your-feature-name
    # or bugfix/your-bug-fix-name
    ```

4.  **Make your changes:** Implement your feature or fix the bug. Ensure your code adheres to the project's coding standards and conventions.

5.  **Run tests:** Before committing, make sure all existing tests pass and add new tests for your changes if applicable.

    ```bash
    # Example: php artisan test
    ```

6.  **Commit your changes:** Write clear and concise commit messages.

    ```bash
    git commit -m "feat: Add new feature X" # for new features
    # or git commit -m "fix: Resolve bug Y" # for bug fixes
    ```

7.  **Push to your fork:**

    ```bash
    git push origin feature/your-feature-name
    ```

8.  **Create a Pull Request (PR):** Go to the original LinguSID repository on GitHub and create a new Pull Request from your branch to the `develop` branch.

## Coding Standards

*   Follow PSR-12 for PHP code style.
*   Use meaningful variable and function names.
*   Add comments where necessary to explain complex logic.
*   Ensure your code is well-tested.

## Code Review Process

All pull requests will be reviewed by maintainers. Please be responsive to feedback and make necessary adjustments.

## Reporting Bugs

If you find a bug, please open an issue on GitHub with a clear description, steps to reproduce, and expected behavior.

## Suggesting Enhancements

For new features or enhancements, open an issue first to discuss your ideas with the community and maintainers.
