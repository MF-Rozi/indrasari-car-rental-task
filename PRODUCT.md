# Product

## Register

product

## Users
- **Customers:** Individuals seeking to rent cars for personal, family, or business travel. Context: browsing on mobile or desktop, selecting dates, requiring fast availability checking, clear pricing breakdowns, simple vehicle return by plate number, and instant printable digital receipts.
- **Fleet Administrators:** Operational managers responsible for car inventory CRUD, monitoring system-wide reservations, auditing rental durations, and reviewing revenue metrics.

## Product Purpose
Indrasari Car Rental provides a reliable, modern web platform for end-to-end car rental operations. It eliminates scheduling conflicts through atomic database collision checking, calculates precise duration and pricing upon return, and offers streamlined fleet administration.

## Brand Personality
- **Voice & Tone:** Professional, trustworthy, precise, and frictionless.
- **3-Word Personality:** Reliable, Clean, Efficient.
- **Emotional Goal:** Customer confidence and complete peace of mind throughout booking, pickup, and return.

## Anti-references
- Cluttered, dated booking forms with confusing date pickers or nested borders.
- Generic AI slop templates (warm cream/sand backgrounds, gradient text, excessive rounded corners `border-radius: 32px+`, ghost shadows).
- Low-contrast dark mode text (e.g. dark slate text on dark blue background).
- Multi-step checkout friction with hidden pricing calculations.

## Design Principles
- **Frictionless Booking & Return:** Enable customers to complete bookings and initiate returns in under a minute with pre-filled profiles and instant license plate lookups.
- **High-Contrast Dual-Theme Craft:** Deliver first-class Light (`#F7F9FB` surface) and Dark (`#0F172A` / `#1E293B` surface) modes with ≥4.5:1 text contrast on all text and inputs.
- **Status Transparency:** Use distinct, meaningful color signals for vehicle and booking statuses (Emerald for Available/Active, Sky for Upcoming, Slate for Completed, Rose for Cancelled, Amber for Maintenance).
- **Zero-FOUC Performance:** Instant theme detection in document `<head>` to prevent theme flicker on page load.

## Accessibility & Inclusion
- WCAG 2.1 AA text contrast compliance on all light and dark surfaces.
- Keyboard-navigable form controls, modal dialogs, and navigation drawers.
- Dedicated `@media print` stylesheet for clean, black-on-white printable invoice receipts.
- Respect `prefers-reduced-motion` for all transitions and hover animations.
