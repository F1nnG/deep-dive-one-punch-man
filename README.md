# Deepdive - One Punch Man

This project was made in a Deep Dive for the Bit Academy,<br>
finished in the span of four days, and presented on the fifth.

For the project we have used Filament with custom pages, which uses the TALL stack.

## 🔧 Installation

1. Clone the repository

```bash
git clone git@github.com:ldideric/deep-dive-one-punch-man.git
```

2. Run the composer and npm install commands.

```bash
composer install
npm install
```

4. Run the npm build command to compile the views.

```bash
npm run build
```

5. Copy the .env.example to .env, and configure it to your liking.

```bash
cp .env.example .env
```

6. Generate a Laravel key.

```bash
php artisan key:generate
```

7. Run the migration & seeder.

```bash
php artisan migrate --seed
```

## ⚙️ Usage

To run a local server, run the following command:

```bash
php artisan serve
```

If you want to run de demo for the Battle system you can run the following command:

```bash
php artisan demo:start
```

## 🔗 Credits

Made by: <br>

[![portfolio](https://img.shields.io/badge/Finn_Groenewoud-1DA1F2?style=for-the-badge&logo=github&logoColor=white)](https://github.com/F1nnG/)<br>
[![portfolio](https://img.shields.io/badge/Lietze_Diderich-00C04B?style=for-the-badge&logo=github&logoColor=white)](https://github.com/ldideric/)
