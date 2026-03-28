# Repair CRM

Repair CRM is a modular Laravel-based internal system for a computer, office equipment, and cartridge repair workshop. The project is designed as a pragmatic monolith: one codebase, one database, a clear module boundary between domains, and a Livewire-based back-office UI.

This repository is intended for real workshop operations, not as a demo app. The system covers the complete operational flow from client intake to service order execution, payment tracking, document generation, attachment storage, and multilingual operator UI.

---

## 1. Product Scope

The system is built around a repair workshop workflow:

1. create or find a client
2. register a service order
3. record intake details and the reported problem
4. move the order through a controlled status workflow
5. add works / parts line items
6. record payments
7. attach photos and files
8. generate documents
9. close and deliver the order

The current documented baseline includes these areas:

- authentication and active-user checks
- operator roles and preferred UI locale
- client management
- service order lifecycle management
- works and parts pricing
- payments and balance tracking
- comments and attachments
- status history
- settings for business profile and payment requisites
- document generation
- multilingual UI support
- automated tests for core flows

---

## 2. Technology Stack

### Backend
- **Laravel 13** style monolith architecture on top of standard Laravel foundations
- **PHP 8.4+**
- **PostgreSQL**
- **Laravel Fortify** for authentication
- **Livewire** for interactive operator UI
- **Eloquent ORM** for persistence
- **Pest** for testing

### Frontend
- **Blade**
- **Livewire**
- **Tailwind CSS**
- lightweight Alpine-based UI enhancements for toast notifications and small interactions

### Optional / extension integrations
- **barryvdh/laravel-dompdf** for PDF generation
- local/private filesystem storage for attachments and generated documents

---

## 3. Architectural Style

The project uses a **modular monolith** structure. It is not a microservice system. Domain boundaries are expressed inside the Laravel application through modules and layered folders.

### Why this shape
This architecture is a good fit because:

- the user count is small
- the operational domain is bounded and cohesive
- most use cases are strongly transactional
- low deployment complexity matters
- modularity is still required for maintainability

### Main architectural principles
- one deployable backend application
- one relational database
- module boundaries per business domain
- explicit application actions for use-case orchestration
- Eloquent models remain inside infrastructure/persistence
- presentation separated into HTTP + Livewire
- enums used for controlled domain values
- documents generated from business entities, not edited manually in the UI

---

## 4. High-Level Project Structure

Current documented project structure is centered around `app/Modules/*`, `app/Shared/*`, Livewire components, and Blade pages.

```text
app/
├── Models/
│   └── User.php
├── Shared/
│   ├── Domain/
│   │   └── Enums/
│   └── Presentation/
│       └── Http/
│           └── Middleware/
├── Modules/
│   ├── Users/
│   │   └── Domain/
│   │       └── Enums/
│   ├── Clients/
│   │   ├── Domain/
│   │   │   └── Enums/
│   │   ├── Application/
│   │   │   └── Actions/
│   │   ├── Infrastructure/
│   │   │   └── Persistence/
│   │   │       └── Models/
│   │   └── Presentation/
│   │       ├── Routes/
│   │       └── Http/
│   │           ├── Controllers/
│   │           ├── Requests/
│   │           └── Resources/
│   ├── ServiceOrders/
│   │   ├── Domain/
│   │   │   └── Enums/
│   │   ├── Application/
│   │   │   └── Actions/
│   │   ├── Infrastructure/
│   │   │   └── Persistence/
│   │   │       └── Models/
│   │   └── Presentation/
│   │       ├── Routes/
│   │       └── Http/
│   │           ├── Controllers/
│   │           ├── Requests/
│   │           └── Resources/
│   ├── Documents/
│   │   ├── Domain/
│   │   │   └── Enums/
│   │   ├── Application/
│   │   │   ├── Actions/
│   │   │   └── Services/
│   │   ├── Infrastructure/
│   │   │   └── Persistence/
│   │   │       └── Models/
│   │   └── Presentation/
│   │       └── Http/
│   │           └── Controllers/
│   ├── Settings/
│   │   ├── Application/
│   │   │   └── Actions/
│   │   └── Infrastructure/
│   │       └── Persistence/
│   │           └── Models/
│   └── Activity/
│       ├── Application/
│       │   └── Actions/
│       └── Infrastructure/
│           └── Persistence/
│               └── Models/
├── Livewire/
│   ├── Dashboard/
│   ├── Clients/
│   ├── ServiceOrders/
│   ├── Settings/
│   └── Profile/
resources/
├── views/
│   ├── layouts/
│   ├── pages/
│   ├── livewire/
│   ├── documents/
│   └── components/
routes/
├── web.php
└── web.frontend.stub.php
database/
├── migrations/
└── seeders/
lang/
├── en/
├── ru/
└── uk/
```

