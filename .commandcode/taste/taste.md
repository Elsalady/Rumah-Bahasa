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
- Reuse existing CSS card components (like .news-card) for new card-based content pages instead of creating custom card styles, for visual consistency. Confidence: 0.60
- Add an active/highlighted color indicator on navbar links to show which section the user is currently viewing. Confidence: 0.70
- Use anchor/hash links on navbar items for section-based pages (like Profil → #about, Galeri → #galeri on the homepage) so they scroll to sections on the dashboard instead of navigating to separate routes. Confidence: 0.70

# architecture
- For "Tentang Rumah Bahasa" section on the homepage/dashboard: use hardcoded text in code files, not database-driven (the Profil model is only for the /profil page managed via admin). Confidence: 0.75

# communication
- Use Indonesian language (bahasa Indonesia) when communicating, not English. Confidence: 0.78

# content
- Show only 3 latest berita (news) items on the homepage/dashboard; the rest should be visible on the /berita page after clicking "lihat selengkapnya". Confidence: 0.80

