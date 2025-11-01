# 🧩 Posts Filter Dashboard (WordPress Plugin)

A simple WordPress admin dashboard plugin that demonstrates how to **apply filters via query parameters** (OOP version).  
It allows you to filter posts by **status** and **author ID** from a custom admin page.

---

## 🚀 Features

- Custom admin menu page: **Posts Filter Dashboard**
- Filter posts by **status** (All, Published, Draft, Pending)
- Filter posts by **author ID**
- Displays results in a clean admin table
- Secure input handling with sanitization
- Object-Oriented Programming (OOP) structure

## ⚙️ How It Works (Step-by-Step)

#### Security Check

The plugin first checks if WordPress is loaded using:
`if ( ! defined( 'ABSPATH' ) ) exit;`

#### Class Definition
A class named `Posts_Filter_Dashboard` wraps all plugin logic.

#### Constructor `(__construct)`
Automatically hooks the `add_admin_menu()` method to WordPress:

`add_action( 'admin_menu', [ $this, 'add_admin_menu' ] );`

#### Admin Menu Registration
Adds a new admin page titled Posts Filter Dashboard under the dashboard menu.

#### Render Admin Page `render_admin_page`
- Displays a form for filtering posts.
- Includes:
    - Hidden page input (keeps the current page active)
    - Dropdown to select post status
    - Author ID input
    - Filter button