---

## 5. Layer Responsibilities

Each module follows the same basic layering idea.

### Domain
Contains enums and value-oriented domain definitions.

Examples:
- `ClientType`
- `ServiceOrderStatus`
- `PaymentMethod`
- `AttachmentType`
- `DocumentType`
- `UserRole`
- `SupportedLocale`

This layer defines allowed values and labels but avoids persistence orchestration.

### Application
Contains use-case actions and small services.

Examples:
- `CreateClientAction`
- `CreateServiceOrderAction`
- `ChangeServiceOrderStatusAction`
- `AddServiceOrderItemAction`
- `RecordPaymentAction`
- `UploadServiceOrderAttachmentAction`
- `GenerateInvoiceAction`
- `DocumentNumberGenerator`

This layer coordinates domain rules, persistence, and side effects.

### Infrastructure
Contains persistence models and storage-related behavior.

Examples:
- Eloquent models
- file path resolution
- generated document record storage
- attachment file metadata
- snapshot persistence

### Presentation
Contains:
- routes
- HTTP controllers
- form request validation
- JSON resources
- Livewire components
- Blade views

This layer translates user input into application actions and formats responses.

---

## 6. Core Modules

## 6.1 Users
The built-in Laravel `User` model is extended with CRM fields:

- `role`
- `phone`
- `is_active`
- `preferred_locale`

The model is cast to:
- `UserRole`
- `SupportedLocale`

### Main responsibilities
- authentication
- UI locale preference
- authorization base
- workshop actor references:
  - order accepted by
  - order assigned master
  - comment author
  - attachment uploader
  - payment recorder
  - document generator

---

## 6.2 Clients
The Clients module stores all workshop customers.

### Main entity: `clients`
Clients can be:
- `person`
- `company`

### Main fields
- `type`
- `full_name`
- `company_name`
- `phone`
- `phone_secondary`
- `email`
- `notes`
- `source`
- `created_by_user_id`
- timestamps
- soft delete

### Key behavior
- `displayName()` resolves the visible client name:
  - `company_name` for companies
  - `full_name` for persons

### Main relationships
- one client has many service orders
- one user may create many clients

---

## 6.3 Service Orders
This is the main operational module of the system.

### Main entity: `service_orders`
A service order is the aggregate root for workshop operations.

### Main fields
Identity and ownership:
- `order_number`
- `client_id`
- `accepted_by_user_id`
- `assigned_master_id`

Classification:
- `status`
- `priority`
- `category`

Device and intake:
- `item_name`
- `brand`
- `model`
- `serial_number`
- `reported_problem`
- `intake_condition`
- `accessories`
- `intake_checklist`
- `device_snapshot`

Repair result:
- `diagnostic_summary`
- `work_result`
- `internal_notes`
- `customer_notes`

Pricing:
- `estimated_price`
- `agreed_price`
- `final_price`
- `paid_amount`
- `balance_amount`

Timeline:
- `received_at`
- `promised_at`
- `approved_at`
- `ready_at`
- `delivered_at`
- `warranty_until`
- `cancelled_at`
- `cancellation_reason`

### Main relationships
A service order belongs to:
- one client
- one accepting user
- optionally one assigned master

