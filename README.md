# Repair CRM

Laravel CRM for a computer and office equipment repair workshop.

## Features

- Client management
- Service order lifecycle management
- Status transitions and status history
- Works and parts line items
- Payment recording and balance tracking
- Internal and customer-visible comments
- Attachment upload and gallery
- Business profile and bank account settings
- Document generation:
    - invoice
    - intake act
    - completion act
- Multilingual UI support

## Tech Stack

- Laravel 13
- Livewire
- PostgreSQL
- Tailwind CSS

## Requirements

- PHP 8.4+
- Composer
- PostgreSQL
- Node.js 20+
- npm

## Installation

```bash
git clone git@github.com:andrewchuev/laravel-repair-crm.git
cd laravel-repair-crm
composer install
npm install
cp .env.example .env
php artisan key:generate
```

Configure database and app settings in `.env`, then run:

```bash
php artisan migrate --seed
npm run build
php artisan serve
```

## Development

```bash
npm run dev
php artisan serve
```

## Testing

```bash
php artisan test
```

## Main Modules

- Dashboard
- Clients
- Service Orders
- Attachments
- Payments
- Documents
- Settings
- Profile / locale preferences

## Documents

The system supports HTML document generation out of the box.

For PDF generation, install a PDF driver such as:

```bash
composer require barryvdh/laravel-dompdf
```

## Localization

UI locale is resolved in this order:

1. User preferred locale
2. System default locale
3. Application fallback locale

Supported locales:

- English
- Russian
- Ukrainian

## License

Proprietary / internal use unless stated otherwise.
