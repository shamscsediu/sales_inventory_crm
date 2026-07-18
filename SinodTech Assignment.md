# **![][image1]** **Technical Assessment: Sales, Inventory & CRM System**

## **Overview**

Thank you for your interest in joining our team.

This technical assessment is designed to evaluate your ability to design and implement a well-structured business application using Laravel. We are primarily assessing your software architecture, database design, and implementation of core business logic rather than visual design.

We value clean, maintainable, and scalable code. A partially completed solution with excellent architecture and coding practices is preferred over a feature-complete submission with poor code quality.

---

# **Technology Stack**

Please use the following technologies for your implementation:

* **Backend:** Laravel (PHP)  
* **Database:** MySQL, SMTP(https://mailtrap.io/)  
* **Frontend:** Blade, React, or Vue

---

# **Functional Requirements**

## **1\. Sales & Inventory Management**

### **Product Management**

Create a basic product catalog that includes information such as:

* Product Name  
* SKU  
* Price  
* Stock Quantity

### **Inventory Control**

When a product is sold:

* Record the sale.  
* Automatically deduct the corresponding stock quantity.  
* Prevent sales when available stock is insufficient.

---

## **2\. Customer Relationship Management (CRM)**

### **Customer Purchase History**

Maintain a complete purchase history for each customer, including:

* Purchase records  
* Purchase frequency  
* Last purchase date

### **Lost Customer Detection**

Implement a mechanism to identify inactive ("lost") customers who have not made a purchase within a configurable period (e.g., 90 days).

### **Customer Re-engagement**

Provide a feature (or simulated action) to send promotional emails or SMS messages to inactive customers.

### **Employee Assignment**

Allow administrators to assign inactive customers to employees for follow-up.

### **KPI Tracking**

When an assigned inactive customer makes a new purchase, automatically increase the assigned employee's KPI score.

---

# **Bonus Features (Optional)**

The following features are optional but will be considered a strong advantage.

### **Multi-Branch Support**

* Manage multiple store locations.  
* Maintain branch-specific inventory.  
* Record sales by branch.

### **Email Invoices**

Automatically generate and send a PDF or HTML invoice to the customer after a successful purchase.

### **E-Commerce Integration API**

Develop a secure REST API that exposes product information for a simulated third-party e-commerce platform.

Suggested fields:

* SKU  
* Product Name  
* Price  
* Available Stock

---

# **AI Usage Policy**

You are welcome to use AI-assisted development tools while completing this assessment.

However, you should have full ownership and understanding of your implementation. During the technical interview, you may be asked to explain:

* Your system architecture  
* Database schema design  
* Business logic implementation  
* Design patterns and architectural decisions

---

# **Submission Requirements**

## **GitHub Repository**

Submit your solution as a **public GitHub repository**.

## **Documentation**

Include a comprehensive **README.md** containing:

* A list of completed features.  
* Step-by-step setup instructions.  
* Environment configuration.  
* Database migration instructions.  
* Seeder execution instructions.  
* Commands required to run the project locally.

## **Seed Data**

Provide database seeders with realistic sample data, including:

* Products  
* Customers  
* Employees  
* Sales  
* Transactions

The application should be ready for testing immediately after running the seeders.

---

# **Evaluation Criteria**

Your submission will be evaluated based on:

* System architecture  
* Database design  
* Business logic implementation  
* Code quality and readability  
* Maintainability and scalability  
* Appropriate use of Laravel features and best practices  
* Documentation quality

---

We look forward to reviewing your submission.

If you have any questions regarding the assessment or the requirements, please don't hesitate to reach out.

[image1]: <data:image/png;base64,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>