A service order has many:
- status history rows
- items
- payments
- comments
- attachments
- generated documents

### Domain behavior
The order model implements:
- `canTransitionTo(ServiceOrderStatus $to)`
- `isEditable()`

That means status transitions are explicit and not fully free-form.

---

## 6.4 Documents
The project started with a minimal generated-documents concept and evolved into a fuller documents subsystem.

### Current documented baseline
Documents are generated from service orders and business settings.

Document generation includes:
- invoice
- intake act
- completion act

### Supporting settings
- business profile
- bank account
- document settings
- document counters
- generated document records

### Main document services
- `DocumentNumberGenerator`
- `DocumentSnapshotBuilder`
- `DocumentHtmlRenderer`
- `DocumentPdfRenderer`

### Main idea
A document is not manually edited. It is generated from:
- service order state
- client data
- pricing/items/payments
- business profile
- selected/default bank account
- document settings and numbering rules

---

## 6.5 Settings
Settings are split from operations because they change rarely and affect many outputs.

### Main entities
- `business_profiles`
- `bank_accounts`
- `document_settings`

### Purpose
- legal/business identity
- default locale fallback
- payment requisites
- document prefixes and footer/terms text

---

## 6.6 Activity
The Activity module provides a generic activity log.

### Main entity
- `activity_logs`

### Purpose
- entity-level audit entries
- action tracking
- old/new value diffs
- contextual metadata

This module is especially useful as the CRM becomes more operationally strict.

---

## 7. Database Model

The current documented schema is best understood as two layers:

1. **operational core**
2. **settings and documents layer**

---

## 7.1 Operational Core Tables

### `users`
Extends default Laravel users.

Important CRM fields:
- `role`
- `phone`
- `is_active`
- `preferred_locale`

### `clients`
Stores workshop customers.

### `service_orders`
Central aggregate for workshop work.

### `service_order_status_history`
Stores the immutable status transition timeline.

### `service_order_items`
Stores line items for work and parts.

### `payments`
Stores money inflow/outflow records tied to a service order.

### `service_order_comments`
Stores textual operator/customer-visible notes.

### `service_order_attachments`
Stores uploaded images and files.

### `generated_documents`
Stores generated document records. In the richer documented baseline this table is extended with snapshot-oriented metadata and HTML/PDF paths.

### `activity_logs`
Generic audit/event table.

---

## 7.2 Settings and Extended Documents Tables

### `business_profiles`
Stores the active business identity used in generated documents and as UI locale fallback.

Main fields:
- legal/business identity
- tax data
- addresses
- signer name/title
- default locale

### `bank_accounts`
Stores one or more workshop payment accounts.

Main fields:
- recipient
- IBAN
- bank name
- bank MFO
- bank EDRPOU
- currency
- payment purpose template
- default/active flags

### `document_settings`
Stores document behavior and template text defaults.

Main fields:
- document locale
- invoice / intake / completion prefixes
- numbering format
- footer texts and terms

### `document_counters`
Stores per-type numbering sequences by year.

### extended `generated_documents`
Stores:
- `service_order_id`
- `business_profile_id`
- `bank_account_id`
- `document_type`
- `document_number`
- `document_date`
- `locale`
- `status`
- `snapshot_json`
- html/pdf disk/path
- issued/voided audit fields

---

## 8. Entity Relationships

Below is the practical relationship map.

