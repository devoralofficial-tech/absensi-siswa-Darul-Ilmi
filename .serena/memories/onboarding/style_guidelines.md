# Style Guidelines & Coding Conventions

- **PHP Standards**: PSR-12 / PER Coding Style 2.0.
- **Naming Conventions**:
  - Controllers: PascalCase (e.g., `AttendanceController`)
  - Models: PascalCase, singular (e.g., `Student`)
  - Views: kebab-case/snake_case (e.g., `attendance-list.blade.php`)
  - Database: snake_case for fields and table names.
- **Code Formatting**:
  - The project uses Laravel Pint for automated PHP style fixing:
    ```bash
    ./vendor/bin/pint
    ```
- **Frontend Standards**:
  - HTML structures should follow semantic HTML5.
  - CSS relies on TailwindCSS.
