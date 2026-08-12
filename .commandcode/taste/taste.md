# Taste (Continuously Learned by [CommandCode][cmd])

[cmd]: https://commandcode.ai/

# css
- Use green (hijau) as primary theme color for this project. Confidence: 0.30 — later contradicted on the homepage: the user emphatically demanded BLUE ("WARNA BIRU IHHH, KO JADI WARNA HIJAUUUUU") when a section rendered greenish, asking for the original blue ("biru kayak yang pertama dulu").
- Use prominent/visible colors, avoid soft/subtle color schemes. Confidence: 0.65
- Add floating/ornamental animations to make the website look premium (user explicitly requested animations on the "Hubungi Kami" form container "biar ngga flat gitu"). Confidence: 0.65
- Decorative banner/marketing sections (like the MEA & AFTA banner) should be built as full-width gradient sections with a prominent badge/pill, large bold heading, descriptive text, and soft blur "floating shape" ornaments — mirroring the premium look of the original website. Confidence: 0.70

# branding
- The project name is "Rumah Bahasa" (not "Rumah Belajar"). Confidence: 0.85

# ui
- Use "Login" text with an arrow icon for navbar login buttons, not "Dashboard". Confidence: 0.75
- Keep member-facing pages (program listing, jadwal, notifications) self-contained within the member area rather than redirecting members to public website pages — members should not need to leave their dashboard to access features. Confidence: 0.83
- Reuse existing CSS card components (like .news-card) for new card-based content pages instead of creating custom card styles, for visual consistency. Confidence: 0.60
- Add an active/highlighted color indicator on navbar links to show which section the user is currently viewing. Every section linked in the navbar (including the hero/landing "Beranda" section) must have a corresponding `id` attribute so scroll-spy works correctly for all navigation items. Confidence: 0.75
- Use anchor/hash links (`route('home') . '#section'`) on navbar items AND footer links for section-based content (Profil → #about, Galeri → #galeri, footer program list → #pelatihan, contact → #kontak) so clicks scroll to the relevant homepage section instead of navigating to separate routes/pages. Confidence: 0.80

# architecture
- WhatsApp groups should be organized as one group per program (not per schedule/jadwal) — a single WhatsApp group for each program where admins post schedule reminders and announcements. Avoid creating separate groups per individual class schedule/jadwal to prevent group proliferation. Confidence: 0.80
- The project uses PostgreSQL as its database — avoid MySQL-specific SQL functions (e.g., FIELD()) and use PostgreSQL-compatible alternatives (e.g., CASE WHEN) for ordering and queries. Confidence: 0.85

# architecture
See [architecture/taste.md](architecture/taste.md)
# communication
See [communication/taste.md](communication/taste.md)
# spacing
- Use generous spacing (e.g., margin-top: 48px) between major content sections on information pages, especially between descriptive/header content and the main content blocks below it. Confidence: 0.80

# formatting
- Display section titles/labels within content (e.g., "Visi", "Misi") as bold headings above their description text — the title should be visually prominent (bold/tebal), not inline or plain. Confidence: 0.80
- On content/information pages (e.g., /profil), do NOT repeat the category name as a label/badge inside individual content cards — the section heading already identifies the category, so inline blue labels like "Sejarah" inside a Sejarah section card are redundant and should be removed. Confidence: 0.85

# ui
- For informational text-heavy content sections like Visi & Misi, use a simple stacked/layout display (title bold, then description below in a plain container) rather than the card grid pattern used for itemized content — content-rich sections should not be forced into card-grid layout. Confidence: 0.78
- All content categories on information pages (like /profil) should use the same stacked/bold-title-above-description layout — no card grid for any category. Keep all categories visually consistent with the visi_misi style. Confidence: 0.85
- On content/information pages, truncate overly long descriptions (e.g., >300 characters) with a "Lihat Selengkapnya" styled button linking to the detail/show page — full content is deferred to a dedicated detail page rather than shown inline. Confidence: 0.78

# content
- Show only 3 latest berita (news) items on the homepage/dashboard; the rest should be visible on the /berita page after clicking "lihat selengkapnya". Confidence: 0.80
- Berita (news) items on the homepage should be clickable cards linking to individual detail pages (`/berita/{slug}`), not display-only static previews — each news card should have a clickable area wrapping the entire card. Confidence: 0.85
- When implementing site features, faithfully mirror the original website (rumahbahasa.surabaya.go.id) — fetch and adapt its actual content (text, categories, structure) from the live site rather than inventing placeholder content. Confidence: 0.85
- The program/class list in the project must exactly match the original Rumah Bahasa website — same set of programs/classes AND same ordering. When discrepancies are found (extra programs not on the original, e.g., Kelas Bahasa Turki; missing ones, e.g., Kelas Bahasa Jawa, Kelas Komputer (BLC)), fix them so the project matches the original exactly rather than keeping a near-identical list. Confidence: 0.9

# architecture
- New user registrations should start with a "pending" status and require admin/staff approval before granting full access to the application. Confidence: 0.85
- Program/class enrollment (pendaftaran program) should use instant-confirmation flow — set status directly to "confirmed" upon registration without requiring admin approval — unlike user account registration which needs admin approval. Members should be immediately enrolled and appear in the admin panel as registered participants. The approve/reject UI for program enrollment must be removed entirely (admin dropdown + update route + controller method, member-facing "Menunggu/Ditolak" pills), not just hidden — the user explicitly asked to delete the reject/approve function and display for program enrollment from both the admin panel and member dashboard, because there is no approval step to manage. The only rejection path is automatic at registration when the class quota (kuota set by the admin on jadwal kelas) is already full — the backend compares total kuota vs confirmed registrations and auto-creates a rejected record with a clear note (e.g., "Kuota kelas sudah penuh") plus an error message to the member. Confidence: 0.9

# admin-ui
See [admin-ui/taste.md](admin-ui/taste.md)
# formatting
- Display timestamps with full date AND time including hours and minutes (format: D MMM YYYY, HH:mm) in admin tables, detail pages, and member-facing views — including tables rendered dynamically in JS from JSON data. Confidence: 0.9
- Display times of day (class start/end times) as `HH:mm` without seconds (e.g., `15:00 - 16:00`, never `15:00:00`) in admin tables and schedule displays — raw time values with seconds are considered "berantakan". Confidence: 0.8
- When serializing data to JavaScript via `@json` (e.g., registrant data for JS drill-down tables), pre-format timestamps in the controller before serialization — WIB + Indonesian locale (`D MMM YYYY, HH:mm`) and times (`H:i`) — so raw ISO strings (`2026-08-10T09:34:00.000000Z`) and raw time values never reach the frontend. Confidence: 0.85
- Display all timestamps in Indonesian timezone WIB (Asia/Jakarta) with Indonesian locale — format via `->timezone('Asia/Jakarta')->locale('id')->isoFormat(...)` in views/controllers so times shown to users are real-time WIB, not the app's default UTC. Confidence: 0.9

# planning
- When defining requirements for new features, prefers being asked structured clarifying questions with multiple-choice options (rather than open-ended questions) before implementation begins — helps align mental model before coding. Confidence: 0.78
- When listing possible next features to work on, present them as structured multiple-choice options with clear recommended/labeled choices (rather than free-form suggestions) — the user picks one option and expects work to start on it. Confidence: 0.78
- After each feature delivery, the user wants to continue immediately to the next gap — repeatedly asks "lanjut apa lagi"/"okey udah, apa lagi"/"okey lanjut"/"nest ke tahap selanjutnya" (what's next) and expects the assistant to propose and proceed with the next improvement rather than ending the session. When working through a deployment audit checklist, the user confirms each item with "okey lanjut : <quoted audit item>" and expects the assistant to execute that item right away and then move to the next. Confidence: 0.98
- After registration/submission, redirect users back to the program detail page (not a generic dashboard/success page) so they can see status, quota info, and post-registration content (like WhatsApp group links). Confidence: 0.75
- For programs that have class schedules and registration, provide a WhatsApp group link after successful registration so members can immediately join the group for further information — display the link prominently on the post-registration page with a clear call-to-action button. Confidence: 0.80

# naming
- Use clear, domain-matching terminology in admin UI labels and route names (e.g., "Program" for academic programs/courses, not "Layanan"/Services) so the interface is immediately understandable and avoids confusion. Confidence: 0.85

# maintenance
See [maintenance/taste.md](maintenance/taste.md)
# ui
- Homepage berita/news section should use a modern interactive 3D Coverflow/Swiper carousel (see ui/taste.md) instead of the static card grid — this supersedes the earlier preference for a square/grid news-card layout on the homepage ("kotak-kotak kayak yang didalam lihat selengkapnya"), which the user explicitly asked to replace. Confidence: 0.85
- Visual/CSS styling of the same component used on different pages must be exactly identical — same CSS classes, same padding (e.g., 24px body), same typography (title 18px bold, description 14px gray), same colors. When a component (like news cards) appears on both the homepage and the /berita listing page, their styling must match precisely, not just be "similar". Confidence: 0.82
See [ui/taste.md](ui/taste.md)