```text
User
├── hasMany Clients (created_by_user_id)
├── hasMany ServiceOrders (accepted_by_user_id)
├── hasMany ServiceOrders (assigned_master_id)
├── hasMany ServiceOrderComments
├── hasMany ServiceOrderAttachments
├── hasMany Payments
└── hasMany GeneratedDocuments

Client
└── hasMany ServiceOrders

ServiceOrder
├── belongsTo Client
├── belongsTo User (acceptedBy)
├── belongsTo User (assignedMaster)
├── hasMany ServiceOrderStatusHistory
├── hasMany ServiceOrderItems
├── hasMany Payments
├── hasMany ServiceOrderComments
├── hasMany ServiceOrderAttachments
└── hasMany GeneratedDocuments

ServiceOrderStatusHistory
├── belongsTo ServiceOrder
└── belongsTo User (changedBy)

ServiceOrderItem
├── belongsTo ServiceOrder
└── belongsTo User (createdBy)

Payment
├── belongsTo ServiceOrder
└── belongsTo User (createdBy)

ServiceOrderComment
├── belongsTo ServiceOrder
└── belongsTo User

ServiceOrderAttachment
├── belongsTo ServiceOrder
└── belongsTo User (uploadedBy)

BusinessProfile
├── hasMany BankAccounts
├── hasOne DocumentSetting
└── hasMany GeneratedDocuments

BankAccount
└── belongsTo BusinessProfile

DocumentSetting
└── belongsTo BusinessProfile

DocumentCounter
└── belongsTo BusinessProfile

GeneratedDocument
├── belongsTo ServiceOrder
├── belongsTo BusinessProfile
├── belongsTo BankAccount
├── belongsTo User (issuedBy / generatedBy)
└── optionally belongsTo User (voidedBy)

ActivityLog
└── optionally belongsTo User
```

---

## 9. Database Relationship Notes

### Client deletion semantics
Clients use soft deletes. This is important because workshop history must usually remain preserved even when a client record is no longer operationally active.

### Service order lifecycle ownership
Every order has:
- one intake/accepting user
- optionally one assigned master

This separation lets reception/manager roles differ from repair-execution roles.

### Item and payment recalculation
`ServiceOrder` stores denormalized totals:
- `final_price`
- `paid_amount`
- `balance_amount`

These are recalculated by application actions, not manually trusted from UI input.

### Attachments
Attachments are metadata rows plus filesystem objects. The database stores:
- path
- disk
- mime
- size
- checksum
- type
- primary flag
- optional `taken_at`

### Generated documents
The richer document subsystem stores **snapshots** to freeze business, client, and order data at generation time. This prevents historical documents from changing when source entities are later edited.

---

## 10. Enumerations and Controlled Values

The project relies heavily on enums to prevent free-form string drift.

### Shared
- `SupportedLocale`: `en`, `ru`, `uk`

### Users
- `UserRole`: `admin`, `manager`, `master`

### Clients
- `ClientType`: `person`, `company`

### Service Orders
- `ServiceOrderStatus`
  - `new`
  - `diagnostics`
  - `awaiting_approval`
  - `approved`
  - `in_progress`
  - `waiting_parts`
  - `ready`
  - `delivered`
  - `cancelled`

- `ServiceOrderPriority`
  - `low`
  - `normal`
  - `high`
  - `urgent`

- `ServiceOrderCategory`
  - `computer`
  - `laptop`
  - `printer`
  - `mfp`
  - `cartridge`
  - `monitor`
  - `network`
  - `other`

- `ServiceOrderItemType`
  - `work`
  - `part`

- `PaymentType`
  - `payment`
  - `refund`

- `PaymentMethod`
  - `cash`
  - `card`
  - `bank_transfer`
  - `other`

- `CommentVisibility`
  - `internal`
  - `public`

- `AttachmentType`
  - `intake_photo`
  - `damage_photo`
  - `serial_photo`
  - `diagnostic_photo`
  - `repair_photo`
  - `final_photo`
  - `document`
  - `receipt`
  - `warranty`
  - `other`

### Documents
Depending on baseline version, document type values evolved from simple generic types to richer operational types. In the current documented direction the meaningful operator-facing types are:
- invoice
- intake act
- completion act
- warranty card
- diagnostic act

---

## 11. Status Workflow

The service order status machine is explicit.

### Allowed transitions
- `new` -> `diagnostics`, `cancelled`
- `diagnostics` -> `awaiting_approval`, `in_progress`, `cancelled`
- `awaiting_approval` -> `approved`, `cancelled`
- `approved` -> `in_progress`, `waiting_parts`, `cancelled`
- `in_progress` -> `waiting_parts`, `ready`, `cancelled`
- `waiting_parts` -> `in_progress`, `ready`, `cancelled`
- `ready` -> `delivered`
- `delivered` -> no further transitions
- `cancelled` -> no further transitions

