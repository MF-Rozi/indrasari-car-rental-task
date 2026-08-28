# System Flowcharts

This document details the architectural and user journey flowcharts for the Indrasari Car Rental application.

---

## 1. High-Level System Architecture Flowchart

```mermaid
flowchart TB
    subgraph ClientLayer [Client & Presentation Layer]
        Guest[Guest User]
        Customer[Customer Client]
        Admin[Administrator Client]
        BladeViews[Blade Templates + Tailwind CSS v4]
    end

    subgraph AppLayer [Application Core - Laravel 13]
        Router[HTTP Router / routes/web.php]
        AuthMiddleware[Auth & Role Middleware]
        
        subgraph Controllers [Controllers]
            AuthController[AuthController]
            CatalogController[CarCatalogController]
            BookingController[RentalBookingController]
            ReturnController[CarReturnController]
            AdminCarController[Admin\CarFleetController]
            AdminBookingController[Admin\BookingOverviewController]
            DashboardController[Admin\DashboardController]
        end

        subgraph BusinessLogic [Core Domain Logic]
            OverlapService[Availability & Collision Checker]
            PricingService[Rental Duration & Billing Calculator]
        end
    end

    subgraph DataLayer [Data Persistence - MySQL in Podman]
        UserTable[(Users Table)]
        CarTable[(Cars Table)]
        RentalTable[(Rentals / Bookings Table)]
        InvoiceTable[(Invoices Table)]
    end

    Guest -->|Browse / Register / Login| Router
    Customer -->|Book / View Rentals / Return| Router
    Admin -->|Fleet CRUD / Booking Monitor| Router

    Router --> AuthMiddleware
    AuthMiddleware --> Controllers

    CatalogController --> OverlapService
    BookingController --> OverlapService
    BookingController --> PricingService
    ReturnController --> PricingService

    Controllers --> DataLayer
    Controllers --> BladeViews
```

---

## 2. Customer Journey Flowchart

```mermaid
flowchart TD
    Start([Start]) --> IsAuth{Authenticated?}
    
    IsAuth -->|No| Register[Register with Name, SIM, Phone, Address, Email, Password]
    Register --> Login[Login with Email & Password]
    IsAuth -->|Yes| BrowseCatalog[Browse Fleet Catalog]
    Login --> BrowseCatalog

    BrowseCatalog --> FilterParams[Apply Filters: Brand, Model, Price, Rental Dates]
    FilterParams --> AvailabilityCheck{Car Available for Dates?}
    
    AvailabilityCheck -->|No| ShowCollisionMsg[Display 'Vehicle Booked for Selected Dates' Alert]
    ShowCollisionMsg --> FilterParams
    
    AvailabilityCheck -->|Yes| ViewCarDetails[View Vehicle Details & Estimate Cost]
    ViewCarDetails --> ConfirmBooking[Confirm Reservation]
    ConfirmBooking --> CreateRentalRecord[System Creates Active Rental Record]
    CreateRentalRecord --> MyRentalsView[View in 'My Rentals' Dashboard]

    MyRentalsView --> UsingCar[Vehicle Usage Period]
    UsingCar --> InitiateReturn{Initiate Return Flow}

    InitiateReturn -->|Via My Rentals| QuickReturn[Click 'Return' on Active Rental Card]
    InitiateReturn -->|Via Plate Form| ManualPlate[Enter License Plate Number on Return Page]

    QuickReturn --> VerifyOwnership
    ManualPlate --> VerifyOwnership{Does Active Rental Match User & Plate?}

    VerifyOwnership -->|No| PlateError[Show Error: 'No Active Rental Found for This Plate']
    PlateError --> ManualPlate

    VerifyOwnership -->|Yes| CalcDuration[Calculate Rental Days: start_date to return_date]
    CalcDuration --> CalcTotalCost[Calculate Total Amount = duration_days * daily_rate]
    CalcTotalCost --> ConfirmReturn[Customer Confirms Return]
    
    ConfirmReturn --> UpdateStatus[Update Rental to 'Completed' & Car to 'Available']
    UpdateStatus --> GenerateInvoice[Generate & Display Digital Invoice / Receipt]
    GenerateInvoice --> End([Finish])
```

---

## 3. Administrator Management Flowchart

```mermaid
flowchart TD
    AdminStart([Admin Login]) --> AdminDash[Admin Dashboard Overview]
    
    AdminDash --> ActionBranch{Select Admin Module}

    %% Fleet Management Branch
    ActionBranch -->|Fleet Management| FleetList[List Fleet Vehicles with Filters]
    FleetList --> FleetAction{Action}
    FleetAction -->|Add Car| AddCarForm[Input Brand, Model, Plate, Daily Rate, Specs, Image]
    AddCarForm --> PlateUniqueCheck{Plate Unique?}
    PlateUniqueCheck -->|No| PlateError[Display Plate Already Exists Error]
    PlateError --> AddCarForm
    PlateUniqueCheck -->|Yes| SaveCar[Save New Vehicle to Database]
    SaveCar --> FleetList

    FleetAction -->|Edit Car| EditCarForm[Update Specs, Rates, Status]
    EditCarForm --> UpdateCar[Save Updates]
    UpdateCar --> FleetList

    FleetAction -->|Delete Car| CheckActiveRentals{Has Active Rentals?}
    CheckActiveRentals -->|Yes| BlockDelete[Block Deletion: Active Rental Exists]
    CheckActiveRentals -->|No| DeleteCar[Delete Vehicle Record]
    DeleteCar --> FleetList

    %% Bookings Management Branch
    ActionBranch -->|Bookings Monitoring| BookingList[View System-Wide Bookings]
    BookingList --> FilterBookings[Filter by Status, Customer, Date, Plate]
    FilterBookings --> ViewInvoiceAudit[Inspect Booking Details & Generated Invoice]
    ViewInvoiceAudit --> BookingList

    %% Analytics Branch
    ActionBranch -->|Statistics| DashStats[View Key Metrics: Fleet Count, Active Rentals, Revenue]
    DashStats --> AdminDash
```
