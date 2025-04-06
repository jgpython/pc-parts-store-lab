# 🖥️ PC Parts Store — Vulnerable Web Application Lab

## 📚 Overview
**PC Parts Store** is a full-featured, intentionally vulnerable PHP/MySQL-based eCommerce application built for cybersecurity testing, red team labs, and OWASP vulnerability demonstrations. This project simulates real-world web application flaws in a realistic UI.

![PHP](https://img.shields.io/badge/PHP-7.x-blue)
![MySQL](https://img.shields.io/badge/MySQL-5.x-lightgrey)
![Vulnerable-Lab](https://img.shields.io/badge/Security-Vulnerable-red)

---

## 🧪 Purpose
This lab provides hands-on experience with:
- Offensive web exploitation (SQLi, XSS, IDOR, CSRF, etc.)
- Secure coding awareness by contrast
- DAST/SAST tool testing (e.g. sqlmap, Burp Suite, OWASP ZAP)
- Red team labs and secure code analysis
- CTF-style exercises and simulated targets

---

## 📦 Project Structure

```
pc-parts-store/
├── admin/                 # Admin interface (no access control, IDOR, user deletion via GET)
│   ├── dashboard.php      # No role enforcement, fake stats (broken auth)
│   ├── orders.php         # Credit card data exposure, CSV injection
│   └── users.php          # Mass assignment, IDOR, account deletion via  │                            GET
│
├── api/                   # Insecure JSON API endpoints (unauthenticated)
│   ├── products.php       # SQL Injection, XSS in JSON output
│   ├── reviews.php        # Stored XSS, IDOR (spoofed user ID)
│   ├── checkout.php       # Raw credit card data via POST, no session
│   └── login.php          # Insecure JWTs, stored in localStorage
│
├── assets/
│   ├── css/               # Modular styling (clean UI, insecure inputs)
│
├── includes/              # Core PHP logic (intentionally insecure)
│   ├── db.php             # Hardcoded credentials, no prepared statements
│   ├── auth.php           # Plaintext password comparison
│   ├── utils.php          # Open redirect with $_GET['url']
│   ├── header.php         # Top nav
│   └── footer.php         # Footer scripts
│
├── index.php              # Homepage (reflected XSS, open redirect)
├── product.php            # Product details (IDOR, stored XSS)
├── products.php           # SQLi via ?search= or ?category=
├── cart.php               # LocalStorage cart, IDOR in removal
├── checkout.php           # Credit card form with no validation or auth
├── login.php              # SQL Injection, plaintext password
├── register.php           # Mass assignment, no validation
├── pc_part_store.sql      # MySQL DB dump (preloaded)
```


---

## ⚠️ Built-In Vulnerabilities (OWASP Reference)

| Type                 | Pages / Features                           | OWASP Category             |
|----------------------|--------------------------------------------|----------------------------|
| **SQL Injection**    | `products.php`, `login.php`, `api/products.php` | A1: Injection             |
| **Reflected XSS**    | `index.php (?msg=)`, `product.php`         | A7: Cross-Site Scripting   |
| **Stored XSS**       | Product reviews                            | A7: Cross-Site Scripting   |
| **Broken Auth**      | `login.php`, `auth.php`                    | A2: Broken Authentication  |
| **CSRF**             | `cart.php`, `checkout.php`                 | A5: Broken Access Control  |
| **Insecure JWT**     | `api/login.php`, `localStorage`            | A2: Broken Auth            |
| **IDOR**             | `product.php?id=`, `users.php?delete=`     | A5: Access Control         |
| **Plaintext PW**     | `auth.php`, `login.php`                    | A3: Sensitive Data Exposure|
| **Insecure Redirects** | `utils.php (redirect($_GET['url'])`)     | A10: Redirects             |
| **Security Misconfig** | `.htaccess`, `php.ini`                   | A6: Misconfiguration       |

---

## 🔧 Setup Instructions


### 🖥️ Requirements
- PHP 7.x/8.x  
- MariaDB / MySQL  
- Apache2 or Nginx  
- `sqlmap`, `curl` (optional for testing)


### 📥 Clone the Project
```bash
git clone https://github.com/YOURNAME/pc-parts-store.git
cd pc-parts-store
```

### 🗃️ Import the Database

`mysql -u root -p < pc_part_store.sql`

This will create the `pc_part_store` database with all users, products, reviews, and orders.

### 🌐 Serve the App

Copy or link the project to your web root (e.g., `/var/www/html/`):

`sudo cp -r pc-parts-store /var/www/html/`

Then start/restart Apache & MySQL:

`sudo systemctl restart apache2 sudo systemctl restart mysql`

Access the site in your browser at:

`http://localhost/pc-parts-store/`

---


## 🧪 Built-in Test Users

This project includes a pre-seeded user table with **realistic accounts** for testing login flows, role-based access, and authentication bypass techniques (e.g. SQLi). All credentials are **plaintext** and designed for demo or red-team testing only.


|Username|Password|Role|Description|
|---|---|---|---|
|`admin`|`admin123`|admin|Default superuser account for admin access. Vulnerable to SQLi login bypass.|
|`john_doe`|`password1`|user|Normal user, used in reviews and orders.|
|`test_user`|`qwerty`|user|Generic account for basic testing.|
|`jane_doe`|`pass123`|user|Additional user to test IDOR and user visibility.|
|`gamerz`|`abc123`|user|Simulates gaming enthusiast purchases.|
|`hwtester`|`testtest`|user|Good for testing edge-case reviews or feedback loops.|
|`exploit_dev`|`exploitme`|admin|“Backdoor” admin account for red team testing.|
|`rootkitz`|`root123`|user|Useful for account enumeration or brute-force scenarios.|
|`xssqueen`|`s3cure!`|user|Submit stored XSS reviews using this account.|
|`sqlinjector`|`dropdb`|user|Ideal for blind/time-based injection testing.|

---


### 🔐 Features Each Role Has Access To:

|Feature|`user` Role|`admin` Role|
|---|---|---|
|Browse Products|✅|✅|
|Add Reviews|✅|✅|
|Submit Orders|✅|✅|
|View Cart|✅|✅|
|Admin Dashboard (`admin/`)|❌|✅|
|Delete Users / Orders|❌|✅|
|View All Orders|❌|✅|
|Access APIs|✅ (unauthenticated)|✅ (with POST, more data)|

---


### 🎯 Recommended Tests Using These Accounts

- Try logging in as `admin' --` for SQL Injection bypass
    
- Submit reviews as `xssqueen` using `<script>alert(1)</script>` for **stored XSS**
    
- Use `exploit_dev` to delete users/orders from the exposed admin panel
    
- Purchase products with `john_doe` and verify orders insert into `orders` table

---


## 🚀 Suggested Testing Scenarios

Explore the core vulnerabilities intentionally built into this application. These scenarios are great for CTFs, red team exercises, or educational penetration testing labs.


|🔍 **Test**|🧪 **How to Perform**|⚠️ **What It Reveals**|
|---|---|---|
|**SQL Injection**|Use `products.php?search=anything'--` directly in the browser, or run:  <br>`sqlmap -u "http://localhost/pc-parts-store/products.php?search=test" --batch --level=5 --risk=3`|Confirms improper sanitization of user input, leading to SQL execution. Exploitable on `products.php`, `login.php`, and parts of `admin/`.|
|**Reflected XSS**|Visit:  <br>`index.php?msg=<script>alert(1)</script>`|Demonstrates lack of output encoding on reflected data (e.g. error messages or status).|
|**Stored XSS**|Submit a product review (e.g., `product.php?id=1`) with:  <br>`<script>alert(1)</script>`|Proves that review inputs are stored and rendered without sanitization, allowing persistent XSS payloads.|
|**IDOR (Insecure Direct Object Reference)**|Access:  <br>`product.php?id=9999` or `admin/users.php?delete=2` without auth|Showcases unrestricted access to resources or user manipulation without authorization checks.|
|**CSRF (Cross-Site Request Forgery)**|From another origin (e.g., attacker page), submit a request like:  <br>`GET cart.php?remove=1`|Highlights absence of CSRF tokens or validation, allowing unauthorized actions if user is authenticated.|
|**Insecure JWT / localStorage tokens**|Login and inspect browser localStorage for the `token` key|The token is a base64-encoded JSON blob, not signed or encrypted, allowing spoofing or tampering.|
|**Login Bypass via SQLi**|Use this payload in the **username** field:  <br>`admin' --`  <br>Password can be anything|Proves that the login query is injectable. This bypasses password checks and grants access.|
|**Plaintext Credential Exposure**|View `includes/db.php` or inspect network traffic|Demonstrates poor password storage and hardcoded DB credentials. No hashing or encryption used.|
|**Credit Card Data Capture (Raw)**|Visit `checkout.php`, fill in any values, inspect traffic|Reveals insecure transmission of sensitive data (e.g., credit cards) with no HTTPS enforcement or session validation.|

💡 **Tip:** Tools like **Burp Suite**, **sqlmap**, **Postman**, and browser dev tools (Storage tab, Console) are perfect for testing this site’s intentional flaws.

---


## 📁 Sample SQLMap Usage

Below are some example SQLMap commands to test the most vulnerable endpoints in the PC Parts Store project. These simulate automated exploitation of SQL injection flaws built intentionally into the application.

> ⚠️ These are **for educational/red team use only**. Make sure you're authorized to test the application before running any automated tools.

### 🔍 1. **Search Filter Injection (products.php)**


`sqlmap -u "http://localhost/pc-parts-store/products.php?search=test" --batch --risk=3 --level=5`

- **Why?** Tests the `search` parameter for injection.
    
- **Result:** Can enumerate tables, extract data, or dump the full database if successful.
    

---

### 🔎 2. **Product ID Injection (product.php)**


`sqlmap -u "http://localhost/pc-parts-store/product.php?id=1" --dbs --batch`

- **Why?** The `id` parameter is directly passed to the SQL query.
    
- **Result:** Lists databases and confirms injection in the product detail page.
    

---

### 🔐 3. **Login Form Injection (login.php)**


`sqlmap -u "http://localhost/pc-parts-store/login.php" --data="user=admin&pass=admin123" --batch`

- **Why?** Simulates SQL injection via POST data.
    
- **Result:** Confirms injectable login credentials check, useful for blind or boolean-based attacks.
    

---

🛠️ **Advanced Usage:**

- Dump table contents:
    
    `--dump -T users -D pc_part_store`
    
- Enumerate user credentials or hashes (if implemented):
    
    `--passwords`
    
- Bypass WAFs:
    
    `--tamper=space2comment,between`
    

---

## 🔐 Disclaimer

This project is intentionally vulnerable. **Do not expose it to the public internet**. Use only in isolated, safe, local, or containerized environments. The author and contributors are not responsible for misuse.

---
## 📜 License

MIT License — Use freely for educational, CTF, research, or red team purposes.

---

## 📎 Author

**jgpython**
Cybersecurity Researcher / Developer  
GitHub: [@jgpython](https://github.com/jgpython)
