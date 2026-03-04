# Nomadic CSS Utilities

A WordPress plugin that provides a curated set of responsive layout, spacing, and typography utility classes for the block editor. Classes are registered with [CSS Class Manager](https://wordpress.org/plugins/css-class-manager/) so clients can apply them without touching code.

## Why

The WordPress block editor exposes layout controls, but they're inconsistent and limited. This plugin gives editors a predictable, prefix-namespaced set of utilities that work on top of (or instead of) the editor's built-in styles — without conflicting with Tailwind CSS utilities used in theme templates.

## Approach

- All classes use the `n-` prefix to avoid conflicts with Tailwind
- `!important` on every rule to reliably override block editor inline styles
- Mobile-first — base classes apply to all screen sizes; `tablet:` and `desktop:` prefixes escalate upward
- Two responsive tiers only: `tablet:` (768px+) and `desktop:` (1024px+)

## Installation

1. Clone or copy this repo into `wp-content/plugins/nomadic-css-utilities/`
2. Activate the plugin in WordPress
3. The utilities are automatically registered with CSS Class Manager

## Class Reference

### Display
`n-block` `n-inline-block` `n-inline` `n-hidden`

### Flex
`n-flex` `n-inline-flex` `n-flex-row` `n-flex-col` `n-flex-row-rev` `n-flex-col-rev`
`n-flex-wrap` `n-flex-nowrap` `n-flex-1` `n-flex-auto` `n-flex-none`

### Grid
`n-grid` `n-inline-grid` `n-grid-cols-{1–6}`

### Alignment
`n-items-{start|center|end|stretch|baseline}`
`n-justify-{start|center|end|between|around}`

### Text Alignment
`n-text-{left|center|right}`

### Spacing

Spacing scale (px): `0 4 8 12 16 20 24 32 40 48 56 64 80 96 128 160`

| Prefix | Property |
|--------|----------|
| `n-p-{n}` | `padding` (all sides) |
| `n-pt-{n}` | `padding-top` |
| `n-pb-{n}` | `padding-bottom` |
| `n-py-{n}` | `padding-block` (top + bottom) |
| `n-pl-{n}` | `padding-left` |
| `n-pr-{n}` | `padding-right` |
| `n-px-{n}` | `padding-inline` (left + right) |
| `n-m-{n}` | `margin` (all sides) |
| `n-mt-{n}` | `margin-top` |
| `n-mb-{n}` | `margin-bottom` |
| `n-my-{n}` | `margin-block` (top + bottom) |
| `n-ml-{n}` | `margin-left` |
| `n-mr-{n}` | `margin-right` |
| `n-mx-{n}` | `margin-inline` (left + right) |
| `n-mx-auto` | `margin-inline: auto` |
| `n-ml-auto` | `margin-left: auto` |
| `n-mr-auto` | `margin-right: auto` |
| `n-gap-{n}` | `gap` |

### Typography

Font size scale (px): `12 14 16 18 20 24 28 32 36 40 48 56 64 72`

`n-text-{n}` — sets `font-size`

### Responsive Prefixes

Every utility above is also available with `tablet:` and `desktop:` prefixes:

```
n-hidden                   → hidden on all screens
tablet:n-block             → visible at 768px+
desktop:n-flex-row         → row direction at 1024px+
tablet:n-pt-32             → 32px top padding at 768px+
```

## CSS Class Manager Integration

The plugin uses the `css_class_manager_filtered_class_names` filter to register all classes as `ClassPreset` objects. Classes appear in the editor's class picker automatically — no manual entry required.

---

## Editor Guide

> For content editors. Share this section with clients.

Every block has a **CSS Class** field in the block settings sidebar under *Advanced*. You can type class names there to control layout, spacing, and text size — without needing a developer.

**All class names start with `n-`** to keep them separate from the theme's own styles.

### Showing and hiding things

| Class | What it does |
|-------|-------------|
| `n-hidden` | Hides the block on all screens |
| `tablet:n-hidden` | Hides at tablet width and above |
| `tablet:n-block` | Shows at tablet width and above (pair with `n-hidden`) |

Mobile-only block: `n-block tablet:n-hidden`
Desktop-only block: `n-hidden tablet:n-block`

### Changing layout direction

| Class | What it does |
|-------|-------------|
| `n-flex` | Lays children out in a row |
| `n-flex-col` | Stacks children vertically |
| `tablet:n-flex-row` | Switches to a row at tablet width |

### Spacing

Numbers represent pixels: `4 8 12 16 20 24 32 40 48 56 64 80 96 128 160`

| Class | What it does |
|-------|-------------|
| `n-pt-{n}` | Padding top |
| `n-pb-{n}` | Padding bottom |
| `n-py-{n}` | Padding top and bottom |
| `n-px-{n}` | Padding left and right |
| `n-mt-{n}` | Margin top |
| `n-mb-{n}` | Margin bottom |

Example: `n-py-32` adds 32px padding above and below. `tablet:n-py-64` increases it at tablet and up.

You can combine them: `n-py-32 tablet:n-py-64 desktop:n-py-96`

### Text size

Sizes in pixels: `12 14 16 18 20 24 28 32 36 40 48 56 64 72`

`n-text-24` sets 24px. `desktop:n-text-32` increases it to 32px on desktop.

### Responsive prefixes

- No prefix — applies on all screen sizes
- `tablet:` — applies at 768px and above
- `desktop:` — applies at 1024px and above

Stack them freely: `n-text-18 tablet:n-text-24 desktop:n-text-32`
