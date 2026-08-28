# Indrasari Car Rental - System Diagrams & Architecture

This directory contains technical diagrams, flowcharts, and sequence flows for the Indrasari Car Rental Application based on the requirements in `documentations/tasks.txt` and UI specifications.

---

## Diagram Index

1. [**Flowcharts (`flowcharts.md`)**](file:///home/mfrozi/Code/Website/php/indrasari-car-rental-task/documentations/diagrams/flowcharts.md)
   - High-level system architecture flowchart
   - End-to-end customer journey flowchart (Registration, Search, Booking, Return, Invoice)
   - Administrator management flowchart (Fleet CRUD, Bookings monitoring, Analytics)

2. [**Sequence Diagrams (`sequence-diagrams.md`)**](file:///home/mfrozi/Code/Website/php/indrasari-car-rental-task/documentations/diagrams/sequence-diagrams.md)
   - Authentication & Role-based redirection sequence
   - Car catalog search with date overlap availability checking
   - Vehicle booking & reservation creation sequence
   - Car return by license plate & billing invoice calculation sequence

3. [**Entity-Relationship Diagram (`erd.md`)**](file:///home/mfrozi/Code/Website/php/indrasari-car-rental-task/documentations/diagrams/erd.md)
   - Database schema, table entities, primary/foreign keys, and relational cardinality

4. [**State Diagrams (`state-diagrams.md`)**](file:///home/mfrozi/Code/Website/php/indrasari-car-rental-task/documentations/diagrams/state-diagrams.md)
   - Vehicle operational state lifecycle (`available`, `rented`, `maintenance`)
   - Rental booking lifecycle states (`active`, `completed`, `cancelled`)
