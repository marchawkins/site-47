# marchawkins.com

Personal website for Marc Hawkins — built with [Kirby CMS](https://getkirby.com), adhering to IndieWeb principles, and styled with a grungy 80s/90s punk-and-zine aesthetic.

---

## Tech Stack

- **CMS:** [Kirby 5](https://getkirby.com) (flat-file, no database)
- **Server-side:** PHP 8.1–8.3
- **Dependencies:** Managed via Composer
- **Frontend:** Vanilla HTML, CSS, and JavaScript — no build tools or bundlers
- **Carousel:** [Flickity](https://flickity.metafizzy.co) (projects, about, and photo detail pages)
- **Analytics:** Google Analytics (gtag.js), loaded on production only
- **Deployment:** GitHub Actions → SSH/SCP to web server on push to `main`

### Kirby Plugins

- [`mauricerenck/komments`](https://github.com/mauricerenck/komments) — comment system powering the Guestbook; stores entries as flat Markdown files
- `kirby-locator` — location field support
- `pechente/kirby-admin-bar` — floating admin bar shown when a Kirby user is logged in

---

## Site Sections

**Home** — The landing page. Displays an animated GIF portrait of Marc alongside site navigation. Intentionally minimal; the design does the talking.

**Projects** — A portfolio index of design and development work, paginated and filterable by tag. Each project has its own detail page with a Flickity image carousel.

**Photos** — A date-sorted gallery of photo pages. The index shows cropped 200×200 thumbnails; individual photo pages display the full image. The About page also pulls photos into a shuffled Flickity carousel.

**About** — Bio and background, structured as an [h-card](https://microformats.org/wiki/h-card) (IndieWeb microformat) with `rel="me"` links, location, and contact info. Includes a photo carousel.

**Guestbook** — A public comment form powered by the Komments plugin, letting visitors leave notes on the site.

**Slashes** — A collection of [/slash pages](https://slashpages.net), staking a claim on the IndieWeb. Current pages include: `/ai`, `/canon`, `/carry`, `/changelog`, `/colophon`, `/ideas`, `/now`, `/pfp`, `/uses`, and `/where`. The `/changelog` page pulls live commit history from the GitHub API.

---

## Design

The site leans hard into early-internet nostalgia — think punk zines, VHS tapes, and late-90s personal homepages. The header uses a looping VHS scan-line GIF as its background, with white all-caps nav links that drop into view from the top. The primary typeface is `Courier New` (monospace), reinforcing the lo-fi, typewritten feel. Animated GIFs appear throughout, including the homepage portrait. The palette is mostly black, white, and grey — high contrast and deliberately rough around the edges. The site is fully responsive: on mobile, the navigation collapses into a hamburger menu with a centered logo button.

---

© 2025 Marc Hawkins
