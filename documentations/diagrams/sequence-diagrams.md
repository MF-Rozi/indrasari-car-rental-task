# System Sequence Diagrams

This document contains detailed UML sequence diagrams demonstrating the step-by-step interactions between the User, Web Controller, Domain Logic/Services, and Database.

---

## 1. Authentication & Role-Based Routing Sequence

```mermaid
sequenceDiagram
    autonumber
    actor User as User / Guest
    participant Browser as Browser Client
    participant AuthCtrl as AuthController
    participant UserDB as Database (users)
    participant Session as Session Manager

    User->>Browser: Enters Email & Password
    Browser->>AuthCtrl: POST /login (email, password)
    AuthCtrl->>UserDB: Query user by email
    UserDB-->>AuthCtrl: User record (hash, role: admin | customer)
    
    alt Invalid Credentials
        AuthCtrl-->>Browser: Redirect back with errors ("Credentials do not match")
        Browser-->>User: Displays error notification
    else Valid Credentials
        AuthCtrl->>Session: Regenerate session & store authenticated User ID
        Session-->>AuthCtrl: Session established
        
        alt Role == 'admin'
            AuthCtrl-->>Browser: Redirect to /admin/dashboard
            Browser-->>User: Renders Admin Dashboard
        else Role == 'customer'
            AuthCtrl-->>Browser: Redirect to /catalog (Customer Home)
            Browser-->>User: Renders Fleet Catalog
        end
    end
```

---

## 2. Car Catalog Search with Date Overlap Check

```mermaid
sequenceDiagram
    autonumber
    actor Customer as Customer
    participant Browser as Browser Client
    participant CatalogCtrl as CarCatalogController
    participant QueryEngine as Collision Query Engine
    participant CarDB as Database (cars, rentals)

    Customer->>Browser: Enters search keyword & date range (start_date, end_date)
    Browser->>CatalogCtrl: GET /cars?brand=Toyota&start_date=2026-09-01&end_date=2026-09-05
    CatalogCtrl->>QueryEngine: Query available vehicles(filters, start_date, end_date)
    
    QueryEngine->>CarDB: SELECT * FROM cars WHERE brand LIKE '%Toyota%'<br/>AND id NOT IN (<br/>  SELECT car_id FROM rentals WHERE status = 'active'<br/>  AND NOT (end_date < '2026-09-01' OR start_date > '2026-09-05')<br/>)
    CarDB-->>QueryEngine: List of available matching cars
    QueryEngine-->>CatalogCtrl: Filtered car models
    CatalogCtrl-->>Browser: Render catalog view with available cars & daily rates
    Browser-->>Customer: Displays matching vehicles ready to book
```

---

## 3. Vehicle Booking & Reservation Sequence

```mermaid
sequenceDiagram
    autonumber
    actor Customer as Customer
    participant Browser as Browser Client
    participant BookingCtrl as RentalBookingController
    participant DBTransaction as Database Transaction
    participant RentalDB as Database (rentals)
    participant CarDB as Database (cars)

    Customer->>Browser: Selects vehicle, inputs dates (2026-09-01 to 2026-09-05), clicks 'Confirm Booking'
    Browser->>BookingCtrl: POST /rentals/book (car_id, start_date, end_date)
    
    BookingCtrl->>DBTransaction: Begin Transaction
    BookingCtrl->>RentalDB: Lock & Check overlapping active rentals for car_id in date range
    
    alt Overlap Detected (Collision)
        RentalDB-->>BookingCtrl: Conflicting booking found
        BookingCtrl->>DBTransaction: Rollback Transaction
        BookingCtrl-->>Browser: Redirect back with error ("Car is no longer available for selected dates")
        Browser-->>Customer: Shows booking collision error
    else No Overlap (Available)
        RentalDB-->>BookingCtrl: No conflict
        BookingCtrl->>BookingCtrl: Calculate days: (end_date - start_date + 1) = 5 days
        BookingCtrl->>BookingCtrl: Calculate estimated cost = 5 * daily_rate
        BookingCtrl->>RentalDB: INSERT INTO rentals (user_id, car_id, start_date, end_date, total_days, estimated_price, status='active')
        BookingCtrl->>CarDB: UPDATE cars SET status = 'rented' WHERE id = car_id
        BookingCtrl->>DBTransaction: Commit Transaction
        BookingCtrl-->>Browser: Redirect to /my-rentals with success banner
        Browser-->>Customer: Displays Active Booking in My Rentals
    end
```

---

## 4. Car Return by License Plate & Billing Sequence

```mermaid
sequenceDiagram
    autonumber
    actor Customer as Customer
    participant Browser as Browser Client
    participant ReturnCtrl as CarReturnController
    participant RentalDB as Database (rentals)
    participant CarDB as Database (cars)
    participant InvoiceDB as Database (invoices)

    Customer->>Browser: Enters License Plate (e.g. "B 1234 CD") on Return Page
    Browser->>ReturnCtrl: POST /rentals/return/verify (license_plate)
    
    ReturnCtrl->>RentalDB: Query active rental by car license_plate & user_id = auth()->id()
    
    alt No Matching Active Rental for User
        RentalDB-->>ReturnCtrl: No active rental found
        ReturnCtrl-->>Browser: Redirect with error ("No active rental found for plate under your account")
        Browser-->>Customer: Displays validation error
    else Active Rental Verified
        RentalDB-->>ReturnCtrl: Rental record found (start_date, daily_rate)
        ReturnCtrl->>ReturnCtrl: Compute actual duration = max(1, diffInDays(start_date, today))
        ReturnCtrl->>ReturnCtrl: Compute final total amount = duration_days * daily_rate
        ReturnCtrl-->>Browser: Show Return Confirmation Modal / Preview with calculated fee
        
        Customer->>Browser: Confirms Return Execution
        Browser->>ReturnCtrl: POST /rentals/return/confirm (rental_id)
        
        ReturnCtrl->>RentalDB: UPDATE rentals SET status='completed', actual_return_date=NOW(), final_price=total_amount WHERE id=rental_id
        ReturnCtrl->>CarDB: UPDATE cars SET status='available' WHERE id=car_id
        ReturnCtrl->>InvoiceDB: INSERT INTO invoices (rental_id, invoice_number, total_amount, payment_status='paid', issued_at=NOW())
        ReturnCtrl-->>Browser: Redirect to /invoices/{id} (Digital Invoice View)
        Browser-->>Customer: Renders Invoice Breakdown & Receipt
    end
```
