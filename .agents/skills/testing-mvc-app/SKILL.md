# Testing the PHP MVC Application (atividade-mvc)

## Environment Setup

1. **Install PHP** (if not present): `sudo apt-get install -y php php-sqlite3 php-cli`
2. **Run migration**: `cd atividade-mvc && php migration.php` — creates `database.sqlite` with `alunos` table
3. **Start server**: `php -S localhost:8000` from the `atividade-mvc/` directory
4. **Verify**: `curl -s http://localhost:8000` should return the HTML form

## Test Scenarios

### 1. Middleware Validation (empty form)
- Submit the form with all fields empty
- **Expected**: Red error banner: "Todos os campos são obrigatórios. Preencha Nome, Idade e Curso."
- No record should be created in SQLite

### 2. Service Business Rule (underage student)
- Submit with a student below the minimum age for their course
- Example: Nome="João Silva", Idade=15, Curso="Medicina" (min age 18)
- **Expected**: Red error banner: "Idade mínima para o curso de Medicina é 18 anos. Você informou 15 anos."
- No record should be created in SQLite

### 3. Valid Submission with Scholarship
- Submit with valid data that qualifies for a scholarship
- Example: Nome="Ana Costa", Idade=19, Curso="Engenharia" (min 17, scholarship 30% if ≤20)
- **Expected**: Green success banner mentioning "bolsa de 30% de desconto"
- Verify SQLite record: `php -r "\$pdo = new PDO('sqlite:database.sqlite'); \$stmt = \$pdo->query('SELECT * FROM alunos'); while(\$row = \$stmt->fetch(PDO::FETCH_ASSOC)) { print_r(\$row); }"`

## Business Rules Reference

| Curso | Idade Mínima | Bolsa (se idade ≤ max) |
|-------|-------------|------------------------|
| Engenharia | 17 | 30% (≤20 anos) |
| Medicina | 18 | — |
| Direito | 17 | — |
| Administração | 16 | 25% (≤22 anos) |
| Design | 16 | 20% (≤21 anos) |

## Tips

- The `database.sqlite` file is in `.gitignore` — always run `php migration.php` first
- To reset the database between test runs: `rm atividade-mvc/database.sqlite && php atividade-mvc/migration.php`
- The form dropdown has a "Selecione o curso..." placeholder with empty value — submitting with this selected triggers the middleware validation (empty curso field)
- The PHP built-in server logs requests to stderr — useful for debugging
- Browser testing is preferred over curl for visual verification of success/error message styling (green vs red banners)

## Devin Secrets Needed

No secrets required — this is a local PHP + SQLite application.
