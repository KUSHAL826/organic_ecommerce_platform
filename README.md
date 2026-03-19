TITLE:ORGANIC FOODS E-COMMERCE PLATFORM

1)PROJECT OVERVIEW:
The Organic Foods E-Commerce Platform is a web-based application that allows users to browse, purchase, and manage organic food products online. The system connects customers directly with farmers or vendors, ensuring access to fresh, chemical-free products while providing a smooth and secure shopping experience.

2)OBJECTIVES
->To promote organic and healthy food consumption
->To create a direct connection between farmers and customers
->To provide an easy-to-use online shopping system
->To manage products, users, and orders efficiently

3)USERS OF THE SYSTEM

i. Customer
Register and login
Browse products
Add products to cart
Place orders
Track orders

ii. Admin
Login securely
Add, update, and delete products
View all orders
Manage users
Update order status

4)TECHNOLOGIES USED
->Frontend: HTML, CSS
->Backend: PHP
->Database: MySQL
->Server: Apache (XAMPP or LAMP)

5)SYSTEM WORKFLOW
i. User Registration
The user enters details such as name, email, and password.
These details are stored in the database and a new account is created.

ii. User Login
The user enters login credentials.
The system verifies the details from the database.
If valid, a session is created and the user is logged in.


iii. Product Browsing
Products are fetched from the database and displayed on the dashboard.
Users can view categories such as fruits, vegetables, and grains.


iv. Add to Cart
The user selects a product and adds it to the cart.
The selected items are stored temporarily in session or cart table.


v. Order Placement
The user reviews the cart and confirms the order.
Order details are stored in the database including user ID, product details, quantity, and time.


vi. Admin Order Management
Admin logs into the system and views all orders.
Admin updates the order status such as Pending, Shipped, or Delivered.

vii. Notifications (Optional Feature)
Emails are sent using PHPMailer.
OTP is used for password reset.
Order confirmation messages are sent to users.

viii. Password Recovery
User clicks on forgot password option.
An OTP is sent to the registered email.
User verifies OTP and sets a new password.

6)DATABASE WORKFLOW
->Tables used in the system:
  users
  products
  orders
  cart

->Flow of data:
  User details are stored in users table
  Product details are stored in products table
  Cart stores temporary selected items
  Orders table stores final confirmed orders


7)FEATURES
Secure login and registration system
Product browsing and search
Add to cart functionality
Order placement and tracking
Admin dashboard for management
Password reset using OTP
Email notifications

8)FUTURE ENHANCEMENTS
Online payment integration
Mobile application support
AI-based product recommendations
Delivery tracking system
Farmer-specific dashboards
