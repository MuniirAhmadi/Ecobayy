### **EcoBay Secure Version Installation Guide**

#### **Prerequisites**
1. **XAMPP/WAMP** (Apache + MySQL + PHP)
2. **Git** (optional, for cloning)
3. **Web browser** (Chrome/Firefox recommended)

---

### **Setup Instructions**

1. **Download the Project**
   ```bash
   git clone https://github.com/MuniirAhmadi/ecobay-secure.git
   ```
   *or*  
   Download the ZIP and extract to `htdocs` (XAMPP).

2. **Database Setup**
   - Open `phpMyAdmin` (http://localhost/phpmyadmin)
   - Create a new database: `ecobay`
   - Import the SQL file:
     ```sql
     source ecobay-secure/ecobayy.sql
     ```

3. **Configure Connections**
   Edit `includes/config.php`:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_USER', 'root');      // Default XAMPP username
   define('DB_PASS', '');          // Default XAMPP password
   define('DB_NAME', 'ecobay');
   ```

4. **Launch the Application**
   - Start Apache and MySQL in XAMPP
   - Access in browser:
     ```
     http://localhost/ecobay-secure
     ```

---

### **First-Time Use**
1. **Register** as a new user or log in with test credentials:
   ```
   Admin: 
   Username or Email: Admin@ecobay.com / Admin
   Password: Admin
   
   User: 
   Username or Email: Ahmad@ecobay.com / Ahmad
   Password: Ahmad
   ```
2. **Submit recyclables** via "Sell Waste" (images auto-save to `uploads/`).
3. **Admin tasks**: Approve/reject items in `/admin/dashboard.php`.

---
