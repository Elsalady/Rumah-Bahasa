# Taste (Continuously Learned by [CommandCode][cmd])

[cmd]: https://commandcode.ai/

# css
- Use green (hijau) as primary theme color for this project. Confidence: 0.70
- Use prominent/visible colors, avoid soft/subtle color schemes. Confidence: 0.65
- Add floating/ornamental animations to make the website look premium. Confidence: 0.50

# branding
- The project name is "Rumah Bahasa" (not "Rumah Belajar"). Confidence: 0.85

# ui
- Use "Login" text with an arrow icon for navbar login buttons, not "Dashboard". Confidence: 0.75
- Keep member-facing pages (program listing, jadwal, notifications) self-contained within the member area rather than redirecting members to public website pages — members should not need to leave their dashboard to access features. Confidence: 0.83
- Reuse existing CSS card components (like .news-card) for new card-based content pages instead of creating custom card styles, for visual consistency. Confidence: 0.60
- Add an active/highlighted color indicator on navbar links to show which section the user is currently viewing. Confidence: 0.70
- Use anchor/hash links on navbar items for section-based pages (like Profil → #about, Galeri → #galeri on the homepage) so they scroll to sections on the dashboard instead of navigating to separate routes. Confidence: 0.70

# architecture
- WhatsApp groups should be organized as one group per program (not per schedule/jadwal) — a single WhatsApp group for each program where admins post schedule reminders and announcements. Avoid creating separate groups per individual class schedule/jadwal to prevent group proliferation. Confidence: 0.80
- The project uses PostgreSQL as its database — avoid MySQL-specific SQL functions (e.g., FIELD()) and use PostgreSQL-compatible alternatives (e.g., CASE WHEN) for ordering and queries. Confidence: 0.85

# architecture
- For "Tentang Rumah Bahasa" section on the homepage/dashboard: use hardcoded text in code files, not database-driven (the Profil model is only for the /profil page managed via admin). Confidence: 0.75
- Class schedule quota should auto-calculate remaining capacity based on confirmed registrations (sisa kuota = total kuota from all schedules - jumlah pendaftar confirmed) rather than requiring manual updates by admin. Confidence: 0.75
- Filter which admin/system operations generate notifications for members — only member-facing content changes (e.g., new/updated programs, class schedules) should trigger member notifications; internal admin housekeeping operations (e.g., periodic schedule resets) should NOT generate member notifications. Confidence: 0.70
- When admin creates, updates, or deletes member-facing resources (e.g., jadwal kelas), auto-create notifications for all approved members so they stay informed of changes without manual communication. Confidence: 0.82

# communication
- Use Indonesian language (bahasa Indonesia) when communicating, not English. Confidence: 0.78
- Provide concise one-sentence summaries of completed technical changes/features when asked, as the user documents these in a logbook (logbook). Confidence: 0.70

# content
- Show only 3 latest berita (news) items on the homepage/dashboard; the rest should be visible on the /berita page after clicking "lihat selengkapnya". Confidence: 0.80

# architecture
- New user registrations should start with a "pending" status and require admin/staff approval before granting full access to the application. Confidence: 0.85

# admin-ui
- Consolidate related admin management sections (e.g., "Data Member" and "Pendaftar Program", or "Program" and "Jadwal Kelas") into a single navbar menu item to keep the sidebar clean and uncluttered — prefer inline/embedded management of child data within the parent page (expandable cards with inline add/edit/delete forms) rather than separate sub-pages or tab-separated views. Confidence: 0.90
- Use detail/show pages (click → detail view) for reviewing user documents and data rather than displaying everything inline in a table row. Confidence: 0.75
- Keep admin pages for similar data types (e.g., Data Member and Pendaftar Program) visually and functionally consistent — same layout style, same table features (export CSV), same header structure. Confidence: 0.75
- Avoid showing the same data redundantly across multiple admin pages (e.g., don't duplicate user documents in Pendaftar Program table since they're already visible in Data Member detail). Confidence: 0.70

# formatting
- Display timestamps with full date AND time including hours and minutes (format: D MMM YYYY, HH:mm) in admin tables, detail pages, and member-facing views. Confidence: 0.85

# planning
- When defining requirements for new features, prefers being asked structured clarifying questions with multiple-choice options (rather than open-ended questions) before implementation begins — helps align mental model before coding. Confidence: 0.65
- After registration/submission, redirect users back to the program detail page (not a generic dashboard/success page) so they can see status, quota info, and post-registration content (like WhatsApp group links). Confidence: 0.75
- For programs that have class schedules and registration, provide a WhatsApp group link after successful registration so members can immediately join the group for further information — display the link prominently on the post-registration page with a clear call-to-action button. Confidence: 0.80

# ui
See [ui/taste.md](ui/taste.md)
