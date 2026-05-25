# 🪁 KiteNomad Group Registration

A production-ready WordPress plugin built from scratch for **KiteNomad Experience** — a wind sports booking platform. Features a complete token-based group invitation system, custom database architecture, HTML email automation, Google Sheets API integration, multilingual support, and a full admin dashboard.

> Built without any third-party form plugins (no Gravity Forms, no WooCommerce, no ACF).

---

## Screenshots

| Group Registration Form | Member Invitation Email | Admin Dashboard |
|------------------------|------------------------|-----------------|
| Organiser fills form + adds member emails | Each member gets a unique link | Expandable groups with full member data |

---

##  Features

###  Registration System
- Group organiser registration form with server-side validation
- Dynamic group member email input (add/remove rows with JavaScript)
- Unique 32-character hex token generated per member using `bin2hex(random_bytes(16))`
- POST → Redirect → GET pattern prevents blank pages and back-button resubmission
- "Already Registered" block shown on any future visit to a completed link
- All fields required with inline error messages and sticky values on validation failure

###  Email Automation
- Branded HTML invite emails sent to each group member with their unique link
- Organiser confirmation email with group reference code
- Member registration confirmation email
- Admin notification emails for both organiser and member registrations
- Custom notification email configurable via Settings page (supports multiple comma-separated emails)

###  Database Architecture
- Two custom MySQL tables: `wp_kn_groups` and `wp_kn_group_members`
- Automatic schema migration using `ALTER TABLE` — safely adds new columns to existing tables without data loss
- One-to-many relationship between groups and members
- Full CRUD operations through WordPress admin

###  Admin Dashboard
- Stats bar showing total groups, confirmed, members invited, registered, and awaiting
- Expandable group rows showing organiser + all member details in one view
- Bulk delete (selected groups or all at once with confirmation)
- Per-group status management (pending / confirmed / completed / cancelled)
- Resend invite emails to pending members directly from admin
- Copy unique registration link button per member
- CSV export of all data including all extra fields
- Diagnostics page for debugging database, credentials, and connection issues

###  Google Sheets Integration
- Direct Google Sheets API v4 connection — no third-party services (no Zapier, no Make.com)
- JWT (JSON Web Token) authentication using Google Service Account
- Access token cached in WordPress transients for 50 minutes (tokens expire after 60 min)
- Auto-appends a row to the sheet on every organiser and member registration
- Silent failure — if Google Sheets is unavailable, registrations still save to WordPress DB
- Built-in connection test page showing each authentication step with ✅/❌ status

###  Multilingual Support (Polylang)
- Full label translation for English, French, and Hebrew
- Single `kn__($key)` helper function handles all translations
- Auto-detects current page language via `pll_current_language()`
- Graceful fallback chain: requested language → English → key name
- Adding a new language requires only adding one array block — no other code changes

###  Form Fields
**Registration Details:**
- First Name, Last Name (required)
- Email Address (required)
- Phone Number with country code dropdown (50+ countries, pure PHP — no external library)
- Kite Experience Level (Beginner / Intermediate / Advanced)
- Preferred Session Date
- Additional Notes

**Kiting Profile:**
- Age
- Years Kiting (Under 1 Year / 1–2 / 3–5 / 5+)
- Already Jumping? (Yes/No radio)
- Self-Rescue Knowledge? (Yes/No radio)
- Bringing Your Own Gear? (Own kit / Needs gear / Partial)
- Accommodation Needed? (Yes/No radio)

###  Security
- WordPress nonces on all forms (`wp_nonce_field` / `wp_verify_nonce`)
- All input sanitized before processing (`sanitize_text_field`, `sanitize_email`, etc.)
- All output escaped before display (`esc_html`, `esc_attr`, `esc_url`)
- All database queries use `$wpdb->prepare()` — no raw SQL with user input
- reCAPTCHA v2 support on both forms

---

##  Technical Architecture

```
User submits form
      ↓
WordPress init hook processes form (before any output)
      ↓
Server-side validation (all fields required)
      ↓
Save to wp_kn_groups (WordPress DB — permanent)
      ↓
Generate unique token per member → save to wp_kn_group_members
      ↓
Send invite emails (wp_mail)
      ↓
Send admin notification emails
      ↓
Append row to Google Sheets (async, silent fail)
      ↓
POST → wp_safe_redirect → GET (success page)
```

### Database Schema

**`wp_kn_groups`**
| Column | Type | Description |
|--------|------|-------------|
| id | BIGINT | Auto-increment primary key |
| group_token | VARCHAR(64) | Unique group identifier |
| first_name, last_name | VARCHAR(100) | Organiser name |
| email | VARCHAR(200) | Organiser email |
| phone | VARCHAR(50) | Phone with country code |
| experience | VARCHAR(100) | Kite experience level |
| age | VARCHAR(10) | Organiser age |
| years_kiting | VARCHAR(20) | Years of experience |
| already_jumping | VARCHAR(3) | Yes/No |
| self_rescue | VARCHAR(3) | Yes/No |
| bringing_gear | VARCHAR(20) | Gear status |
| accommodation | VARCHAR(3) | Yes/No |
| session_date | DATE | Preferred session date |
| message | TEXT | Additional notes |
| status | VARCHAR(30) | pending/confirmed/completed/cancelled |
| created_at | DATETIME | Registration timestamp |

