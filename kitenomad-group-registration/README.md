# KiteNomad Group Registration — WordPress Plugin

## What This Plugin Does

1. **Organiser submits the main form** — fills in personal details + pastes/enters group members' email addresses
2. **Each group member gets a unique email** with their own personal registration link (e.g. `/kn-member-register/abc123def456/`)
3. **Members click their link** and complete their own registration details
4. **Admin sees everything grouped** — expandable rows showing the organiser + all group members, their status, and registration details
5. **CSV export** for reporting

---

## Plugin Structure

```
kitenomad-group-registration/
├── kitenomad-group-registration.php   ← Main plugin file
└── assets/
    ├── kn-styles.css    ← Frontend form styles
    ├── kn-scripts.js    ← Frontend JS (dynamic member rows)
    └── kn-admin.css     ← Admin dashboard styles
```

---

## Installation

1. Copy the entire `kitenomad-group-registration` folder to `/wp-content/plugins/`
2. Go to **WordPress Admin → Plugins** and activate **KiteNomad Group Registration**
3. The plugin will automatically create two database tables:
   - `wp_kn_groups` — one row per organiser
   - `wp_kn_group_members` — one row per invited member

---

## Setup

### Step 1 — Create the Group Registration Page
- Create a new WordPress page (e.g. "Group Registration")
- Add this shortcode to the page content:
  ```
  [kn_registration_form]
  ```

### Step 2 — Create the Member Registration Page
- Create another page (e.g. "Member Registration")
- Add this shortcode:
  ```
  [kn_member_registration]
  ```
- Member links auto-route to this page via `/kn-member-register/TOKEN/`
- If this page is not found, the plugin renders the form directly

### Step 3 — Flush Rewrite Rules
After creating pages, go to **Settings → Permalinks** and click **Save Changes** (this refreshes WordPress routing)

---

## How the Unique Link System Works

| Step | What Happens |
|------|-------------|
| 1 | Organiser fills main form with their details + member emails |
| 2 | Plugin generates a unique `group_token` (32-char hex) for the group |
| 3 | For each member email, a unique `member_token` is generated |
| 4 | Member is saved to DB with status = `invited` |
| 5 | Invite email sent to member: `yoursite.com/kn-member-register/{member_token}/` |
| 6 | Member opens link, sees their email pre-filled, completes form |
| 7 | Member status updates to `registered` in DB |
| 8 | Admin can see organiser + all members grouped in the admin panel |

---

## Admin Dashboard

Go to **KN Groups** in the WordPress admin sidebar.

Features:
- **Stats bar** — total groups, confirmed, total members, registered members
- **Search** by organiser name or email
- **Filter** by status (pending / confirmed / completed / cancelled)
- **Expandable rows** — click ▶ on any group to see all member details
- **Status updates** — change group status inline
- **Copy member link** — button to copy unique registration URL
- **CSV Export** — download all data as spreadsheet

---

## Shortcodes Reference

### `[kn_registration_form]`
Main organiser form. No attributes needed.

### `[kn_member_registration]`
Member form. Token is read from the URL automatically. For static testing:
```
yoursite.com/member-registration/?token=abc123...
```

---

## Email Customisation

Emails are built inside `kn_get_email_template()` in the main plugin file. Edit the HTML in that function to match your branding.

To change the invite email subject line:
- Go to **KN Groups → Settings** in the admin

---

## Database Tables

### `wp_kn_groups`
| Column | Type | Description |
|--------|------|-------------|
| id | BIGINT | Auto-increment primary key |
| group_token | VARCHAR(64) | Unique identifier for the group |
| first_name | VARCHAR(100) | Organiser's first name |
| last_name | VARCHAR(100) | Organiser's last name |
| email | VARCHAR(200) | Organiser's email |
| phone | VARCHAR(50) | Organiser's phone |
| experience | VARCHAR(100) | Experience level |
| session_date | DATE | Preferred session date |
| message | TEXT | Additional notes |
| status | VARCHAR(30) | pending / confirmed / completed / cancelled |
| created_at | DATETIME | When group was registered |

### `wp_kn_group_members`
| Column | Type | Description |
|--------|------|-------------|
| id | BIGINT | Auto-increment primary key |
| group_id | BIGINT | FK → wp_kn_groups.id |
| member_token | VARCHAR(64) | Unique token for this member's link |
| email | VARCHAR(200) | Member's email (pre-filled from organiser) |
| first_name | VARCHAR(100) | Filled by member on their form |
| last_name | VARCHAR(100) | Filled by member on their form |
| phone | VARCHAR(50) | Filled by member on their form |
| experience | VARCHAR(100) | Filled by member on their form |
| status | VARCHAR(30) | invited / registered |
| invited_at | DATETIME | When invite was sent |
| registered_at | DATETIME | When member completed their form |

---

## Extending / Customisation

**Adding fields to the organiser form:**
1. Add the HTML field in `kn_registration_form_shortcode()` 
2. Add the column to `wp_kn_groups` in `kn_create_tables()`
3. Add the `sanitize_*` + `$wpdb->insert()` line

**Adding fields to the member form:**
1. Same pattern in `kn_member_registration_shortcode()`
2. Add column to `wp_kn_group_members`

**Custom email templates:**
Edit `kn_get_email_template()` — it returns HTML strings for `invite`, `organiser_confirm`, and `member_confirm`

---

## Troubleshooting

**Member links return 404:**
→ Go to Settings → Permalinks → Save Changes (flushes rewrite rules)

**Emails not sending:**
→ Install the WP Mail SMTP plugin and configure your SMTP provider

**Tables not created:**
→ Deactivate and reactivate the plugin, or check MySQL user permissions

---

## Requirements
- WordPress 5.8+
- PHP 7.4+
- MySQL 5.7+
