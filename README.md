<p align="center">
  <img src="resources/img/logo.png" alt="Burnout Logo" width="200"/>
</p>

<h1 align="center">🔥 BURNOUT</h1>

<p align="center">
  <em>The first 100% motorcycle-focused social network.</em><br>
  <strong>Ride. Share. Chat. Live full throttle.</strong>
</p>

<p align="center">
  <a href="https://github.com/Twikus/burnout-social-network/actions">
    <img alt="CI status" src="https://img.shields.io/github/actions/workflow/status/Twikus/burnout-social-network/ci.yml?branch=main&label=build" />
  </a>
  <a href="https://opensource.org/licenses/MIT">
    <img alt="MIT License" src="https://img.shields.io/badge/license-MIT-green.svg" />
  </a>
</p>

---

## 🏍️ About

**Burnout** is the first social network 100% dedicated to motorcycle enthusiasts.  
No pointless chatter — just the roar of engines, burning rubber, and pure two-wheel passion.

Share your bikes, comment on community rides, and chat live with riders around the world via our built-in real-time messaging system.

Whether you're into café racers, sport bikes, customs, or off-road trails, **Burnout** is your tribe.

---

## 🚀 Features

- 🔐 Social authentication (OAuth)
- 🧑‍💻 Two-factor authentication (2FA)
- 💬 Real-time instant messaging (Pusher)
- 🏍️ Community feed & motorcycle showcases
- 📱 Available to WebApp

---

## 🛠️ Tech Stack

| Layer            | Technology              |
|------------------|-------------------------|
| Framework        | Laravel                 |
| Frontend         | Inertia + Tailwind CSS  |
| Real-time Engine | Pusher (WebSockets)     |
| Database         | MySQL.                  |
| Package Managers | Composer, NPM           |

---

## 📦 Installation

### 🔧 Requirements

- PHP ≥ 8.2
- Composer
- Node.js ≥ 18
- MySQL
- Pusher credentials

### ⚙️ Setup

```bash
# Clone the repo
git clone https://github.com/Twikus/burnout-social-network.git
cd burnout

# Install backend dependencies
composer install

# Install frontend assets
npm install && npm run dev

# Copy and configure .env file
cp .env.example .env

# Configure DB (MySQL) & Pusher in .env
# Example:
# DB_CONNECTION=pgsql
# DB_HOST=127.0.0.1
# DB_PORT=5432
# DB_DATABASE=burnout
# DB_USERNAME=your_user
# DB_PASSWORD=your_password

# Start Docker
./vendor/bin/sail up -d

# Generate AppKey
./vendor/bin/sail artisan key:generate

# Run migrations
./vendor/bin/sail artisan migrate

# Npm installation
npm install

# Start vite server
npm run dev

```

---

## 🧪 Testing

Burnout includes plans for:

- ✅ Unit Tests (PHPUnit)
- ✅ Integration Tests

To run all tests:

```bash
./vendor/bin/sail artisan test
```

---

## 📸 Screenshots

> *Coming soon — UI preview, chat window, bike feed...*

---

## 🔄 CI/CD

GitHub Actions CI pipeline will be available in `.github/workflows/ci.yml`.

Badge reflects the status of the main branch builds:  
![CI](https://img.shields.io/github/actions/workflow/status/Twikus/burnout-social-network/ci.yml?branch=main&label=build)

---

## 👨‍💻 Author

**Axel Duquelzar**  
🌐 [axelduquelzar.fr](https://axelduquelzar.fr)  
🔗 [LinkedIn](https://www.linkedin.com/in/axel-duquelzar)

---

## 📜 License

This project is licensed under the [MIT License](LICENSE).

> ⚠️ This is a side project created for learning and experimentation.  
> It is not intended for production deployment as-is.

---

## 🤘 Final Word

Burnout is not just code — it’s the spark for a community of riders.  
Join in, share your world, and ride full throttle.  

**#RideShareChat**