**`wp_kn_group_members`**
| Column | Type | Description |
|--------|------|-------------|
| id | BIGINT | Auto-increment primary key |
| group_id | BIGINT | Foreign key → wp_kn_groups.id |
| member_token | VARCHAR(64) | Unique token for registration link |
| email | VARCHAR(200) | Member email (set by organiser) |
| first_name, last_name | VARCHAR(100) | Filled by member |
| phone | VARCHAR(50) | Filled by member |
| experience, age, years_kiting | VARCHAR | Filled by member |
| already_jumping, self_rescue | VARCHAR(3) | Yes/No |
| bringing_gear | VARCHAR(20) | Gear status |
| accommodation | VARCHAR(3) | Yes/No |
| status | VARCHAR(30) | invited / registered |
| invited_at | DATETIME | When invite was sent |
| registered_at | DATETIME | When member completed form |

---

##  Installation

1. Download or clone this repository
2. Upload the `kitenomad-group-registration` folder to `/wp-content/plugins/`
3. Activate via **WordPress Admin → Plugins**
4. The plugin automatically creates the required database tables on activation

### Page Setup
Create two WordPress pages and add the shortcodes:

| Page | Shortcode |
|------|-----------|
| Group Registration | `[kn_registration_form]` |
| Member Registration | `[kn_member_registration]` |

---

## ⚙️ Configuration

### Basic Settings
Go to **KN Groups → Settings** to configure:
- **Invite Email Subject** — customize the subject line of invite emails
- **Notification Email(s)** — additional emails to receive registration notifications (comma-separated)

### Google Sheets Integration
1. Create a project at [console.cloud.google.com](https://console.cloud.google.com)
2. Enable the **Google Sheets API**
3. Create a **Service Account** and download the JSON credentials file
4. Share your Google Sheet with the service account email (Editor access)
5. Add to your plugin file:
```php
define( 'KN_SHEET_ID',      'your-sheet-id-from-url' );
define( 'KN_SERVICE_EMAIL', 'your-service@project.iam.gserviceaccount.com' );
define( 'KN_PRIVATE_KEY',   "-----BEGIN PRIVATE KEY-----\n...\n-----END PRIVATE KEY-----\n" );
```
6. Go to **KN Groups → Sheets Test** to verify the connection

### Multilingual (Polylang)
The plugin auto-detects the page language via Polylang. Supported languages out of the box:
- 🇬🇧 English (`en`)
- 🇫🇷 French (`fr`)
- 🇮🇱 Hebrew (`he`)

To add a new language, add a new array block in the `kn__()` function with the 2-letter language code.

---

##  File Structure

```
kitenomad-group-registration/
├── kitenomad-group-registration.php   ← Main plugin file (1600+ lines)
├── README.md
└── assets/
    ├── kn-styles.css     ← Frontend form styles
    ├── kn-admin.css      ← Admin dashboard styles
    └── kn-scripts.js     ← Frontend JavaScript (member rows, form submit)
```

---

##  Shortcodes

| Shortcode | Description |
|-----------|-------------|
| `[kn_registration_form]` | Main organiser registration form |
| `[kn_member_registration]` | Member form — reads `?kn_token=` from URL |

---

## 📐 Key Concepts Used

| Concept | Implementation |
|---------|---------------|
| WordPress Hooks | `add_action('init')`, `add_action('admin_menu')`, `add_shortcode()` |
| Custom DB Tables | `dbDelta()` for creation, `ALTER TABLE` for migrations |
| Security | Nonces, sanitization, escaping, `$wpdb->prepare()` |
| Token System | `bin2hex(random_bytes(16))` — cryptographically secure |
| POST→Redirect→GET | `wp_safe_redirect()` after form processing |
| JWT Auth | Manual JWT construction for Google OAuth 2.0 |
| Transient Caching | `set_transient()` for Google access tokens |
| Multilingual | Custom `kn__()` helper with Polylang detection |
| Defensive Programming | `function_exists()`, null coalescing `??`, silent API failures |

---

##  Scaling Considerations

| Group Size | Recommendation |
|-----------|----------------|
| Up to 20 members | Plugin works as-is |
| 20–100 members | Add Action Scheduler for background email sending |
| 100–500 members | Add AJAX pagination to admin panel |
| 500+ members | VPS/dedicated server + Amazon SES for email |

---

##  Email Flow

```
Organiser submits form
    ├── Organiser receives: "Registration Confirmed" email
    ├── Admin receives: "New Group Registration" email  
    └── Each member receives: "You've been invited" email
              ↓
    Member clicks unique link → fills form → submits
              ↓
    Member receives: "Registration Complete" email
    Admin receives: "New Member Registered" email
```

---

##  Requirements

- WordPress 5.8+
- PHP 7.4+ (PHP 8.0+ recommended)
- MySQL 5.7+
- OpenSSL extension (for Google Sheets JWT)
- WP Mail SMTP (recommended for reliable email delivery)

---

##  License

MIT License — free to use, modify, and distribute.

---

##  Author

Built by **Ammar Aziz**

- Portfolio project demonstrating custom WordPress plugin development
- No page builders, no form plugins, no shortcuts — pure PHP, MySQL, and WordPress APIs

---

##  Acknowledgements

- [WordPress Plugin Developer Handbook](https://developer.wordpress.org/plugins/)
- [Google Sheets API v4 Documentation](https://developers.google.com/sheets/api)
- [Polylang Documentation](https://polylang.pro/doc/)
