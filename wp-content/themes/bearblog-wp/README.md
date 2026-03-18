# BearPress WordPress Theme

A faithful WordPress recreation of [BearBlog](https://bearblog.dev)'s brutally minimal aesthetic.

## What it includes

- `style.css` — all styles + WP theme header
- `functions.php` — theme setup, customizer options, head cleanup
- `header.php` / `footer.php`
- `index.php` — post list (date + title, no excerpts)
- `single.php` — single post with tags and prev/next nav
- `page.php` — static pages
- `archive.php` — tag / category / date archives
- `search.php` + `searchform.php`
- `comments.php`
- `404.php`
- `assets/css/editor.css` — block editor styles matching the frontend

## Installation

```bash
# Zip it up
zip -r bearpress.zip bearblog-wp/

# Then in WP Admin:
# Appearance → Themes → Add New → Upload Theme → bearpress.zip → Install → Activate
```

Or drop the folder directly into `wp-content/themes/bearpress/`.

## Customizer options

Under **Appearance → Customize → BearPress Options**:

| Option | Default | Notes |
|---|---|---|
| Show tagline in header | on | |
| Show dates in post list | on | |
| List date format | `Y-m-d` | Any PHP date string |
| Footer text | (site name) | HTML allowed |
| Column width | 660px | 400–1200px |
| Base font size | 16px | 12–24px |
| Show tags on single posts | on | |

## Navigation

Assign a menu to **Primary Navigation** in Appearance → Menus. Links appear as a flat row of small gray links under the site title.

## Notes

- No sidebar, no widgets — by design.
- No JavaScript loaded by the theme.
- WP emoji scripts and generator meta tag stripped.
- Block editor styles match the frontend.
