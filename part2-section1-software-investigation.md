# Part 2 - Section 1: Software Investigation

## 1. Introduction

FoodDash is a small web-based food delivery application developed to support customers who want to browse food items, register an account, log in, add items to a cart, and place an order online. The system also provides an admin area to monitor users, menu items, and orders. This investigation examines the business need, the system scope, the intended users, and the key requirements that justify the development of the software.

## 2. Business Need

Many food businesses need a simple digital platform that allows customers to order meals without relying only on phone calls or in-person ordering. Manual ordering methods are often slow, difficult to track, and prone to human error. A food delivery website can improve operational efficiency by allowing menu browsing, customer registration, order submission, and order monitoring in one system.

For this project, the business need is to create a lightweight ordering platform for a food service provider. The platform must:

- present menu items clearly to customers
- allow account registration and login
- provide a shopping cart for order preparation
- save order data into a database
- support administrative monitoring of customers and orders

## 3. Problem Statement

The current ordering approach assumed by the project is inefficient because it does not provide structured digital management for customers, menu data, and order records. Without a web-based application:

- customers cannot place orders conveniently online
- user information is difficult to manage
- order details are not stored in a central database
- business staff cannot easily track order history
- system growth becomes difficult as customer volume increases

Therefore, a software solution is required to digitise the ordering process and improve reliability, accuracy, and accessibility.

## 4. Proposed Solution

The proposed solution is a web-based food delivery application named FoodDash. The system is developed using HTML, CSS, JavaScript, PHP, and MySQL. It provides a simple interface for customers and an administration area for management purposes.

The solution includes the following main modules:

- Home page
- User registration
- User login
- Food menu display
- Shopping cart
- Order placement
- Admin dashboard

This solution is appropriate because it is cost-effective, easy to deploy in a local server environment such as XAMPP, and suitable for small and medium food-ordering operations.

## 5. Stakeholders

The main stakeholders involved in the system are:

### 5.1 Customers

Customers use the system to browse food items, create accounts, log in, add products to the cart, and place orders.

### 5.2 Administrator

The administrator manages the system and monitors business activity. Admin users can access the dashboard to review registered users, menu items, and customer orders.

### 5.3 Business Owner

The business owner benefits from digital order tracking, centralised information management, and improved service efficiency.

### 5.4 Developer

The developer is responsible for designing, implementing, testing, and maintaining the application to ensure it meets business requirements.

## 6. System Objectives

The main objectives of FoodDash are:

- to provide customers with a convenient online ordering platform
- to reduce manual order handling
- to store menu and order data in a structured database
- to improve order accuracy and traceability
- to support basic administrative management
- to provide a foundation for future system expansion

## 7. Scope of the System

### 7.1 In Scope

The current system includes:

- user registration and login
- food menu retrieval from the database
- cart management on the client side
- order submission to the server
- order storage in MySQL
- admin monitoring of users, menu items, and orders

### 7.2 Out of Scope

The current version does not include:

- online payment gateway integration
- delivery driver tracking
- real-time order status updates for customers
- discount coupon management
- product image upload through admin panel
- advanced analytics and reporting

## 8. Functional Requirements Identified During Investigation

From the software investigation, the following functional requirements are identified:

- The system shall allow a new user to register an account.
- The system shall allow an existing user to log in.
- The system shall display menu items from the database.
- The system shall allow users to add menu items to a cart.
- The system shall allow users to update quantities in the cart.
- The system shall allow users to submit an order.
- The system shall store order details in the database.
- The system shall allow an admin to view users, menu items, and orders.

## 9. Non-Functional Requirements Identified During Investigation

The investigation also identifies several non-functional requirements:

- The system should be easy to use for non-technical users.
- The interface should be responsive on desktop and mobile devices.
- The system should validate login and registration data.
- The database connection should be reliable.
- The system should maintain basic session control for admin and user access.
- The system should provide acceptable performance for small-scale business use.

## 10. Constraints

The project has several constraints:

- development time is limited by assignment deadlines
- the application is developed using a local server environment
- the current system is designed for demonstration and academic purposes
- there is no integration with third-party delivery or payment services
- the application uses a relatively simple architecture suitable for student-level implementation

## 11. Risks

Possible risks identified during investigation include:

- database connection errors
- invalid or incomplete user input
- weak password handling if security is not improved
- session issues when managing admin access
- inconsistent data if order validation is insufficient

These risks suggest the need for careful validation, secure authentication, and structured testing during later development stages.

## 12. Conclusion

The software investigation shows that FoodDash addresses a clear business need by replacing manual ordering with a digital food delivery platform. The system provides practical benefits for customers and administrators, while also creating a strong basis for future enhancements. This investigation supports the decision to proceed with the software lifecycle by defining the problem, the stakeholders, the project scope, and the initial requirements.
