# ✅ Project TODOs & Developer Task List

This document outlines the remaining tasks for the application. Prioritize by urgency and dependencies. Update this file as features are completed or updated.

## 🔒 Security Audit & Hardening

- [ ] Add CSRF protection to all forms
- [ ] Sanitize and validate all user input (`$_POST`, `$_GET`, `$_FILES`)
- [ ] Escape output in views to prevent XSS
- [ ] Ensure secure password hashing (`password_hash()`)
- [ ] Implement rate limiting or simple throttling on login/resend routes
- [ ] Audit public routes for exposure risk
- [ ] Add HTTP headers for security (`Content-Security-Policy`, `X-Frame-Options`, etc.)

---

## 🌐 Routing & Views

- [ ] Improve 404 error handling
- [ ] Add fallback route for unexpected paths
- [ ] Refactor repetitive routes to use dynamic controllers

---

## 📈 Nice-to-Haves (Stretch Goals)

- [ ] Support image optimization on upload
- [ ] Make site PWA-ready (offline fallback, manifest, service worker)
- [ ] Add SEO tags & social share previews for public pages

---

> ✍️ Keep this list updated and tag tasks with initials or dates for accountability.
