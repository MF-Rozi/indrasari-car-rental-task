# State Transition Diagrams

This document illustrates the lifecycle states and transition triggers for vehicles and rental transactions in the Indrasari Car Rental system.

---

## 1. Vehicle Operational State Lifecycle

```mermaid
stateDiagram-v2
    [*] --> Available: Vehicle Registered by Admin

    Available --> Rented: Customer Confirms Booking (Booking Start)
    Rented --> Available: Customer Returns Vehicle (Plate Verified & Invoice Issued)
    
    Available --> Maintenance: Admin Marks Under Repair / Servicing
    Maintenance --> Available: Maintenance Finished & Approved

    Available --> [*]: Admin Deletes / Retires Vehicle
```

### Vehicle State Descriptions
- **`Available`:** Vehicle is in the fleet and ready to be discovered and reserved by customers across open date ranges.
- **`Rented`:** Vehicle is currently under an active rental agreement.
- **`Maintenance`:** Vehicle is temporarily out of service for inspection, repairs, or cleaning and excluded from booking.

---

## 2. Rental Booking Lifecycle

```mermaid
stateDiagram-v2
    [*] --> Active: Customer Completes Booking Reservation

    state Active {
        [*] --> Upcoming: Booking created prior to start date
        Upcoming --> Ongoing: Current date >= start_date
        Ongoing --> [*]
    }

    Active --> Completed: Customer Initiates Return via Plate & Confirms Bill
    Active --> Cancelled: Booking Cancelled prior to pickup

    Completed --> [*]: Transaction Finalized & Invoice Archived
    Cancelled --> [*]: Slot Released
```

### Rental State Descriptions
- **`Active`:** The reservation is confirmed. The vehicle is reserved for the designated `start_date` to `end_date`.
- **`Completed`:** The customer has returned the vehicle by license plate number, duration and fees have been calculated, and the invoice has been issued.
- **`Cancelled`:** The booking was voided before the rental commenced, unlocking the car for other customers.
