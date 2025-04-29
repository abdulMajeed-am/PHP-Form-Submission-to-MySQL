<!-- Great! Let’s break down the PHP and SQL code in more detail so you can understand what’s happening under the hood:

---

### **Explanation of `index.php` (Form Page)**

```php
require_once 'config/db.php'; // Connect to DB
```
- **`require_once 'config/db.php';`**:
  - This line is important for connecting to your database. The `require_once` statement includes and runs the code in `db.php` (which contains your database connection). By using `require_once`, you ensure the file is only included once, even if it is called multiple times in your code. If the file doesn’t exist or there's an error, it will stop the script and show an error.

---

```php
$tableQuery = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$pdo->exec($tableQuery);
```
- **Create table if not exists**:
  - This block of code creates the `users` table in your database if it doesn't already exist. It uses SQL (`CREATE TABLE`) to define the structure of the table.
  - **`id INT AUTO_INCREMENT PRIMARY KEY`**: Creates an `id` column, which is an integer that automatically increments with each new entry. This column is the primary key, meaning it uniquely identifies each row in the table.
  - **`name VARCHAR(100) NOT NULL`**: Creates a `name` column that can store up to 100 characters and cannot be `NULL`.
  - **`email VARCHAR(100) NOT NULL`**: Similar to `name`, but stores the email address.
  - **`created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP`**: Automatically stores the timestamp when the row is created.
  - **`$pdo->exec($tableQuery);`**: This executes the SQL query using PDO (PHP Data Objects), which allows for secure database interactions. It ensures the table is created only if it doesn't already exist.

---

```php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name  = $_POST['name'];
    $email = $_POST['email'];

    $stmt = $pdo->prepare("INSERT INTO users (name, email) VALUES (?, ?)");
    $stmt->execute([$name, $email]);

    echo "Data submitted successfully!";
}
```
- **Form submission and inserting data**:
  - **`if ($_SERVER['REQUEST_METHOD'] == 'POST') {`**: This checks if the form is submitted using the **POST** method. Only when the form is submitted does the code inside the `if` block run.
  - **`$name  = $_POST['name'];` and `$email = $_POST['email'];`**: Retrieves the values entered by the user in the `name` and `email` form fields and stores them in variables.
  - **`$stmt = $pdo->prepare("INSERT INTO users (name, email) VALUES (?, ?)");`**: Prepares an **SQL statement** to insert the values into the `users` table. The question marks `?` are placeholders for the actual data.
  - **`$stmt->execute([$name, $email]);`**: Executes the prepared statement, replacing the placeholders with the actual values from the form (`$name` and `$email`). This ensures the data is securely inserted into the table.
  - **`echo "Data submitted successfully!";`**: After the insertion, this message is displayed to the user to let them know the data was submitted successfully.

---

### **Explanation of `view.php` (View Data Page)**

```php
$stmt = $pdo->query("SELECT * FROM users ORDER BY created_at DESC");
$data = $stmt->fetchAll();
```
- **`$stmt = $pdo->query("SELECT * FROM users ORDER BY created_at DESC");`**:
  - This executes an **SQL SELECT query** to fetch all the rows from the `users` table. The `ORDER BY created_at DESC` part ensures the results are ordered by the `created_at` column in **descending** order, meaning the most recently added entries appear first.
  - The `fetchAll()` function fetches all the results returned by the query and stores them in the `$data` variable. Each item in `$data` represents a row from the `users` table.

---

```php
<?php foreach ($data as $row): ?>
    <tr>
        <td><?= htmlspecialchars($row['id']) ?></td>
        <td><?= htmlspecialchars($row['name']) ?></td>
        <td><?= htmlspecialchars($row['email']) ?></td>
        <td><?= htmlspecialchars($row['created_at']) ?></td>
    </tr>
<?php endforeach; ?>
```
- **Displaying the data**:
  - **`foreach ($data as $row):`**: This is a loop that iterates through each row of data stored in `$data`. Each iteration stores one row's data in the `$row` variable.
  - **`<td><?= htmlspecialchars($row['id']) ?></td>`**: Each row contains four table cells (`<td>` tags):
    - The `id` value is fetched and displayed.
    - **`htmlspecialchars()`**: This function converts any special characters (e.g., `<`, `>`, `&`) into their HTML entity equivalents, preventing issues like XSS (Cross-Site Scripting) attacks.
  - **`$row['name']`, `$row['email']`, `$row['created_at']`**: These are the columns from the `users` table being displayed for each row.

---

### **Explanation of Database Connection (`config/db.php`)**

```php
$host = '127.0.0.1'; // Host (usually localhost)
$db   = 'practice_db'; // Database name
$user = 'root'; // Database username
$pass = ''; // Database password
$charset = 'utf8mb4'; // Character set for storing data

$dsn = "mysql:host=$host;dbname=$db;charset=$charset"; // Data Source Name (DSN) for PDO

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Enable error reporting
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Fetch rows as associative arrays
    PDO::ATTR_EMULATE_PREPARES   => false, // Disable emulated prepared statements
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options); // Try connecting to the database
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode()); // Handle connection errors
}
```
- **Database connection setup**:
  - **`$host = '127.0.0.1';`**: Defines the host where your database is running. In most cases, `127.0.0.1` or `localhost` will work for a local development setup.
  - **`$db = 'practice_db';`**: Specifies the name of the database you want to connect to.
  - **`$user = 'root';`** and **`$pass = '';`**: These define the **username** and **password** used to authenticate the connection. For MySQL on localhost, the default username is `root`, and often, the password is empty.
  - **`$charset = 'utf8mb4';`**: Sets the character set for the database to support all Unicode characters (including emojis).
  - **`$dsn = "mysql:host=$host;dbname=$db;charset=$charset";`**: The Data Source Name (DSN) defines how to connect to the database. It includes the type of database (`mysql`), host, database name, and charset.
  - **`$pdo = new PDO($dsn, $user, $pass, $options);`**: Establishes the database connection using **PDO**. The `$options` array defines connection attributes like error handling and fetch mode.
  - **`catch (\PDOException $e)`**: If the connection fails, this block catches the exception and throws an error with the message.

---

### Summary of the Flow:

1. **Form Submission (`index.php`)**:
   - The user fills out the form with their name and email.
   - When the form is submitted, the data is sent to `submit.php`, which processes it, creates the `users` table (if it doesn't exist), and inserts the data into the database.
   - After submission, a success message is shown.

2. **View Data (`view.php`)**:
   - The `view.php` page retrieves all data from the `users` table.
   - It loops through the results and displays them in a clean table format.

---

Let me know if you need further clarification on any specific part! -->