### Why this matters
This design prevents invalid workshop states such as:
- delivered before ready
- ready before work started
- approval flow being skipped unintentionally in cases that require it

All transitions are captured in `service_order_status_history`.

---

## 12. Request / Use-Case Flow

A typical backend use case follows this pattern:

1. route resolves to a controller
2. request object validates payload
3. controller delegates to an application action
4. action updates models / logs side effects
5. resource class formats response

### Example: record payment
- `POST /service-orders/{serviceOrder}/payments`
- `StorePaymentRequest`
- `RecordPaymentAction`
- `RecalculateServiceOrderTotalsAction`
- `PaymentResource`

### Example: change order status
- `POST /service-orders/{serviceOrder}/status`
- `ChangeServiceOrderStatusRequest`
- `ChangeServiceOrderStatusAction`
- status history row created
- date fields like `approved_at`, `ready_at`, `delivered_at`, or `cancelled_at` may be affected

---

## 13. API Surface

The documented route baseline includes these operational endpoints:

### Auth / session
- `GET /login`
- `POST /login`
- `POST /logout`
- `GET /me`

### Clients
- `GET /clients`
- `POST /clients`
- `GET /clients/{client}`

### Service Orders
- `GET /service-orders`
- `POST /service-orders`
- `GET /service-orders/{serviceOrder}`

### Nested service order operations
- `POST /service-orders/{serviceOrder}/status`
- `POST /service-orders/{serviceOrder}/items`
- `POST /service-orders/{serviceOrder}/payments`
- `POST /service-orders/{serviceOrder}/comments`
- `POST /service-orders/{serviceOrder}/attachments`

The frontend/back-office uses separate app routes such as:

- `/app/dashboard`
- `/app/profile`
- `/app/clients`
- `/app/service-orders`
- `/app/service-orders/{serviceOrder}`
- `/app/service-orders/{serviceOrder}/documents`
- `/app/settings/business`
- `/app/settings/bank-accounts`
- `/app/settings/documents`

---

## 14. Frontend / Livewire UI

The back-office UI is Livewire-driven and route-based.

### Main Livewire areas
- `DashboardStats`
- `ClientIndex`
- `ClientForm`
- `OrderIndex`
- `OrderShow`
- service-order subcomponents:
  - status changer
  - item list / item form
  - payment list / payment form
  - comment list / comment form
  - attachment gallery / upload
  - status history timeline
  - documents panel
- settings components:
  - business profile
  - bank account
  - document preferences
- profile settings form

### UI composition idea
The order details page is not one giant procedural view. It is assembled from focused Livewire units. This makes the page easier to evolve independently by concern.

---

## 15. Documents Architecture

The documents subsystem is built as a projection layer on top of workshop operations.

### Inputs
- service order
- client
- items
- payments
- business profile
- selected/default bank account
- document settings
- locale

### Outputs
- HTML representation
- optional PDF
- generated document record
- immutable snapshot payload

### Current operator-facing documents
- invoice
- intake act
- completion act

### Why snapshot-based generation matters
Documents are business evidence. If the client name, bank account, or order totals change later, old issued documents must still reflect the values that were valid when they were created.

That is why `snapshot_json` is a critical design decision.

---

## 16. Localization Strategy

Localization is not bolted on as a late UI trick. It is modeled explicitly.

### UI locale
Stored in:
- `users.preferred_locale`

### System fallback locale
Stored in:
- `business_profiles.default_locale`

### Document locale
Stored separately in:
- `document_settings.document_locale`

### Locale resolution order
1. authenticated user preferred locale
2. active business profile default locale
3. `config('app.locale')`

### Supported UI languages
- English
- Russian
- Ukrainian

This separation allows a practical workshop scenario:
- UI for operator in Russian
- generated business documents in Ukrainian

---

## 17. Validation and Resources

The project uses dedicated form request classes for input validation and dedicated resource classes for API shaping.

### Examples
- `StoreClientRequest`
- `StoreServiceOrderRequest`
- `ChangeServiceOrderStatusRequest`
- `StoreServiceOrderItemRequest`
- `StorePaymentRequest`
- `StoreServiceOrderCommentRequest`
- `StoreServiceOrderAttachmentRequest`

### JSON resources
- `ClientResource`
- `ServiceOrderListResource`
- `ServiceOrderDetailResource`
- `ServiceOrderItemResource`
- `PaymentResource`
- `ServiceOrderCommentResource`
- `ServiceOrderAttachmentResource`
- `ServiceOrderStatusHistoryResource`

This avoids leaking raw model structure directly to the frontend.

---

## 18. Storage Strategy

### Attachments
Stored on filesystem with metadata persisted in `service_order_attachments`.

### Generated documents
Stored as HTML and optionally PDF, with paths persisted in `generated_documents`.

### Why filesystem + DB
This split is practical:
- large binary files stay out of database rows
- metadata remains queryable
- records can still be listed, filtered, and audited

---

## 19. Testing Strategy

The project uses **Pest** for automated tests.

The documented test baseline covers:
- authentication
- `/me` endpoint
- client creation and listing
- service order creation
- status transition
- adding items
- recording payments
- adding comments

This is enough to protect the main business workflow while the product is still evolving rapidly.

Recommended future test expansion:
- attachment upload validation
- document generation
- locale persistence
- role-based authorization
- activity log assertions

---

## 20. Seed Data and Local Bootstrap

### Existing seeders
- `AdminUserSeeder`
- `DemoDataSeeder`
- `WorkshopBusinessSettingsSeeder` (when settings/documents overlay is applied)

### Typical bootstrap flow
```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
npm run build
php artisan serve
```

For development:
```bash
npm run dev
php artisan serve
```

For tests:
```bash
php artisan test
```

---

## 21. Design Decisions Worth Noting

### Modular monolith over microservices
Chosen because the domain is cohesive and deployment simplicity matters more than independent service scaling.

### Eloquent models in infrastructure
The project treats Eloquent as persistence infrastructure rather than core domain.

### Explicit actions over fat controllers
Use cases live in application actions, keeping controllers slim and predictable.

### Enums over free strings
This keeps status, role, locale, type, method, and visibility values controlled and consistent.

### Denormalized order totals
`final_price`, `paid_amount`, and `balance_amount` are stored on the order for fast reads and UI simplicity, but recalculated by application logic.

### Snapshot-based documents
Critical for business correctness and document immutability.

---

## 22. Current Known Boundaries

The project is intentionally optimized for:
- small to medium workshop teams
- a single workshop or tightly coupled operation
- one primary business entity / profile
- low operational overhead

This is not yet intended as:
- a public multi-tenant SaaS
- a marketplace platform
- a highly distributed service architecture
- a generalized ERP

---

## 23. Suggested Future Extensions

Logical next steps for the system:

- role-based authorization policies beyond enum-only role checks
- device inventory / stock / spare parts warehouse
- customer notifications
- calendar / promised date planning
- richer financial reporting
- printable intake checklist templates
- warranty claim flows
- branch / multi-location support
- invoice numbering rules per legal entity
- stronger audit trail and compliance features

---

## 24. Summary

Repair CRM is a structured, production-oriented Laravel workshop system built as a modular monolith. The center of the model is the **service order aggregate**, connected to clients, users, line items, payments, comments, attachments, documents, and status history. Surrounding this operational core are supporting modules for settings, localization, documents, and audit logging.

The architecture deliberately balances:
- practical delivery speed
- low infrastructure complexity
- clean module boundaries
- explicit business workflow modeling
- long-term maintainability

If you are extending the project, keep the following rule in mind:

> treat the service order as the operational aggregate root, and treat settings/documents/localization as supporting bounded modules around it.
